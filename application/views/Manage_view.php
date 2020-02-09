<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>您好！欢迎来到 [ 花之依恋 ]</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	</style>
</head>
<frameset rows="20%,80%">
        <frame src="<?php echo base_url("manage/nav"); ?>" scrolling="no" frameborder="0" marginheight="0" marginwidth="0" />
        <frame name="subpage-manage-view" src="<?php echo base_url("product/manage/dresses"); ?>" scrolling="auto" frameborder="0" marginheight="0" marginwidth="0" />
</frameset>

</html>
