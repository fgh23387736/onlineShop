var pageListPath="/onlineShop/src/v1/order/order.php";
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
});
var pageListmanage=new MyPage();
pageListmanage.init({
	requesturl:pageListPath,//向后台请求数据路径
	dataListId:"#pageList_tbody",//填充数据的元素可根据id(要写#  eg:#content)也可根据class(要写. eg:.content)也可直接写标签名称
	pageUI:"#pageList_pageui",//分页条按钮填充区域命名规则同上
	myname:"pageListmanage",//用户声明的变量名称
	searchType:1,
    searchKeys:'',
    searchData:{
		GoodsId:'',
        Type:'3+5'
	},//用户需要传到后台的多余数据可以为字符串，数字，或者json数据(此项可用来筛选数据，做查询功能)
	pgz:10,//每页显示数据条数
	but_num:20,//分页条按钮每组最多显示多少页
	beginsearch:true,//是否在初始化时填充数据
	drawDatatoCotent:function (data){
			var allstr="";
            switch(data.Type){
                case '0':
                    data.Type='待确认';
                break;
                case '1':
                    data.Type='已接单';
                break;
                case '2':
                    data.Type='配送中';
                break;
                case '3':
                    data.Type='已取消';
                break;
                case '4':
                    data.Type='已送达';
                break;
                case '5':
                    data.Type='已完成';
                break;
                default:
                    data.Type='未知状态';
            }
			switch(data.CustomerEvaluate){
                case '0':
                    data.CustomerEvaluate='<span class="label label-success">好评</span>';
                break;
                case '1':
                    data.CustomerEvaluate='<span class="label label-warning">中评</span>';
                break;
                case '2':
                    data.CustomerEvaluate='<span class="label label-danger">差评</span>';
                break;
                default:
                    data.CustomerEvaluate='<span class="label label-default">未评价</span>';
            }
            allstr="<tr>"
            +"<td><input type=\"checkbox\" name=\"pageList_eachcheckbox\" value='"+data.Id+"'>"
            +"</td><td>"+data.Id
            +"</td><td>"+this.checkTypedof(data.GoodsId)
            +"</td><td>"+this.checkTypedof(data.GoodsName)
            +"</td><td>"+this.checkTypedof(data.UserName)
            +"</td><td>"+this.checkTypedof(data.UserPhone)
            +"</td><td>"+this.checkTypedof(data.UserSchool)
            +"</td><td>"+this.checkTypedof(data.Type)
            +"</td><td>"+this.checkTypedof(data.Number)
            +"</td><td>"+this.checkTypedof(data.Price)
            +"</td><td>"+this.checkTypedof(data.CustomerEvaluate)
            /*+"</td><td>"+"<button type='button' class='btn btn-success  btn-sm' onclick='pageListOkOne("+data.Id+")'>确认送达</button>\n<button type='button' class='btn btn-danger  btn-sm' onclick='pageListDeleteOne("+data.Id+")'>取消订单</button>"*/
            +"</td></tr>";
			return allstr;
	}
});
function pageListInit(){
    pageListmanage.searchAll();
}
function pageListOk() {
    if ($("input[name='pageList_eachcheckbox']:checked").length == 0) {
        layer.msg('请选择至少一条数据', {
            icon: 7
        });
    } else {
        layer.load(2);
        var str = "";
        $("input[name='pageList_eachcheckbox']:checked").each(function() {
            str += $(this).val() + "+";
        });
        str = str.substring(0, str.length - 1);
        $.ajax({
            url: pageListPath,
            type: 'PUT',
            dataType: 'json',
            data: {
                Type:0,
                Id:str,
                Update: {
                    Type:4
                }
            },
            success: function(data) {
                layer.msg('确认成功', {
                    icon: 6
                });
                pageListmanage.searchAll();
                layer.closeAll('loading');
            },
            error: function() {
                pageListmanage.searchAll();
                layer.closeAll('loading');
                layer.msg(JSON.parse(data.responseText).Error, {
                    icon: 5
                });
            }
        });
    }
}

function pageListOkOne(id) {
    layer.load(2);
    $.ajax({
        url: pageListPath,
        type: 'PUT',
        dataType: 'json',
        data: {
            Type:0,
            Id:id,
            Update: {
                Type:4
            }
        },
        success: function(data) {
            layer.msg('确认成功', {
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

function pageListDeleteOne(id) {
    layer.msg('您确定取消订单吗？', {
        time: 0 //不自动关闭
        ,
        btn: ['取消订单', '再考虑一下'],
        yes: function(index) {
            layer.close(index);
            layer.load(2);
            $.ajax({
                url: pageListPath,
                type: 'PUT',
                dataType: 'json',
                data: {
                    Type:0,
                    Id:id,
                    Update: {
                        Type:3
                    }
                },
                success: function(data) {
                    layer.msg('取消成功', {
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

function pageListDelete() {
    if ($("input[name='pageList_eachcheckbox']:checked").length == 0) {
        layer.msg('请选择至少一条数据', {
            icon: 7
        });
    } else {
        layer.msg('您确定取消订单吗？', {
            time: 0 //不自动关闭
            ,
            btn: ['取消订单', '再考虑一下'],
            yes: function(index) {
                layer.close(index);
                layer.load(2);
                var str = "";
                $("input[name='pageList_eachcheckbox']:checked").each(function() {
                    str += $(this).val() + "+";
                });
                str = str.substring(0, str.length - 1);
                $.ajax({
                    url: pageListPath,
                    type: 'PUT',
                    dataType: 'json',
                    data: {
                        Type:0,
                        Id:str,
                        Update: {
                            Type:3
                        }
                    },
                    success: function(data) {
                        layer.msg('取消成功', {
                            icon: 6
                        });
                        pageListmanage.searchAll();
                        layer.closeAll('loading');
                    },
                    error: function() {
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
}
function pageListSearch(){
	pageListmanage.pg=1;
	pageListmanage.nowgroup=1;
	pageListmanage.searchData={
		GoodsId:$("#goodsId").val(),
        Type:'3+5'
	};
	pageListmanage.searchAll();
}
function pageListSearchAll(){
	$("#goodsId").val("");
	pageListSearch();
}
initSearchList();
function initSearchList(){
    
}