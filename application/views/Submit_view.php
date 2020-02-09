<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title></title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
            color: #444;
            background-color: transparent;
            font-weight: normal;
            text-decoration:none;
        }
    a:hover {
            color: cornflowerblue;
            background-color: transparent;
            font-weight: normal;
            text-decoration: underline;
        }

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 16px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
    
    button {
            margin: 3px;
            width: 80px;
            color: #444;
            background-color: transparent;
            border: 1px solid #D0D0D0;
            font-size: 14px;
            font-weight: normal;
            border-radius: 5px;
    }
    
        #continue-to-add {
            margin-left: 2%;
        }
	</style>
</head>
<body>

<div id="container">
	<h1>图片，视频上传中，请勿关闭页面。整个过程的时间依据上传的图片或视频的数量，大小而定，请耐心等待。</h1>
    <ul>
        <?php foreach($uploaded_list as $index => $uploaded_file) :?>
        <li>文件 <?php echo $uploaded_file?> 已上传.</li>
        <?php endforeach; ?>
    </ul>
    <!--
    <pre>
        <?php print_r($product_data) ?>
    </pre>
    <pre>
        <?php print_r($uploaded_list) ?>
    </pre>
    <pre>
        <?php print_r($files) ?>
    </pre>
    <pre>
        <?php print_r($post) ?>
    </pre>
    -->
    <div id="continue-to-add">
        <a href="<?php echo base_url("product/add"); ?>" target="_self"><button type="button" value="add">继续添加</button></a>
    </div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>
