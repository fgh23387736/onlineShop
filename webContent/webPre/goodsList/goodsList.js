var pageListPath="/onlineShop/src/v1/goods/goods.php";
var pageListmanage=new MyPage();
pageListmanage.init({
	requesturl:pageListPath,//向后台请求数据路径
	dataListId:"#insideBox",//填充数据的元素可根据id(要写#  eg:#content)也可根据class(要写. eg:.content)也可直接写标签名称
	pageUI:"#pageList_pageui",//分页条按钮填充区域命名规则同上
	myname:"pageListmanage",//用户声明的变量名称
	searchType:2,
    searchKeys:'',
    searchData:{
		Name:theName,
        Type:theType,
        Id:''
	},//用户需要传到后台的多余数据可以为字符串，数字，或者json数据(此项可用来筛选数据，做查询功能)
	pgz:20,//每页显示数据条数
	but_num:20,//分页条按钮每组最多显示多少页
	beginsearch:true,//是否在初始化时填充数据
	drawDatatoCotent:function (data){
			var allstr="";
			allstr=''
			+'<div class="box1  hvr-wobble-horizontal">'
			+	'<a href="/onlineShop/webContent/webPre/goods/goods.php?id='+data.Id+'">'
			+		'<img class="imgg" src="'+data.ImgUrl+'"/>'
			+		'<p class="big" title="'+this.checkTypedof(data.Name)+'">'+this.checkTypedof(data.Name)+'</p>'
			+		'<p class="middle">'+this.checkTypedof(data.UserName)+'</p>'
			+		'<span class="lnr lnr-smile">'+this.checkTypedof(data.Good)+'</span>'
			+		'<span class="lnr lnr-neutral">'+this.checkTypedof(data.Middle)+'</span>'
			+		'<span class="lnr lnr-sad">'+this.checkTypedof(data.Bad)+'</span>'
			+		'<br>'
			+		'<p class="small">￥'+this.checkTypedof(data.Price)+'</p>'
			+	'</a>'
			+'</div>';
			return allstr;
	}
});