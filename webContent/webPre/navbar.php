<?php 
	session_start();
	include $_SERVER['DOCUMENT_ROOT']."/".'onlineShop/src/MySqlPDO.class.php';
	$mypdo=new MySqlPDO();
	$goodsType=array();
	$sql='SELECT * FROM `os_goods_type`';
	$mypdo->prepare($sql);
	if($mypdo->executeArr(array())){
		while ($rs=$mypdo->fetch()) {
			$temp=array();
			$temp['Id']=$rs['Id'];
			$temp['Name']=$rs['Name'];
			$goodsType[]=$temp;
		}
	}
	$loginText=array();
	if($_SESSION['type']=='user'){
		$loginText['url']='/onlineShop/webContent/end/user/index/index.php';
		$loginText['text']='管理后台';
	}else if($_SESSION['type']=='admin'){
		$loginText['url']='/onlineShop/webContent/end/admin/index/index.php';
		$loginText['text']='管理后台';
	}else{
		$loginText['url']='/onlineShop/webContent/end/login/login.php';
		$loginText['text']='登录/注册';
	}

	$theType='';
	if(isset($_GET['type'])&&!empty($_GET['type'])){
		$theType=htmlspecialchars($_GET['type']);
	}
	$theName='';
	if(isset($_GET['name'])&&!empty($_GET['name'])){
		$theName=htmlspecialchars($_GET['name']);
	}
?>
		<link rel="stylesheet" href="/onlineShop/webContent/webPre/assets/css/navbar.css">
		<nav class="navbar navbar-default navbar-fixed-top Ba_color">
			<div class="Nav_core">
				<a href="/onlineShop/webContent/webPre/index/index.php"><img src="/onlineShop/webContent/end/assets/img/logo-dark.png" alt="Klorofil Logo" class="img-responsive logo" style="height:60px;margin-left:50px;width:101px;"></a>
				<!-- <ul class="nav nav-pills Nav_a">
				 					 <li role="presentation"><a href="#">找课程</a></li>
				  					<li role="presentation"><a href="#">微专业</a></li>
				  					<li role="presentation"><a href="#">下载APP</a></li>
				</ul> -->

				<div class="Nav_Search_area" >
				<div class="row">
  					<div class="col-lg-6">
   						 <div class="input-group">
     							 <div class="input-group-btn">
       							 <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">类型 <span class="caret"></span></button>
        							<ul class="dropdown-menu">
        							<?php 
        								foreach ($goodsType as $key => $value) {
        									echo "<li><a href='/onlineShop/webContent/webPre/goodsList/goodsList.php?type=".$value['Id']."'>".$value['Name']."</a></li>";
        								}
        							 ?>
        							</ul>
      							</div><!-- /btn-group -->
      							<input type="text" class="form-control" placeholder="货物名称" style="width:195px;" value="<?php echo $theName;?>" id='navSearchInput'/>
      							<span class="input-group-btn">
       								 <button class="btn btn-default" type="button" onclick="searchNav()">
       								 	<span class="glyphicon glyphicon-search" aria-hidden="true" ></span>
       								 </button>
     							 </span>
    						</div><!-- /input-group -->
  					</div><!-- /.col-lg-6 -->
				</div><!-- /.row -->
			</div><!-- /.Search_area -->
		<!-- <div class="Nav_Div Nav_Div1"><a href="#" >我的学习</a></div> -->
		<div class="Nav_Div Nav_Div2"><a href="/onlineShop/webContent/webPre/index/index.php" >首页</a></div>
			<div class="Nav_Div Nav_Div3"><a href="/onlineShop/webContent/webPre/shoppingCart/shoppingCart.php" >购物车</a></div>
			<div class="Nav_Div Nav_Div4"><a href="<?php echo $loginText['url'];?>"><?php echo $loginText['text']; ?></a></div>
			<!-- <button type="button" class="btn btn-default Nav_Button" aria-label="Left Align">
			 				 <span class="lnr lnr-user" aria-hidden="true" ></span>
			</button> -->
			</div>
		</nav>


		<script type="text/javascript">
		function searchNav () {
			var theInput=document.getElementById('navSearchInput').value;
			window.location='/onlineShop/webContent/webPre/goodsList/goodsList.php?type=<?php echo $theType;?>&name='+theInput;
		}
		</script>