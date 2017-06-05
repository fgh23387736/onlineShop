1.  <a name='goods'></a>**商品[增](#goods_add)、[删](#goods_delete)、[改](#goods_change)、[查](#goods_search)**
	- <a name="goods_add">增</a>
	
			POST /onlineShop/src/v1/goods/goods.php
			to:{
				ImgUrl(string):, # 展示图片Url
				Name(string), #货物名称
				Type(int)：，#货物类型Id
				Number(int):,#货物剩余数量
				Price(int):,#价格
				Introduce(string):#货物介绍
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
	- <a name="goods_delete">删</a>
	
			DELETE /onlineShop/src/v1/goods/goods.php
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
	- <a name="goods_change">改</a>
	
			PUT  /onlineShop/src/v1/goods/goods.php
			#只有货物拥有者有权限进行本操作，若当前用户无权限中断程序并返回401
			to:{
				Type：（0）#修改方式（具体有多少情况根据开发增加）
				Id:'1+',#修改活动Id		
				Update:{

				}	
			}
			
			Update∈{
				{
					ImgUrl(string):, # 展示图片Url					
					Name(string), #货物名称
					Type(int)：，#货物类型Id
					Number(int):,#货物剩余数量
					Price(int):,#价格
					Introduce(string):#货物介绍
				},#Type为0时（这种方式Id必须只有一个值）
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
	- <a name="goods_search">查</a>  
			
			GET /onlineShop/src/v1/goods/goods.php
			to:{
				Type：（0|1|2|）#筛选方式（具体有多少情况根据开发增加）
				Keys:'Id+ImgUrl+Name...',#需要获取的属性名，每个属性之间用'+'隔开
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
					Name(string), #货物名称
					Type(int)：，#货物类型Id，若为空则搜索全部类型
				},#Type为1时,这种方式要求用户必须登录，且只会检索到该用户的商品
				{
					Id(int), #货物Id，若为空则搜索全部
					Name(string), #货物名称
					Type(int)：，#货物类型Id，若为空则搜索全部类型
				},#Type为2时
				
			}	
			#若Keys为空则表示搜索下方全部字段
			Keys∈{
				Id(int): ,#货物Id
				ImgUrl(string):, # 展示图片Url
				Name(string), #货物名称
				UserId(int)：#货物所属者Id
				UserName(string)：#货物所属者名称
				Type(int)：，#货物类型Id
				Number(int):,#货物剩余数量
				Price(int):,#价格
				Introduce(string):#货物介绍
				Good(int):,#好评数量
				Middle(int):#中评数量
				Bad(int):#差评数量
			}
			
			#正确返回时状态码为200
			return{
				Total：10,#未分页时搜索到总数据条数，当Page和PageSize不存在时就是ResultList的长度
				ResultList[
					{
						Id:,
						ImgUrl:,
						Name:,
						...	
					},
					{
						Id:,
						ImgUrl:,
						Name:,
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

1.  <a name='type'></a>**商品类型[增](#type_add)、[删](#type_delete)、[改](#type_change)、[查](#type_search)**
	- <a name="type_add">增</a>
	
			POST /onlineShop/src/v1/goods/type.php
			#只有管理员有权限操作
			to:{
				Name(string)：，#类型名称

			}
			#状态码为201时表示增加成功 并返回下列信息
			RETURN {
				Id:#Id
			}
			#修改失败时（状态码非201）并返回下列信息
			RETURN {
				Error:#出错原因
			}
			
			401 Unauthorized - [*]：表示用户没有权限（令牌、用户名、密码错误）。
			422 Unprocesable entity - [POST/PUT/PATCH] 当创建一个对象时，发生一个验证错误。
	- <a name="type_delete">删</a>
	
			DELETE /onlineShop/src/v1/goods/type.php
			#只有管理员和活动发起者有权限进行本操作，若不是管理员中断程序并返回401
			to:{
				Type：（0|1|）#筛选方式（具体有多少情况根据开发增加）
				Search:{
					  Id：id1+id2+id3+... #要删除的id
				}	
			}
			
			Search∈{
				{
					  Id：id1+id2+id3+... #要删除的id
				},#Type为0时
				{
					Name(string)：，#类型名称
				},#Type为1时
			}	
		
			#正确返回时状态码为204
			return{
			}
			#会删除所有该问题的回答
			#错误时除返回码还要返回错误信息
			return{
				Error:'错误信息'
			}
		
			错误码：
				401 Unauthorized - [*]：表示用户没有权限（令牌、用户名、密码错误）。
				403 Forbidden - [*] 表示用户得到授权（与401错误相对），但是访问是被禁止的。
				404 NOT FOUND - [*]：用户发出的请求针对的是不存在的记录，服务器没有进行操作，该操作是幂等的。
				406 Not Acceptable - [GET]：用户请求的格式不可得（比如用户请求JSON格式，但是只有XML格式）
				500 INTERNAL SERVER ERROR - [*]：服务器发生错误，用户将无法判断发出的请求是否成功。
	- <a name="type_change">改</a>
	
			PUT  /onlineShop/src/v1/goods/type.php
			#只有管理员有权限进行本操作，若当前用户无权限中断程序并返回401
			to:{
				Type：（0|1|）#修改方式（具体有多少情况根据开发增加）
				Id:'1+2+3+...',#记录Id
				Update:{
					Name(string)：，#类型名称
				}	
			}
			
			Update∈{
				{
					Name(string)：，#类型名称
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
	- <a name="type_search">查</a>  
			
			GET /onlineShop/src/v1/goods/type.php
			to:{
				Type：（0|1|）#筛选方式（具体有多少情况根据开发增加）
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
					Name(string)：，#类型名称，采用模糊搜多，若为空则为全部
				},#Type为1时
			}	
			#若Keys为空则表示搜索下方全部字段
			Keys∈{
				Id(int): ,#类型Id
				Name(string)：，#类型名称
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


1.  <a name='photo'></a>**货物照片[增](#photo_add)、[删](#photo_delete)、[改](#photo_change)、[查](#photo_search)**
	- <a name="photo_add">增</a>
	
			POST /onlineShop/src/v1/goods/photo.php
			#只有货物拥有者有权限进行本操作，若当前用户无权限中断程序并返回401
			to:{
				GoodsId(int)：，#货物Id
				Url(string)：, #图片base64编码
			}
			#状态码为201时表示增加成功 并返回下列信息
			RETURN {
				Id:#照片Id
			}
			#修改失败时（状态码非201）并返回下列信息
			RETURN {
				Error:#出错原因
			}
			
			401 Unauthorized - [*]：表示用户没有权限（令牌、用户名、密码错误）。
			422 Unprocesable entity - [POST/PUT/PATCH] 当创建一个对象时，发生一个验证错误。
	- <a name="photo_delete">删</a>
	
			DELETE /onlineShop/src/v1/goods/photo.php
			#只有货物拥有者有权限进行本操作，若当前用户无权限中断程序并返回401
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
	- <a name="photo_change">改</a>
			
			#不提供修改接口，若需修改则删除后重新添加

	- <a name="photo_search">查</a>  
			
			GET /onlineShop/src/v1/goods/photo.php
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
					GoodsId(int)：，#货物Id，若为空则则搜索全部记录
				},#Type为1时
				{
					GoodsId(int)：，#货物Id，若为空则则搜索全部记录
				},#Type为2时，这种方式只会返回该用户自己的货物照片
			}	
			#若Keys为空则表示搜索下方全部字段
			Keys∈{
				Id(int): ,#照片Id
				GoodsId(int)：，#货物Id
				Url(string)：, #图片Url
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
