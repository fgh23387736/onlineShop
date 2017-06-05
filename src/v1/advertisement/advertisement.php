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
			https(402);
			echo json_encode(array('Error' => "不提供修改接口"));
    		exit();
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
		$request_data['ImgUrl']=$imgs->saveBase64toImg('/onlineShop/uploaddate/advertisement/photos',$request_data['ImgUrl']);
		$sql='INSERT INTO `os_advertisement`
			(
				`ImgUrl`,
				`Url`
			) VALUES (
				?,?
			)';
		$mypdo->prepare($sql);
		$myarr=array(
			$request_data['ImgUrl'],
			$request_data['Url']
		);
		if($mypdo->executeArr($myarr)){
			$myecho['Id']=$mypdo->lastInsertId();
		}else{
			if(file_exists($root.$request_data['Url'])){
				unlink($root.$request_data['Url']);
			}
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
		$sql_f="DELETE FROM `os_advertisement` WHERE ";
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
			break;
			default:
				$myecho['Error']="请求格式错误";
				https(422);
				echo json_encode($myecho);
				exit();
				break;
		}
		$sql="SELECT `ImgUrl` FROM `os_advertisement` WHERE ".$sql_b;
		$mypdo->prepare($sql);
		if(!$mypdo->executeArr($wherevalues)){
			$myecho['Error']="系统错误";
			https(500);
			echo json_encode($myecho);
			exit();
		}else{
			$root=$_SERVER['DOCUMENT_ROOT'];
			while ($rs=$mypdo->fetch()) {
				if(file_exists($root.$rs['ImgUrl'])){
					unlink($root.$rs['ImgUrl']);
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
		$sql_f="SELECT * FROM `os_advertisement` WHERE ";
		$sql_c="SELECT count(*) AS `AllNumber` FROM `os_advertisement` WHERE ";
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
				    'ImgUrl',
				    'Url'
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
					if(array_key_exists($value, $rs)){
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