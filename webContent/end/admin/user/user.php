<!doctype html>
<html lang="en">

<head>
	<title>小黄帽</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/webContent/end/link.php';?>
	<style type="text/css">
		#inputTime{
			height: 50px;
			width: 200px;
			position: relative;
		}
		#TimeInput{
			position: absolute;
			width: 180px;
			top:50%;
			left: 50%;
			margin-left: -90px;
		}
	</style>
	<link rel="stylesheet" type="text/css" href="../../../../static/js/laydate/">
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
					<h3 class="page-title">用户</h3>
					<div class="panel panel-headline demo-icons">
						
						<div class="panel-body">
							<form class="form-inline" role="form">
								<div class="form-group" style="margin:5px 0px;">
									名称：
									<input type="text" class="form-control" id="userName" 
										   placeholder="请输入名称">
								</div>
								<div class="form-group" style="margin:5px 0px;">
									Id：
									<input type="text" class="form-control" id="userId" 
										   placeholder="请输入名称">
								</div>
								<button type="button" class="btn btn-primary" style="margin:5px 0px;" onclick="pageListSearch()">搜索</button>
								<button type="button" class="btn btn-primary" style="margin:5px 0px;" onclick="pageListSearchAll()">查看全部</button>
							</form>
						</div>
					</div>
					<div class="panel panel-headline demo-icons">
						<div class="panel-heading">
							<!-- <div  class="btn btn-success" onclick="pageListAdd()">增加</div> -->
							<div  class="btn btn-danger" onclick="pageListDelete()">批量封停</div>
						</div>
						<div class="panel-body">
							
							<table class="table table-bordered">
								<thead>
									<th>
							       	<input type="checkbox" id="pageList_selectAll">
							       	</th>
							        <th>Id</th>
							        <th>名称</th>
							        <th>性别</th>
							        <th>手机</th>
							        <th>学校</th>
							        <th>货物数量</th>
							        <th>好评率</th>
							        <th>封停截止日期</th>
							        <th>操作</th>
								</thead>
								<tbody id="pageList_tbody">
								</tbody>
							</table>
							<div class="pageUI">
							    <div class="page_footer" id="pageList_pageui" onselectstart="return false">
							    </div>
							</div>
						</div>
					</div>
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
	<script type="text/javascript" src="../../../../static/js/laydate/laydate.js"></script>
	
	<script type="text/javascript" src="user.js"></script>
</body>
<div id="inputTime">
	<div>
		<input type="text" id="TimeInput" class="laydate-icon">
	</div>
</div>
</html>
<script type="text/javascript">
	laydate({
	  	elem: '#TimeInput', //目标元素。由于laydate.js封装了一个轻量级的选择器引擎，因此elem还允许你传入class、tag但必须按照这种方式 '#id .class'
		format: 'YYYY-MM-DD hh:mm:ss',
		istime: true, //是否开启时间选择
	});
	laydate.skin('molv');  //加载皮肤，参数lib为皮肤名 
</script>