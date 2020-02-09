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
            width: inherit;
            height: auto;
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
            #background-color:   #E0C0D0;
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
        
        div.user_info {
            margin: 15px;
            width: inherit;
            height: auto;
        }
        
        div.user_cart {
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
        
        table tr {
            margin: 5px;
            padding: 5px;
            width: inherit;
        }
        
        td {
            width: inherit;
            height: 32px;
            text-align: left;
            font-size: 14px;
        }
        
        input {
            font-size: 14px;
            padding: 3px;
            padding-left: 8px;
            height: 20px;
            border-radius: 5px;
        }
        
        tr.comments {
            font-size: 12px;
            color: #B0B0B0;
        }
        
        div.del_from_cart {
            float: right;
            margin: 15px;
            padding: 15px;
        }
        
	</style>
    <script type="text/javascript" src="/scripts/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="/scripts/jquery.md5.js"></script>
    <script type="text/javascript">
        function encrypt(cnode) {
            if (cnode.value) {
                var passwd = cnode.value;
                var new_pw = $.md5(passwd);
                cnode.value = new_pw;
            }
        }
        
        function hlight(cnode) {
            nodes = document.getElementsByTagName('button');
            for (i=0; i<nodes.length; i++) {
                nodes[i].setAttribute('style', 'border-color: transparent');
            }
            cnode.setAttribute('style', 'border-color: #E0C0D0');
            
        }
        
        function activeModify() {
            nodes = document.getElementsByClassName('comments');
            for (i=0; i<nodes.length; i++) {
                nodes[i].removeAttribute('hidden');
            }
            nodes = document.getElementsByClassName('user_input_field');
            for (i=0; i<nodes.length; i++) {
                nodes[i].removeAttribute('disabled');
            }
        }
        
        function activePasswdModify() {
            nodes = document.getElementsByClassName('passwd_modify');
            for (i=0; i<nodes.length; i++) {
                nodes[i].removeAttribute('hidden');
            }
        }
        
        function cancelModify() {
            nodes = document.getElementsByClassName('cancel');
            for (i=0; i<nodes.length; i++) {
                nodes[i].setAttribute('hidden', 'hidden');
            }
            nodes = document.getElementsByClassName('user_input_field');
            for (i=0; i<nodes.length; i++) {
                nodes[i].setAttribute('disabled', 'disabled');
            }
        }

        function submitModify() {
            var nodes = document.getElementsByClassName('user_info_field');
            var formdata = new FormData();
            for (i=0; i<nodes.length; i++) {
                formdata.append(nodes[i].name, nodes[i].value);
            }
            
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        if(this.responseText.match("成功|失败")) {
                            document.getElementById('status_bar').innerHTML = '';
                            var r = document.createTextNode(this.responseText);
                            document.getElementById('status_bar').appendChild(r);
                            cancelModify();
                            setTimeout("document.getElementById('status_bar').innerHTML = '';", 5000);
                        }
                    }
            };
            xmlhttp.open("POST", 'http://'+document.domain+'/user/modify', true);
            xmlhttp.send(formdata);
        }
        
        function modifyCart(cnode) {
            var action = cnode.id.split('_')[0];
            var product_code = cnode.id.split('_')[1];
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
            var count = Number(document.getElementById('modify_'+product_code).value);
            if (action == 'reduce' && count > 0) {
                count = count - 1;
                if (count == 0) {
                    xmlhttp.open("GET", 'http://'+document.domain+'/user/cart/delete/cart/'+product_code, true);
                    xmlhttp.send();
                    document.getElementById(product_code).parentNode.removeChild(document.getElementById(product_code));
                } else {
                    //document.getElementById('modify_'+product_code).value = count;
                    document.getElementById('modify_'+product_code).setAttribute('value', count);
                    xmlhttp.open("GET", 'http://'+document.domain+'/user/cart/'+action+'/cart/'+product_code+'/'+document.getElementById('modify_'+product_code).value, true);
                    xmlhttp.send();
                }
                //console.log(document.getElementById('modify_'+product_code));
            } else if (action == 'increase') {
                count = count + 1;
                //document.getElementById('modify_'+product_code).value = count;
                document.getElementById('modify_'+product_code).setAttribute('value', count);
                xmlhttp.open("GET", 'http://'+document.domain+'/user/cart/'+action+'/cart/'+product_code+'/'+document.getElementById('modify_'+product_code).value, true);
                xmlhttp.send();
                //console.log(document.getElementById('modify_'+product_code));
            } else if (action == 'modify' && document.getElementById('modify_'+product_code).value != "") {
                document.getElementById('modify_'+product_code).setAttribute('value', document.getElementById('modify_'+product_code).value);
                if (document.getElementById('modify_'+product_code).value <= 0) {
                    xmlhttp.open("GET", 'http://'+document.domain+'/user/cart/delete/cart/'+product_code, true);
                    xmlhttp.send();
                    document.getElementById(product_code).parentNode.removeChild(document.getElementById(product_code));
                } else {
                    xmlhttp.open("GET", 'http://'+document.domain+'/user/cart/'+action+'/cart/'+product_code+'/'+document.getElementById('modify_'+product_code).value, true);
                    xmlhttp.send();
                }
                //console.log(document.getElementById('modify_'+product_code));
            } else if (action == 'delete') {
                xmlhttp.open("GET", 'http://'+document.domain+'/user/cart/'+action+'/cart/'+product_code, true);
                xmlhttp.send();
                document.getElementById(product_code).parentNode.removeChild(document.getElementById(product_code));
            }
        }
    </script>
</head>
<body>

<div id="container">
    <div class="user_info">
        <form>
            <table>
                <tr class="comments cancel" hidden><td colspan="3"></td><td>用户名无法修改</td></tr>
                <tr>
                    <td>*</td>
                    <td><b>用户名</b></td>
                    <td>:</td>
                    <td><input class="user_info_field" name="user" value="<?php echo $user_detail['user']; ?>" disabled/></td>
                    <?php if($user_detail['authority'] == 31): ?>
                        <td><a href="<?php echo base_url('manage') ?>" target="_self"><button type="button" value="">管理产品</button></a></td>
                    <?php endif; ?>
                </tr>
                <tr class="comments cancel" hidden><td colspan="3"></td><td>请在此输入手机号，长度11个字符，必填</td></tr>
                <tr>
                    <td>*</td>
                    <td><b>电 话</b></td>
                    <td>:</td>
                    <td><input class="user_info_field user_input_field" name="tel" maxlength="11" type="tel" pattern="[0-9]{11}" required="required" value="<?php echo $user_detail['tel']; ?>" disabled/></td>
                </tr>
                <tr class="comments cancel" hidden><td colspan="3"></td><td>请在此输入收货地址，最大长度64个字符, 可选填</td></tr>
                <tr>
                    <td></td>
                    <td><b>地 址</b></td>
                    <td>:</td>
                    <td><input class="user_info_field user_input_field" name="address" maxlength="128" type="text" style="width: 360%; white-space: nowrap;" value="<?php echo $user_detail['address']; ?>" disabled/></td>
                </tr>
                <tr class="comments cancel" hidden><td colspan="3"></td><td>用户等级无法修改</td></tr>
                <tr>
                    <td></td>
                    <td><b>等 级</b></td>
                    <td>:</td>
                    <td><input class="user_info_field" name="tag" value="<?php echo $user_detail['tag']; ?>" disabled/></td>
                </tr>
                <tr class="passwd_modify cancel" hidden><td colspan="3"></td><td>请在此输入密码，长度8-16个字符，必填</td></tr>
                <tr class="passwd_modify cancel" hidden>
                    <td>*</td>
                    <td><b>密 码</b></td>
                    <td>：</td>
                    <td><input class="user_info_field user_input_field" name="passwd" maxlength="16" type="password" pattern="[_A-Za-z0-9]{8,32}" required="required" onblur="encrypt(this)"/></td>
                </tr>
            </table>
            <table>
                <tr>
                    <td><button type="button" value="" onclick="activeModify()">修改基本信息</button></td>
                    <td><button type="button" value="" onclick="activePasswdModify()">修改密码</button></td>
                    <td><button type="button" value="" onclick="submitModify()">提交</button></td>
                    <td><button type="button" value="" onclick="cancelModify()">取消</button></td>
                </tr>
            </table>
        </form>
    </div>
    
    <div>
        <h1 style="margin-left:10%; border-bottom: 1px solid #D0D0D0; width:80%;"></h1>
        <h1 style="text-align: center;">购物车列表</h1>
        <h1 style="margin-left:10%; border-top: 1px solid #D0D0D0; width:80%;"></h1>
        <p id="status_bar" style="text-align: center; height:28px; vertical-align: middle;"></p>
    </div>
    
    <div class="user_cart">
        <?php if(count($cart) > 0): ?>
            <?php foreach($cart as $product_row) : ?>
                <div class="product-item" id="<?php echo $product_row->code; ?>" name="<?php echo $product_row->name; ?>">
                    <div class="del_from_cart">
                        <button type="button" id="delete_<?php echo "$product_row->code"; ?>" onclick="modifyCart(this)">从购物车删除</button>
                        <button id="reduce_<?php echo "$product_row->code"; ?>" onclick="modifyCart(this)">-</button>
                        <input id="modify_<?php echo "$product_row->code"; ?>" max="99" min="0" style="text-align: center;" type="number" value="<?php echo "$product_row->count"; ?>" onchange="modifyCart(this)" />
                        <button id="increase_<?php echo "$product_row->code"; ?>" onclick="modifyCart(this)">+</button>
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
                            <a href="<?php echo base_url("product/get_media/$product_type/$video_name"); ?>" target="_blank"><video id="<?php echo $video_name; ?>" src="<?php echo base_url("product/get_media/$product_type/$video_name"); ?>" controls="controls"><?php echo $product_row->name; ?></video></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align: center; height:28px; vertical-align: middle; font-size: 18px;">空空如也，快去首页充实您的购物车吧。</p>
        <?php endif; ?>
    </div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>
