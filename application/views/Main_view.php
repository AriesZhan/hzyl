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
            text-decoration:underline;
        }

        h1 {
            color: #444;
            background-color: transparent;
            font-size: 19px;
            font-weight: normal;
            margin: 0 0 5px 0;
            padding: 15px 15px 10px 15px;
            text-shadow: 5px 3px 3px #E0C0D0;
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
            border: 1px solid #E0C0D0;
            box-shadow: 0 0 8px #E0C0D0;
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
            box-shadow: 0 0 8px #E0C0D0;
            #background-image: url(icons/button.png);
            #background-color:   #E0C0D0;
        }
        
        #nav {
            margin: 15px;
            padding: 5px;
        }
        
        iframe {
            width:100%;
            height: 720px;
        }
        
        #search_div {
            position: relative;
            left:25%;
            width: 55%;
            margin: 15px;
        }
        
        input.search {
            margin: 3px;
            width: 70%;
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
    <div id="search_div">
        <form action="<?php echo base_url("product/search/ls"); ?>" name="search_form" method="post" target="subpage-product-list-view" enctype="multipart/form-data">
            <input class="search" maxlength="32" name="search_pattern" value="" required/>
            <button type="submit" value="search">搜索</button>
        </form>
    </div>

    <div id="nav">
        <?php foreach ($product_type_map as $en => $cn) : ?>
        <div class="list-btn-form">
            <form action="<?php echo base_url("product/main/$en"); ?>" name="<?php echo $en; ?>_list_btn_form" method="get" target="subpage-product-list-view" enctype="multipart/form-data">
                <button type="submit" id="<?php echo $en; ?>_list_btn" name="<?php echo $en; ?>_list_btn" onclick="hlight(this)">
                    <a><?php echo "$cn"; ?></a>
                </button>
            </form>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div id="product_list">
        <iframe name="subpage-product-list-view" src="<?php echo base_url("product/main/dresses"); ?>" scrolling="auto" frameborder="0" marginheight="0" marginwidth="0" />
    </div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>
