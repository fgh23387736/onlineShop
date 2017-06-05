1. <a name='province'></a> **省份[增](#province_add)、[删](#province_delete)、[改](#province_change)、[查](#province_search)**
	- <a name="province_add">增</a>
	
			POST /onlineShop/src/v1/place/province.php
			#只有管理员有权限操作
			to:{
				Name:#省份名称
			}
			#状态码为201时表示增加成功 并返回下列信息
			RETURN {
				Id:#省份Id
			}
			#修改失败时（状态码非201）并返回下列信息
			RETURN {
				Error:#出错原因
			}
			
			401 Unauthorized - [*]：表示用户没有权限（令牌、用户名、密码错误）。
			422 Unprocesable entity - [POST/PUT/PATCH] 当创建一个对象时，发生一个验证错误。
	- <a name="province_delete">删</a>
	
			DELETE /onlineShop/src/v1/place/province.php
			#只有管理员有权限进行本操作，若不是管理员中断程序并返回401
			to:{
				Type：（0|）#筛选方式（具体有多少情况根据开发增加）
				Search:{
					 Id：id1+id2+id3+... #要删除的省份id
				}	
			}
			
			Search∈{
				{
					 Id：id1+id2+id3+... #要删除的省份id
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
	- <a name="province_change">改</a>
	
			PUT  /onlineShop/src/v1/place/province.php
			#只有管理员有权限进行本操作，若当前用户无权限中断程序并返回401
			to:{
				Type：（0）#修改方式（具体有多少情况根据开发增加）
				Id:'1+',#修改省份Id		
				Update:{
					Name:#省份名称
				}	
			}
			
			Update∈{
				{
					Name:#省份名称
				},#Type为0时，
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
	- <a name="province_search">查</a>  
			
			GET /onlineShop/src/v1/place/province.php
			to:{
				Type：（0|1|）#筛选方式（具体有多少情况根据开发增加）
				Keys:'Id+Name+Citys...',#需要获取的属性名，每个属性之间用'+'隔开
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
					Name:1,#省份名称
				},#Type为1时
			}	
			#若Keys为空则表示搜索下方全部字段
			Keys∈{
				Id(int): ,#省份Id
				Name(string), #姓名
				Citys(arr,json)：[
					{
						Id(int)：该省城市1id，
						Name(string)：城市名称
					}，
					{
						Id(int)：该省城市2id，
						Name(string)：城市名称
					}，
					...
				],
				CitysId(arr,int)：[id1,id2,id3,...],该省城市id
			}
			
			#正确返回时状态码为200
			return{
				Total：10,#未分页时搜索到总数据条数，当Page和PageSize不存在时就是ResultList的长度
				ResultList[
					{
						Id:,
						Name:,
						Citys:,
						...	
					},
					{
						Id:,
						Name:,
						Citys:,
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
1. <a name='city'></a> **城市[增](#city_add)、[删](#city_delete)、[改](#city_change)、[查](#city_search)**
	- <a name="city_add">增</a>
	
			POST /onlineShop/src/v1/place/city.php
			#只有管理员有权限操作
			to:{
				ProvinceId：#所属省份Id
				Name:#城市名称
			}
			#状态码为201时表示增加成功 并返回下列信息
			RETURN {
				Id:#城市Id
			}
			#修改失败时（状态码非201）并返回下列信息
			RETURN {
				Error:#出错原因
			}
			
			401 Unauthorized - [*]：表示用户没有权限（令牌、用户名、密码错误）。
			422 Unprocesable entity - [POST/PUT/PATCH] 当创建一个对象时，发生一个验证错误。
	- <a name="city_delete">删</a>
	
			DELETE /onlineShop/src/v1/place/city.php
			#只有管理员有权限进行本操作，若不是管理员中断程序并返回401
			to:{
				Type：（0|）#筛选方式（具体有多少情况根据开发增加）
				Search:{
					  Id：id1+id2+id3+... #要删除的城市id
				}	
			}
			
			Search∈{
				{
					  Id：id1+id2+id3+... #要删除的城市id
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
	- <a name="city_change">改</a>
	
			PUT  /onlineShop/src/v1/place/city.php
			#只有管理员有权限进行本操作，若当前用户无权限中断程序并返回401
			to:{
				Type：（0|1|）#修改方式（具体有多少情况根据开发增加）
				Id:'1+2+3+...',#修改城市Id		
				Update:{
					Name:#城市名称
					ProvinceId:#所属省份Id
				}	
			}
			
			Update∈{
				{
					Name:#城市名称
					ProvinceId:#所属省份Id
				},#Type为0时，
				{
					ProvinceId:#所属省份Id
				},#Type为1时
				
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
	- <a name="city_search">查</a>  
			
			GET /onlineShop/src/v1/place/city.php
			to:{
				Type：（0|1|）#筛选方式（具体有多少情况根据开发增加）
				Keys:'Id+SchoolsId+ProvinceId...',#需要获取的属性名，每个属性之间用'+'隔开
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
					Name, #城市名称，若为空则搜索全部				
					ProvinceId：所属省份Id，若为空则表示搜索全部
				},#Type为1时
			}	
		
			Keys∈{
				Id(int): ,#城市Id
				Name(string), #城市名称
				Schools(arr,json)：[
					{
						Id(int)：该市学校1id，
						Name(string)：学校名称
					}，
					{
						Id(int)：该市学校1id，
						Name(string)：学校名称
					}，
					...
				],
				SchoolsId(arr,int)：[id1,id2,id3,...],该城市学校id
				ProvinceId(int)：所属省份Id
				Province(string)：所属省份名称
				
			}
			
			#正确返回时状态码为200
			return{
				Total：10,#未分页时搜索到总数据条数，当Page和PageSize不存在时就是ResultList的长度
				ResultList[
					{
						Id:,
						SchoolsId:,
						ProvinceId:,
						...	
					},
					{
						Id:,
						SchoolsId:,
						ProvinceId:,
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

			

1. <a name='school'></a> **学校[增](#school_add)、[删](#school_delete)、[改](#school_change)、[查](#school_search)**
	- <a name="school_add">增</a>
	
			POST /onlineShop/src/v1/place/school.php
			#只有管理员有权限操作
			to:{
				CityId：#所属城市Id
				Name:#学校名称
			}
			#状态码为201时表示增加成功 并返回下列信息
			RETURN {
				Id:#学校Id
			}
			#修改失败时（状态码非201）并返回下列信息
			RETURN {
				Error:#出错原因
			}
			
			401 Unauthorized - [*]：表示用户没有权限（令牌、用户名、密码错误）。
			422 Unprocesable entity - [POST/PUT/PATCH] 当创建一个对象时，发生一个验证错误。
	- <a name="school_delete">删</a>
	
			DELETE /onlineShop/src/v1/place/school.php
			#只有管理员有权限进行本操作，若不是管理员中断程序并返回401
			to:{
				Type：（0|）#筛选方式（具体有多少情况根据开发增加）
				Search:{
					 Id：id1+id2+id3+... #要删除的学校id
				}	
			}
			
			Search∈{
				{
					  Id：id1+id2+id3+... #要删除的学校id
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
	- <a name="school_change">改</a>
	
			PUT  /onlineShop/src/v1/place/school.php
			#只有管理员有权限进行本操作，若当前用户无权限中断程序并返回401
			to:{
				Type：（0|1|）#修改方式（具体有多少情况根据开发增加）
				Id:'1+2+3+...',#修改城市Id		
				Update:{
					Name:#学校名称
					CityId:#所属城市Id
				}	
			}
			
			Update∈{
				{
					Name:#学校名称
					CityId:#所属城市Id
				},#Type为0时，
				{
					CityId:#所属城市Id
				},#Type为1时
				
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
	- <a name="school_search">查</a>  
			
			GET /onlineShop/src/v1/place/school.php
			to:{
				Type：（0|1|）#筛选方式（具体有多少情况根据开发增加）
				Keys:'Id+Name+CityId...',#需要获取的属性名，每个属性之间用'+'隔开
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
					Name(string), #学校名称，若为空则表示全部
					ProvinceId(int)：所属省份Id（可选），若为空则表示搜索全部
					CityId(int)：所属城市Id，若为空则表示搜索该省全部，若省也为空则表示全部
				},#Type为1时
			}	
			#若Keys为空则表示搜索下方全部字段
			Keys∈{
				Id(int): ,#学校Id
				Name(string), #学校名称
				CityId(int)：所属城市Id
				City(string)：所属城市名称
				ProvinceId(string)：所属省份Id
				Province(string)：所属省份名称
				
			}
			
			#正确返回时状态码为200
			return{
				Total：10,#未分页时搜索到总数据条数，当Page和PageSize不存在时就是ResultList的长度
				ResultList[
					{
						Id:,
						Name:,
						CityId:,
						...	
					},
					{
						Id:,
						Name:,
						CityId:,
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


1. <a name='JSON'></a> **JSON数据**
	
			URL /onlineShop/src/v1/place/place.json
			
			数据格式eg：
			[
				{
					name:"全国",
					Id:"",
					sub:[
						{
							name:"全部城市"，
							Id："",
							sub:[
								{
									name:"全部学校"，
									Id：""
								}
							]
						}
					]
				},
				{
					name:"山东省",
					Id:"1",
					sub:[
						{
							name:"全部城市"，
							Id："",
							sub:[
								{
									name:"全部学校"，
									Id：""
								}
							]
						}，
						{
							name:"威海市"，
							Id："1",
							sub:[
								{
									name:"全部学校"，
									Id：""
								},
								{
									name:"哈工大威海"，
									Id："1"
								},
								....
							]
						},
						....
						
					]
				},
				.....
			]