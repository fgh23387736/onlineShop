<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
	<title>小黄帽</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/webContent/end/link.php';?>
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box ">
					<div class="left">
						<div class="content">
							<div class="header">
								<div class="logo text-center"><img src="../assets/img/logo-dark.png" alt="Klorofil Logo" style="width:50%;"></div>
								<p class="lead">注册</p>
							</div>
							<form class="form-auth-small" action="index.php">
								<div class="form-group">
									<label for="signin-email" class="control-label sr-only">手机号</label>
									<input type="text" class="form-control" id="Phone" value="" placeholder="手机号" onblur="checkPhone()">
								</div>
								
								<!-- <div id="col"></div> -->

								<div class="form-group">
									<label for="signin-password" class="control-label sr-only">密码</label>
									<input type="password" class="form-control" id="Password" value="" placeholder="密码" >
								</div>
								<div class="form-group">
									<label for="signin-password" class="control-label sr-only">确认密码</label>
									<input type="password" class="form-control" id="RepeatPassword" value="" placeholder="重复密码" onblur="checkRepassword()">
								</div>
								<div class="form-group clearfix">
								</div>
								<div class="btn btn-primary btn-lg btn-block" onclick="validateForm()">注册</div>
							</form>
						</div>
					</div>
					<div class="right">
						<div class="overlay"></div>
						<div class="content text">
							<h1 class="heading">方便的校园，方便的你我</h1>
							<p>--小黄帽</p>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
	<?php include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/webContent/end/script.php'; ?>
	<script type="text/javascript" src='/onlineShop/static/js/md5.js'></script>
	<script type="text/javascript" src="register.js"></script>
</body>

</html>
