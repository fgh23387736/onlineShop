<!doctype html>
<html lang="en">

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
		<!-- NAVBAR -->
		<?php include '../navbar.php';?>
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<?php include '../leftSidebar.php';?>
		<!-- END LEFT SIDEBAR -->
		<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">个人数据</h3>
							<p class="panel-subtitle" id="nowDate"></p>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-3">
									<div class="metric">
										<span class="icon"><i class="fa fa-shopping-bag"></i></span>
										<p>
											<span class="number" id='GoodsNumber'>203</span>
											<span class="title">我的商品</span>
										</p>
									</div>
								</div>
								<div class="col-md-3">
									<div class="metric">
										<span class="icon"><i class="fa fa-shopping-cart"></i></span>
										<p>
											<span class="number" id='PurchasedGoodsNumber'>1,252</span>
											<span class="title">我买过的商品</span>
										</p>
									</div>
								</div>
								
								<div class="col-md-3">
									<div class="metric">
										<span class="icon"><i class="fa fa-credit-card-alt"></i></span>
										<p>
											<span class="number" id='SoldGoodsNubmer'>274,678</span>
											<span class="title">我卖出的商品</span>
										</p>
									</div>
								</div>
								<div class="col-md-3">
									<div class="metric">
										<span class="icon"><i class="fa fa-bar-chart"></i></span>
										<p>
											<span class="number" id='GoodPercent'>35%</span>
											<span class="title">好评率</span>
										</p>
									</div>
								</div>
							</div>
							<div class="row" id="Charts" style="height:300px;">
								
							</div>
						</div>
					</div>
					<!-- END OVERVIEW -->
                    <div class="copyrights">Collect from <a href="http://www.cssmoban.com/" >企业网站模板</a></div>
					<div class="row">
						<div class="col-md-6">
							<!-- RECENT PURCHASES -->
							
							<!-- END RECENT PURCHASES -->
						</div>
						<div class="col-md-6">
							<!-- MULTI CHARTS -->
							
							<!-- END MULTI CHARTS -->
						</div>
					</div>
					<div class="row">
						<div class="col-md-7">
							<!-- TODO LIST -->
							
							<!-- END TODO LIST -->
						</div>
						<div class="col-md-5">
							<!-- TIMELINE -->
							
							<!-- END TIMELINE -->
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<!-- TASKS -->
							
							<!-- END TASKS -->
						</div>
						<div class="col-md-4">
							<!-- VISIT CHART -->
							
							<!-- END VISIT CHART -->
						</div>
						<div class="col-md-4">
							<!-- REALTIME CHART -->
							
							<!-- END REALTIME CHART -->
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
	<script type="text/javascript" src="index.js"></script>
	
</body>

</html>
