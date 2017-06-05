<?php
	session_start();
	/**用户登录后会自动写入session
	*$_SESSION['type']='user|admin';
	*$_SESSION['id']=1;
	*/
	include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/src/MySqlPDO.class.php';
	include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/src/Imgs.class.php';
	include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/src/request.php';
	include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/src/https.php';
	include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/src/public_functions.php';
	switch ($request_method) {
		case 'POST':
			toPost($request_data);
			break;
		case 'GET':
			toDelete($request_data);
			break;
		default:
	    	https(500);
	    	echo json_encode(array('Error' => "请求错误"));
	    	exit();
			break;
	}

	function toPost($request_data){
		$myecho=array();
		$mypdo=new MySqlPDO();
		if(isset($request_data['Username'])&&isset($request_data['Password'])&&isset($request_data['Type'])){
			if($request_data['Type']=='2'){
				$sql='SELECT `Id`,`Password` FROM `os_admin` WHERE `Phone`=?';
			}else{
				$sql='SELECT `Id`,`Password`,`Deadline` FROM `os_user` WHERE `Phone`=?';
			}
			$mypdo->prepare($sql);
			$myarr=array(
				$request_data['Username']
			);
			//执行预处理
			if($mypdo->executeArr($myarr)){
				if($rs=$mypdo->fetch()){
					if(md5($rs['Password'])==$request_data['Password']){
						if($request_data['Type']=='2'){
							$_SESSION['type']='admin';
							$_SESSION['id']=$rs['Id'];
						}else{
							if(strtotime(date("Y-m-d H:i:s"))<strtotime($rs['Deadline'])){
								$myecho['Error']="您的账号处于封停状态，截止日期：".$rs['Deadline'];
								https(401);
								echo json_encode($myecho);
								exit();
							}else{
								$_SESSION['id']=$rs['Id'];
								$_SESSION['type']='user';
								$sql_login='SELECT `Id` FROM `os_login_record` WHERE `UserId`=? AND DATE_FORMAT(`Time`,\'%Y-%m-%d\')="'.date("Y-m-d").'"';
								$mypdo->prepare($sql_login);
								$mypdo->executeArr(array($rs['Id']));
								if($rs_login=$mypdo->fetch()){
									$sql="UPDATE `os_login_record` SET `Time`=?,`Number`=`Number`+1,`Ip`=? where `Id`=?";
									$mypdo->prepare($sql);
									if($mypdo->executeArr(array(
										date("Y-m-d H:i:s"),
										getIP(),
										$rs_login['Id']
									))){
									}else{
										$myecho['Error']="系统错误";
										https(500);
										echo json_encode($myecho);
										exit();
									};
								}else{
									$sql="INSERT INTO `os_login_record` (`UserId`,`Time`,`Number`,`Ip`) VALUES (?,?,?,?)";
									$mypdo->prepare($sql);
									if($mypdo->executeArr(array(
										$rs["Id"],
										date("Y-m-d H:i:s"),
										1,
										getIP()
									))){
									}else{
										$myecho['Error']="系统错误";
										https(500);
										echo json_encode($myecho);
										exit();
									};
								}
							}
						}
					}else{
						$myecho['Error']="密码错误";
						https(401);
						echo json_encode($myecho);
						exit();
					}
				}else{
					$myecho['Error']="用户名不存在";
					https(401);
					echo json_encode($myecho);
					exit();
				}
			}else{
				$myecho['Error']="增加失败";
				https(400);
				echo json_encode($myecho);
				exit();
			}
		}else{
			$myecho['Error']="请求格式错误";
			https(422);
			echo json_encode($myecho);
			exit();
		}
		https(201);
		echo json_encode($myecho);
	}

	function toDelete($request_data){
		if(isset($_SESSION['id'])&&isset($_SESSION['type'])){
			unset($_SESSION['id']);
			unset($_SESSION['type']);
			
		}
		echo "<script>window.location='/onlineShop/webContent/webPre/index/index.php'</script>";
	}

?>

