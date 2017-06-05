var path = "/onlineShop/src/v1/place/school.php";
var index = parent.layer.getFrameIndex(window.name);
function submitData() {
    if (checkFrom()) {
        var theData = {};
        var x = document.getElementById("form");
        for (var i = 0; i < x.elements.length; i++) {
            theData[x.elements[i].name] = x.elements[i].value;
        }
        layer.load(2);
        if(id!=''){
            $.ajax({
                url: path,
                type: 'PUT',
                dataType: 'json',
                data: {
                    Type:0,
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
            $.ajax({
                url: path,
                type: 'POST',
                dataType: 'json',
                data: theData,
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
        }
        
    }
}

function checkFrom() {
    var username = $("#Name").val();
    var ProvinceId=$("#ProvinceId").val();
    if (username == "") {
        layer.msg('名称不能为空！', {
            icon: 7
        });
        return false;
    }else if(ProvinceId==''||ProvinceId==null){
        layer.msg('省份不能为空！', {
            icon: 7
        });
        return false;
    }
    return true;

}



function init(){
    /*初始化列表*/
    layer.load(2);
    $.ajax({
        url: '/onlineShop/src/v1/place/province.php',
        type: 'GET',
        dataType: 'json',
        data:{
            Type:0,
            Keys:'',
            Search:{
                Id:''
            }
        },
        success: function(data) {
            layer.closeAll('loading');
            var obj = document.getElementById("ProvinceId"); //定位id
            obj.options.length=0;
            for (var i = 0; i < data.ResultList.length; i++) {
                obj.options.add(new Option(data.ResultList[i].Name,data.ResultList[i].Id));
            };
        },
        error: function() {
            layer.closeAll('loading');
            layer.msg(JSON.parse(data.responseText).Error, {
                icon: 5
            });
        }
    });
    /*初始化数据*/
    if(id!=''){
        layer.load(2);
        $.ajax({
            url: path,
            type: 'GET',
            dataType: 'json',
            data:{
                Type:0,
                Keys:'Name+ProvinceId',
                Search:{
                    Id:id
                }
            },
            success: function(data) {
                
                $('#Name').attr('value', data.ResultList[0].Name);
                $('#ProvinceId').val( data.ResultList[0].ProvinceId);
                layer.closeAll('loading');
            },
            error: function() {
                layer.closeAll('loading');
                layer.msg(JSON.parse(data.responseText).Error, {
                    icon: 5
                });
            }
        });
    }
}

init();