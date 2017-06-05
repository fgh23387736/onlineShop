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
				<td>名称:<span style='color:red;'>*</span></td>
				<td>
					<input type="text" id="Name" placeholder="要增加的名称" name="Name" class="form-control input-lg">
				</td>
				<td>省份:<span style='color:red;'>*</span></td>
				<td>
					<select  class="form-control input-lg" id="ProvinceId" name="ProvinceId">
				    </select>
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
<script type="text/javascript" src="addCity.js"></script>
