<?php
if (isset($_SESSION['alert'])) {
	if (count($_SESSION['alert']) > 0) {
		foreach ($_SESSION['alert'] as $key => $item) {
			echo $item;
		}
		$_SESSION['alert'] = NULL;
	}
}
?>
