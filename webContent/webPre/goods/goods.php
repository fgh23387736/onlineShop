<?php 
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>小黄帽</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/webContent/webPre/link.php';?>
	<link rel="stylesheet" href="goods.css">
</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/webContent/webPre/navbar.php';?>
	<div class="main">
		<!-- <ol class="breadcrumb">
			<li><a class="bread1" href="#">首页</a></li>
			<li><a class="bread1" href="#">全部课程</a></li>
			<li><a class="bread1" href="#">办公效率</a></li>
			<li><a class="bread1" href="#">工作效率</a></li>
			<li><a class="bread1" href="#">思维导图</a></li>
			<li class="active">课程详情</li>
		</ol> -->
		<div class="panel panel-default no1">
			<div class="panel-body">
				<div class="box">

					<div id="myCarousel" class="carousel slide" >
						<div id="picInside">
							<!-- 轮播（Carousel）指标 -->
							<ol class="carousel-indicators">
								<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
								<li data-target="#myCarousel" data-slide-to="1"></li>
								<li data-target="#myCarousel" data-slide-to="2"></li>
							</ol>
							<!-- 轮播（Carousel）项目 -->
							<div class="carousel-inner" data-ride="carousel">
								<div class="item active">
									<img src="img/1.jpg"  style="width:450px;height:270px;">
								</div>
								<div class="item">
									<img src="img/2.jpg"  style="width:450px;height:270px;">
								</div>
								<div class="item">
									<img src="img/3.jpg"  style="width:450px;height:270px;">
								</div>
							</div>
						</div>
						
						<!-- 轮播（Carousel）导航 -->
						<a class="carousel-control left Turnpre"  href="#myCarousel" 
						data-slide="prev">&lsaquo;
						</a>
						<a class="carousel-control right Turnnext" href="#myCarousel" 
						data-slide="next">&rsaquo;
						</a>
					</div>

						<!-- <img class="iimg" src="images/big1.jpg" width="450" height="270"/> -->
						<div class="wenzi">
							<p class="big" id="goodsName">商品</p>
							<p class="middle" id="userName">小黄帽</p>
							<span class="lnr lnr-smile" id='Good'>0</span>
							<span class="lnr lnr-neutral" id='Middle'>0</span>
							<span class="lnr lnr-sad" id='Bad'>0</span>
							<br>
							<p class="middle" id="Number">0</p>
							<p class="small" id="Price">￥0</p>
							<button class="btn btn-lg btn-primary" id="BuyNow" onclick="buyNow()"> 立即购买</button>
							<button class="btn btn-lg btn-warning" id="AddToShoppingCart" onclick="addToShoppingCart()"> 加入购物车</button>
						</div>
					
				</div>
				<div class="custom-tabs-line tabs-line-bottom left-aligned">
					<ul class="nav" role="tablist">
						<li class="active"><a href="#tab-bottom-left1" role="tab" data-toggle="tab">介绍</a></li>
						<li><a href="#tab-bottom-left2" role="tab" data-toggle="tab">评价</a></li>
					</ul>
				</div>
				
			</div>
		</div>
		<div class="panel panel-default no2">
			<div class="panel-body">
				<div class="tab-content">
					<div class="tab-pane fade in active" id="tab-bottom-left1">
						
					</div>
					<div class="tab-pane fade" id="tab-bottom-left2">
						<div id="userComment">
							
						</div>
						<div class="pageUI">
					    	<div class="page_footer" id="pageList_pageui" onselectstart="return false">
					    </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/webContent/webPre/footer.php';?>
</body>
</html>
<?php include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/webContent/webPre/script.php';?>
<script type="text/javascript">
    <?php 
        $id='';
        if(isset($_GET['id'])){
            if(is_numeric($_GET['id'])){
                $id=$_GET['id'];
            }
        }
    ?>
	var id="<?php echo $id;?>";
</script>
<script type="text/javascript" src="goods.js"></script>