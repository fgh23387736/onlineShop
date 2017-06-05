

init();
function init(){
	var time=getNowFormatDate();
	document.getElementById('nowDate').innerHTML=time;
	layer.load(2);
    $.ajax({
        url: '/onlineShop/src/v1/operation/website.php',
        type: 'GET',
        dataType: 'json',
        data: {
		    Keys:''
        },
        success: function(data) {
            document.getElementById('GoodsNumber').innerHTML=data.GoodsNumber;
            document.getElementById('UserNumber').innerHTML=data.UserNumber;
            document.getElementById('OrderNubmer').innerHTML=data.OrderNubmer;
            document.getElementById('LoginNubmer').innerHTML=data.LoginNubmer;
            makeCharts(data.OrderNubmerILSD,data.NewUserNubmerILSD,data.LoginNubmerILSD);
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

function getNowFormatDate() {
    var date = new Date();
    var seperator1 = "-";
    var seperator2 = ":";
    var month = date.getMonth() + 1;
    var strDate = date.getDate();
    if (month >= 1 && month <= 9) {
        month = "0" + month;
    }
    if (strDate >= 0 && strDate <= 9) {
        strDate = "0" + strDate;
    }
    var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate
            + " " + date.getHours() + seperator2 + date.getMinutes()
            + seperator2 + date.getSeconds();
    return currentdate;
}
function format(format,date)
{
 var o = {
 "M+" : date.getMonth()+1, //month
 "d+" : date.getDate(),    //day
 "h+" : date.getHours(),   //hour
 "m+" : date.getMinutes(), //minute
 "s+" : date.getSeconds(), //second
 "q+" : Math.floor((date.getMonth()+3)/3),  //quarter
 "S" : date.getMilliseconds() //millisecond
 }
 if(/(y+)/.test(format)) format=format.replace(RegExp.$1,
 (date.getFullYear()+"").substr(4 - RegExp.$1.length));
 for(var k in o)if(new RegExp("("+ k +")").test(format))
 format = format.replace(RegExp.$1,
 RegExp.$1.length==1 ? o[k] :
 ("00"+ o[k]).substr((""+ o[k]).length));
 return format;
}

function makeCharts(order,user,login){
	var option = {
		title:{
			text:'最近一周数据'
		},
		legend:{
			show:true,
			data:[
				{
					name:'订单数量',
					textStyle:{
						color:'#3398DB'
					}
					
				},
				{
					name:'新增用户',
					textStyle:{
						color:'#F52C2C'
					}
				},
				{
					name:'登录数量',
					textStyle:{
						color:'#41B314'
					}
				}
			],
			backrroungColor:'#FCBE56'

		},
	    color: ['#3398DB'],
	    tooltip : {
	        trigger: 'axis',
	        axisPointer : {            // 坐标轴指示器，坐标轴触发有效
	            type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
	        }
	    },
	    grid: {
	        left: '3%',
	        right: '4%',
	        bottom: '3%',
	        containLabel: true
	    },
	    xAxis : [
	        {
	            type : 'category',
	            data : [format("yyyy-MM-dd",new Date(new Date()-24*60*60*1000*6)), format("yyyy-MM-dd",new Date(new Date()-24*60*60*1000*5)), format("yyyy-MM-dd",new Date(new Date()-24*60*60*1000*4)), format("yyyy-MM-dd",new Date(new Date()-24*60*60*1000*3)), format("yyyy-MM-dd",new Date(new Date()-24*60*60*1000*2)), format("yyyy-MM-dd",new Date(new Date()-24*60*60*1000*1)),format("yyyy-MM-dd",new Date())],
	            axisTick: {
	                alignWithLabel: true
	            }
	        }
	    ],
	    yAxis : [
	        {
	            type : 'value'
	        }
	    ],
	    series : [
	        {
	            name:'订单数量',
	            type:'line',
	            data:[order[0],order[1],order[2],order[3],order[4],order[5],order[6]]
	        },
	        {
	            name:'新增用户',
	            itemStyle : {  
                    normal : {  
                        color:'#F03C3C'  
                    }  
                }, 
	            type:'line',
	            data:[user[0],user[1],user[2],user[3],user[4],user[5],user[6]]
	        },
	        {
	            name:'登录数量',
	            itemStyle : {  
                    normal : {  
                        color:'#41B314'  
                    }  
                }, 
	            type:'line',
	            data:[login[0],login[1],login[2],login[3],login[4],login[5],login[6]]
	        }
	    ]
	};
	var myChart = echarts.init(document.getElementById('Charts'));
	myChart.setOption(option);

}


