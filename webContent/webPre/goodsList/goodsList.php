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
	<link rel="stylesheet" href="goodsList.css">
</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/webContent/webPre/navbar.php';?>
	<div class="main">
		
		<!-- <ol class="breadcrumb">
			<li><a class="bread1" href="#">首页</a></li>
			<li><a class="bread2" href="http://localhost/onlineShop/webContent/webPre/goodsList/goodsList.php">全部课程</a></li>
		</ol> -->


		<ul class="nav nav-pills no">
			<?php 
				if(''==$theType){
					echo "<li role='presentation' class='active'><a href='/onlineShop/webContent/webPre/goodsList/goodsList.php?type='>全部商品</a></li>";
				}else{
					echo "<li role='presentation' ><a href='/onlineShop/webContent/webPre/goodsList/goodsList.php?type='>全部商品</a></li>";
				}
				foreach ($goodsType as $key => $value) {
					if($value['Id']==$theType){
						echo "<li role='presentation' class='active'><a href='/onlineShop/webContent/webPre/goodsList/goodsList.php?type=".$value['Id']."'>".$value['Name']."</a></li>";
					}else{
						echo "<li role='presentation' ><a href='/onlineShop/webContent/webPre/goodsList/goodsList.php?type=".$value['Id']."'>".$value['Name']."</a></li>";
					}
					
				}
			 ?>
		</ul>

		<div class="home_imgbox">
			<div id="insideBox">
				<!-- <div class="box1">
					<a href="http://www.baidu.com">
						<img class="imgg" src="images/big1.jpg"/>
						<p class="big">和秋叶一起学做PPT</p>
						<p class="middle">幻方秋叶PPT</p>
						<span class="lnr lnr-smile">1000</span>
						<span class="lnr lnr-neutral">0</span>
						<span class="lnr lnr-sad">0</span>
						<br>
						<p class="small">￥169.00</p>
					</a>
				</div> -->
			</div>
			<div style="clear:both;"></div>
			<div class="pageUI">
		    	<div class="page_footer" id="pageList_pageui" onselectstart="return false">
		    </div>
		</div>
		</div>
		



	</div>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/webContent/webPre/footer.php';?>
</body>
</html>
<?php include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/webContent/webPre/script.php';?>
<script type="text/javascript">
	var theType='<?php echo $theType; ?>';
	var theName='<?php echo $theName; ?>';
</script>
<script type="text/javascript" src="goodsList.js"></script>