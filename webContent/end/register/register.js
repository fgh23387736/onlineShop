var name;
var password;
var repassword;
function validateForm(){
    if(checkPhone()&&checkPassword()&&checkRepassword()){
        /*layer.msg("恭喜您！注册成功！", {
            icon: 6
        });*/
		layer.load(2);
	    $.ajax({
	        url: '/onlineShop/src/v1/user/user.php',
	        type: 'POST',
	        dataType: 'json',
	        data: {
	           Phone:name,
	           Password:hex_md5(password),
	           RepeatPassword:hex_md5(repassword)
	        },
	        success: function(data) {
	            layer.closeAll('loading');
	            layer.alert('恭喜您！注册成功', {icon: 6});
	            window.location='/onlineShop/webContent/end/login/login.php';
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
//手机号验证(以1开头的11位数字)
function checkPhone(){
    name=document.getElementById("Phone").value;
    var nameRegex=/^[1][0-9]{10}$/;
    //document.getElementById("Phone").value=name.checkPhone();
    if(!nameRegex.test(name)){
    	layer.msg("请输入11位手机号", {
            icon: 5
        });
    }else{
        return true;
    }
}

//验证密码（长度在8个字符到16个字符）
function checkPassword(){
    password=document.getElementById("Password").value;
    //密码长度在8个字符到16个字符，由字母、数字和"_"组成
    var passwordRegex=/^[0-9A-Za-z_]\w{7,15}$/;
    if(!passwordRegex.test(password)){
    	layer.msg("密码长度必须是由字母、数字和_组成的8到16个字符", {
            icon: 5
        });
    }else{
        return true;
    }
}

//验证校验密码（和上面密码必须一致）
function checkRepassword(){
	password=document.getElementById("Password").value;
    repassword=document.getElementById("RepeatPassword").value;
    //校验密码和上面密码必须一致
    console.log(repassword);
    console.log(password);
    if(repassword!=password){
    	//document.getElementById("col").innerHTML="两次输入的密码不一致";
        layer.msg("两次输入的密码不一致", {
            icon: 5
        });
    }else if(repassword==password){
    	//document.getElementById("col").innerHTML="";
        return true;
    }
}