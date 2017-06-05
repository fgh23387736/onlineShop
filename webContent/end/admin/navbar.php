		<?php 
			session_start();
			include $_SERVER['DOCUMENT_ROOT']."/".'onlineShop/src/MySqlPDO.class.php';
			$mypdo=new MySqlPDO();
			$sql="SELECT `Name`,`HeadImgUrl` FROM `os_admin` WHERE `Id`=?";
			$rs=array();
			if($_SESSION['type']=='admin'){
				$mypdo->prepare($sql);
				if($mypdo->executeArr(array($_SESSION['id']))){
					if($rs=$mypdo->fetch()){
						if(empty($rs['HeadImgUrl'])){
							$rs['HeadImgUrl']='/onlineShop/webContent/end/assets/img/guest.png';
						}
					}else{
						echo "<script>window.location='/onlineShop/webContent/end/login/login.php'</script>";
						exit();
					}
				}else{
					echo "<script>window.location='/onlineShop/webContent/end/login/login.php'</script>";
					exit();
				}
			}else if($_SESSION['type']=='user'){
				echo "<script>window.location='/onlineShop/webContent/end/user/index/index.php'</script>";
				exit();
			}else{
				echo "<script>window.location='/onlineShop/webContent/end/login/login.php'</script>";
				exit();
			}
		?>
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand" style="padding:3px 30px;">
				<a href="/onlineShop/webContent/webPre/index/index.php"><img src="/onlineShop/webContent/end/assets/img/logo-dark.png" alt="Klorofil Logo" class="img-responsive logo" style="height:80px;"></a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
				</div>
				<!-- <div class="navbar-btn navbar-btn-right">
					<a class="btn btn-success update-pro" href="#downloads/klorofil-pro-bootstrap-admin-dashboard-template/?utm_source=klorofil&utm_medium=template&utm_campaign=KlorofilPro" title="Upgrade to Pro" target="_blank"><i class="fa fa-rocket"></i> <span>UPGRADE TO PRO</span></a>
				</div> -->
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
						<!-- <li class="dropdown">
							<a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
								<i class="lnr lnr-alarm"></i>
								<span class="badge bg-danger">5</span>
							</a>
							<ul class="dropdown-menu notifications">
								<li><a href="#" class="notification-item"><span class="dot bg-warning"></span>System space is almost full</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-danger"></span>You have 9 unfinished tasks</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-success"></span>Monthly report is available</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-warning"></span>Weekly meeting in 1 hour</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-success"></span>Your request has been approved</a></li>
								<li><a href="#" class="more">See all notifications</a></li>
							</ul>
						</li> -->
						<li class="dropdown">
							<a href="" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-arrows"></i> <span>其他操作</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="/onlineShop/webContent/webPre/index/index.php">回到主页</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="<?php echo $rs['HeadImgUrl'];?>" class="img-circle" alt="Avatar"> <span><?php echo $rs['Name'];?></span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="/onlineShop/webContent/end/admin/personalInformation/personalInformation.php"><i class="lnr lnr-user"></i> <span>个人主页</span></a></li>
								<!-- <li><a href="#"><i class="lnr lnr-envelope"></i> <span>Message</span></a></li>
								<li><a href="#"><i class="lnr lnr-cog"></i> <span>Settings</span></a></li> -->
								<li><a href="/onlineShop/src/v1/operation/login.php"><i class="lnr lnr-exit"></i> <span>退出</span></a></li>
							</ul>
						</li>
						<!-- <li>
							<a class="update-pro" href="#downloads/klorofil-pro-bootstrap-admin-dashboard-template/?utm_source=klorofil&utm_medium=template&utm_campaign=KlorofilPro" title="Upgrade to Pro" target="_blank"><i class="fa fa-rocket"></i> <span>UPGRADE TO PRO</span></a>
						</li> -->
					</ul>
				</div>
			</div>
		</nav>