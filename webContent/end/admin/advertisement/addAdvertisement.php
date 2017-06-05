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
				<td>连接Url:<span style='color:red;'>*</span></td>
				<td colspan="3">
					<input type="text" id="Url" placeholder="连接Url" name="Url" class="form-control input-lg">
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
<script type="text/javascript" src="addAdvertisement.js"></script>
