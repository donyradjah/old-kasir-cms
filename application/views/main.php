<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
	<title>POS SEDERHANA - <?= $title ?></title>
	<link rel="icon" type="image/x-icon" href="<?= base_url() ?>/assets/img/favicon.ico"/>

	<!--	<link href="--><? //= base_url() ?><!--/assets/css/loader.css" rel="stylesheet" type="text/css"/>-->
	<!--	<script src="--><? //= base_url() ?><!--/assets/js/loader.js"></script>-->


	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
	<link href="<?= base_url() ?>/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?= base_url() ?>/assets/css/plugins.css" rel="stylesheet" type="text/css"/>
	<!-- END GLOBAL MANDATORY STYLES -->

	<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
	<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/css/elements/alert.css">
	<link href="<?= base_url() ?>/assets/plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
	<link href="<?= base_url() ?>/assets/plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css"/>
	<link href="<?= base_url() ?>/assets/css/components/custom-sweetalert.css" rel="stylesheet" type="text/css"/>

	<?php

	$lastfile = explode(".", $content);
	$lastfile = $lastfile[count($lastfile) - 1];

	$content_file = str_replace(".", "/", $content);

	if (file_exists('./application/views/' . $content_file . '/' . $lastfile . '-css.php')) {
		$this->load->view($content_file . '/' . $lastfile . '-css');
	}

	?>


	<style>
		.blockui-growl-message {
			display: none;
			text-align: left;
			padding: 15px;
			background-color: #455a64;
			color: #fff;
			border-radius: 3px;
		}

		.blockui-animation-container {
			display: none;
		}

		.multiMessageBlockUi {
			display: none;
			background-color: #455a64;
			color: #fff;
			border-radius: 3px;
			padding: 15px 15px 10px 15px;
		}

		.multiMessageBlockUi i {
			display: block
		}
	</style>

	<!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

</head>
<body class="sidebar-noneoverflow">
<!-- BEGIN LOADER-->
<!--<div id="load_screen">-->
<!--	<div class="loader">-->
<!--		<div class="loader-content">-->
<!--			<div class="spinner-grow align-self-center"></div>-->
<!--		</div>-->
<!--	</div>-->
<!--</div>-->
<!--  END LOADER-->

<!--  BEGIN NAVBAR  -->
<?php $this->load->view("layout/header"); ?>
<!--  END NAVBAR  -->

<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container" id="container">

	<div class="overlay"></div>
	<div class="search-overlay"></div>

	<!--  BEGIN SIDEBAR  -->
	<?php $this->load->view("layout/sidebar"); ?>
	<!--  END SIDEBAR  -->

	<!--  BEGIN CONTENT AREA  -->
	<?php $this->load->view($content_file . '/' . $lastfile) ?>
	<!--  END CONTENT AREA  -->


</div>
<!-- END MAIN CONTAINER -->

<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="<?= base_url() ?>/assets/js/libs/jquery-3.1.1.min.js"></script>
<script src="<?= base_url() ?>/assets/bootstrap/js/popper.min.js"></script>
<script src="<?= base_url() ?>/assets/js/jquery.redirect.js"></script>
<script src="<?= base_url() ?>/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>/assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?= base_url() ?>/assets/js/app.js"></script>
<script>
	$(document).ready(function () {
		App.init();
	});
</script>
<script src="<?= base_url() ?>/assets/js/custom.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<script src="<?= base_url() ?>/assets/plugins/sweetalerts/sweetalert2.min.js"></script>
<script src="<?= base_url() ?>/assets/plugins/sweetalerts/custom-sweetalert.js"></script>
<script>
	$('[data-toggle="tooltip"]').tooltip()
</script>
<script src="<?= base_url() ?>/assets/plugins/font-icons/feather/feather.min.js"></script>
<script type="text/javascript">
	feather.replace();
</script>

<script src="<?= base_url() ?>/assets/plugins/blockui/jquery.blockUI.min.js"></script>
<?php

if (file_exists('./application/views/' . $content_file . '/' . $lastfile . '-js.php')) {
	$this->load->view($content_file . '/' . $lastfile . '-js');
}

?>

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->


</body>
</html>
