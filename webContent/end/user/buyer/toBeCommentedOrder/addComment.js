var path = "/onlineShop/src/v1/order/order.php";
var index = parent.layer.getFrameIndex(window.name);

function submitData() {
    if (checkFrom()) {
        var theData = {};
        theData['CustomerEvaluate']=$("input[name='Comment']:checked").val();
        theData['CustomerEvaluateText']=$("#Content").val();
        layer.load(2);
        if(id!=''){
            $.ajax({
                url: path,
                type: 'PUT',
                dataType: 'json',
                data: {
                    Type:1,
                    Id:id,
                    Update:theData
                },
                success: function(data) {
                    layer.closeAll('loading');
                    parent.layer.msg('提交成功', {
                        icon: 6
                    });
                    parent.pageListmanage.searchAll();
                    parent.layer.close(index);

                },
                error: function() {
                    layer.closeAll('loading');
                    layer.msg(JSON.parse(data.responseText).Error, {
                        icon: 5
                    });
                }
            });
        }else{
            layer.msg('未知错误', {
                icon: 5
            });
        }
    }
}

function checkFrom() {
    var Comment=$("input[name='Comment']:checked").val();
    if (Comment == "") {
        layer.msg('评价不能为空', {
            icon: 7
        });
        return false;
    }
    return true;

}

function init(){
    /*初始化列表*/
    
}

init();