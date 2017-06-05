<!DOCTYPE html>
<html>
<head>
	<title>小黄帽</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/webContent/webPre/link.php';?>
	<link rel="stylesheet" href="shoppingCart.css">
</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/webContent/webPre/navbar.php';?>
	<div class="main">
		<div class="Cart_core">
			<div class="Cart_title">
				<h3 class="Cart_h1">我的购物车</h3>
				<h5 class="Cart_h2" id="GoodsNumber">共0件商品</h5>
			</div>
			<!--Cart_inall-->
			<div class="Cart_inall">
				<!-- <label><input name="Cart_Select_all" type="checkbox" value="" class="Cart_checkbox_all" style="position:absolute;left:10px;top:18px;"/><h5 class="Cart_h11">全选</h5></label> -->
				<h style="position:absolute;right:215px;top:8px;font-size:16px;">合计：</h>
				<h style="position:absolute;right:148px;top:5px;font-size:22px;color:red;" id='AllPrice'>￥0.00</h>
				<!-- <h style="position:absolute;right:145px;bottom:8px;font-size:12px;">(若购买享有优惠，相应金额将在订单结算界面减扣)</h> -->
				<button class="Cart_pay btn btn-primary" id="goPay" disabled="disabled" onclick="goPay()">去结算</button>
			</div><!--Cart_inall-->
			<!--Cart_title-->
			<div class="Cart_table">
				<label><input name="Cart_Select_all" type="checkbox" value="" class="Cart_checkbox_all" id="pageList_selectAll" /><h5 class="Cart_h3">全选</h5></label> 
				<h5 class="Cart_h4">商品名称</h5>
				<h5 class="Cart_h5">数量</h5>
				<h5 class="Cart_h6">单价（元）</h5>
			</div><!--Cart_table-->
			<div class="Cart_shop">
				<!-- <div style="height:40px;"><label><input name="Cart_Select_shop" type="checkbox" value="" class="Cart_checkbox_shop"/><h5 class="Cart_h3">店铺名称</h5></label> </div> -->
				<div id="insideList">
					<!-- <div class="Cart_good">
						<label><input name="Cart_Select_good" type="checkbox" value="" class="Cart_checkbox_good"/></label> 
						<img src="" width="120px" height="65px;">
						<h5 class="Cart_h7">商品名称</h5>
						<h5 class="Cart_h8">1</h5>
						<h5 class="Cart_h9">00.00</h5>
						<button type="button" class="btn btn-default Cart_delete" aria-label="Left Align">
						  						<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
						</button>
					</div> -->
				</div>
				<br>
				<div class="pageUI">
				    <div class="page_footer" id="pageList_pageui" onselectstart="return false">
				    </div>
				</div>
				<!--Cart_good-->
				<!-- <div class="Cart_shop_inall">
					<h4 class="Cart_h10">该店铺小计：￥0.00</h4>
				</div>Cart_shop_inall -->
			</div><!--Cart_shop-->
			
		</div><!--Cart_core-->
	</div><!--main-->
	<?php include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/webContent/webPre/footer.php';?>
</body>
</html>
<?php include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/webContent/webPre/script.php';?>
<script type="text/javascript" src="shoppingCart.js"></script>