/*
*例子
*在页面中引入jquery.js,layer.js,pages.js
*pages.css
 */
/*在需要显示分页条的地方插入下面这句，class不要动，id可任意修改
<div class="pageUI">
    <div class="page_footer" id="mypage" onselectstart="return false">
    </div>
</div>
*/
/*var mpp=new MyPage();
mpp.init({
	requesturl:"../../../yora/doaction/pcWeb/admin/other_manage/do_school_manage.php?action=0",//向后台请求数据路径
	dataListId:"tbody",//填充数据的元素可根据id(要写#  eg:#content)也可根据class(要写. eg:.content)也可直接写标签名称
	pageUI:"#mypage",//分页条按钮填充区域命名规则同上
	myname:"mpp",//用户声明的变量名称
	searchData:",,",//用户需要传到后台的多余数据可以为字符串，数字，或者json数据(此项可用来筛选数据，做查询功能)
	pgz:1,//每页显示数据条数
	but_num:20,//分页条按钮每组最多显示多少页
	drawDatatoCotent:function (data){
			var allstr="";
			allstr="<ul class='another_line'>"
			+"<li class='another' style='width:30px'><input type=\"checkbox\" name=\"select\" value='"+data.Id+"'>"
			+"</li><li class='another' style='text-align:left;width:200px;'>"+data.Name
			+"</li><li class='another' style='text-align:left;width:200px;'>"+data.city
			+"</li><li class='another' style='text-align:left;width:200px;'>"+data.province
			+"</li></ul>";
			return allstr;
	}
});*/

/*
*后台代码示例
 */
/*	function GetSchoolList(){
		include("../../../../tools/conn.php");//连接数据库
		$pgz=$_POST['pageSize'];//不用修改
		$pg=$_POST['page'];//不用修改
		$searchData=$_POST['searchData'];//不用修改
		$searchDataarr = explode(",", $searchData);//按照逗号分隔，若前台传过来的是json数据则另行处理
		$data=array();//不用修改
		$sql_num="select * from school";//输入需要字段和表名

		//以下是筛选条件
		$sql_num.=" where Name like '%".$searchDataarr[0]."%'";
		if(isset($searchDataarr[1])&&$searchDataarr[1]!=""){
			$sql_num.=" and CityId=".$searchDataarr[1];
		}
		if(isset($searchDataarr[2])&&$searchDataarr[2]!=""){
			$sql_num.=" and CityId in (select Id from city where ProvinceId=".$searchDataarr[2].")";
		}
		//筛选条件结束
		$num=mysql_num_rows(mysql_query($sql_num));//不用修改

		$sql_select=$sql_num." order by Id LIMIT ".$pgz*($pg-1).",$pgz";//不用修改
		$result=mysql_query($sql_select);//不用修改
		$data['total']=$num;//不用修改
		$data['resultList']=array();//不用修改
		$i=0;//不用修改
		while($rs=mysql_fetch_array($result)){
			$data['resultList'][$i]=array();//不用修改
			foreach ($rs as $key => $value) {
					//若涉及到依据某字段进行其他表的查询
					//可以用if进行判断
					//if($key==='字段名'){
					//	进行查询获取到newkey,newvalue注意这里的newkey不可与外层的key重复，否则数据会被覆盖
					//	注意if中不可再定义$rs,$sql,$result,$i,$data,否则数据会错误
					//	$data['resultList'][$i][$newkey]=$newvalue;
					//}
					//不用修改，这个语句会自动生成key为字段名，value为所需值得数组
					$data['resultList'][$i][$key]=$value;
			}
			$i++;
		}
		mysql_close($conn);//不用修改
		echo json_encode($data);//不用修改
	}*/


var MyPage = new Function();
MyPage.prototype ={
		pg:1/*页码*/,
		tot:0/*一共有多少页*/,
		pgz:10/*一页有几条*/,
		pgtot:1/*一共有几组*/,
		but_num:5/*每组几个按钮*/,
		dataNum:0,/*数据总数*/
		nowgroup:1/*当前组*/,
		searchKeys:'',/*搜索字段*/
		searchType:0,/*选择搜索类型*/
		beginindex:0,/*当前页起始数据序号*/
		searchData:"",/*传到后台的多余数据*/
		requesturl:"",/*请求数据地址*/
		dataListId:"#allresultlist",/*填充数据的框的id*/
		pageUI:"#mypage",/*填充数据的框的id*/
		myname:"page",/*对象变量名*/
		beginsearch:true,/*是否在初始化时填充数据*/
		init:function(p){
			var that=this;
			$.each(p,function(name,value) {
				switch(name){
					case 'pg':that.pg=value;
					break;
					case 'tot':that.tot=value;
					break;
					case 'pgz':that.pgz=value;
					break;
					case 'pgtot':that.pgtot=value;
					break;
					case 'but_num':that.but_num=value;
					break;
					case 'dataNum':that.dataNum=value;
					break;
					case 'nowgroup':that.nowgroup=value;
					break;
					case 'searchKeys':that.searchKeys=value;
					break;
					case 'searchType':that.searchType=value;
					break;
					case 'beginindex':that.beginindex=value;
					break;
					case 'searchData':that.searchData=value;
					break;
					case 'requesturl':that.requesturl=value;
					break;
					case 'dataListId':that.dataListId=value;
					break;
					case 'pageUI':that.pageUI=value;
					break;
					case 'myname':that.myname=value;
					break;
					case 'beginsearch':that.beginsearch=value;
					break;
					case 'drawDatatoCotent':that.drawDatatoCotent=value;
					break;
					case 'callBack':that.callBack=value;
					break;
					case 'callBackOk':that.callBackOk=value;
					break;
					case 'callBackNo':that.callBackNo=value;
					break;
					default:;
				}
			});
			if(this.beginsearch){
				this.searchAll();
			}
		},
		//页码按钮
		changepage:function(p){
			if(this.pg!=p){
				if(p==1){
					this.nowgroup=1;
				}else if(p==this.tot){
					this.nowgroup=this.pgtot;
				}
				this.pg=p;
				this.searchAll();
			}
		},
		changepage2:function(){
			this.nowgroup--;
			this.pg=this.nowgroup*this.but_num;
			if(this.pg<=0){
				this.pg=1;
			}else{
				this.searchAll();
			}
		},
		changepage3:function(){
			this.nowgroup++;
			this.pg=(this.nowgroup-1)*this.but_num+1;
			if(this.pg>this.tot){
				this.pg=this.tot;
			}else{
				this.searchAll();
			}
		},
		//动态画出页码按钮
		drawcontrolUI:function(){
			$(this.pageUI).children().remove();
			if(this.pg!=1&&this.tot!=0){
				$(this.pageUI).append("<div class='front_page' onclick='"+this.myname+".frontpage()'>上一页</div>");
			}
			if((this.nowgroup-1)*this.but_num+1>this.but_num){
				$(this.pageUI).append("<div class='normal_page noselected'  onclick='"+this.myname+".changepage(1)'>1</div>");
				$(this.pageUI).append("<div class='normal_page noselected' onclick='"+this.myname+".changepage2()'>...</div>");
			}
			for(i=(this.nowgroup-1)*this.but_num+1;i<=(this.nowgroup-1)*this.but_num+this.but_num&&i<=this.tot;i++){
				if(this.pg==i){
					$(this.pageUI).append("<div class='normal_page selected' onclick='"+this.myname+".changepage("+i+")'>"+i+"</div>");
				}else{
					$(this.pageUI).append("<div class='normal_page noselected' onclick='"+this.myname+".changepage("+i+")'>"+i+"</div>");
				}
			}

			if(--i<this.tot){
				$(this.pageUI).append("<div class='normal_page noselected'  onclick='"+this.myname+".changepage3()'>...</div>");
				$(this.pageUI).append("<div class='normal_page noselected'  onclick='"+this.myname+".changepage("+this.tot+")'>"+this.tot+"</div>");
			}
			if(this.pg!=this.tot&&this.tot!=0){
				$(this.pageUI).append("<div class='next_page' onclick='"+this.myname+".nextpage()'>下一页</div>");
			}
		},
		drawDatatoCotent:function (data){
			var allstr="";
			allstr="需要插入的html代码";
			return allstr;
		},
		/*搜索函数，用户可自行调用*/
		searchAll:function(){
			var that=this;
			layer.load(2);
			$.ajax({
				url: that.requesturl,
				type: 'GET',
				dataType: 'json',
				data:{
					Keys:that.searchKeys,
					Type:that.searchType,
					Page:that.pg,
					PageSize:that.pgz,
					Search:that.searchData
				},
				success:function(data){
					$(that.dataListId).children().remove();
					that.dataNum=data.Total;
					that.tot=Math.ceil(data.Total/that.pgz);
	                that.pgtot=Math.ceil(that.tot/that.but_num);
	                if(that.tot!=0&&that.pg>that.tot){
	                	that.pg=that.tot;
	                	that.nowgroup=that.pgtot;
	                	that.searchAll();
	                }
	                that.beginindex=that.pgz*(that.pg-1)+1;
					for(i=0;i<data.ResultList.length;i++){
						$(that.dataListId).append(that.drawDatatoCotent(data.ResultList[i]));
					}

					that.drawcontrolUI();
					that.callBackOk();
					layer.closeAll('loading');
				},
				error:function(data) {
					layer.closeAll('loading');
					layer.msg(JSON.parse(data.responseText).Error, {icon: 5});
					that.callBackNo();
				}
			});
			that.callBack();
		},

		frontpage:function() {
			this.pg--;
			if(this.nowgroup>1){
				if(this.pg<=this.but_num*(this.nowgroup-1)){
					this.nowgroup--;
				}
			}
			if(this.pg<=0){
				this.pg=1;
			}else{
				this.searchAll();
			}
			
		},
		nextpage:function() {
			this.pg++;
			if(this.nowgroup<this.pgtot){
				if(this.pg>this.but_num*this.nowgroup){
					this.nowgroup++;
				}
			}
			if(this.pg>this.tot){
				this.pg=this.tot;
			}else{
				this.searchAll();
			}
		},
		/*格式化时间*/
		formatDate:function(date, format) {
		    if (!date) return;   
		    if (!format) format = "yyyy-MM-dd";
		    switch(typeof date) {   
		        case "string":   
		            date = new Date(date.replace(/^(\d{4})-(\d{1,2})-(\d{1,2})$/, "$2/$3/$1"));
		            break;
		        case "number":
		            date = new Date(date);   
		            break;   
		    }
		    if (!date instanceof Date) return;   
		    var dict = {   
		        "yyyy": date.getFullYear(),   
		        "M": date.getMonth() + 1,   
		        "d": date.getDate(),   
		        "H": date.getHours(),   
		        "m": date.getMinutes(),   
		        "s": date.getSeconds(),   
		        "MM": ("" + (date.getMonth() + 101)).substr(1),   
		        "dd": ("" + (date.getDate() + 100)).substr(1),   
		        "HH": ("" + (date.getHours() + 100)).substr(1),   
		        "mm": ("" + (date.getMinutes() + 100)).substr(1),   
		        "ss": ("" + (date.getSeconds() + 100)).substr(1)   
		    };       
		    return format.replace(/(yyyy|MM?|dd?|HH?|ss?|mm?)/g, function() {   
		        return dict[arguments[0]];   
		    });                   
		},
		/*数据处理防止出现null，undefined*/
		checkTypedof:function(name){
			if(typeof(name)=="undefined"){
				return "-";
			}else if(name==null){
				return "-";
			}else if(name==""){ 
				return "-";
			}else{
				return name;
			}
		},
		/*search后的回调函数*/
		callBack:function(){
			
		},
		/*search成功后的回调函数*/
		callBackOk:function(){
			
		},
		/*search失败后的回调函数*/
		callBackNo:function(){
			
		}
};

