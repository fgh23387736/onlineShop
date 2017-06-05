<?php
	session_start();
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
		$sql="INSERT INTO `os_city`
		(
			`ProvinceId`,
			`Name`
		)VALUES(
			?,?
		)";
		$mypdo->prepare($sql);
		$myarr=array(
			$request_data['ProvinceId'],
			$request_data['Name']
		);

		if($mypdo->executeArr($myarr))
		{
			$myecho['Id']=$mypdo->lastInsertId();
		}else{
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

		$sql_f="DELETE FROM `os_city` WHERE ";
		$wherevalues=array();
		switch($request_data['Type'])
		{
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
		// echo $sql;
		$mypdo->prepare($sql);
		if(!$mypdo->executeArr($wherevalues)){
			$myecho['Error']="系统错误";
			https(500);
			// echo "<br>=========<br>";
			echo json_encode($myecho);   //--bug
			// echo "<br>=========<br>";
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
		$sql_f="UPDATE `os_city` SET ";
		$sql_i="";
		$insidevalues=array();
		$wherevalues=array();
		$Ids=explode('+',$request_data['Id']);
		$sql_b="`Id` in (";
		foreach($Ids as $key => $value){
			$sql_b.="?,";
			$wherevalues[]=$value;
		}
		$sql_b=substr($sql_b,0,strlen($sql_b)-1);
		$sql_b.=")";
		switch($request_data['Type']){
			case '0':{
				if(count($Ids)!=1){
					$myecho['Error']="请求格式错误";
					hppts(422);
					echo json_encode($myecho);
					exit();
				}
				$sql_i="
					`Name`=?,
					`ProvinceId`=?
				";
				$insidevalues=array(
					$request_data['Update']['Name'],
					$request_data['Update']['ProvinceId']
				);
				break;
			}
			case '1':{
				if(count($Ids)!=1){
					$myecho['Error']="请求格式错误";
					hppts(422);
					echo json_encode($myecho);
					exit();
				}
				$sql_i="`ProvinceId`=?";
				$insidevalues=array($request_data['Update']['ProvinceId']
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
		foreach($insidevalues as $key => $value)
		{
			$theLastValues[]=$value;
		}
		foreach($wherevalues as $key => $value)
		{
			$theLastValues[]=$value;
		}
		if(!$mypdo->executeArr($theLastValues))
		{
			$myecho['Error']="系统错误";
			// echo "sssss";  bug
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
		$sql_f="SELECT * FROM `os_city` WHERE ";
		$sql_c="SELECT count(*) AS `ALLNumber` FROM `os_city` WHERE ";
		$sql_b="";
		$wherevalues=array();

		switch($request_data['Type'])
		{
			case '0':{
				if(isset($request_data['Search']['Id'])&&!empty($request_data['Search']['Id']))
				{
					$Ids=explode('+',$request_data['Search']['Id']);
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
				if(isset($request_data['Search']['Name'])&&isset($request_data['Search']['ProvinceId']))
				{
					$sql_b="`Name` LIKE ?";
					$wherevalues[]='%'.$request_data['Search']['Name'].'%';
					if(!empty($request_data['Search']['ProvinceId'])){
						$sql_b.=" AND `ProvinceId`=?";
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
			// $attrs=explode('+', $request_data['Keys']);
			if(empty($request_data['Keys'])){
				$attrs=array(
					'Id',
			    	'Name',
			    	'Schools',
                	'SchoolsId',
                	'ProvinceId',
                	'Province'
				);
			}else{
				$attrs=explode('+', $request_data['Keys']);
			}
			$arr_Province=array();
			while($rs=$mypdo->fetch()){
				$temp=array();

				foreach($attrs as $key => $value){
					if($value=='Schools'){
						$temp[$value]=array();
						$sql_temp="SELECT `Id`,`Name` FROM `os_school` WHERE `CityId`=?";
						$mypdo_temp->prepare($sql_temp);
						if($mypdo_temp->executeArr(array($rs['Id']))){
							while ($rs_temp=$mypdo_temp->fetch()) {
								$temp_Schools=array();
								$temp_Schools['Id']=$rs_temp['Id'];
								$temp_Schools['Name']=$rs_temp['Name'];
								$temp[$value][]=$temp_Schools;
							}
						}
					}else if($value=='SchoolsId'){
						$temp[$value]=array();
						$sql_temp="SELECT `Id` FROM `os_school` WHERE `CityId`=?";
						$mypdo_temp->prepare($sql_temp);
						if($mypdo_temp->executeArr(array($rs['Id']))){
							while ($rs_temp=$mypdo_temp->fetch()) {
								$temp[$value][]=$rs_temp['Id'];
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