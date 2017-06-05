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
	if($_SESSION['type']!='admin'){
		https(401);
		echo json_encode(array('Error'=>"您还未登录，请使用管理员账号登录"));
		exit();
	}
	switch ($request_method) {
		case 'POST':
			https(401);
			echo json_encode(array('Error' => "不提供该接口"));
    		exit();
			
			break;
		case 'DELETE':
			https(401);
			echo json_encode(array('Error' => "不提供该接口"));
    		exit();
			break;
		case 'PUT':
			https(401);
			echo json_encode(array('Error' => "不提供该接口"));
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
	function toGet($request_data){
		$myecho=array();
		$mypdo=new MySqlPDO();
		$mypdo_temp=new MySqlPDO();
		if(!isset($request_data['Keys'])){
			$myecho['Error']="请求格式错误";
			https(422);
			echo json_encode($myecho);
			exit();
		}

		if(empty($request_data['Keys'])){
			$attrs=array(
				'GoodsNumber',
			    'UserNumber',
			    'OrderNubmer',
			    'LoginNubmer',
			    'OrderNubmerILSD',
			    'NewUserNubmerILSD',
			    'LoginNubmerILSD'
			);
		}else{
			$attrs=explode('+', $request_data['Keys']);
		}
		  //按分隔符把字符串打散为数组
		foreach ($attrs as $key => $value) {
			if($value=='GoodsNumber'){
				$sql='SELECT count(*) AS `Number` FROM `os_goods`';
				$mypdo->prepare($sql);
				$mypdo->executeArr(array());
				if($rs=$mypdo->fetch()){
					$myecho[$value]=$rs['Number'];
				}else{
					$myecho[$value]=0;
				}
			}else if($value=='UserNumber'){
				$sql='SELECT count(*) AS `Number` FROM `os_user`';
				$mypdo->prepare($sql);
				$mypdo->executeArr(array());
				if($rs=$mypdo->fetch()){
					$myecho[$value]=$rs['Number'];
				}else{
					$myecho[$value]=0;
				}
			}else if($value=='OrderNubmer'){
				$sql='SELECT count(*) AS `Number` FROM `os_order`';
				$mypdo->prepare($sql);
				$mypdo->executeArr(array());
				if($rs=$mypdo->fetch()){
					$myecho[$value]=$rs['Number'];
				}else{
					$myecho[$value]=0;
				}
			}else if($value=='LoginNubmer'){
				$sql='SELECT sum(`Number`) AS `AllNumber` FROM `os_login_record`';
				$mypdo->prepare($sql);
				$mypdo->executeArr(array());
				if($rs=$mypdo->fetch()){
					if (empty($rs['AllNumber'])) {
						$rs['AllNumber']=0;
					}
					$myecho[$value]=$rs['AllNumber'];
				}else{
					$myecho[$value]=0;
				}
			}else if($value=='OrderNubmerILSD'){
				$sql_temp="SELECT count(*) as `Number` FROM `os_order` WHERE  DATE_FORMAT(`os_order`.`Time`,'%Y-%m-%d')=?";
				$mypdo_temp->prepare($sql_temp);
				$myecho[$value]=array();
				for($i=6;$i>=0;$i--){
					if($mypdo_temp->executeArr(array(date('Y-m-d',strtotime("-$i day"))))){
						if($rs_temp=$mypdo_temp->fetch()){
							$myecho[$value][]=$rs_temp['Number'];
						}else{
							$myecho[$value][]=0;
						}
					}else{
						$myecho[$value][]=0;
					}
				}
			}else if($value=='NewUserNubmerILSD'){
				$sql_temp="SELECT count(*) as `Number` FROM `os_user` WHERE  DATE_FORMAT(`os_user`.`Time`,'%Y-%m-%d')=?";
				$mypdo_temp->prepare($sql_temp);
				$myecho[$value]=array();
				for($i=6;$i>=0;$i--){
					if($mypdo_temp->executeArr(array(date('Y-m-d',strtotime("-$i day"))))){
						if($rs_temp=$mypdo_temp->fetch()){
							$myecho[$value][]=$rs_temp['Number'];
						}else{
							$myecho[$value][]=0;
						}
					}else{
						$myecho[$value][]=0;
					}
				}
			}else if($value=='LoginNubmerILSD'){
				$sql_temp="SELECT sum(`Number`) as `AllNumber` FROM `os_login_record` WHERE  DATE_FORMAT(`os_login_record`.`Time`,'%Y-%m-%d')=?";
				$mypdo_temp->prepare($sql_temp);
				$myecho[$value]=array();
				for($i=6;$i>=0;$i--){
					if($mypdo_temp->executeArr(array(date('Y-m-d',strtotime("-$i day"))))){
						if($rs_temp=$mypdo_temp->fetch()){
							if(empty($rs_temp['AllNumber'])){
								$rs_temp['AllNumber']=0;
							}
							$myecho[$value][]=$rs_temp['AllNumber'];
						}else{
							$myecho[$value][]=0;
						}
					}else{
						$myecho[$value][]=0;
					}
				}
			}
		}
		https(200);
		echo json_encode($myecho);
	}
?>




 