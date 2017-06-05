<!DOCTYPE html>
<html>
<head>
	<title>小黄帽</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/webContent/webPre/link.php';?>
	<link rel="stylesheet" href="index.css">
</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/webContent/webPre/navbar.php';?>
	<div class="main Index_main">
		<div class="Index_top">
			<ul class="nav nav-pills">
  				<li role="presentation" class="active l1" ><a href="/onlineShop/webContent/webPre/goodsList/goodsList.php?type=">全部商品</a></li>
 				  	<!-- <li role="presentation" class="dropdown" >
 				  	   				 		<a class="dropdown-toggle l2" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
 				  	      						货物类型 <span class="caret"></span>
 				  	    					</a>
 				  	    					<ul class="dropdown-menu" style="margin-top:-33px;">
 				  	    						<?php 
 				  									foreach ($goodsType as $key => $value) {
 				  										echo "<li role='presentation'><a href='".$value['Id']."'>".$value['Name']."</a></li>";
 				  									}
 				  								 ?>
 				  	    					</ul>
 				  	  					</li> -->
 				<?php 
					foreach ($goodsType as $key => $value) {
						echo "<li role='presentation' class='l2'><a style='padding:0px;' href='/onlineShop/webContent/webPre/goodsList/goodsList.php?type=".$value['Id']."'>".$value['Name']."</a></li>";
					}
				 ?>
  				<!-- <li role="presentation" class="l2"><a href="#">微专业</a></li>
  				<li role="presentation" class="l2"><a href="#">企业版</a></li>
  				<li role="presentation" class="l2"><a href="#">下载APP</a></li> -->
			</ul>
			<!-- <div class="Search_area" >
				<div class="row">
			  					<div class="col-lg-6">
			   						 <div class="input-group">
			     							 <div class="input-group-btn">
			       							 <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">课程 <span class="caret"></span></button>
			        							<ul class="dropdown-menu">
			          								<li><a href="#">课程</a></li>
			          								<li><a href="#">提供方</a></li>
			        							</ul>
			      							</div>/btn-group
			      							<input type="text" class="form-control" placeholder="Username" style="width:180px;" />
			      							<span class="input-group-btn">
			       								 <button class="btn btn-default" type="button">
			       								 	<span class="glyphicon glyphicon-search" aria-hidden="true" ></span>
			       								 </button>
			     							 </span>
			    						</div>/input-group
			  					</div>/.col-lg-6
				</div>/.row
			</div> -->
			<!-- /.Search_area -->
		</div><!-- /.index_top -->
		<div class="Index_middle">

			<div id="myCarousel" class="carousel slide" >
    				<!-- 轮播（Carousel）指标 -->
    			<div id="picInside">
	    			<ol class="carousel-indicators">
	       					<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
	        				<li data-target="#myCarousel" data-slide-to="1"></li>
	       				 	<li data-target="#myCarousel" data-slide-to="2"></li>
	       				 	<li data-target="#myCarousel" data-slide-to="3"></li>
	   				 </ol>   
	   				 <!-- 轮播（Carousel）项目 -->
	    				<div class="carousel-inner" data-ride="carousel">
	       					 <div class="item active">
	            						<img src="img/1.jpg"  style="width:100%;height:400px;">
	        					</div>
	        					<div class="item">
	            					<img src="img/2.jpg"  style="width:100%;height:400px;">
	        					</div>
	        					<div class="item">
	            					<img src="img/3.jpg"  style="width:100%;height:400px;">
	       					 </div>
	       					 <div class="item">
	            					<img src="img/4.jpg"  style="width:100%;height:400px;">
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






			<!-- <div class="Middle_core">
				
				<div class="Core_middle">
				
				</div>/.Core_,middle
				
			</div> --><!-- /.Middle_core -->
		</div><!-- /.index_middle -->
		<div class="Index_body">
			<div class="Body_title">
				<h3>畅销课程</h3>
				<button type="button" class="btn btn-default btn-lg g">
  					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true" ></span> <a href="#">更多</a>
				</button>
			</div><!-- /.Body_title -->
			<div class="Body_content">
				<div class="Adver a1">
					<a href="#" ><img src="" width="223px" height="145px"></a>
					<a href="#" class="Ad_b" >财报从入门到精通</a>
					<h4 class="Ad_g" style="line-height:10px;font-size:12px;">主讲人</h4>
					<span class="Adver_pri">￥000.00</span>
					<span class="lnr lnr-smile Index_j1"></span>
					<span class="Index_j2">00</span>
					<span class="lnr lnr-neutral Index_j3"></span>
					<span class="Index_j4">00</span>
					<span class="lnr lnr-sad Index_j5"></span>
					<span class="Index_j6">00</span>
				</div>
			</div><!-- /.Body_content -->
		</div>
	</div><!-- /main-->
	
	<?php include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/webContent/webPre/footer.php';?>
</body>
</html>
<?php include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/webContent/webPre/script.php';?>
<script type="text/javascript" src="index.js"></script>