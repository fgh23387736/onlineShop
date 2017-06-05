2. **管理员[增](#add)、[删](#delete)、[改](#change)、[查](#search)**
	- <a name="add">增</a>    
	
			POST /onlineShop/src/v1/admin/admin.php
			#只有管理员有权限操作
			to:{
				HeadImgUrl:, # HeadImgUrl是base64的形式
				# eg： data:image/png;base64,iVBORw0KG...
				# 数据应按格式解码并保存，GET 请求时返回的
				# 应是url而非dataurl 的格式
				Password，#加密后密码
				Name(string), #姓名
				Sex(int), #性别 ∈ {1：男 2：女 0：未知}
				Phone(string):#手机号，用作用户名
			}
			#状态码为201时表示增加成功 并返回下列信息
			RETURN {
				Id:#管理员Id
			}
			#修改失败时（状态码非201）并返回下列信息
			RETURN {
				Error:#出错原因
			}
			
			401 Unauthorized - [*]：表示用户没有权限（令牌、用户名、密码错误）。
			422 Unprocesable entity - [POST/PUT/PATCH] 当创建一个对象时，发生一个验证错误。
	- <a name="delete">删</a>  
	
			DELETE /onlineShop/src/admin/admin.php
			#只有高级别管理员有权限进行本操作，若不是高级别管理员中断程序并返回401
			to:{
				Type：（0|）#筛选方式（具体有多少情况根据开发增加）
				Search:{
					 Id：id1+id2+id3+... #要删除的管理员id
				}	
			}
			
			Search∈{
				{
					 Id：id1+id2+id3+... #要删除的管理员id
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
	- <a name="change">改</a>
	
			PUT  /onlineShop/src/v1/admin/admin.php
			#只有管理员自身有权限进行本操作，若当前用户无权限中断程序并返回401
			to:{
				Type：（01|2|）#修改方式（具体有多少情况根据开发增加）
				Id:'1+',#修改管理Id（若为空则为管理员本身）	
				Update:{

				}	
			}
			
			Update∈{
				{
					HeadImgUrl(string), #是base64或者URL
					# eg： data:image/png;base64,iVBORw0KG...
					# 数据应按格式解码并保存，GET 请求时返回的
					# 应是url而非dataurl 的格式
					Name(string), #姓名
					Sex(int), #性别 ∈ {1：男 2：女 0：未知}
				},#Type为0时（这种方式Id必须只有一个值）
				{
					Password(string):#原密码 MD5二级加密
					NewPassword(string):#新密码 MD5一级加密
					RepeatNewPassword(string):#重复新密码 MD5一级加密
				},#Type为1时此种情况下id只允许为一个
				
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
	- <a name="search">查</a>    
		
			GET /onlineShop/src/v1/admin/admin.php
			to:{
				Type：（0|1|）#筛选方式（具体有多少情况根据开发增加）
				Keys:'Id+HeadImgUrl+Name...',#需要获取的属性名，每个属性之间用'+'隔开
				Page:1,#当前页数，（可选，Page和PageSize必须同时存在）
				PageSize：10，#每页数据条数（可选，Page和PageSize必须同时存在）
				Search:{
					Id:'1+2+3+...',#搜索记录Id，若为空则为管理员本身
				}	
			}
			
			Search∈{
				{
					Id:'1+2+3+...',#搜索记录Id，若为空则为管理员本身
				},#Type为0时
			}	
			#若Keys为空则表示搜索下方全部字段
			Keys∈{
				Id(int): ,#管理Id
				HeadImgUrl(string), #个人头像的url
				Name(string), #姓名
				Sex(int), #性别 ∈ {1：男 2：女 0：未知}
				Phone(string):#手机号
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