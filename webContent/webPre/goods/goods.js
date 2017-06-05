init();
var pageListmanage=new MyPage();
function init(){
	if (id=='') {
		layer.alert('路径格式错误', {
		  /*skin: 'layui-layer-molv' //样式类名
		  ,*/title:'警告'
		  ,icon:5
		  ,closeBtn: 0
		}, function(){
		  window.location='/onlineShop/webContent/webPre/index/index.php';
		});
		return
	};
	layer.load(2);
	$.ajax({
        url: '/onlineShop/src/v1/goods/goods.php',
        type: 'GET',
        dataType: 'json',
        data: {
            Type:0,
            Keys:'',
            Search: {
                Id:id
            }
        },
        success: function(data) {
        	if(data.ResultList.length>0){
        		document.getElementById('goodsName').innerHTML=data.ResultList[0].Name;
        		document.getElementById('userName').innerHTML=data.ResultList[0].UserName;
        		document.getElementById('Good').innerHTML=data.ResultList[0].Good;
        		document.getElementById('Middle').innerHTML=data.ResultList[0].Middle;
        		document.getElementById('Bad').innerHTML=data.ResultList[0].Bad;
        		document.getElementById('Price').innerHTML='￥'+data.ResultList[0].Price;
        		document.getElementById('Number').innerHTML='剩余数量:'+data.ResultList[0].Number;
        		document.getElementById('tab-bottom-left1').innerHTML=data.ResultList[0].Introduce;
        		if(data.ResultList[0].Number<=0){
        			document.getElementById('BuyNow').disabled=true;
        			document.getElementById('AddToShoppingCart').disabled=true;
        		}
        		var Img=data.ResultList[0].ImgUrl;
        		$.ajax({
			        url: '/onlineShop/src/v1/goods/photo.php',
			        type: 'GET',
			        dataType: 'json',
			        data: {
			            Type:1,
			            Keys:'Url',
			            Search: {
			                GoodsId:id
			            }
			        },
			        success: function(data) {
			        	drawPic(Img,data.ResultList);
			        },
			        error: function(data) {
			            layer.closeAll('loading');
			            layer.msg(JSON.parse(data.responseText).Error, {
			                icon: 5
			            });
			        }
			    });
			    pageListmanage.init({
					requesturl:'/onlineShop/src/v1/order/order.php',//向后台请求数据路径
					dataListId:"#userComment",//填充数据的元素可根据id(要写#  eg:#content)也可根据class(要写. eg:.content)也可直接写标签名称
					pageUI:"#pageList_pageui",//分页条按钮填充区域命名规则同上
					myname:"pageListmanage",//用户声明的变量名称
					searchType:3,
				    searchKeys:'UserName+CustomerEvaluate+CustomerEvaluateText+UserImgUrl',
				    searchData:{
						GoodsId:id
					},//用户需要传到后台的多余数据可以为字符串，数字，或者json数据(此项可用来筛选数据，做查询功能)
					pgz:20,//每页显示数据条数
					but_num:20,//分页条按钮每组最多显示多少页
					beginsearch:true,//是否在初始化时填充数据
					drawDatatoCotent:function (data){
							var allstr="";
							switch(data.CustomerEvaluate){
								case '0':
									data.CustomerEvaluate='<span class="lnr lnr-smile"></span>';
								break;
								case '1':
									data.CustomerEvaluate='<span class="lnr lnr-neutral"></span>';
								break;
								case '2':
									data.CustomerEvaluate='<span class="lnr lnr-sad"></span>';
								break;
								default:
									data.CustomerEvaluate='';
							}
							allstr+=''
							+'<div class="pinglun">'
							+	'<img class="img1" src="'+data.UserImgUrl+'" width=50px height=50px> '
							+	'<div class="user1">'
							+		'<p class="name1">'+data.UserName+'</p>'
							+		data.CustomerEvaluate
							+	'</div>'
							+	'<br>'
							+	'<br>'
							+	'<br>'
							+	'<div class="comment">'
							+		'<p>'+data.CustomerEvaluateText+'</p>'
							+	'</div>'
							+'</div>';
							return allstr;
					}
				});
        	}else{
        		layer.closeAll('loading');
        		layer.alert('该商品不存在', {
				  /*skin: 'layui-layer-molv' //样式类名
				  ,*/title:'警告'
				  ,icon:5
				  ,closeBtn: 0
				}, function(){
				  window.location='/onlineShop/webContent/webPre/index/index.php';
				});
        	}
        	layer.closeAll('loading');
        },
        error: function(data) {
            layer.closeAll('loading');
            layer.msg(JSON.parse(data.responseText).Error, {
                icon: 5
            });
        }
    });
}


function drawPic (Img,data) {
	$('#picInside').children().remove();
	var strOl='<ol class="carousel-indicators">';
	var strImg='<div class="carousel-inner" data-ride="carousel">'
	strOl+='<li data-target="#myCarousel" data-slide-to="0" class="active"></li>';
	strImg+=''
		+'<div class="item active">'
		+	'<img src="'+Img+'"  style="width:450px;height:270px;">'
		+'</div>';
	for (var i = 1; i <= data.length; i++) {
		if(i==0){
			strOl+='<li data-target="#myCarousel" data-slide-to="'+i+'" class="active"></li>';
			strImg+=''
				+'<div class="item active">'
				+	'<img src="'+data[i-1].Url+'"  style="width:450px;height:270px;">'
				+'</div>';
		}else{
			strOl+='<li data-target="#myCarousel" data-slide-to="0" ></li>';
			strImg+=''
				+'<div class="item">'
				+	'<img src="'+data[i-1].Url+'"  style="width:450px;height:270px;">'
				+'</div>';
		}
	};
	strOl+='</ol>';
	strImg+='</div>';
	$('#picInside').append(strOl+strImg);
}



function buyNow () {
	layer.prompt({title: '输入购买数量', formType: 0}, function(text, index){
	    layer.close(index);
	    if(text<=0){
	    	layer.msg('请输入大于0的数', {
                icon: 5
            });
	    	return;
	    }
	    layer.load(2);
		$.ajax({
	        url: '/onlineShop/src/v1/order/order.php',
	        type: 'POST',
	        dataType: 'json',
	        data: {
	            GoodsId:id,
	            Number:text
	        },
	        success: function(data) {
	        	layer.msg('下单成功，请到后台管理界面查看订单详细信息', {
	                icon: 6
	            });
	        	layer.closeAll('loading');
	        },
	        error: function(data) {
	            layer.closeAll('loading');
	            layer.msg(JSON.parse(data.responseText).Error, {
	                icon: 5
	            });
	        }
	    });
	});
}

function addToShoppingCart () {
	layer.prompt({title: '输入购买数量', formType: 0}, function(text, index){
		if(text<=0){
	    	layer.msg('请输入大于0的数', {
                icon: 5
            });
	    	return;
	    }
	    layer.close(index);
	    layer.load(2);
		$.ajax({
	        url: '/onlineShop/src/v1/shoppingcart/shoppingcart.php',
	        type: 'POST',
	        dataType: 'json',
	        data: {
	            GoodsId:id,
	            Number:text
	        },
	        success: function(data) {
	        	layer.msg('加入购物车成功', {
	                icon: 6
	            });
	        	layer.closeAll('loading');
	        },
	        error: function(data) {
	            layer.closeAll('loading');
	            layer.msg(JSON.parse(data.responseText).Error, {
	                icon: 5
	            });
	        }
	    });
	});
}
