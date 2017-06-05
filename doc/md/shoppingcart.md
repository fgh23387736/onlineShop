1.  **购物车[增](#shoppingcart_add)、[删](#shoppingcart_delete)、[改](#shoppingcart_change)、[查](#shoppingcart_search)**
	- <a name="shoppingcart_add">增</a>
	
			POST /onlineShop/src/v1/shoppingcart/shoppingcart.php
			#必须登录
			to:{
				GoodsId(int)：，#货物Id
				Number(int)：，#数量
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
	
			DELETE /onlineShop/src/v1/shoppingcart/shoppingcart.php
			#只有货物拥有者有权限进行本操作，若不是管理员中断程序并返回401
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
	- <a name="shoppingcart_change">改</a>
	
			PUT  /onlineShop/src/v1/shoppingcart/shoppingcart.php
			#只有货物拥有者有权限进行本操作，若当前用户无权限中断程序并返回401
			to:{
				Type：（0）#修改方式（具体有多少情况根据开发增加）
				Id:'1+',#修改记录Id		
				Update:{

				}	
			}
			
			Update∈{
				{
					Number(int)：，#数量
				},#Type为0时
			}	
		
			
			正确返回时状态码为201
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
				406 Not Acceptable - [GET]：用户请求的格式不可得（比如用户请求JSON格式，但是只有XML格式）。
				500 INTERNAL SERVER ERROR - [*]：服务器发生错误，用户将无法判断发出的请求是否成功。
	- <a name="shoppingcart_search">查</a>  
			
			GET /onlineShop/src/v1/shoppingcart/shoppingcart.php
			to:{
				Type：（0|1|2|）#筛选方式（具体有多少情况根据开发增加）
				Keys:'Id+...',#需要获取的属性名，每个属性之间用'+'隔开
				Page:1,#当前页数，（可选，Page和PageSize必须同时存在）
				PageSize：10，#每页数据条数（可选，Page和PageSize必须同时存在）
				Search:{
					Id:'1+2+3+...',#搜索记录Id，若为空则搜索全部记录
				}	
			}
			
			Search∈{
				{
					Id:'1+2+3+...',#搜索记录Id，若为空则则搜索全部记录
				},#Type为0时
				{
					Id:'1+2+3+...',#搜索记录Id，若为空则则搜索全部记录
				},#Type为1时，这种方式只会返回该用户的购物车
				
			}	
			#若Keys为空则表示搜索下方全部字段
			Keys∈{
				Id(int): ,#记录Id
				UserId(int)：#收藏者Id
				GoodsId(int)：，#货物Id
				GoodsImgUrl(string)：，#货物照片
				GoodsName(string)：，#货物名称
				GoodsPrice(int)：，#货物单价
				Number(int)：，#数量
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

