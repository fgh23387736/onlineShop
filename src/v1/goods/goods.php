<?php
	header("Content-type: text/html; charset=utf-8");
	session_start();
	/**用户登录后会自动写入session
	*$_SESSION['type']='user|user';
	*$_SESSION['id']=1;
	*/
	/*$_SESSION['type']='user';
	$_SESSION['id']=1;*/
	include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/src/MySqlPDO.class.php';
	include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/src/Imgs.class.php';
	include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/src/request.php';
	include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/src/https.php';
	include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/src/public_functions.php';
	switch ($request_method) {
		case 'POST':
			if($_SESSION['type']!='user'){
				https(401);
				echo json_encode(array('Error' => "您不具有权限操作请用普通用户账号登录"));
	    		exit();
			}else{
				toPost($request_data);
			}
			
			break;
		case 'DELETE':
			if($_SESSION['type']!='user'){
				https(401);
				echo json_encode(array('Error' => "您不具有权限操作请用普通用户账号登录"));
	    		exit();
			}else{
				toDelete($request_data);
			}
			break;
		case 'PUT':
			if($_SESSION['type']!='user'){
				$request_data['Id']=$_SESSION['id'];
			}
			toPut($request_data);
			break;
		case 'GET':
			toGet($request_data);
			break;
		default:
			https(500);
			echo json_encode(array('Error' => "请求错误"));
			exit();
			break;
	}
	function toPost($request_data){
		$myecho=array();
		$imgs=new Imgs();
		$mypdo=new MySqlPDO();
		$request_data['ImgUrl']=$imgs->saveBase64toImg('/onlineShop/uploaddate/goods/headimg',$request_data['ImgUrl']);
		$request_data['Introduce']=saveContentToFile('/onlineShop/uploaddate/goods/Introduce',$request_data['Introduce']);
		$sql='INSERT INTO `os_goods`
			(
				`ImgUrl`,
				`Name`,
				`Type`,
				`Number`,
				`Price`,
				`Introduce`,
				`UserId`
			) VALUES (
				?,?,?,?,?,?,?
			)';
		$mypdo->prepare($sql);
		$myarr=array(
			$request_data['ImgUrl'],
			$request_data['Name'],
			$request_data['Type'],
			$request_data['Number'],
			$request_data['Price'],
			$request_data['Introduce'],
			$_SESSION['id']
		);
		if($mypdo->executeArr($myarr)){
			$myecho['Id']=$mypdo->lastInsertId();
		}else{
			$myecho['Error']="增加失败";
			https(400);
			echo json_encode($myecho);
			exit();
		}
		https(201);
		echo json_encode($myecho);
	}
	function toDelete($request_data){
		$myecho=array();
		$mypdo=new MySqlPDO();
		$mypdo_temp=new MySqlPDO();
		if(!isset($request_data['Type'])||!isset($request_data['Search'])){
			$myecho['Error']="请求格式错误";
			https(422);
			echo json_encode($myecho);
			exit();
		}
		$sql_f="DELETE FROM `os_goods` WHERE ";
		$sql_b="";
		$wherevalues=array();
		switch ($request_data['Type']) {
			case '0':{
				if(isset($request_data['Search']['Id'])&&!empty($request_data['Search']['Id'])){
					$Ids=explode('+', $request_data['Search']['Id']);
					$sql_b="`Id` in (";
					foreach ($Ids as $key => $value) {
						$sql_b.="?,";
						$wherevalues[]=$value;
					}
					$sql_b=substr($sql_b,0,strlen($sql_b)-1);
					$sql_b.=") AND `UserId`=?";
					$wherevalues[]=$_SESSION['id'];
				}else{
					$myecho['Error']="请求格式错误";
					https(422);
					echo json_encode($myecho);
					exit();
				}
			}
			break;
			default:
				$myecho['Error']="请求格式错误";
				https(422);
				echo json_encode($myecho);
				exit();
				break;
		}
		$sql="SELECT `ImgUrl`,`Id`,`Introduce` FROM `os_goods` WHERE ".$sql_b;
		$mypdo->prepare($sql);
		if(!$mypdo->executeArr($wherevalues)){
			$myecho['Error']="系统错误";
			https(500);
			echo json_encode($myecho);
			exit();
		}else{
			$root=$_SERVER['DOCUMENT_ROOT'];
			while ($rs=$mypdo->fetch()) {
				$sql_photo="SELECT `Url` FROM `os_goods_photo` WHERE `GoodsId`=?";
				$mypdo_temp->prepare($sql_photo);
				if($mypdo_temp->executeArr(array($rs['Id']))){
					while ($rs_temp=$mypdo_temp->fetch()) {
						if(file_exists($root.$rs['Url'])){
							unlink($root.$rs['Url']);
						}
					}
				}
				$sql_photo="DELETE  FROM `os_goods_photo` WHERE `GoodsId`=?";
				$mypdo_temp->prepare($sql_photo);
				if($mypdo_temp->executeArr(array($rs['Id']))){
				}
				if(file_exists($root.$rs['ImgUrl'])){
					unlink($root.$rs['ImgUrl']);
				}
				if(file_exists($root.$rs['Introduce'])){
					unlink($root.$rs['Introduce']);
				}
			}
		}

		$sql=$sql_f.$sql_b;
		$mypdo->prepare($sql);
		if(!$mypdo->executeArr($wherevalues)){
			$myecho['Error']="系统错误";
			https(500);
			echo json_encode($myecho);
			exit();
		}
		https(204);
		echo json_encode($myecho);
	}
	function toPut($request_data){
		$myecho=array();
		$imgs=new Imgs();
		$mypdo=new MySqlPDO();
		//print_r($request_data);
		if(!isset($request_data['Type'])||!isset($request_data['Update'])||!isset($request_data['Id'])){
			https(442);
			$myecho['Error']='请求格式错误';
			echo json_encode($myecho);
			exit();
		}
		$sql_f="UPDATE `os_goods` SET ";
		$sql_i="";
		$insidevalues=array();
		$wherevalues=array();
		$Ids=explode('+', $request_data['Id']);
		$sql_b="`Id` IN (";
		foreach ($Ids as $key => $value) {
			$sql_b.="?,";
			$wherevalues[]=$value;
		}
		$sql_b=substr($sql_b, 0,strlen($sql_b)-1);
		$sql_b.=")";
		switch ($request_data['Type']) {
			case '0':{
				if(count($Ids)!=1){
					$myecho['Error']="请求格式错误";
					https(422);
					echo json_encode($myecho);
					exit();
				}
				if(substr($request_data['Update']['ImgUrl'],0, 4)=='data'){
					$request_data['Update']['ImgUrl']=$imgs->saveBase64toImg('/onlineShop/uploaddate/goods/headimg',$request_data['Update']['ImgUrl']);
				}
				$request_data['Update']['Introduce']=saveContentToFile('/onlineShop/uploaddate/goods/Introduce',$request_data['Update']['Introduce']);
				$sql="SELECT `ImgUrl` FROM `os_goods` WHERE ".$sql_b;
				$mypdo->prepare($sql);
				if(!$mypdo->executeArr($wherevalues)){
					$myecho['Error']="系统错误";
					https(500);
					echo json_encode($myecho);
					exit();
				}else{
					$root=$_SERVER['DOCUMENT_ROOT'];
					while ($rs=$mypdo->fetch()) {
						if(!empty($rs['ImgUrl'])&&file_exists($root.$rs['ImgUrl'])&&$rs['ImgUrl']!=$request_data['Update']['ImgUrl']){
							unlink($root.$rs['ImgUrl']);
						}
						if(!empty($rs['Introduce'])&&file_exists($root.$rs['Introduce'])){
							unlink($root.$rs['Introduce']);
						}
					}
				}
				$sql_i="
					`Name`=?,
					`ImgUrl`=?,
					`Type`=?,
					`Number`=?,
					`Price`=?,
					`Introduce`=?
				";
				$insidevalues=array(
					$request_data['Update']['Name'],
					$request_data['Update']['ImgUrl'],
					$request_data['Update']['Type'],
					$request_data['Update']['Number'],
					$request_data['Update']['Price'],
					$request_data['Update']['Introduce']
				);
				break;
			}
			default:
				$myecho['Error']="请求格式错误";
				https(422);
				echo json_encode($myecho);
				exit();
				break;
		}
		$sql=$sql_f.$sql_i." WHERE ".$sql_b;
		$mypdo->prepare($sql);
		$theLastValues=array();
		foreach ($insidevalues as $key => $value) {
			$theLastValues[]=$value;
		}
		foreach ($wherevalues as $key => $value) {
			$theLastValues[]=$value;
		}
		if(!$mypdo->executeArr($theLastValues)){
			$myecho['Error']="系统错误";
			https(500);
			echo json_encode($myecho);
			exit();
		}
		$myecho['Id']=$request_data['Id'];
		https(201);
		echo json_encode($myecho);
	}
	function toGet($request_data){
		$myecho=array();
		$mypdo=new MySqlPDO();
		$mypdo_temp=new MySqlPDO();
		if(!isset($request_data['Type'])||!isset($request_data['Search'])||!isset($request_data['Keys'])){
			$myecho['Error']="请求格式错误";
			https(422);
			echo json_encode($myecho);
			exit();
		}
		$sql_f="SELECT * FROM `os_goods` WHERE ";
		$sql_c="SELECT count(*) AS `AllNumber` FROM `os_goods` WHERE ";
		$sql_b="";
		$wherevalues=array();
		switch ($request_data['Type']) {
			case '0':{
				if(isset($request_data['Search']['Id'])&&!empty($request_data['Search']['Id'])){
					$Ids=explode('+', $request_data['Search']['Id']);
					$sql_b="`Id` IN (";
					foreach ($Ids as $key => $value) {
						$sql_b.="?,";
						$wherevalues[]=$value;
					}
					$sql_b=substr($sql_b,0,strlen($sql_b)-1);
					$sql_b.=")";
				}else{
					$sql_b="1=1";
				}
				break;
			}
			case '1':{
				if($_SESSION['type']=='user'){
					if(isset($request_data['Search']['Name'])&&isset($request_data['Search']['Type'])){
						$sql_b="`Name` LIKE ?";
						$wherevalues[]='%'.$request_data['Search']['Name'].'%';
						if($request_data['Search']['Type']!=''){
							$sql_b.=" AND `Type`=?";
							$wherevalues[]=$request_data['Search']['Type'];
						}
						$sql_b.=" AND `UserId`=?";
						$wherevalues[]=$_SESSION['id'];
					}else{
						https(402);
						echo json_encode(array('Error'=>"格式错误"));
						exit();
					}
				}else{
					https(401);
					echo json_encode(array('Error'=>"请使用普通账号登录"));
					exit();
				}
				break;
			}
			case '2':{
				if(/*$_SESSION['type']=='admin'*/true){
					if(isset($request_data['Search']['Name'])&&isset($request_data['Search']['Type'])&&isset($request_data['Search']['Id'])){
						$sql_b="`Name` LIKE ?";
						$wherevalues[]='%'.$request_data['Search']['Name'].'%';
						if($request_data['Search']['Type']!=''){
							$sql_b.=" AND `Type`=?";
							$wherevalues[]=$request_data['Search']['Type'];
						}
						if($request_data['Search']['Id']!=''){
							$sql_b.=" AND `Id`=?";
							$wherevalues[]=$request_data['Search']['Id'];
						}
					}else{
						https(402);
						echo json_encode(array('Error'=>"格式错误"));
						exit();
					}
				}else{
					https(401);
					echo json_encode(array('Error'=>"请使用管理员账号登录"));
					exit();
				}
				break;
			}
			default:
				$myecho['Error']="请求格式错误";
				https(422);
				echo json_encode($myecho);
				exit();
				break;
		}
		$sql=$sql_c.$sql_b;
		$mypdo->prepare($sql);
		if(!$mypdo->executeArr($wherevalues)){
			$myecho['Error']="系统错误";
			https(500);
			echo json_encode($myecho);
			exit();
		}else{
			$rs=$mypdo->fetch();
			$myecho['Total']=$rs['AllNumber'];
		}
		if(isset($request_data['Page'])&&isset($request_data['PageSize'])){
			if(is_numeric($request_data['Page'])&&is_numeric($request_data['PageSize'])){
				$sql_b.=" LIMIT ".$request_data['PageSize'] * ($request_data['Page'] - 1).",".$request_data['PageSize'];
			}
		}
		$sql=$sql_f.$sql_b;
		$mypdo->prepare($sql);
		if(!$mypdo->executeArr($wherevalues)){
			$myecho['Error']="系统错误";
			https(500);
			echo json_encode($myecho);
			exit();
		}else{
			$myecho['ResultList']=array();
			if(empty($request_data['Keys'])){
				$attrs=array(
					'Id',
				    'ImgUrl',
				    'Name',
				    'UserId',
				    'Type',
				    'Number',
				    'Price',
				    'Introduce',
				    'Good',
				    'Middle',
				    'Bad',
				    'UserName'
				);
			}else{
				$attrs=explode('+', $request_data['Keys']);
			}
			  //按分隔符把字符串打散为数组
			$arr_UserName=array();
			while ($rs=$mypdo->fetch()) {
				$temp=array();
				foreach ($attrs as $key => $value) {
					if($value=='Introduce'){
						if(!empty($rs[$value])&&file_exists($_SERVER['DOCUMENT_ROOT'].$rs[$value])){
							$temp[$value]=file_get_contents($_SERVER['DOCUMENT_ROOT'].$rs[$value]);
						}else{
							$temp[$value]='';
						}
					}else if($value=='Good'){
						$sql='SELECT count(*) AS `Number` FROM `os_order` WHERE `GoodsId`=? AND `CustomerEvaluate`= 0';
						$mypdo_temp->prepare($sql);
						if($mypdo_temp->executeArr(array($rs['Id']))){
							if($rs_temp=$mypdo_temp->fetch()){
								$temp[$value]=$rs_temp['Number'];
							}else{
								$temp[$value]='-';
							}
						}else{
							$temp[$value]='-';
						}
					}else if($value=='Middle'){
						$sql='SELECT count(*) AS `Number` FROM `os_order` WHERE `GoodsId`=? AND `CustomerEvaluate`= 1';
						$mypdo_temp->prepare($sql);
						if($mypdo_temp->executeArr(array($rs['Id']))){
							if($rs_temp=$mypdo_temp->fetch()){
								$temp[$value]=$rs_temp['Number'];
							}else{
								$temp[$value]='-';
							}
						}else{
							$temp[$value]='-';
						}
					}else if($value=='Bad'){
						$sql='SELECT count(*) AS `Number` FROM `os_order` WHERE `GoodsId`=? AND `CustomerEvaluate`= 2';
						$mypdo_temp->prepare($sql);
						if($mypdo_temp->executeArr(array($rs['Id']))){
							if($rs_temp=$mypdo_temp->fetch()){
								$temp[$value]=$rs_temp['Number'];
							}else{
								$temp[$value]='-';
							}
						}else{
							$temp[$value]='-';
						}
					}else if($value=='UserName'){
						if(isset($arr_UserName[$rs['UserId']])){
							$temp[$value]=$arr_UserName[$rs['UserId']];
						}else{
							$sql_temp="SELECT `Name` FROM `os_user` Where `Id`=?";
							$mypdo_temp->prepare($sql_temp);
							$mypdo_temp->executeArr(array($rs['UserId']));
							if($rs_dd=$mypdo_temp->fetch()){
								$temp[$value]=$rs_dd['Name'];
								$arr_UserName[$rs['UserId']]=$rs_dd['Name'];
								/*$arr_UserPhone[$rs['UserId']]=$rs_dd['Phone'];
								$sql_temp='SELECT `Name` FROM `os_school` WHERE `Id`=?';
								$mypdo_temp->prepare($sql_temp);
								if($mypdo_temp->executeArr(array($rs_dd['SchoolId']))){
									if($rs_dt=$mypdo_temp->fetch()){
										$arr_UserSchool[$rs['UserId']]=$rs_dt['Name'];
									}
								}*/
							}else{
								$temp[$value]="";
							}
						}
					}else if(array_key_exists($value, $rs)){
						$temp[$value]=$rs[$value];
					}
				}
				$myecho['ResultList'][]=$temp;
			}
		}
		https(200);
		echo json_encode($myecho);
	}
?>