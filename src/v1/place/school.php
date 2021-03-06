<?php
	session_start();
		/**用户登录后会自动写入session
	*$_SESSION['type']='user|admin';
	*$_SESSION['id']=1;
	*/
	/*$_SESSION['type']='admin';
	// $_SESSION['id']=1;*/
	include $_SERVER['DOCUMENT_ROOT']."/".'onlineShop/src/MySqlPDO.class.php';
	include $_SERVER['DOCUMENT_ROOT']."/".'onlineShop/src/Imgs.class.php';
	include $_SERVER['DOCUMENT_ROOT']."/".'onlineShop/src/request.php';
	include $_SERVER['DOCUMENT_ROOT']."/".'onlineShop/src/https.php';
	include $_SERVER['DOCUMENT_ROOT']."/".'onlineShop/src/public_functions.php';

	switch($request_method){
		case 'POST':{
			if($_SESSION['type']!='admin'){
				https(401);
				echo json_encode(array('Error'=>"新不具有权限操作请用管理员登陆"));
			}else{
				toPost($request_data);
			}
			break;
		}
		case 'DELETE':{
			if($_SESSION['type']!='admin'){
				https(401);
				echo json_encode(array('Error'=>"新不具有权限操作请用管理员登陆"));
			}else{
				toDelete($request_data);
			}
			break;
		}
		case 'PUT':{
			if($_SESSION['type']!='admin'){
				https(401);
				echo json_encode(array('Error'=>"新不具有权限操作请用管理员登陆"));
			}else{
				toPut($request_data);
			}
			break;
		}
		case 'GET':{
			toGet($request_data);
			break;
		}
		default:
			https(500);
			echo json_encode(array('Error'=>"请求错误"));
			break;
	}

	//---------函数实现------
	function toPost($request_data){
		$myecho=array();
		$mypdo=new MySqlPDO();
		$sql="INSERT INTO `os_school`
		(
			`Name`,
			`CityId`
		)VALUES(
			?,?
		)";
		$myarr=array(
			$request_data['Name'],
			$request_data['CityId']
		);
		$mypdo->prepare($sql);
		if($mypdo->executeArr($myarr)){
			$myecho['Id']=$mypdo->lastInsertId();
		}
		else{
			$myecho['Error']="增加失败";
			https(400);
			echo json_encode($myecho);   
			exit();
		}
		placeFromMysqlToJson();
		https(201);
		echo json_encode($myecho);
	}

	function toDelete($request_data){
		$myecho=array();
		$mypdo=new MySqlPDO();
		if(!isset($request_data['Type'])||!isset($request_data['Search']))
		{
			$myecho['Error']="请求格式错误";
			https(422);
			echo json_encode($myecho);
			exit();
		}

		$sql_f="DELETE FROM `os_school` WHERE ";
		$wherevalues=array();
		switch($request_data['Type']){
			case '0':{
				$Ids=explode('+',$request_data['Search']['Id']);
				$sql_b="`Id` in (";
				foreach($Ids as $key => $value)
				{
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
		$sql=$sql_f.$sql_b;
		$mypdo->prepare($sql);
		$mypdo->prepare($sql);
		if(!$mypdo->executeArr($wherevalues)){
			$myecho['Error']="系统错误";
			https(500);
			echo json_encode($myecho);  
			exit();
		}
		placeFromMysqlToJson();
		https(204);
		echo json_encode($myecho);
	}

	function toPut($request_data){
		$myecho=array();
		$mypdo=new MySqlPDO();
		if(!isset($request_data['Type'])||!isset($request_data['Update'])||!isset($request_data['Id']))
		{
			$myecho['Error']="请求格式错误";
			https(422);
			echo json_encode($myecho);
			exit();
		}
		$sql_f="UPDATE `os_school` SET ";
		$sql_i="";
		$insidevalues=array();
		$wherevalues=array();
		$Ids=explode('+',$request_data['Id']);
		$sql_b="`Id` IN (";
		foreach ($Ids as $key => $value) {
			$sql_b.="?,";
			$wherevalues[]=$value;
		}
		$sql_b=substr($sql_b,0,strlen($sql_b)-1);
		$sql_b.=")";

		switch($request_data['Type']){
			case '0':{
				if(count($Ids)!=1){
					$myecho['Error']="请求格式错误";
					https(422);
					echo json_encode($myecho);
					exit();
				}
				$sql_i="
					`Name`=?,
					`CityId`=?
				";
				$insidevalues=array(
					$request_data['Update']['Name'],
					$request_data['Update']['CityId']
				);
				break;
			}
			case '1':{
				$sql_i="
					`CityId`=?
				";
				$insidevalues=array(
					$request_data['Update']['CityId']
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
		// print_r($wherevalues);
		foreach ($wherevalues as $key => $value) {
			$theLastValues[]=$value;
		}
		// echo "<br>";
		// echo $sql;
		// echo "<br>";
		print_r($theLastValues);
		if(!$mypdo->executeArr($theLastValues))
		{
			$myecho['Error']="系统错误";
			// echo "ssss";   bug
			https(500);
			echo json_encode($myecho);	
			exit();
		}
		placeFromMysqlToJson();
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
		$sql_f="SELECT * FROM `os_school` WHERE ";
		$sql_c="SELECT count(*) AS `ALLNumber` FROM `os_school` WHERE ";
		$sql_b="";
		$wherevalues=array();
		switch($request_data['Type']){
			case '0':{
				if(isset($request_data['Search']['Id'])&&!empty($request_data['Search']['Id']))
				{
					$Ids=explode('+', $request_data['Search']['Id']);
					$sql_b="`Id` IN (";
					foreach ($Ids as $key => $value) {
						$sql_b.="?,";
						$wherevalues[]=$value;
					}
					$sql_b=substr($sql_b,0,strlen($sql_b)-1);
					$sql_b.=")";
				}
				else{
					$sql_b="1=1";
				}
				break;
			}
			case '1':{
				if(isset($request_data['Search']['Name'])&&isset($request_data['Search']['CityId']))
				{
					$sql_b="`Name` LIKE ?";
					$wherevalues[]='%'.$request_data['Search']['Name'].'%';
					if(!empty($request_data['Search']['CityId'])){
						$sql_b.=" AND `CityId`=?";
						$wherevalues[]=$request_data['Search']['CityId'];
					}

					if(isset($request_data['Search']['ProvinceId'])&&!empty($request_data['Search']['ProvinceId'])){
						$sql_b.=" AND `CityId` IN (SELECT `Id` FROM `os_city` WHERE `ProvinceId`=?)";
						$wherevalues[]=$request_data['Search']['ProvinceId'];
					}
				}
				else{
					$myecho['Error']="请求格式错误";
					https(422);
					echo json_encode($myecho);
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
			$myecho['Total']=$rs['ALLNumber'];
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
		}
		else
		{
			$myecho['ResultList']=array();
			if(empty($request_data['Keys'])){
				$attrs=array(
					'Id',
					'Name',
					'CityId',
					'City',
					'ProvinceId',
					'Province'
				);
			}else{
				$attrs=explode('+', $request_data['Keys']);
			}
			$arr_Province=array();
			$arr_ProvinceId=array();
			$arr_City=array();
			while($rs=$mypdo->fetch()){
				$temp=array();
				foreach($attrs as $key => $value){
					if($value=="Province"){
						if(isset($arr_Province[$rs['CityId']])){
							$temp[$value]=$arr_Province[$rs['CityId']];
						}else{
							$sql_temp="SELECT `Name` FROM `os_province` Where `Id`=(SELECT `ProvinceId` FROM `os_city` WHERE `Id`=?)";
							$mypdo_temp->prepare($sql_temp);
							$mypdo_temp->executeArr(array($rs['CityId']));
							if($rs_dd=$mypdo_temp->fetch()){
								$temp[$value]=$rs_dd['Name'];
								$arr_Province[$rs['CityId']]=$rs_dd['Name'];
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
					}else if($value=="ProvinceId"){
						if(isset($arr_ProvinceId[$rs['CityId']])){
							$temp[$value]=$arr_ProvinceId[$rs['CityId']];
						}else{
							$sql_temp="SELECT `ProvinceId` FROM `os_city` Where `Id`=?";
							$mypdo_temp->prepare($sql_temp);
							$mypdo_temp->executeArr(array($rs['CityId']));
							if($rs_dd=$mypdo_temp->fetch()){
								$temp[$value]=$rs_dd['ProvinceId'];
								$arr_ProvinceId[$rs['CityId']]=$rs_dd['ProvinceId'];
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