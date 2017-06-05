1.  <a name='user'></a>**用户[增](#user_add)、[删](#user_delete)、[改](#user_change)、[查](#user_search)**  
	- <a name="shoppingcart_add">增</a>
	
			POST /onlineShop/src/v1/user/user.php
			to:{
				Phone(string):#手机号
				Password(string):#密码
				RepeatPassword(string):#重复密码
			}
			#状态码为201时表示增加成功 并返回下列信息
			RETURN {
				Id:#记录Id
			}
			#修改失败时（状态码非201）并返回下列信息
			RETURN {
				Error:#出错原因
			}
			
			401 Unauthorized - [*]：表示用户没有权限（令牌、用户名、密码错误）。
			422 Unprocesable entity - [POST/PUT/PATCH] 当创建一个对象时，发生一个验证错误。
	- <a name="shoppingcart_delete">删</a>
	
			DELETE /onlineShop/src/v1/user/user.php
			#只有管理员有权限进行本操作，若不是管理员中断程序并返回401
			to:{
				Type：（0|）#筛选方式（具体有多少情况根据开发增加）
				Search:{
					 Id：id1+id2+id3+... #要删除的记录id
				}	
			}
			
			Search∈{
				{
					 Id：id1+id2+id3+... #要删除的记录id
				},#Type为0时
			}	
		
			正确返回时状态码为204
			return{
			}
			
			错误时除返回码还要返回错误信息
			return{
				Error:'错误信息'
			}
		
			错误码：
				401 Unauthorized - [*]：表示用户没有权限（令牌、用户名、密码错误）。
				403 Forbidden - [*] 表示用户得到授权（与401错误相对），但是访问是被禁止的。
				404 NOT FOUND - [*]：用户发出的请求针对的是不存在的记录，服务器没有进行操作，该操作是幂等的。
				406 Not Acceptable - [GET]：用户请求的格式不可得（比如用户请求JSON格式，但是只有XML格式）
				500 INTERNAL SERVER ERROR - [*]：服务器发生错误，用户将无法判断发出的请求是否成功。
	- <a name="user_change">改</a>

			PUT /onlineShop/src/v1/user/user.php
			#只有管理员和用户自身有权限进行本操作，若当前用户无权限中断程序并返回401
			to:{
				Type：（0|）#修改方式（具体有多少情况根据开发增加）
				Id:'1+2+3+...',#搜索用户Id，若为空则搜索用户本身			
				Update:{
					
				}	
			}
			
			Update∈{
				{
					Name(string), #姓名
					HeadImgUrl(string), #个人头像的url或者base64编码
					Sex(int), #性别 ∈ {1：男 2：女 0：未知}
					ProvinceId(int):,# 省份（id）
					CityId(int):,#城市（id）
					SchoolId(int), # 学校（id)
				},#Type为0时在此种情况下id只允许为一个
				{
					Deadline(string):#封停截止日期
				},#Type为1时
				{
					Password(string):#原密码 MD5二级加密
					NewPassword(string):#新密码 MD5一级加密
					RepeatNewPassword(string):#重复新密码 MD5一级加密
				},#Type为2时此种情况下id只允许为一个
			}	
		
			
			正确返回时状态码为201
			return{
				Id:[
				]#修改成功的Id，这里是数组，就算只有一条数据也是数组
			}
			
			错误时除返回码还要返回错误信息
			return{
				Error:'错误信息'
			}
		
			错误码：
				401 Unauthorized - [*]：表示用户没有权限（令牌、用户名、密码错误）。
				403 Forbidden - [*] 表示用户得到授权（与401错误相对），但是访问是被禁止的。
				404 NOT FOUND - [*]：用户发出的请求针对的是不存在的记录，服务器没有进行操作，该操作是幂等的。
				406 Not Acceptable - [GET]：用户请求的格式不可得（比如用户请求JSON格式，但是只有XML格式）。
				500 INTERNAL SERVER ERROR - [*]：服务器发生错误，用户将无法判断发出的请求是否成功。
	- <a name="user_search">查</a>  
			
			GET /onlineShop/src/v1/user/user.php
	
			to:{
				Type：（0|）#筛选方式（具体有多少情况根据开发增加）
				Keys:'Id+...',#需要获取的属性名，每个属性之间用'+'隔开
				Page:1,#当前页数，（可选，Page和PageSize必须同时存在）
				PageSize：10，#每页数据条数（可选，Page和PageSize必须同时存在）
				Search:{
					Id:'1+2+3+...',#搜索用户Id，若为空则搜索用户本身	
				}	
			}
			
			Search∈{
				{
					Id:'1+2+3+...',#搜索用户Id，若为空则搜索用户本身	
				},#Type为0时
				{
					Id:'1+2+3+...',#搜索用户Id，若为空则搜索全部
					Name(string), #姓名，模糊搜索
				},#Type为1时
				
			}	
			#若Keys为空则表示搜索下方全部字段
			Keys∈{
				Id(int): ,#用户Id
				Name(string), #姓名
				HeadImgUrl(string), #个人头像的url
				Sex(int), #性别 ∈ {1：男 2：女 0：未知}
				ProvinceId(int):,# 省份（id）
				CityId(int):,#城市（id）
				SchoolId(int), # 学校（id)
				Province(string):,# 省份
				City(string):,#城市
				School(string), # 学校
				Phone(string):#手机号
				Password(string):#密码
				Good(int):,#好评数量
				Middle(int):#中评数量
				Bad(int):#差评数量
				GoodsNumber(int):#货物数量
				PurchasedGoodsNumber(int):#购买的商品
				SoldGoodsNubmer(int):#卖出的商品
				OrderNubmerILSD(arr,int):[1,2,3,4,5,6,7]#过去七天的订单数量
				PurchasedGoodsNumberILSD(arr，int):[1,2,3,4,5,6,7]#过去七天购买的货物数量
				Deadline(string):#封停截止日期
				Time(string):#注册时间
				
			}
			
			#正确返回时状态码为200
			return{
				Total：10,#未分页时搜索到总数据条数，当Page和PageSize不存在时就是ResultList的长度
				ResultList[
					{
						...	
					},
					{
						...	
					},
					...
				]
				
			}
			
			错误时除返回码还要返回错误信息
			return{
				Error:'错误信息'
			}
		
			错误码：
				401 Unauthorized - [*]：表示用户没有权限（令牌、用户名、密码错误）。
				403 Forbidden - [*] 表示用户得到授权（与401错误相对），但是访问是被禁止的。
				404 NOT FOUND - [*]：用户发出的请求针对的是不存在的记录，服务器没有进行操作，该操作是幂等的。
				406 Not Acceptable - [GET]：用户请求的格式不可得（比如用户请求JSON格式，但是只有XML格式）。
				410 Gone -[GET]：用户请求的资源被永久删除，且不会再得到的。
				500 INTERNAL SERVER ERROR - [*]：服务器发生错误，用户将无法判断发出的请求是否成功。

