<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<?php include $_SERVER['DOCUMENT_ROOT'].'/onlineShop/webContent/end/link.php';?>
<style type="text/css">
    .addDataMain{
        width: 800px;
        margin: 30px auto;
    }
</style>
<div class="addDataMain">
	<form action="#" method="post" id="form">
		<table class="table table-bordered">
			<tr>
                <td>展示图片:<span style='color:red;'>*</span></td>
                <td colspan="3">
                    <img src=""
                      alt="请选择一张图片" class=""
                      style="max-width:100%"
                      id="ImgUrl" name="ImgUrl">
                    <input type="file" class='' id="ImgUrlInput" placeholder="展示图片" name="ImgUrlInput">
                </td>
            </tr>
            <tr>
				<td>名称:<span style='color:red;'>*</span></td>
				<td>
					<input type="text" id="Name" placeholder="要增加的名称" name="Name" class="form-control input-lg">
				</td>
				<td>类型:<span style='color:red;'>*</span></td>
				<td>
					<select  class="form-control input-lg" id="Type" name="Type">
				    </select>
				</td>
			</tr>
            <tr>
                <td>数量:<span style='color:red;'>*</span></td>
                <td>
                    <input type="number" id="Number" placeholder="剩余数量" name="Number" class="form-control input-lg">
                </td>
                <td>价格:<span style='color:red;'>*</span></td>
                <td>
                    <input type="number" id="Price" placeholder="价格" name="Price" class="form-control input-lg">
                </td>
            </tr>
			<tr>
				<td>内容:</td>
				<td colspan="3">
					<textarea name="Introduce" id="Introduce" ></textarea>
				</td>
			</tr>
		</table>
	</form>
	<div class="btn btn-primary btn-lg" onclick="submitData()">提交</div>
</div>
<script type="text/javascript">
    <?php 
        $id='';
        if(isset($_GET['id'])){
            if(is_numeric($_GET['id'])){
                $id=$_GET['id'];
            }
        }
    ?>
	var id="<?php echo $id;?>";
</script>
<script type="text/javascript" src="/onlineShop/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/onlineShop/static/js/layer/layer.js"></script>
<script type="text/javascript" src="/onlineShop/static/js/ueditor/utf8-php/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="/onlineShop/static/js/ueditor/utf8-php/ueditor.all.js"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('Introduce',{
          toolbars: [
    [
                            'source', //源代码
                    'undo', //撤销
                    'redo', //重做
                    'bold', //加粗
                    'indent', //首行缩进
                    'italic', //斜体
                    'underline', //下划线
                    'strikethrough', //删除线
                    'subscript', //下标
                    'fontborder', //字符边框
                    'superscript', //上标
                    'formatmatch', //格式刷
                    'blockquote', //引用
                    'pasteplain', //纯文本粘贴模式
                    'selectall', //全选
                    'preview', //预览
                    'horizontal', //分隔线
                    'removeformat', //清除格式
                    'time', //时间
                    'date', //日期
                    'unlink', //取消链接
                    'insertrow', //前插入行
                    'insertcol', //前插入列
                    'mergeright', //右合并单元格
                    'mergedown', //下合并单元格
                    'deleterow', //删除行
                    'deletecol', //删除列
                    'splittorows', //拆分成行
                    'splittocols', //拆分成列
                    'splittocells', //完全拆分单元格
                    'deletecaption', //删除表格标题
                    'inserttitle', //插入标题
                    'mergecells', //合并多个单元格
                    'deletetable', //删除表格
                    'cleardoc', //清空文档
                    'insertparagraphbeforetable', //"表格前插入行"
                    'fontfamily', //字体
                    'fontsize', //字号
                    'paragraph', //段落格式
                    'simpleupload', //单图上传
                    'edittable', //表格属性
                    'edittd', //单元格属性
                    'link', //超链接
                    'spechars', //特殊字符
                    'searchreplace', //查询替换
                    'justifyleft', //居左对齐
                    'justifyright', //居右对齐
                    'justifycenter', //居中对齐
                    'justifyjustify', //两端对齐
                    'forecolor', //字体颜色
                    'backcolor', //背景色
                    'insertorderedlist', //有序列表
                    'insertunorderedlist', //无序列表
                    'fullscreen', //全屏
                    'directionalityltr', //从左向右输入
                    'directionalityrtl', //从右向左输入
                    'rowspacingtop', //段前距
                    'rowspacingbottom', //段后距
                    'pagebreak', //分页
                    'imagenone', //默认
                    'imageleft', //左浮动
                    'imageright', //右浮动
                    'imagecenter', //居中
                    'lineheight', //行间距
                    'edittip ', //编辑提示
                    'customstyle', //自定义标题
                    'autotypeset', //自动排版});
                    'touppercase', //字母大写
                    'tolowercase', //字母小写
                    'inserttable', //插入表格
                    'charts', // 图表
    ]
], 
          autoFloatEnabled:false,
          zIndex :3,
          elementPathEnabled:false,
          autoHeightEnabled :false,
          wordCount:false});
            </script>
<script type="text/javascript" src="addGoods.js"></script>
