1.  <a name='photo'></a>**广告照片[增](#photo_add)、[删](#photo_delete)、[改](#photo_change)、[查](#photo_search)**
	- <a name="photo_add">增</a>
	
			POST /onlineShop/src/v1/advertisement/advertisement.php
			#只有货物拥有者有权限进行本操作，若当前用户无权限中断程序并返回401
			to:{
				ImgUrl(string)：, #图片base64编码
				Url(string)：, #连接路径
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
	
			DELETE /onlineShop/src/v1/advertisement/advertisement.php
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
			
			GET /onlineShop/src/v1/advertisement/advertisement.php
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
			}	
			#若Keys为空则表示搜索下方全部字段
			Keys∈{
				Id(int): ,#照片Id
				ImgUrl(string)：, #图片Url
				Url(string)：, #连接路径
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
