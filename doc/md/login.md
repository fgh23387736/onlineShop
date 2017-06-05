#[登录](#login)、[退出登录](#logout)

###<a name='login'>登录</a>
	POST /onlineShop/src/v1/operation/login.php
	
	to:{
		Username:#用户名
		Password:#md5*2加密后的密码
		Type:(1|2)用户类型∈{
						1:普通用户
						2：管理员						
					}
	}
	#状态码为201时表示增加成功 并返回下列信息
	RETURN {
		
	}
	#修改失败时（状态码非201）并返回下列信息
	RETURN {
		Error:#出错原因
	}
	
	401 Unauthorized - [*]：表示用户没有权限（令牌、用户名、密码错误）。
	422 Unprocesable entity - [POST/PUT/PATCH] 当创建一个对象时，发生一个验证错误。

###<a name='logout'>2. 退出登录</a>
	GET /onlineShop/src/v1/operation/login.php
	#只有管理员有权限进行本操作，若不是管理员中断程序并返回401
	to:{
			
	}
	正确返回时状态码为204
	return{
	}
	#会自动跳转到主界面
	错误时除返回码还要返回错误信息
	return{
		Error:'错误信息'
	}

	错误码：
		401 Unauthorized - [*]：表示用户没有权限（令牌、用户名、密码错误）。

		
