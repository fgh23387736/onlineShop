var iPhone;
var Password;
var NewPassword;
var RepeatNewPassword;

var  HeadImgUrl;
var Name;
var Sex;
var Phone;
var base64Code="";
var reader = new FileReader();
var imgFileInput = $('#ImgUrlInput');
imgFileInput.on('change', function (e) {
  reader.onload = function () {
    base64Code = reader.result
    $('#HeadImgUrl').attr('src', base64Code)
  }
  reader.readAsDataURL(this.files[0])
});


information();
init();

//原始密码
function oldPassword(){
    Password=document.getElementById("Password").value;
    //密码长度在8个字符到16个字符，由字母、数字和"_"组成
    var passwordRegex=/^[0-9A-Za-z_]\w{7,15}$/;
    if(!passwordRegex.test(Password)){
        layer.msg("请输入原始密码", {
            icon: 5
        });
    }else{
        return true;
    }
}

//新密码（长度在8个字符到16个字符）
function checkPassword(){
    NewPassword=document.getElementById("NewPassword").value;
    //密码长度在8个字符到16个字符，由字母、数字和"_"组成
    var passwordRegex=/^[0-9A-Za-z_]\w{7,15}$/;
    if(!passwordRegex.test(NewPassword)){
        layer.msg("密码长度必须是由字母、数字和_组成的8到16个字符", {
            icon: 5
        });
    }else{
        return true;
    }
}

//校验新密码（和上面密码必须一致）
function checkRepassword(){
    NewPassword=document.getElementById("NewPassword").value;
    RepeatNewPassword=document.getElementById("RepeatNewPassword").value;
    //校验密码和上面密码必须一致
    //console.log(RepeatNewPassword);
    //console.log(NewPassword);
    if(RepeatNewPassword!=NewPassword){
        layer.msg("两次输入的密码不一致", {
            icon: 5
        });
    }else if(RepeatNewPassword==NewPassword){
        return true;
    }
}



function init(){
    layer.load(2);

    //GET手机号
    $.ajax({
        url: '/onlineShop/src/v1/user/user.php',
        type: 'GET',
        dataType: 'json',
        data: {
            Type:0,
            Keys:'Id+Phone',
            Search:{
                Id:''
            }
        },
        success: function(data) {
            //console.log(data.ResultList[0].Phone);
            layer.closeAll('loading');
            $('#tab-bottom-left2 #Phone').attr('value', data.ResultList[0].Phone);
            $('#tab-bottom-left2 #Phone').prop('readonly','readonly');
        },
        error: function(data) {
            layer.closeAll('loading');
            layer.msg(JSON.parse(data.responseText).Error, {
                icon: 5
            });
        }
    });
}

//修改密码
function validateForm(){
    if(oldPassword()&&checkPassword()&&checkRepassword()){
        layer.load(2);
        $.ajax({
            url: '/onlineShop/src/v1/user/user.php',
            type: 'PUT',
            dataType: 'json',
            data: {
                Type:2,
                Id:'',
                Update:{
                    Password:hex_md5(Password),
                    NewPassword:hex_md5(NewPassword),
                    RepeatNewPassword:hex_md5(RepeatNewPassword)
                }
                
            },
            success: function(data) {
                layer.closeAll('loading');
                layer.alert('密码修改成功', {
                   icon: 6
                  ,closeBtn: 0
                }, function(){
                    window.location='/onlineShop/webContent/end/login/login.php';
                });
            },
            error: function(data) {
                layer.closeAll('loading');
                layer.msg(JSON.parse(data.responseText).Error, {
                    icon: 5
                });
            }
        });
    }
}


function information(){
    layer.load(2);
    $.ajax({
        url: '/onlineShop/src/v1/user/user.php',
        type: 'GET',
        dataType: 'json',
        data: {
            Type:0,
            Keys:'HeadImgUrl+Name+Sex+Phone+ProvinceId+SchoolId+CityId',
            Search:{
                Id:''
            }
        },
        success: function(data) {
            HeadImgUrl=data.ResultList[0].HeadImgUrl;
            base64Code = HeadImgUrl;
            $('#HeadImgUrl').attr('src', base64Code);
            Name=data.ResultList[0].Name
            $('#Name').attr('value', Name);
            Sex=data.ResultList[0].Sex;
            $('#Sex').attr('value', Sex);
            Phone=data.ResultList[0].Phone
            $('#Phone').attr('value', Phone);
           
            radios=document.getElementsByName("Sex");
            for(var i=0;i<radios.length;i++){
                if( Sex==radios[i].value){
                    radios[i].checked=true;
                }
            }
            var data_1=data;
            $.ajax({
                url: '/onlineShop/src/v1/place/province.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    Type:0,
                    Keys:'Id+Name',
                    Search:{
                        Id:''
                    }
                },
                success: function(data) {
                    var obj = document.getElementById("ProvinceId"); //定位id
                    obj.options.length=0;
                    for (var i = 0; i < data.ResultList.length; i++) {
                        obj.options.add(new Option(data.ResultList[i].Name,data.ResultList[i].Id));
                    }
                    var ppId='';
                    if(data_1.ResultList[0].ProvinceId==''||data_1.ResultList[0].ProvinceId==null){
                        ppId=data.ResultList[0].Id;
                    }else{
                        ppId=data_1.ResultList[0].ProvinceId;
                        $('#ProvinceId').val(data_1.ResultList[0].ProvinceId);
                    }
                    var data_2=data;
                    $.ajax({
                        url: '/onlineShop/src/v1/place/city.php',
                        type: 'GET',
                        dataType: 'json',
                        data: {
                            Type:1,
                            Keys:'Id+Name',
                            Search:{
                                Name:'',
                                ProvinceId:ppId
                            }
                        },
                        success: function(data) {
                            var obj = document.getElementById("CityId"); //定位id
                            obj.options.length=0;
                            for (var i = 0; i < data.ResultList.length; i++) {
                                obj.options.add(new Option(data.ResultList[i].Name,data.ResultList[i].Id));
                            }
                            var ccId='';
                            if(data_1.ResultList[0].CityId==''||data_1.ResultList[0].CityId==null){
                                ccId=data.ResultList[0].Id;
                            }else{
                                ccId=data_1.ResultList[0].CityId;
                                $('#CityId').val(data_1.ResultList[0].CityId);
                            }
                            var data_3=data;
                            $.ajax({
                                url: '/onlineShop/src/v1/place/school.php',
                                type: 'GET',
                                dataType: 'json',
                                data: {
                                    Type:1,
                                    Keys:'Id+Name',
                                    Search:{
                                        Name:'',
                                        CityId:ccId
                                    }
                                },
                                success: function(data) {
                                    var obj = document.getElementById("SchoolId"); //定位id
                                    obj.options.length=0;
                                    for (var i = 0; i < data.ResultList.length; i++) {
                                        obj.options.add(new Option(data.ResultList[i].Name,data.ResultList[i].Id));
                                    }
                                    if(data_1.ResultList[0].SchoolIdSchoolId==''||data_1.ResultList[0].SchoolId==null){
                                    }else{
                                        $('#SchoolId').val(data_1.ResultList[0].SchoolId);
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
                        },
                        error: function(data) {
                            layer.closeAll('loading');
                             layer.msg(JSON.parse(data.responseText).Error, {
                                icon: 5
                            });
                        }
                    });
                },
                error: function(data) {
                    layer.closeAll('loading');
                     layer.msg(JSON.parse(data.responseText).Error, {
                        icon: 5
                    });
                }
            });

        },
        error: function(data) {
            layer.closeAll('loading');
             layer.msg(JSON.parse(data.responseText).Error, {
                icon: 5
            });
        }
    });
}

function oFocus_1() {
 HeadImgUrl=document.getElementById("HeadImgUrl").src;
}

function oBlur_1() {
HeadImgUrl=document.getElementById("HeadImgUrl").src;
if(!HeadImgUrl){
      layer.msg('请上传头像！', {
                        icon: 5
                    });
      return false;
}
}

function oFocus_2() {
 Name=document.getElementById("Name").value;
}

function oBlur_2() {
Name=document.getElementById("Name").value;
if(!Name){
      layer.msg('请输入真实姓名！', {
                        icon: 5
                    });
      return false;
}
}



function submit(){
    HeadImgUrl=document.getElementById("HeadImgUrl").src;
    Sex=$("input[name='Sex']:checked").val();
    if(!HeadImgUrl){
        layer.msg('请上传头像！', {
                        icon: 5
                    });
      return false;
    }
    if(!Name){
         layer.msg('请输入真实姓名！', {
                        icon: 5
                    });
      return false;
    }

  layer.load(2);
     $.ajax({
        url: '/onlineShop/src/v1/user/user.php',
        type: 'PUT',
        dataType: 'json',
        data: {
              Type:0,
              Id:'',
              Update:{
                Name:Name,
                HeadImgUrl:base64Code,
                Sex:Sex,
                ProvinceId:$('#ProvinceId').val(),
                CityId:$('#CityId').val(),
                SchoolId:$('#SchoolId').val()

              }
        },
        success: function(data) {
            layer.closeAll('loading');
            layer.alert('修改成功', {
               icon: 6
              ,closeBtn: 0
            }, function(){
              location.reload(); 
            });
            
        },
        error: function(data) {
            layer.closeAll('loading');
             layer.msg(JSON.parse(data.responseText).Error, {
                icon: 5
            });
        }
    });

}


function changeCity(){
    if($('#ProvinceId').val()==''||$('#ProvinceId').val()==null){
        var obj = document.getElementById("CityId"); //定位id
        obj.options.length=0;
        return;
    }
    layer.load(2);
    $.ajax({
        url: '/onlineShop/src/v1/place/city.php',
        type: 'GET',
        dataType: 'json',
        data: {
            Type:1,
            Keys:'Id+Name',
            Search:{
                Name:'',
                ProvinceId:$('#ProvinceId').val()
            }
        },
        success: function(data) {
            var obj = document.getElementById("CityId"); //定位id
            obj.options.length=0;
            for (var i = 0; i < data.ResultList.length; i++) {
                obj.options.add(new Option(data.ResultList[i].Name,data.ResultList[i].Id));
            }
            if(data.ResultList.length>0){
                $('#CityId').val(data.ResultList[0].Id);
            }else{
                $('#CityId').val('')
            }
            changeSchool();
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


function changeSchool(){
    if($('#CityId').val()==''||$('#CityId').val()==null){
        var obj = document.getElementById("SchoolId"); //定位id
        obj.options.length=0;
        return;
    }
    layer.load(2);
    $.ajax({
        url: '/onlineShop/src/v1/place/school.php',
        type: 'GET',
        dataType: 'json',
        data: {
            Type:1,
            Keys:'Id+Name',
            Search:{
                Name:'',
                CityId:$('#CityId').val()
            }
        },
        success: function(data) {
            var obj = document.getElementById("SchoolId"); //定位id
            obj.options.length=0;
            for (var i = 0; i < data.ResultList.length; i++) {
                obj.options.add(new Option(data.ResultList[i].Name,data.ResultList[i].Id));
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