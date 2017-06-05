init();
function init(){
	$('.Index_body').remove();
	layer.load(2);
	$.ajax({
        url: '/onlineShop/src/v1/advertisement/advertisement.php',
        type: 'GET',
        dataType: 'json',
        async: false,
        data: {
            Type:0,
            Keys:'',
            Search: {
                Id:''
            }
        },
        success: function(data) {
        	drawPic(data.ResultList);
        },
        error: function(data) {
            layer.closeAll('loading');
            layer.msg(JSON.parse(data.responseText).Error, {
                icon: 5
            });
        }
    });
    $.ajax({
        url: '/onlineShop/src/v1/goods/type.php',
        type: 'GET',
        dataType: 'json',
        async: false,
        data: {
            Type:0,
            Keys:'',
            Search: {
                Id:''
            }
        },
        success: function(data) {
        	var i=0;
        	var data_type=data;
            for(i=0;i<data_type.ResultList.length;i++){
            	$.ajax({
			        url: '/onlineShop/src/v1/goods/goods.php',
			        type: 'GET',
			        dataType: 'json',
			        async: false,
			        data: {
			            Type:2,
			            Keys:'',
			            Page:1,
			            PageSize:5,
			            Search: {
			                Name:'',
			                Type:data_type.ResultList[i].Id,
			                Id:''
			            }
			        },
			        success: function(data) {
			        	drawGoods(data_type.ResultList[i],data.ResultList);
			        },
			        error: function(data) {
			            layer.closeAll('loading');
			            layer.msg(JSON.parse(data.responseText).Error, {
			                icon: 5
			            });
			        }
			    });
            }
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


function drawGoods(type,goodsList){
	var str="";
	var insideStr="";
	for (var i = 0; i < goodsList.length; i++) {
		insideStr+=''
			+'<div class="Body_content   hvr-wobble-horizontal">'
			+	'<div class="Adver a1">'
			+		'<a href="/onlineShop/webContent/webPre/goods/goods.php?id='+goodsList[i].Id+'" ><img src="'+goodsList[i].ImgUrl+'" width="223px" height="145px" class="goodsImg"></a>'
			+		'<a href="/onlineShop/webContent/webPre/goods/goods.php?id='+goodsList[i].Id+'" class="Ad_b" >'+goodsList[i].Name+'</a>'
			+		'<h4 class="Ad_g" style="line-height:10px;font-size:12px;">'+goodsList[i].UserName+'</h4>'
			+		'<span class="Adver_pri">￥'+goodsList[i].Price+'</span>'
			+		'<span class="lnr lnr-smile Index_j1"></span>'
			+		'<span class="Index_j2">'+goodsList[i].Good+'</span>'
			+		'<span class="lnr lnr-neutral Index_j3"></span>'
			+		'<span class="Index_j4">'+goodsList[i].Middle+'</span>'
			+		'<span class="lnr lnr-sad Index_j5"></span>'
			+		'<span class="Index_j6">'+goodsList[i].Bad+'</span>'
			+	'</div>'
			+'</div>';
	}
	str=''
		+'<div class="Index_body">'
		+	'<div class="Body_title">'
		+		'<span class="Body_title_text">'+type.Name+'</span>'
		+		'<a href="/onlineShop/webContent/webPre/goodsList/goodsList.php?type='+type.Id+'"><button type="button" class="btn btn-info g">'
  		+			'<span class="glyphicon glyphicon-chevron-right" aria-hidden="true" ></span> 更多'
		+		'</button></a>'
		+	'</div>'
		+	insideStr
		+'</div>'
		+'<div style="clear:both;"></div>';
	$('.Index_main').append(str);
}



function drawPic (data) {
	$('#picInside').children().remove();
	var strOl='<ol class="carousel-indicators">';
	var strImg='<div class="carousel-inner" data-ride="carousel">'
	for (var i = 0; i < data.length; i++) {
		if(i==0){
			strOl+='<li data-target="#myCarousel" data-slide-to="'+i+'" class="active"></li>';
			strImg+=''
				+'<div class="item active">'
				+	'<a href="'+data[i].Url+'"><img src="'+data[i].ImgUrl+'"  style="width:100%;height:400px;"></a>'
				+'</div>';
		}else{
			strOl+='<li data-target="#myCarousel" data-slide-to="0" ></li>';
			strImg+=''
				+'<div class="item">'
				+	'<a href="'+data[i].Url+'"><img src="'+data[i].ImgUrl+'"  style="width:100%;height:400px;"></a>'
				+'</div>';
		}
	};
	strOl+='</ol>';
	strImg+='</div>';
	$('#picInside').append(strOl+strImg);
}