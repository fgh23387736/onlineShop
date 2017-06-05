var pageListPath="/onlineShop/src/v1/shoppingcart/shoppingcart.php";
$("#pageList_selectAll").click(function(event) {
		var checkall = $(this).prop('checked');
		if(checkall) {
			$("input[name='pageList_eachcheckbox']").each(function() {
				$(this).prop('checked',true);
			});
		}
		else {
			$("input[name='pageList_eachcheckbox']").each(function() {
				$(this).prop('checked',false);
			});
		}
		getPrice();
});
var pageListmanage=new MyPage();
pageListmanage.init({
	requesturl:pageListPath,//向后台请求数据路径
	dataListId:"#insideList",//填充数据的元素可根据id(要写#  eg:#content)也可根据class(要写. eg:.content)也可直接写标签名称
	pageUI:"#pageList_pageui",//分页条按钮填充区域命名规则同上
	myname:"pageListmanage",//用户声明的变量名称
	searchType:1,
    searchKeys:'',
    searchData:{
		Id:''
	},//用户需要传到后台的多余数据可以为字符串，数字，或者json数据(此项可用来筛选数据，做查询功能)
	pgz:30,//每页显示数据条数
	but_num:20,//分页条按钮每组最多显示多少页
	beginsearch:true,//是否在初始化时填充数据
	drawDatatoCotent:function (data){
			var allstr="";
			allstr=''
			+'<div class="Cart_good">'
			+	'<label><input name="pageList_eachcheckbox" type="checkbox" value="'+data.Id+'" class="Cart_checkbox_good" onclick="getPrice()"/></label> '
			+	'<a href="/onlineShop/webContent/webPre/goods/goods.php?id='+data.GoodsId+'"><img src="'+data.GoodsImgUrl+'" width="120px" height="65px;"></a>'
			+	'<h5 class="Cart_h7">'+data.GoodsName+'</h5>'
			+	'<h5 class="Cart_h8">'+data.Number+'</h5>'
			+	'<h5 class="Cart_h9">'+data.GoodsPrice+'</h5>'
			+	'<button type="button" class="btn btn-default Cart_delete" aria-label="Left Align" onclick="pageListDeleteOne('+data.Id+')">'
			+			'<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>'
			+	'</button>'
			+	'<input type="hidden" value="'+data.GoodsId+'"/>'
			+'</div>';
			return allstr;
	},
	callBackOk:function(){
		document.getElementById('GoodsNumber').innerHTML='共'+this.dataNum+'件商品';
		getPrice();
	}
});


function pageListDeleteOne(id) {
    layer.msg('删除后不可恢复，您确定删除吗？', {
        time: 0 //不自动关闭
        ,
        btn: ['删除', '取消'],
        yes: function(index) {
            layer.close(index);
            layer.load(2);
            $.ajax({
                url: pageListPath,
                type: 'DELETE',
                dataType: 'json',
                data: {
                    Type:0,
                    Search: {
                        Id:id
                    }
                },
                success: function(data) {
                    layer.msg('删除成功', {
                        icon: 6
                    });
                    pageListmanage.searchAll();
                    layer.closeAll('loading');
                },
                error: function(data) {
                    pageListmanage.searchAll();
                    layer.closeAll('loading');
                    layer.msg(JSON.parse(data.responseText).Error, {
                        icon: 5
                    });
                }
            });
        }
    });
}

function getPrice(){
	var price=0;
	$("input[name='pageList_eachcheckbox']:checked").each(function() {
        var number=$(this).parents().next().next().next();
        price+=number.html()*number.next().html();
    });
    document.getElementById('AllPrice').innerHTML='￥'+price;
    if($("input[name='pageList_eachcheckbox']:checked").length>0){
    	document.getElementById('goPay').disabled=false;
    }else{
    	document.getElementById('goPay').disabled=true;
    }
}


function goPay() {
	var isReturn=false;
	if ($("input[name='pageList_eachcheckbox']:checked").length == 0) {
        layer.msg('请选择至少一条数据', {
            icon: 7
        });
    } else {
        layer.msg('您确定提交订单吗？', {
            time: 0 //不自动关闭
            ,
            btn: ['确定', '取消'],
            yes: function(index) {
                layer.close(index);
                layer.load(2);
                $("input[name='pageList_eachcheckbox']:checked").each(function() {
                    var index = $(this).val();
                    if(!isReturn){
                    	$.ajax({
					        url: '/onlineShop/src/v1/order/order.php',
					        type: 'POST',
					        dataType: 'json',
					        async: false,
					        data: {
					            GoodsId:$(this).parents().next().next().next().next().next().next().val(),
					            Number:$(this).parents().next().next().next().html()
					        },
					        success: function(data) {
					        	$.ajax({
					                url: pageListPath,
					                type: 'DELETE',
					                dataType: 'json',
					                async: false,
					                data: {
					                    Type:0,
					                    Search: {
					                        Id:index
					                    }
					                },
					                success: function(data) {
					                },
					                error: function(data) {
					                    pageListmanage.searchAll();
					                    layer.closeAll('loading');
					                    layer.msg(JSON.parse(data.responseText).Error, {
					                        icon: 5
					                    });
					                    isReturn=true;
					                    return;
					                }
					            });
					        	layer.closeAll('loading');
					        },
					        error: function(data) {
					            layer.closeAll('loading');
					            pageListmanage.searchAll();
					            layer.msg(JSON.parse(data.responseText).Error, {
					                icon: 5
					            });
					            isReturn=true;
					            return;
					        }
					    });
					}else{
						return;
					}
                    
                });
				if(!isReturn){
					pageListmanage.searchAll();
					layer.closeAll('loading');
					layer.msg('提交成功', {
		                icon: 6
		            });
				}
				
            }
        });
    }
}