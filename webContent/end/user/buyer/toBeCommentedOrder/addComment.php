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
                <td>评分<span style='color:red;'>*</span></td>
                <td>
                    <label class="fancy-radio" style="float:left;margin-right:20px;">
                        <input name="Comment" value="0" type="radio" checked>
                        <span><i></i>好评</span>
                    </label>
                    <label class="fancy-radio" style="float:left;margin-right:20px;">
                        <input name="Comment" value="1" type="radio">
                        <span><i></i>中评</span>
                    </label>
                    <label class="fancy-radio" style="float:left;">
                        <input name="Comment" value="2" type="radio">
                        <span><i></i>差评</span>
                    </label>
                </td>
            </tr>
			<tr>
				<td>描述:</td>
				<td >
					<textarea name="Content" id="Content" class='form-control'></textarea>
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
            $id=htmlspecialchars($_GET['id']);
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
<script type="text/javascript" src="addComment.js"></script>
