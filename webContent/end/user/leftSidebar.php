		<?php 
			$url_page=explode('/', $_SERVER['PHP_SELF']);
			$url_page=explode('.', $url_page[count($url_page)-1]);
			$url_page=$url_page[0];
		 ?>
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li><a href="/onlineShop/webContent/end/user/index/index.php" class="<?php if($url_page=='index') echo 'active';?>"><i class="lnr lnr-home"></i> <span>首页</span></a></li>
						<li>
							<a href="#menuBuyer" data-toggle="collapse" class="<?php if($url_page=='finishedOrder'||$url_page=='toBeServedOrder'||$url_page=='toBeReceivedOrder'||$url_page=='toBeCommentedOrder') echo 'active'; else echo 'collapsed'?>"><i class="lnr lnr-cart"></i> <span>我是买家</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="menuBuyer" class="collapse <?php if($url_page=='finishedOrderB'||$url_page=='toBeServedOrder'||$url_page=='toBeReceivedOrder'||$url_page=='toBeCommentedOrder') echo 'in'; else echo ''?>">
								<ul class="nav">
									<li><a href="/onlineShop/webContent/end/user/buyer/toBeServedOrder/toBeServedOrder.php" class="<?php if($url_page=='toBeServedOrder') echo 'active'; else echo ''?>">待发货</a></li>
									<li><a href="/onlineShop/webContent/end/user/buyer/toBeReceivedOrder/toBeReceivedOrder.php" class="<?php if($url_page=='toBeReceivedOrder') echo 'active'; else echo ''?>">待收货</a></li>
									<li><a href="/onlineShop/webContent/end/user/buyer/toBeCommentedOrder/toBeCommentedOrder.php" class="<?php if($url_page=='toBeCommentedOrder') echo 'active'; else echo ''?>">待评价</a></li>
									<li><a href="/onlineShop/webContent/end/user/buyer/finishedOrder/finishedOrderB.php" class="<?php if($url_page=='finishedOrderB') echo 'active'; else echo ''?>">已完成订单</a></li>
								</ul>
							</div>
						</li>
						<li>
							<a href="#menuSeller" data-toggle="collapse" class="<?php if($url_page=='goods'||$url_page=='goodsPhoto'||$url_page=='toBeConfirmedOrder'||$url_page=='notIssuedOrder'||$url_page=='notServedOrder'||$url_page=='toBeEvaluateOrder'||$url_page=='finishedOrder') echo 'active'; else echo 'collapsed'?>"><i class="lnr lnr-store"></i> <span>我是卖家</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="menuSeller" class="collapse <?php if($url_page=='goods'||$url_page=='goodsPhoto'||$url_page=='toBeConfirmedOrder'||$url_page=='notIssuedOrder'||$url_page=='notServedOrder'||$url_page=='toBeEvaluateOrder'||$url_page=='finishedOrder') echo 'in'; else echo ''?>">
								<ul class="nav">
									<li><a href="/onlineShop/webContent/end/user/seller/goods/goods.php" class="<?php if($url_page=='goods') echo 'active'; else echo ''?>">我的商品</a></li>
									<li><a href="/onlineShop/webContent/end/user/seller/goodsPhoto/goodsPhoto.php" class="<?php if($url_page=='goodsPhoto') echo 'active'; else echo ''?>">商品相册</a></li>
									<li><a href="/onlineShop/webContent/end/user/seller/toBeConfirmedOrder/toBeConfirmedOrder.php" class="<?php if($url_page=='toBeConfirmedOrder') echo 'active'; else echo ''?>">待确认订单</a></li>
									<li><a href="/onlineShop/webContent/end/user/seller/notIssuedOrder/notIssuedOrder.php" class="<?php if($url_page=='notIssuedOrder') echo 'active'; else echo ''?>">未发出订单</a></li>
									<li><a href="/onlineShop/webContent/end/user/seller/notServedOrder/notServedOrder.php" class="<?php if($url_page=='notServedOrder') echo 'active'; else echo ''?>">未送达订单</a></li>
									<li><a href="/onlineShop/webContent/end/user/seller/toBeEvaluateOrder/toBeEvaluateOrder.php" class="<?php if($url_page=='toBeEvaluateOrder') echo 'active'; else echo ''?>">未评价订单</a></li>
									<li><a href="/onlineShop/webContent/end/user/seller/finishedOrder/finishedOrder.php" class="<?php if($url_page=='finishedOrder') echo 'active'; else echo ''?>">已完成订单</a></li>
								</ul>
							</div>
						</li>
						<li><a href="/onlineShop/webContent/end/user/personalInformation/personalInformation.php" class="<?php if($url_page=='personalInformation') echo 'active';?>"><i class="lnr lnr-user"></i> <span>个人中心</span></a></li>
					</ul>
				</nav>
			</div>
		</div>