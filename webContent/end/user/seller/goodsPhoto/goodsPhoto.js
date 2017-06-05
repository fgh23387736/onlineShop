var pageListPath="/onlineShop/src/v1/goods/photo.php";
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
	searchType:2,
    searchKeys:'',
    searchData:{
		GoodsId:''
	},//用户需要传到后台的多余数据可以为字符串，数字，或者json数据(此项可用来筛选数据，做查询功能)
	pgz:10,//每页显示数据条数
	but_num:20,//分页条按钮每组最多显示多少页
	beginsearch:true,//是否在初始化时填充数据
	drawDatatoCotent:function (data){
			var allstr="";
			allstr="<tr>"
			+"<td><input type=\"checkbox\" name=\"pageList_eachcheckbox\" value='"+data.Id+"'>"
			+"</td><td>"+data.Id
            +"</td><td><img src='"+this.checkTypedof(data.Url)+"' height='80'>"
            +"</td><td>"+data.GoodsId
			+"</td><td>"+"<button type='button' class='btn btn-danger  btn-sm' onclick='pageListDeleteOne("+data.Id+")'>删除</button>"
			+"</td></tr>";
			return allstr;
	}
});
function pageListInit(){
    pageListmanage.searchAll();
}
function pageListAdd() {
    layer.open({
        type: 2,
        area: ['1000px', '500px'],
        fix: false,
        //不固定
        maxmin: true,
        content: '/onlineShop/webContent/end/user/seller/goodsPhoto/addGoodsPhoto.php',
        title: '增加图片'
    });
}

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

function pageListDelete() {
    if ($("input[name='pageList_eachcheckbox']:checked").length == 0) {
        layer.msg('请选择至少一条数据', {
            icon: 7
        });
    } else {
        layer.msg('删除后不可恢复，您确定删除吗？', {
            time: 0 //不自动关闭
            ,
            btn: ['删除', '取消'],
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
                    type: 'DELETE',
                    dataType: 'json',
                    data: {
                        Type:0,
                        Search: {
                            Id:str
                        }
                    },
                    success: function(data) {
                        layer.msg('删除成功', {
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
		GoodsId:$("#goodsId").val()
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