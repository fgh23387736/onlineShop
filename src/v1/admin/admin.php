<?php
	session_start();
	/*用户登录后会自动写入session
	*$_SESSION['type']='user|admin';
	*$_SESSION['id']=1;
	*/
	/*$_SESSION['type']='admin';
	$_SESSION['id']=1;*/
	include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/src/MySqlPDO.class.php';
	include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/src/Imgs.class.php';
	include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/src/request.php';
	include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/src/https.php';
	include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/src/public_functions.php';
	switch ($request_method) {
		case 'POST':
			if($_SESSION['type']!='admin'){
				https(401);
				echo json_encode(array('Error' => "您不具有权限操作请用管理员账号登录"));
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
			if($_SESSION['type']!='admin'){
				https(401);
				echo json_encode(array('Error' => "您不具有权限操作请用管理员账号登录"));
	    		exit();
			}else{
				if($request_data['Id']==''){
					$request_data['Id']=$_SESSION['id'];
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
		$request_data['HeadImgUrl']=$imgs->saveBase64toImg('/onlineShop/uploaddate/admins/headimg',$request_data['HeadImgUrl']);
		$sql='INSERT INTO `os_admin`
			(
				`HeadImgUrl`
				`Password`,
				`Name`,
				`Sex`,
				`Phone`
			) VALUES (
				?,?,?,?,?,?
			)';
		$mypdo->prepare($sql);
		$myarr=array(
			$request_data['HeadImgUrl'],
			$request_data['Password'],
			$request_data['Name'],
			$request_data['Sex'],
			$request_data['Phone'],
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
		$sql_f="DELETE FROM `os_admin` WHERE ";
		$sql_b="";
		$wherevalues=array();
		switch ($request_data['Type']) {
			case '0':{
				$Ids=explode('+', $request_data['Search']['Id']);
				$sql_b="`Id` in (";
				foreach ($Ids as $key => $value) {
					$sql_b.="?,";
					$wherevalues[]=$value;
				}
				$sql_b=substr($sql_b,0,strlen($sql_b)-1);
				$sql_b.=")";
				break;
			}
			default:
				$myecho['Error']="请求格式错误";
				https(422);
				echo json_encode($myecho);
				exit();
				break;
		}
		$sql="SELECT `HeadImgUrl` FROM `os_admin` WHERE ".$sql_b;
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
		if(!isset($request_data['Type'])||!isset($request_data['Update'])||!isset($request_data['Id'])){
			$myecho['Error']="请求格式错误";
			https(422);
			echo json_encode($myecho);
			exit();
		}
		$sql_f="UPDATE `os_admin` SET ";
		$sql_i="";
		$insidevalues=array();
		$wherevalues=array();
		$Ids=explode('+', $request_data['Id']);
		$sql_b="`Id` IN (";
		foreach ($Ids as $key => $value) {
			$sql_b.="?,";
			$wherevalues[]=$value;
		}
		$sql_b=substr($sql_b,0,strlen($sql_b)-1);
		$sql_b.=")";
		switch ($request_data['Type']) {
			case '0':{
				if(count($Ids)!=1){
					$myecho['Error']="请求格式错误";
					https(422);
					echo json_encode($myecho);
					exit();
				}
				if(substr($request_data['Update']['HeadImgUrl'],0,4)=='data'){
						$request_data['Update']['HeadImgUrl']=$imgs->saveBase64toImg('/onlineShop/uploaddate/admins/headimg',$request_data['Update']['HeadImgUrl']);
					}
				$sql="SELECT `HeadImgUrl` FROM `os_admin` WHERE ".$sql_b;
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
					`HeadImgUrl`=?,
					`Name`=?,
					`Sex`=?
				";
				$insidevalues=array(
					$request_data['Update']['HeadImgUrl'],
					$request_data['Update']['Name'],
					$request_data['Update']['Sex']
				);
				break;
			}
			case '1':{
				if(count($Ids)!=1){
					$myecho['Error']="请求格式错误2";
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
						$sql_temp="SELECT `Password` FROM `os_admin` WHERE `Id`=?";
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
		$sql_f="SELECT * FROM `os_admin` WHERE ";
		$sql_c="SELECT count(*) AS `AllNumber` FROM `os_admin` WHERE ";
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
				    'HeadImgUrl',
				    'Username',
				    'Name',
				    'Sex',
				    'Phone',
				);
			}else{
				$attrs=explode('+', $request_data['Keys']);
			}
			while ($rs=$mypdo->fetch()) {
				$temp=array();
				foreach ($attrs as $key => $value) {
					$temp[$value]=$rs[$value];
				}
				$myecho['ResultList'][]=$temp;
			}
		}
		https(200);
		echo json_encode($myecho);
	}
?>