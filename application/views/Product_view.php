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
            width: inherit;
            background-color: #fff;
            font: 13px/20px normal Helvetica, Arial, sans-serif;
            color: #4F5155;
        }

        a {
            color: #003399;
            background-color: transparent;
            font-weight: normal;
        }

   
        div.product-view {
            width: inherit;
            padding: 5px;
            #border: 1px solid #D0D0D0;
            #box-shadow: 0 0 8px #D0D0D0;
        }
        
        img {
            margin: 5px;
            padding: 3px;
            max-width:  240px;
            max-height: 300px;
        }
        
        video {
            margin: 5px;
            padding: 3px;
            width: 300px;
            height: 240px;
        }
        
        table.product-item-data-table {
            margin: 5px;
            border-collapse:collapse;
            #border-bottom: 1px solid #E0C0D0;
        }
        
        th {
            padding: 3px;
            text-align: left;
            vertical-align: middle;
            word-spacing: 1px;
        }
        
        td {
            padding: 3px;
            text-align: left;
            vertical-align: middle;
            word-spacing: 1px;
        }
        
        div.product-view-list {
            margin-top: 36px;
            width: inherit;
            height: auto;
        }
        
        div.product-item {
            width: inherit;
            height: auto;
            margin-left: 10px;
            margin-right: 10px;
            margin-top: 10px;
            margin-bottom: 33px;
            padding: 5px;
            border: 1px solid #E0C0D0;
            box-shadow: 0 0 8px #E0C0D0;
            border-radius: 10px;
        }
        
        div.product-item-media {
            width: inherit;
            height: auto;
        }
        
        div.product-data-description {
            width: 50%;
            float: right;
        }
        
        div.add_to_cart {
            float: right;
            margin: 15px;
            padding: 15px;
        }
        
        button {
            margin: 5px;
            padding-left: 15px;
            padding-right: 15px;
            padding-top: 5px;
            padding-bottom: 5px;
            width: auto;
            color: #444;
            background-color: transparent;
            border-bottom: 1px solid #D0D0D0;
            font-size: 14px;
            font-weight: normal;
            border-radius: 5px;
            box-shadow: 0 0 8px #E0C0D0;
            #background-image: url(icons/button.png);
        }
        
	</style>
    <script type="text/javascript">
        function addToCart(cnode) {
            var product_type = cnode.name.split('-')[0];
            var product_code = cnode.name.split('-')[1];
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if(this.responseText.match("成功|失败")) {
                        document.getElementById('status_bar').innerHTML = '';
                        var r = document.createTextNode(this.responseText);
                        document.getElementById('status_bar').appendChild(r);
                        setTimeout("document.getElementById('status_bar').innerHTML = '';", 2000);
                    } else {
                        document.body.innerHTML = this.responseText;
                    }
                }
            };
            xmlhttp.open("GET", 'http://'+document.domain+'/user/cart/add/'+product_type+'/'+product_code, true);
            xmlhttp.send();
        }

    </script>
</head>
<body>
    <div style="width:auto; height:auto;">
        <h1 style="margin-left:10%; border-bottom: 1px solid #D0D0D0; width:80%;"></h1>
        <h1 style="text-align: center;"><?php echo $product_type_map[$product_type_en]; ?></h1>
        <h1 style="margin-left:10%; border-top: 1px solid #D0D0D0; width:80%;"></h1>
        <p id="status_bar" style="text-align: center; width:inherit; height: inherit; vertical-align: middle;"></p>
    </div>

    <div class="product-view">
	
    <div class="product-view-list" id="<?php echo $product_type_en; ?>_list" name="<?php echo $product_type_en; ?>_list">
    <?php foreach($product_data as $index => $product_row) : ?>
        <div class="product-item" id="<?php echo $product_row->code; ?>" name="<?php echo $product_row->name; ?>">
            <div class="add_to_cart">
                    <button type="button" name="<?php echo "$product_row->type-$product_row->code"; ?>" onclick="addToCart(this)">加入购物车</button>
            </div>
            <div class="product-data-description">
                <p><b>产品信息：</b></p>
                <p><?php echo $product_row->description; ?></p>
            </div>
            
            <div class="product-data-field">
                <table class="product-item-data-table">
                        <tr>
                            <th>品 种</th><td>:</td><td><?php echo $product_type_map[$product_row->type]; ?></td>
                        </tr>
                        <tr>
                            <th>产品编码</th><td>:</td><td><?php echo "$product_row->code"; ?></td>
                        </tr>
                        <tr>
                            <th>产品名称</th><td>:</td><td><?php echo "$product_row->name"; ?></td>
                        </tr>
                        <tr>
                            <th>售出数量</th><td>:</td><td><?php echo "$product_row->totalSoldOut"; ?></td>
                        </tr>
                        <tr>
                            <th>库存数量</th><td>:</td><td><?php echo "$product_row->inventory"; ?></td>
                        </tr>
                        <tr>
                            <th>售 价</th><td>:</td><td><?php echo "$product_row->price"; ?></td>
                        </tr>
                </table>
            </div>
            
            <div class="product-item-media">
                <?php $product_type = $product_row->type; ?>
                <?php foreach($product_row->pics as $index => $pic_name): ?>
                    <a href="<?php echo base_url("product/get_media/$product_type/$pic_name"); ?>" target="_blank"><img src="<?php echo base_url("product/get_media/$product_type/$pic_name"); ?>" alt="<?php echo $product_row->name; ?>" /></a>
                <?php endforeach; ?>

                <?php foreach($product_row->videos as $index => $video_name): ?>
                    <video id="<?php echo $video_name; ?>" src="<?php echo base_url("product/get_media/$product_type/$video_name"); ?>" controls="controls"></video>
                <?php endforeach; ?>
            </div>
        </div>
	<?php endforeach; ?>
    </div>
    
    </div>

</body>
</html>
