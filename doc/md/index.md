## 一些公共api
	
> 鉴于php控制路由不方便，不采用标准RESTful

> <label id="CD" />restful 状态码
> 
	200 OK - [GET]：服务器成功返回用户请求的数据，该操作是幂等的（Idempotent）。
	201 CREATED - [POST/PUT/PATCH]：用户新建或修改数据成功。
	202 Accepted - [*]：表示一个请求已经进入后台排队（异步任务）
	204 NO CONTENT - [DELETE]：用户删除数据成功。
	400 INVALID REQUEST - [POST/PUT/PATCH]：用户发出的请求有错误，服务器没有进行新建或修改数据的操作，该操作是幂等的。
	401 Unauthorized - [*]：表示用户没有权限（令牌、用户名、密码错误）。
	403 Forbidden - [*] 表示用户得到授权（与401错误相对），但是访问是被禁止的。
	404 NOT FOUND - [*]：用户发出的请求针对的是不存在的记录，服务器没有进行操作，该操作是幂等的。
	406 Not Acceptable - [GET]：用户请求的格式不可得（比如用户请求JSON格式，但是只有XML格式）。
	410 Gone -[GET]：用户请求的资源被永久删除，且不会再得到的。
	422 Unprocesable entity - [POST/PUT/PATCH] 当创建一个对象时，发生一个验证错误。
	500 INTERNAL SERVER ERROR - [*]：服务器发生错误，用户将无法判断发出的请求是否成功。



### 1. [用户](user.html)
>	-  [用户基本管理](user.html) 
### 2. [管理员](admin.html)
### 3. [商品](goods.html)
>	-  [商品基本管理](goods.html#goods) 
>	-  [商品类型管理](goods.html#type) 
>	-  [商品照片管理](goods.html#photo) 
### 4. [地区](place.html)
>	-  [省份](place.html#province) 
>	-  [城市](place.html#city) 	
>	-  [学校](place.html#school)
### 5. [购物车](shoppingcart.html)
### 6. [订单](order.html)
### 7. [广告](advertisement.html)
### 8. 操作接口
>	-  [登录](login.html) 
>	-  [站点信息](website.html) 