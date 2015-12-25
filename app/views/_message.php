<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>页面提示</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if(!empty($url)):?>
    <meta http-equiv='Refresh' content='<?php echo $time?>;URL=<?php echo $url?>'>
    <?php endif;?>
	<link href="static/css/style.css" rel="stylesheet" media="all">
	<link href="static/css/font-awesome.css" rel="stylesheet" media="all"></head>

<body class="collapse-leftbar">
	<?php include 'header.php';?>

    <div id="page-container">
		<?php include 'nav.php';?>


<div id="page-content">
	<div id='wrap'>
		<div class="container">
        
			<div class="row">
				<div class="col-md-12">
                    <br/>
                    <br/>
                    <br/>
					<p class="text-center">
                        <?php if($state):?>
						<span class="text-success" style="font-size:2em;">操作成功！<?php echo $info?></span>
                        <?php else:?>
						<span class="text-danger" style="font-size:2em;">操作失败！<?php echo $info?></span>
                        <?php endif;?>
					</p>
                    <?php if(!empty($url)):?>
					<p class="text-center">页面将在 <strong><?php echo $time?></strong> 秒后自动跳转，如果不想等待请点击 <a href="<?php echo $url?>">这里</a> 跳转</p>
                    <?php endif;?>
				</div>
			</div>

		</div> <!-- container -->
	</div> <!--wrap -->
</div> <!-- page-content -->

<?php include 'footer.php';?>

</div> <!-- page-container -->

<script type='text/javascript' src='static/js/jquery-1.10.2.min.js'></script> 
<script type='text/javascript' src='static/js/bootstrap.min.js'></script>
<script type='text/javascript' src='static/js/main.js'></script>
</body>
</html>