		<?php 
			$url_page=explode('/', $_SERVER['PHP_SELF']);
			$url_page=explode('.', $url_page[count($url_page)-1]);
			$url_page=$url_page[0];
		 ?>
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li><a href="/onlineShop/webContent/end/admin/index/index.php" class="<?php if($url_page=='index') echo 'active';?>"><i class="lnr lnr-home"></i> <span>首页</span></a></li>
						<li>
							<a href="#menuGoods" data-toggle="collapse" class="<?php if($url_page=='goodsType'||$url_page=='goods') echo 'active'; else echo 'collapsed'?>"><i class="lnr lnr-store"></i> <span>商品管理</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="menuGoods" class="collapse <?php if($url_page=='goodsType'||$url_page=='goods') echo 'in'; else echo ''?>">
								<ul class="nav">
									<li><a href="/onlineShop/webContent/end/admin/goods/goodsType/goodsType.php" class="<?php if($url_page=='goodsType') echo 'active'; else echo ''?>">商品类型管理</a></li>
									<li><a href="/onlineShop/webContent/end/admin/goods/goods/goods.php" class="<?php if($url_page=='goods') echo 'active'; else echo ''?>">商品管理</a></li>
								</ul>
							</div>
						</li>
						<li>
							<a href="#menuPlace" data-toggle="collapse" class="<?php if($url_page=='province'||$url_page=='city'||$url_page=='school') echo 'active'; else echo 'collapsed'?>"><i class="fa fa-map-o"></i> <span>地区管理</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="menuPlace" class="collapse <?php if($url_page=='province'||$url_page=='city'||$url_page=='school') echo 'in'; else echo ''?>">
								<ul class="nav">
									<li><a href="/onlineShop/webContent/end/admin/place/province/province.php" class="<?php if($url_page=='province') echo 'active'; else echo ''?>">省份管理</a></li>
									<li><a href="/onlineShop/webContent/end/admin/place/city/city.php" class="<?php if($url_page=='city') echo 'active'; else echo ''?>">城市管理</a></li>
									<li><a href="/onlineShop/webContent/end/admin/place/school/school.php" class="<?php if($url_page=='school') echo 'active'; else echo ''?>">学校管理</a></li>
								</ul>
							</div>
						</li>
						<li><a href="/onlineShop/webContent/end/admin/user/user.php" class="<?php if($url_page=='user') echo 'active';?>"><i class="fa fa-user-plus"></i> <span>用户管理</span></a></li>
						<li><a href="/onlineShop/webContent/end/admin/advertisement/advertisement.php" class="<?php if($url_page=='advertisement') echo 'active';?>"><i class="lnr lnr-leaf"></i> <span>广告管理</span></a></li>
						<li><a href="/onlineShop/webContent/end/admin/personalInformation/personalInformation.php" class="<?php if($url_page=='personalInformation') echo 'active';?>"><i class="lnr lnr-user"></i> <span>个人中心</span></a></li>
					</ul>
				</nav>
			</div>
		</div>