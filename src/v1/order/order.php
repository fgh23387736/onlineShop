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
			if($_SESSION['type']!='admin'){
				https(401);
				echo json_encode(array('Error' => "您不具有权限操作请用管理员账号登录"));
	    		exit();
			}else{
				toDelete($request_data);
			}
			break;
		case 'PUT':
			if($_SESSION['type']!='user'){
				https(401);
				echo json_encode(array('Error' => "您不具有权限操作请用普通用户账号登录"));
	    		exit();
			}else{
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
		$sql="SELECT `Price`,`Number`,`UserId` FROM `os_goods` WHERE `Id`=?";
		$mypdo->prepare($sql);
		$price=0;
		if($mypdo->executeArr(array($request_data['GoodsId']))){
			if($rs=$mypdo->fetch()){
				$price=$rs['Price'];
				if($rs['UserId']==$_SESSION['id']){
					$myecho['Error']="您无法购买自己的商品！";
					https(400);
					echo json_encode($myecho);
					exit();
				}
				if($rs['Number']<$request_data['Number']){
					$myecho['Error']="下单失败，货物不足";
					https(400);
					echo json_encode($myecho);
					exit();
				}
			}else{
				$myecho['Error']="增加失败,货物不存在";
				https(400);
				echo json_encode($myecho);
				exit();
			}
		}else{
			$myecho['Error']="增加失败,货物不存在";
			https(400);
			echo json_encode($myecho);
			exit();
		}
		$sql='INSERT INTO `os_order`
			(
				`UserId`,
				`GoodsId`,
				`Type`,
				`Number`,
				`Price`,
				`CustomerEvaluate`,
				`BusinessmanEvaluate`,
				`Time`
			) VALUES (
				?,?,?,?,?,?,?,?
			)';
		$mypdo->prepare($sql);
		$myarr=array(
			$_SESSION['id'],
			$request_data['GoodsId'],
			0,
			$request_data['Number'],
			$price*$request_data['Number'],
			null,
			null,
			date("Y-m-d H:i:s")
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
		$sql_f="DELETE FROM `os_order` WHERE ";
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
					$wherevalues[]=$_SESSION['id'];
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
		$mypdo_temp=new MySqlPDO();
		//print_r($request_data);
		if(!isset($request_data['Type'])||!isset($request_data['Update'])||!isset($request_data['Id'])){
			https(442);
			$myecho['Error']='请求格式错误1';
			echo json_encode($myecho);
			exit();
		}
		$sql_f="UPDATE `os_order` SET ";
		$sql_i="";
		$insidevalues=array();
		$wherevalues=array();
		$Ids=explode('+', $request_data['Id']);
		$sql_b="`os_order`.`Id` IN (";
		foreach ($Ids as $key => $value) {
			$sql_b.="?,";
			$wherevalues[]=$value;
		}
		$sql_b=substr($sql_b, 0,strlen($sql_b)-1);
		$sql_b.=") AND (`os_order`.`UserId`=? OR `os_order`.`GoodsId` IN (SELECT `os_goods`.`Id` FROM `os_goods` WHERE `os_goods`.`UserId`=?))";
		$wherevalues[]=$_SESSION['id'];
		$wherevalues[]=$_SESSION['id'];
		switch ($request_data['Type']) {
			case '0':{
				if($request_data['Update']['Type']>=0&&$request_data['Update']['Type']<=5){
					$sql_i="
						`os_order`.`Type`=?
					";
					$insidevalues=array(
						$request_data['Update']['Type']
					);
				}else{
					https(401);
					echo json_encode(array('Error' => "您不具有权限修改"));
		    		exit();
				}
				break;
			}
			case '1':{
				$sql_i="
					`CustomerEvaluate`=?,
					`CustomerEvaluateText`=?,
					`Type`=?
				";
				$insidevalues=array(
					$request_data['Update']['CustomerEvaluate'],
					htmlspecialchars($request_data['Update']['CustomerEvaluateText']),
					5
				);

				$sql="SELECT `Number`,`GoodsId` FROM `os_order` WHERE ".$sql_b;
				$mypdo->prepare($sql);
				if($mypdo->executeArr($wherevalues)){
					while ($rs=$mypdo->fetch()) {
						$sql_temp="UPDATE `os_goods` SET `Number`=`Number`-? WHERE `Id` = ?";
						$mypdo_temp->prepare($sql_temp);
						if($mypdo_temp->executeArr(array($rs['Number'],$rs['GoodsId']))){

						}else{
							$myecho['Error']="系统错误";
							https(500);
							echo json_encode($myecho);
							exit();
						}
					}
				}
				


				break;
			}
			case '2':{
				$sql_i="
					`BusinessmanEvaluate`=?,
					`BusinessmanEvaluateText`=?
				";
				$insidevalues=array(
					$request_data['Update']['BusinessmanEvaluate'],
					$request_data['Update']['BusinessmanEvaluateText']
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
		$sql_f="SELECT * FROM `os_order` WHERE ";
		$sql_c="SELECT count(*) AS `AllNumber` FROM `os_order` WHERE ";
		$sql_b="";
		$wherevalues=array();
		switch ($request_data['Type']) {
			case '0':{
				if(isset($request_data['Search']['Id'])&&!empty($request_data['Search']['Id'])){
					$Ids=explode('+', $request_data['Search']['Id']);
					$sql_b="`os_order`.`Id` IN (";
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
				if(!isset($_SESSION['type'])){
					https(401);
					echo json_encode(array('Error'=>"您还未登录"));
					exit();
				}
				if(isset($request_data['Search']['Type'])&&!empty($request_data['Search']['Type'])||$request_data['Search']['Type']==0){
					$Types=explode('+', $request_data['Search']['Type']);
					$sql_b="`os_order`.`Type` IN (";
					foreach ($Types as $key => $value) {
						$sql_b.="?,";
						$wherevalues[]=$value;
					}
					$sql_b=substr($sql_b,0,strlen($sql_b)-1);
					$sql_b.=") AND `os_order`.`GoodsId` IN (SELECT `os_goods`.`Id` FROM `os_goods` WHERE `os_goods`.`UserId`=?)";
					$wherevalues[]=$_SESSION['id'];
				}else{
					$sql_b="`os_order`.`GoodsId` IN (SELECT `os_goods`.`Id` FROM `os_goods` WHERE `os_goods`.`UserId`=?)";
					$wherevalues[]=$_SESSION['id'];
				}
				if(isset($request_data['Search']['GoodsId'])&&!empty($request_data['Search']['GoodsId'])){
					$sql_b.=' AND `os_order`.`GoodsId`=?';
					$wherevalues[]=$request_data['Search']['GoodsId'];
				}
				break;
			}
			case '2':{
				if(!isset($_SESSION['type'])){
					https(401);
					echo json_encode(array('Error'=>"您还未登录"));
					exit();
				}
				if(isset($request_data['Search']['Type'])&&!empty($request_data['Search']['Type'])||$request_data['Search']['Type']==0){
					$Types=explode('+', $request_data['Search']['Type']);
					$sql_b="`os_order`.`Type` IN (";
					foreach ($Types as $key => $value) {
						$sql_b.="?,";
						$wherevalues[]=$value;
					}
					$sql_b=substr($sql_b,0,strlen($sql_b)-1);
					$sql_b.=") AND `os_order`.`UserId` = ?";
					$wherevalues[]=$_SESSION['id'];
				}else{
					$sql_b="`os_order`.`UserId` = ?";
					$wherevalues[]=$_SESSION['id'];
				}
				if(isset($request_data['Search']['GoodsId'])&&!empty($request_data['Search']['GoodsId'])){
					$sql_b.=' AND `os_order`.`GoodsId`=?';
					$wherevalues[]=$request_data['Search']['GoodsId'];
				}
				break;
			}
			case '3':{
				if(isset($request_data['Search']['GoodsId'])&&!empty($request_data['Search']['GoodsId'])){
					$sql_b='`Type`=5 AND `os_order`.`GoodsId`=?';
					$wherevalues[]=$request_data['Search']['GoodsId'];
				}else{
					$myecho['Error']="请求格式错误";
					https(422);
					echo json_encode($myecho);
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
				    'UserId',
				    'GoodsId',
				    'GoodsName',
				    'UserName',
				    'UserPhone',
				    'UserImgUrl',
				    'UserSchool',
				    'Number',
				    'Price',
				    'Type',
				    'CustomerEvaluate',
				    'CustomerEvaluateText',
				    'BusinessmanEvaluate',
				    'BusinessmanEvaluateText',
				    'Time'
				);
			}else{
				$attrs=explode('+', $request_data['Keys']);
			}
			  //按分隔符把字符串打散为数组
			$arr_Province=array();
			$arr_City=array();
			$arr_School=array();
			$arr_GoodsName=array();
			$arr_UserName=array();
			$arr_UserPhone=array();
			$arr_UserImgUrl=array();
			$arr_UserSchool=array();
			while ($rs=$mypdo->fetch()) {
				$temp=array();
				foreach ($attrs as $key => $value) {
					if($value=='GoodsName'){
						if(isset($arr_GoodsName[$rs['GoodsId']])){
							$temp[$value]=$arr_GoodsName[$rs['GoodsId']];
						}else{
							$sql_temp="SELECT `Name` FROM `os_goods` Where `Id`=?";
							$mypdo_temp->prepare($sql_temp);
							$mypdo_temp->executeArr(array($rs['GoodsId']));
							if($rs_dd=$mypdo_temp->fetch()){
								$temp[$value]=$rs_dd['Name'];
								$arr_GoodsName[$rs['GoodsId']]=$rs_dd['Name'];
							}else{
								$temp[$value]="";
							}
						}
					}else if($value=='UserName'){
						if(isset($arr_UserName[$rs['UserId']])){
							$temp[$value]=$arr_UserName[$rs['UserId']];
						}else{
							$sql_temp="SELECT `Name`,`Phone`,`SchoolId`,`HeadImgUrl` FROM `os_user` Where `Id`=?";
							$mypdo_temp->prepare($sql_temp);
							$mypdo_temp->executeArr(array($rs['UserId']));
							if($rs_dd=$mypdo_temp->fetch()){
								$temp[$value]=$rs_dd['Name'];
								$arr_UserName[$rs['UserId']]=$rs_dd['Name'];
								$arr_UserPhone[$rs['UserId']]=$rs_dd['Phone'];
								$arr_UserImgUrl[$rs['UserId']]=$rs_dd['HeadImgUrl'];
								$sql_temp='SELECT `Name` FROM `os_school` WHERE `Id`=?';
								$mypdo_temp->prepare($sql_temp);
								if($mypdo_temp->executeArr(array($rs_dd['SchoolId']))){
									if($rs_dt=$mypdo_temp->fetch()){
										$arr_UserSchool[$rs['UserId']]=$rs_dt['Name'];
									}
								}
							}else{
								$temp[$value]="";
							}
						}
					}else if($value=='UserPhone'){
						if(isset($arr_UserPhone[$rs['UserId']])){
							$temp[$value]=$arr_UserPhone[$rs['UserId']];
						}else{
							$sql_temp="SELECT `Name`,`Phone`,`SchoolId`,`HeadImgUrl` FROM `os_user` Where `Id`=?";
							$mypdo_temp->prepare($sql_temp);
							$mypdo_temp->executeArr(array($rs['UserId']));
							if($rs_dd=$mypdo_temp->fetch()){
								$temp[$value]=$rs_dd['Phone'];
								$arr_UserName[$rs['UserId']]=$rs_dd['Name'];
								$arr_UserPhone[$rs['UserId']]=$rs_dd['Phone'];
								$arr_UserImgUrl[$rs['UserId']]=$rs_dd['HeadImgUrl'];
								$sql_temp='SELECT `Name` FROM `os_school` WHERE `Id`=?';
								$mypdo_temp->prepare($sql_temp);
								if($mypdo_temp->executeArr(array($rs_dd['SchoolId']))){
									if($rs_dt=$mypdo_temp->fetch()){
										$arr_UserSchool[$rs['UserId']]=$rs_dt['Name'];
									}
								}
							}else{
								$temp[$value]="";
							}
						}
					}else if($value=='UserImgUrl'){
						if(isset($arr_UserImgUrl[$rs['UserId']])){
							$temp[$value]=$arr_UserImgUrl[$rs['UserId']];
						}else{
							$sql_temp="SELECT `Name`,`Phone`,`SchoolId`,`HeadImgUrl` FROM `os_user` Where `Id`=?";
							$mypdo_temp->prepare($sql_temp);
							$mypdo_temp->executeArr(array($rs['UserId']));
							if($rs_dd=$mypdo_temp->fetch()){
								$temp[$value]=$rs_dd['HeadImgUrl'];
								$arr_UserName[$rs['UserId']]=$rs_dd['Name'];
								$arr_UserPhone[$rs['UserId']]=$rs_dd['Phone'];
								$arr_UserImgUrl[$rs['UserId']]=$rs_dd['HeadImgUrl'];
								$sql_temp='SELECT `Name` FROM `os_school` WHERE `Id`=?';
								$mypdo_temp->prepare($sql_temp);
								if($mypdo_temp->executeArr(array($rs_dd['SchoolId']))){
									if($rs_dt=$mypdo_temp->fetch()){
										$arr_UserSchool[$rs['UserId']]=$rs_dt['Name'];
									}
								}
							}else{
								$temp[$value]="";
							}
						}
					}else if($value=='UserSchool'){
						if(isset($arr_UserSchool[$rs['UserId']])){
							$temp[$value]=$arr_UserSchool[$rs['UserId']];
						}else{
							$sql_temp="SELECT `Name`,`Phone`,`SchoolId`,`HeadImgUrl` FROM `os_user` Where `Id`=?";
							$mypdo_temp->prepare($sql_temp);
							$mypdo_temp->executeArr(array($rs['UserId']));
							if($rs_dd=$mypdo_temp->fetch()){
								$arr_UserName[$rs['UserId']]=$rs_dd['Name'];
								$arr_UserPhone[$rs['UserId']]=$rs_dd['Phone'];
								$arr_UserImgUrl[$rs['UserId']]=$rs_dd['HeadImgUrl'];
								$sql_temp='SELECT `Name` FROM `os_school` WHERE `Id`=?';
								$mypdo_temp->prepare($sql_temp);
								if($mypdo_temp->executeArr(array($rs_dd['SchoolId']))){
									if($rs_dt=$mypdo_temp->fetch()){
										$arr_UserSchool[$rs['UserId']]=$rs_dt['Name'];
										$temp[$value]=$rs_dt['Name'];
									}else{
										$temp[$value]="";
									}
								}else{
									$temp[$value]="";
								}
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