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

        body {
            background-color: #fff;
            margin: 10px;
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
            font-size: 19px;
            font-weight: normal;
            margin: 0 0 14px 0;
            padding: 14px 15px 10px 15px;
        }

        #container {
            margin: 3px;
            #border: 1px solid #D0D0D0;
            #box-shadow: 0 0 8px #D0D0D0;
        }

        button {
            margin: 3px;
            width: 80px;
            color: #444;
            background-color: transparent;
            border-bottom: 1px solid #D0D0D0;
            font-size: 14px;
            font-weight: normal;
            border-radius: 5px;
            box-shadow: 0 0 8px #D0D0D0;
            
        }
    
        #nav {
            background-color: transparent;
            margin: 15px;
            padding: 5px;
        }
        
        #search_mng_div {
            position: relative;
            left:30%;
            width: 55%
        }
        
        input.search {
            margin: 3px;
            width: 50%;
            color: #444;
            background-color: transparent;
            border: 1px solid #D0D0D0;
            font-size: 14px;
            font-weight: normal;
            border-radius: 5px;
            #box-shadow: 0 0 8px #E0C0D0;
        }
        
        div.list-btn-form {
            float:left;
        }

	</style>
    <script type="text/javascript">
        function hlight(cnode) {
            nodes = document.getElementsByTagName('button');
            for (i=0; i<nodes.length; i++) {
                nodes[i].setAttribute('style', 'border-color: transparent');
            }
            cnode.setAttribute('style', 'border-color: #E0A0D0');
            
        }
    </script>
</head>
<body>

<div id="container">
	<h1>管理员您好，您可以通过本页面管理您的产品信息，进行添加/删除/修改您的产品信息（包括产品名称，描述，图片和视频）。</h1>
    <div>
        <div id="search_mng_div">
            <form action="<?php echo base_url("product/search/mng"); ?>" name="search_form" method="post" target="subpage-manage-view" enctype="multipart/form-data">
                <input class="search" maxlength="32" name="search_pattern" value="" required/>
                <button type="submit" value="search"><a>搜索</a></button>
                <button style="float: right; margin-right: 150px;" type="button" class="back_home_btn">
                    <a class="back_home_link" href="<?php echo base_url(); ?>" target="_blank">返回首页</a>
                </button>
                <button style="float: right;" type="button" name="product_add_btn">
                    <a id="product_add_btn_link" href="<?php echo base_url("product/add"); ?>" target="_blank">添加产品</a>
                </button>
                
            </form>
            
        </div>
    </div>
    <div id="nav">
        <?php foreach ($product_type_map as $en => $cn) : ?>
        <div class="list-btn-form">
            <form action="<?php echo base_url("product/manage/$en"); ?>" name="<?php echo $en; ?>_manage_btn_form" method="get" target="subpage-manage-view" enctype="multipart/form-data">
                <button type="submit" id="<?php echo $en; ?>_manage_btn" name="<?php echo $en; ?>_manage_btn" onclick="hlight(this)">
                    <a><?php echo "$cn"; ?></a>
                </button>
            </form>
        </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
