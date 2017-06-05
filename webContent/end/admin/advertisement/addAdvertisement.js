var path = "/onlineShop/src/v1/advertisement/advertisement.php";
var index = parent.layer.getFrameIndex(window.name);

var base64Code="";
function submitData() {
    if (checkFrom()){
        var theData = {};
        var x = document.getElementById("form");
        for (var i = 0; i < x.elements.length; i++) {
            theData[x.elements[i].name] = x.elements[i].value;
        }
        theData['ImgUrl']=base64Code;
        layer.load(2);
        if(id!=''){
            layer.msg('路径错误', {
                icon: 5
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
    /*var username = $("#Name").val();
    if (username == "") {
        layer.msg('名称不能为空！', {
            icon: 7
        });
        return false;
    }*/
    return true;

}

var reader = new FileReader();
var imgFileInput = $('#ImgUrlInput');
imgFileInput.on('change', function (e) {
  reader.onload = function () {
    base64Code = reader.result
    $('#ImgUrl').attr('src', base64Code)
  }
  reader.readAsDataURL(this.files[0])
})



function init(){
    /*初始化列表*/
    /*初始化数据*/
    if(id!=''){
        layer.load(2);
        $.ajax({
            url: path,
            type: 'GET',
            dataType: 'json',
            data:{
                Type:0,
                Keys:'',
                Search:{
                    Id:id
                }
            },
            success: function(data) {
                layer.closeAll('loading');
                base64Code=data.ResultList[0].Url;
                $('#ImgUrl').attr('src', data.ResultList[0].ImgUrl);
                $('#Url').attr('value', data.ResultList[0].Url);
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