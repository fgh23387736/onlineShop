var pageListPath="/onlineShop/src/v1/user/user.php";
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
		Name:'',
        Id:''
	},//用户需要传到后台的多余数据可以为字符串，数字，或者json数据(此项可用来筛选数据，做查询功能)
	pgz:10,//每页显示数据条数
	but_num:20,//分页条按钮每组最多显示多少页
	beginsearch:true,//是否在初始化时填充数据
	drawDatatoCotent:function (data){
			var allstr="";
            var GoodPercent='0%';
            if(data.Good==0&&data.Middle==0&&data.Bad==0){
                GoodPercent='0%';
            }else{
                GoodPercent=(data.Good*100/(data.Good*1+data.Middle*1+data.Bad*1))+'%';
            }
            switch(data.Sex){
                case '0':
                    data.Sex='保密';
                break;
                case '1':
                    data.Sex='男';
                break;
                case '2':
                    data.Sex='女';
                break;
                default:
                    data.Sex='未知';
            }
			allstr="<tr>"
			+"<td><input type=\"checkbox\" name=\"pageList_eachcheckbox\" value='"+data.Id+"'>"
			+"</td><td>"+data.Id
			+"</td><td>"+this.checkTypedof(data.Name)
            +"</td><td>"+this.checkTypedof(data.Sex)
            +"</td><td>"+this.checkTypedof(data.Phone)
            +"</td><td>"+this.checkTypedof(data.School)
            +"</td><td>"+this.checkTypedof(data.GoodsNumber)
            +"</td><td>"+this.checkTypedof(GoodPercent)
            +"</td><td>"+this.checkTypedof(data.Deadline)
			+"</td><td>"+"<button type='button' class='btn btn-danger  btn-sm' onclick='pageListDeleteOne("+data.Id+")'>封停</button>"
			+"</td></tr>";
			return allstr;
	}
});
function pageListInit(){
    pageListmanage.searchAll();
}
/*function pageListAdd() {
    layer.open({
        type: 2,
        area: ['1000px', '500px'],
        fix: false,
        //不固定
        maxmin: true,
        content: 'addUser.php',
        title: '增加用户'
    });
}
function pageListEdit(id) {
    layer.open({
        type: 2,
        area: ['1000px', '500px'],
        fix: false,
        //不固定
        maxmin: true,
        content: 'addUser.php?id=' + id,
        title: '修改用户信息'
    });
}*/
/*function pageListDeleteOne(id) {
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
}*/
/*
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
}*/
function pageListDeleteOne(id) {
    $('#TimeInput').val('');
    layer.open({
        type:1,
        shade: false,
        title: '封停截止时间', //不显示标题
        content: $('#inputTime') //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
        ,btn: ['确定']
        ,yes: function(index, layero){
            var Time=$('#TimeInput').val();
            layer.close(index);
            layer.load(2);
            $.ajax({
                url: pageListPath,
                type: 'PUT',
                dataType: 'json',
                data: {
                    Type:1,
                    Id:id,
                    Update: {
                        Deadline:Time
                    }
                },
                success: function(data) {
                    layer.msg('封停成功', {
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
        },
        cancel: function(){
        
        }
    });
}
function pageListDelete() {
    if ($("input[name='pageList_eachcheckbox']:checked").length == 0) {
        layer.msg('请选择至少一条数据', {
            icon: 7
        });
    } else {
        $('#TimeInput').val('');
        layer.open({
            type:1,
            shade: false,
            title: '封停截止时间', //不显示标题
            content: $('#inputTime') //捕获的元素，注意：最好该指定的元素要存放在body最外层，否则可能被其它的相对元素所影响
            ,btn: ['确定']
            ,yes: function(index, layero){
                var Time=$('#TimeInput').val();
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
                        Type:1,
                        Id:str,
                        Update: {
                            Deadline:Time
                        }
                    },
                    success: function(data) {
                        layer.msg('封停成功', {
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
            },
            cancel: function(){
            
            }
        });
    }
}
function pageListSearch(){
	pageListmanage.pg=1;
	pageListmanage.nowgroup=1;
	pageListmanage.searchData={
		Name:$("#userName").val(),
        Id:$("#userId").val()
	};
	pageListmanage.searchAll();
}
function pageListSearchAll(){
	$("#userName").val("");
    $("#userId").val("");
	pageListSearch();
}
initSearchList();
function initSearchList(){
   
}