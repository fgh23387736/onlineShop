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
			toPost($request_data);
			break;
		case 'DELETE':
			if($_SESSION['type']!='admin'){
				https(401);
				echo json_encode(array('Error' => "您不具有权限操作请用管理员账号登录"));
	    		exit();
			}else{
				toDelete($request_data);
			}
			break;
		case 'PUT':
			if(!isset($_SESSION['type'])){
				https(401);
				echo json_encode(array('Error' => "您还未登录"));
	    		exit();
			}else{
				if($request_data['Id']==''){
					if($_SESSION['type']=='user'){
						$request_data['Id']=$_SESSION['id'];
					}else{
						https(401);
						echo json_encode(array('Error' => "您不具有权限操作请用普通账号登录"));
			    		exit();
					}
				}
				toPut($request_data);
			}
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
		$sql="SELECT `Id` FROM `os_user` WHERE `Phone`=?";
		$mypdo->prepare($sql);
		if($mypdo->executeArr(array($request_data['Phone']))){
			if($rs=$mypdo->fetch()){
				$myecho['Error']="该手机已注册";
				https(400);
				echo json_encode($myecho);
				exit();
			}else{
				if($request_data['Password']!=$request_data['RepeatPassword']){
					$myecho['Error']="两次输入密码不一样";
					https(400);
					echo json_encode($myecho);
					exit();
				}
			}
		}else{
			https(500);
			echo json_encode(array('Error' => "系统错误"));
			exit();
		}
		$schoolIdTemp=1;
		$cityIdTemp=1;
		$provinceIdTemp=1;
		$sql="SELECT * FROM `os_school`";
		$mypdo->prepare($sql);
		if($mypdo->executeArr(array())){
			if($rs=$mypdo->fetch()){
				$schoolIdTemp=$rs['Id'];
				$cityIdTemp=$rs['CityId'];
				$sql="SELECT * FROM `os_city` WHERE `Id`=?";
				$mypdo->prepare($sql);
				if($mypdo->executeArr(array($cityIdTemp))){
					if($rs=$mypdo->fetch()){
						$provinceIdTemp=$rs['ProvinceId'];
					}else{
						https(500);
						echo json_encode(array('Error' => "系统错误"));
						exit();
					}
				}else{
					https(500);
					echo json_encode(array('Error' => "系统错误"));
					exit();
				}
			}else{
				https(500);
				echo json_encode(array('Error' => "系统错误"));
				exit();
			}
		}else{
			https(500);
			echo json_encode(array('Error' => "系统错误"));
			exit();
		}
		$request_data['HeadImgUrl']='';/*$imgs->saveBase64toImg('/onlineShop/uploaddate/users/headimg',$request_data['HeadImgUrl']);*/
		$request_data['Name']='无名氏';
		$request_data['Sex']=0;
		$sql='INSERT INTO `os_user`
			(
				`HeadImgUrl`,
				`Password`,
				`Name`,
				`Sex`,
				`Phone`,
				`ProvinceId`,
				`CityId`,
				`SchoolId`,
				`Good`,
				`Middle`,
				`Bad`,
				`Deadline`,
				`Time`
			) VALUES (
				?,?,?,?,?,?,?,?,?,?,?,?,?
			)';
		$mypdo->prepare($sql);
		$myarr=array(
			$request_data['HeadImgUrl'],
			$request_data['Password'],
			$request_data['Name'],
			$request_data['Sex'],
			$request_data['Phone'],
			$provinceIdTemp,
			$cityIdTemp,
			$schoolIdTemp,
			0,
			0,
			0,
			'2017-05-18 00:00:00',
			date("Y-m-d")
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
		if(!isset($request_data['Type'])||!isset($request_data['Search'])){
			$myecho['Error']="请求格式错误";
			https(422);
			echo json_encode($myecho);
			exit();
		}
		$sql_f="DELETE FROM `os_user` WHERE ";
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
					$sql_b.=")";
				}else{
					$myecho['Error']="请求格式错误";
					https(422);
					echo json_encode($myecho);
					exit();
				}
			}
			default:
				$myecho['Error']="请求格式错误";
				https(422);
				echo json_encode($myecho);
				exit();
				break;
		}
		$sql="SELECT `HeadImgUrl` FROM `os_user` WHERE ".$sql_b;
		$mypdo->prepare($sql);
		if(!$mypdo->executeArr($wherevalues)){
			$myecho['Error']="系统错误";
			https(500);
			echo json_encode($myecho);
			exit();
		}else{
			$root=$_SERVER['DOCUMENT_ROOT'];
			while ($rs=$mypdo->fetch()) {
				if(file_exists($root.$rs['HeadImgUrl'])){
					unlink($root.$rs['HeadImgUrl']);
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
		$sql_f="UPDATE `os_user` SET ";
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
				if(substr($request_data['Update']['HeadImgUrl'],0, 4)=='data'){
					$request_data['Update']['HeadImgUrl']=$imgs->saveBase64toImg('/onlineShop/uploaddate/users/headimg',$request_data['Update']['HeadImgUrl']);
				}
				$sql="SELECT `HeadImgUrl` FROM `os_user` WHERE ".$sql_b;
				$mypdo->prepare($sql);
				if(!$mypdo->executeArr($wherevalues)){
					$myecho['Error']="系统错误";
					https(500);
					echo json_encode($myecho);
					exit();
				}else{
					$root=$_SERVER['DOCUMENT_ROOT'];
					while ($rs=$mypdo->fetch()) {
						if(file_exists($root.$rs['HeadImgUrl'])&&$rs['HeadImgUrl']!=$request_data['Update']['HeadImgUrl']){
							unlink($root.$rs['HeadImgUrl']);
						}
					}
				}
				$sql_i="
					`Name`=?,
					`HeadImgUrl`=?,
					`Sex`=?,
					`ProvinceId`=?,
					`CityId`=?,
					`SchoolId`=?
				";
				$insidevalues=array(
					$request_data['Update']['Name'],
					$request_data['Update']['HeadImgUrl'],
					$request_data['Update']['Sex'],
					$request_data['Update']['ProvinceId'],
					$request_data['Update']['CityId'],
					$request_data['Update']['SchoolId']
				);
				break;
			}	
			case '1':{
				foreach ($request_data['Update'] as $key => $value) {
					if ($value=="") {
						$request_data['Update'][$key]=null;
					}
				}
				$sql_i="
					`Deadline`=?
				";
				$insidevalues=array(
					$request_data['Update']['Deadline']
				);
				break;
			}
			case '2':{
				if(count($Ids)!=1){
					$myecho['Error']="请求格式错误";
					https(422);
					echo json_encode($myecho);
					exit();
				}
				if($_SESSION['id']!=$Ids[0]){
					https(401);
					echo json_encode(array('Error' => "您不具有权限操作"));
		    		exit();
				}
				if(isset($request_data['Update']['Password'])&&isset($request_data['Update']['NewPassword'])&&isset($request_data['Update']['RepeatNewPassword'])){
					if($request_data['Update']['NewPassword']==$request_data['Update']['RepeatNewPassword']){
						$sql_temp="SELECT `Password` FROM `os_user` WHERE `Id`=?";
						$mypdo->prepare($sql_temp);
						if($mypdo->executeArr(array($_SESSION['id']))){
							if($rs=$mypdo->fetch()){
								if(md5($rs['Password'])!=$request_data['Update']['Password']){
									https(404);
									echo json_encode(array('Error' => "原密码错误"));
						    		exit();
								}
							}else{
								https(404);
								echo json_encode(array('Error' => "当前用户不存在"));
					    		exit();
							}
						}else{
							$myecho['Error']="系统错误";
							https(500);
							echo json_encode($myecho);
							exit();
						}
					}else{
						$myecho['Error']="两次输入新密码不一样";
						https(422);
						echo json_encode($myecho);
						exit();
					}
				}else{
					$myecho['Error']="请求格式错误";
					https(422);
					echo json_encode($myecho);
					exit();
				}
				$sql_i="
					`Password`=?
				";
				$insidevalues=array(
					$request_data['Update']['NewPassword']
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
		$sql_f="SELECT * FROM `os_user` WHERE ";
		$sql_c="SELECT count(*) AS `AllNumber` FROM `os_user` WHERE ";
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
					if($_SESSION['type']!='user'){
						https(401);
						echo json_encode(array('Error'=>"请使用普通账号登录"));
						exit();
					}else{
						$sql_b="`Id`=?";
						$wherevalues[]=$_SESSION['id'];
					}
					
					
				}
				break;
			}
			case '1':{

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
					$sql_b='1=1';
				}
				if(isset($request_data['Search']['Name'])){
					$sql_b.=' AND `Name` LIKE ?';
					$wherevalues[]='%'.$request_data['Search']['Name'].'%';
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
				    'Name',
				    'HeadImgUrl',
				    'Sex',
				    'Birthday',
				    'ProvinceId',
				    'CityId',
				    'SchoolId',
				    'Province',
				    'City',
				    'School',
				    'Phone',
				    'Password',
				    'Good',
				    'Middle',
				    'Bad',
				    'GoodsNumber',
				    'PurchasedGoodsNumber',
				    'SoldGoodsNubmer',
				    'OrderNubmerILSD',
				    'PurchasedGoodsNumberILSD',
				    'Deadline'
				);
			}else{
				$attrs=explode('+', $request_data['Keys']);
			}
			  //按分隔符把字符串打散为数组
			$arr_Province=array();
			$arr_City=array();
			$arr_School=array();
			while ($rs=$mypdo->fetch()) {
				$temp=array();
				foreach ($attrs as $key => $value) {
					if($value=="Password"){
						$temp[$value]="密码能告诉你么！";
					}else if($value=="GoodsNumber"){
						$sql_temp="SELECT count(*) as `Number` FROM `os_goods` WHERE `UserId`=?";
						$mypdo_temp->prepare($sql_temp);
						if($mypdo_temp->executeArr(array($rs['Id']))){
							if($rs_temp=$mypdo_temp->fetch()){
								$temp[$value]=$rs_temp['Number'];
							}else{
								$temp[$value]=0;
							}
						}else{
							$temp[$value]=0;
						}
					}else if($value=="PurchasedGoodsNumber"){
						$sql_temp="SELECT count(*) as `Number` FROM `os_order` WHERE `UserId`=? AND `Type`=?";
						$mypdo_temp->prepare($sql_temp);
						if($mypdo_temp->executeArr(array($rs['Id'],5))){
							if($rs_temp=$mypdo_temp->fetch()){
								$temp[$value]=$rs_temp['Number'];
							}else{
								$temp[$value]=0;
							}
						}else{
							$temp[$value]=0;
						}
					}else if($value=="Good"){
						$sql_temp="SELECT count(*) as `Number` FROM `os_order` WHERE `GoodsId` IN (SELECT `Id` FROM `os_goods` WHERE `UserId`=?) AND `CustomerEvaluate`=?";
						$mypdo_temp->prepare($sql_temp);
						if($mypdo_temp->executeArr(array($rs['Id'],0))){
							if($rs_temp=$mypdo_temp->fetch()){
								$temp[$value]=$rs_temp['Number'];
							}else{
								$temp[$value]=0;
							}
						}else{
							$temp[$value]=0;
						}
					}else if($value=="Middle"){
						$sql_temp="SELECT count(*) as `Number` FROM `os_order` WHERE `GoodsId` IN (SELECT `Id` FROM `os_goods` WHERE `UserId`=?) AND `CustomerEvaluate`=?";
						$mypdo_temp->prepare($sql_temp);
						if($mypdo_temp->executeArr(array($rs['Id'],1))){
							if($rs_temp=$mypdo_temp->fetch()){
								$temp[$value]=$rs_temp['Number'];
							}else{
								$temp[$value]=0;
							}
						}else{
							$temp[$value]=0;
						}
					}else if($value=="Bad"){
						$sql_temp="SELECT count(*) as `Number` FROM `os_order` WHERE `GoodsId` IN (SELECT `Id` FROM `os_goods` WHERE `UserId`=?) AND `CustomerEvaluate`=?";
						$mypdo_temp->prepare($sql_temp);
						if($mypdo_temp->executeArr(array($rs['Id'],2))){
							if($rs_temp=$mypdo_temp->fetch()){
								$temp[$value]=$rs_temp['Number'];
							}else{
								$temp[$value]=0;
							}
						}else{
							$temp[$value]=0;
						}
					}else if($value=="SoldGoodsNubmer"){
						$sql_temp="SELECT count(*) as `Number` FROM `os_order` WHERE `GoodsId` IN (SELECT `Id` FROM `os_goods` WHERE `UserId`=?) AND `Type`=?";
						$mypdo_temp->prepare($sql_temp);
						if($mypdo_temp->executeArr(array($rs['Id'],5))){
							if($rs_temp=$mypdo_temp->fetch()){
								$temp[$value]=$rs_temp['Number'];
							}else{
								$temp[$value]=0;
							}
						}else{
							$temp[$value]=0;
						}
					}else if($value=="OrderNubmerILSD"){
						$sql_temp="SELECT count(*) as `Number` FROM `os_order` WHERE `os_order`.`GoodsId` IN (SELECT `os_goods`.`Id` FROM `os_goods` WHERE `os_goods`.`UserId`=?) AND DATE_FORMAT(`os_order`.`Time`,'%Y-%m-%d')=?";
						$mypdo_temp->prepare($sql_temp);
						$temp[$value]=array();
						for($i=6;$i>=0;$i--){
							if($mypdo_temp->executeArr(array($rs['Id'],date('Y-m-d',strtotime("-$i day"))))){
								if($rs_temp=$mypdo_temp->fetch()){
									$temp[$value][]=$rs_temp['Number'];
								}else{
									$temp[$value][]=0;
								}
							}else{
								$temp[$value][]=0;
							}
						}
						
					}else if($value=="PurchasedGoodsNumberILSD"){
						$sql_temp="SELECT count(*) as `Number` FROM `os_order` WHERE `UserId`=? AND `Type`=? AND DATE_FORMAT(`Time`,'%Y-%m-%d')=?";
						$mypdo_temp->prepare($sql_temp);
						$temp[$value]=array();
						for($i=6;$i>=0;$i--){
							if($mypdo_temp->executeArr(array($rs['Id'],5,date('Y-m-d',strtotime("-$i day"))))){
								if($rs_temp=$mypdo_temp->fetch()){
									$temp[$value][]=$rs_temp['Number'];
								}else{
									$temp[$value][]=0;
								}
							}else{
								$temp[$value][]=0;
							}
						}
						
					}else if($value=="Province"){
						if(isset($arr_Province[$rs['ProvinceId']])){
							$temp[$value]=$arr_Province[$rs['ProvinceId']];
						}else{
							$sql_temp="SELECT `Name` FROM `os_province` Where `Id`=?";
							$mypdo_temp->prepare($sql_temp);
							$mypdo_temp->executeArr(array($rs['ProvinceId']));
							if($rs_dd=$mypdo_temp->fetch()){
								$temp[$value]=$rs_dd['Name'];
								$arr_Province[$rs['ProvinceId']]=$rs_dd['Name'];
							}else{
								$temp[$value]="";
							}
						}
					}else if($value=="City"){
						if(isset($arr_City[$rs['CityId']])){
							$temp[$value]=$arr_City[$rs['CityId']];
						}else{
							$sql_temp="SELECT `Name` FROM `os_city` Where `Id`=?";
							$mypdo_temp->prepare($sql_temp);
							$mypdo_temp->executeArr(array($rs['CityId']));
							if($rs_dd=$mypdo_temp->fetch()){
								$temp[$value]=$rs_dd['Name'];
								$arr_City[$rs['CityId']]=$rs_dd['Name'];
							}else{
								$temp[$value]="";
							}
						}
					}else if($value=="School"){
						if(isset($arr_School[$rs['SchoolId']])){
							$temp[$value]=$arr_School[$rs['SchoolId']];
						}else{
							$sql_temp="SELECT `Name` FROM `os_school` Where `Id`=?";
							$mypdo_temp->prepare($sql_temp);
							$mypdo_temp->executeArr(array($rs['SchoolId']));
							if($rs_dd=$mypdo_temp->fetch()){
								$temp[$value]=$rs_dd['Name'];
								$arr_School[$rs['SchoolId']]=$rs_dd['Name'];
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