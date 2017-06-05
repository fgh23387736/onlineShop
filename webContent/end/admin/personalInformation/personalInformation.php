<!doctype html>
<html lang="en">

<head>
	<title>小黄帽</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/webContent/end/link.php';?>
	<style type="text/css">
		.ImgUrlInput{
			width: 100px;
			height: 100px;
			opacity: 0;
			float: left;
			cursor: pointer;
			
		}
		.HeadImgUrl{
			margin-left:-100px;
			
		}
		.ImgUrlInput:hover{
			border: 2px solid #78A3ED;
		}
	</style>
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<?php include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/webContent/end/admin/navbar.php';?>
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<?php include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/webContent/end/admin/leftSidebar.php';?>
		<!-- END LEFT SIDEBAR -->
		<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<h3 class="page-title">个人中心</h3>

					<div class="panel">
						<div class="panel-body">
							<div class="custom-tabs-line tabs-line-bottom left-aligned">
								<ul class="nav" role="tablist">
									<li class="active"><a href="#tab-bottom-left1" role="tab" data-toggle="tab">个人资料</a></li>
									<li><a href="#tab-bottom-left2" role="tab" data-toggle="tab">账户信息</a></li>
								</ul>
							</div>
							<div class="tab-content">
								<div class="tab-pane fade in active" id="tab-bottom-left1">
									<table class="table table-bordered">
										<tbody>
											<tr>
												<td>头像:</td>
												<td>
													<img src=""
								                      alt="请选择一张图片" 
								                      width="100"
								                      height="100"
								                      id="HeadImgUrl" name="HeadImgUrl" class="HeadImgUrl">
								                    <input type="file" class='ImgUrlInput' id="ImgUrlInput" placeholder="展示图片" name="ImgUrlInput">
												</td>
											</tr>
											<tr>
												<td>姓名:</td>
												<td>
													<input type="text" class="form-control" placeholder="姓名" id="Name" onblur="oBlur_2()" onfocus="oFocus_2()">
												</td>
											</tr>
											<tr>
												<td>性别:</td>
												<td>
													<label class="fancy-radio" style="float:left;margin-right:10px;">
														<input name="Sex" value="1" type="radio">
														<span><i></i>男生</span>
													</label>
													<label class="fancy-radio" style="float:left;margin-right:10px;">
														<input name="Sex" value="2" type="radio">
														<span><i></i>女生</span>
													</label>
													<label class="fancy-radio" style="float:left;">
														<input name="Sex" value="0" type="radio">
														<span><i></i>保密</span>
													</label>
												</td>
											</tr>
											<tr>
												<td colspan="2">
													<div class="btn btn-primary" onclick="submit()">提交</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="tab-pane fade" id="tab-bottom-left2">
									<table class="table table-bordered">
										<tbody>
											<tr>
												<td>用户名:</td>
												<td>
													<input type="text" class="form-control" placeholder="用户名" id="Phone">
												</td>
											</tr>
											<tr>
												<td>原密码:</td>
												<td>
													<input type="password" class="form-control" placeholder="原密码" id="Password" onblur="oldPassword()">
												</td>
											</tr>
											<tr>
												<td>新密码:</td>
												<td>
													<input type="password" class="form-control" placeholder="新密码" id="NewPassword" onblur="checkPassword()">
												</td>
											</tr>
											<tr>
												<td>确认新密码:</td>
												<td>
													<input type="password" class="form-control" placeholder="确认新密码" id="RepeatNewPassword" onblur="checkRepassword()">
												</td>
											</tr>
											<tr>
												<td colspan="2">
													<div  class="btn btn-primary" onclick="validateForm()">修改密码</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!-- TABBED CONTENT -->
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
		<!-- END MAIN -->
		<div class="clearfix"></div>
		<?php include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/webContent/end/footer.php'; ?>
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<?php include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/webContent/end/script.php'; ?>
	<script type="text/javascript" src='/onlineShop/static/js/md5.js'></script>
	<script type="text/javascript" src="personalInformation.js"></script>
</body>

</html>
