1.  <a name='website'></a>**站点、[查](#website_search)**  
	
	- <a name="website_search">查</a>  
			
			GET /onlineShop/src/v1/operation/website.php
	
			to:{
				Keys:'GoodsNumber+...',#需要获取的属性名，每个属性之间用'+'隔开
			}
			
			#若Keys为空则表示搜索下方全部字段
			Keys∈{
				GoodsNumber(int):#货物数量
				UserNumber(int):#用户数量
				OrderNubmer(int):#订单数量
				LoginNubmer(int):#登录数量
				OrderNubmerILSD(arr,int):[1,2,3,4,5,6,7]#过去七天的订单数量
				NewUserNubmerILSD(arr,int):[1,2,3,4,5,6,7]#过去七天的用户注册数量
				LoginNubmerILSD(arr,int):[1,2,3,4,5,6,7]#过去七天的用户登录数量
				
			}
			
			#正确返回时状态码为200
			return{
				GoodsNumber：，
				.....
				
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

