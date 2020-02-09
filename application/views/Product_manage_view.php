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
        
        p {
            text-indent: 15px;
            color: #444;
            background-color: transparent;
            font-size: 14px;
            font-weight: normal;
        }

        p.footer {
            text-align: right;
            font-size: 11px;
            border-top: 1px solid #D0D0D0;
            line-height: 32px;
            padding: 0 10px 0 10px;
            margin: 20px 0 0 0;
        }

        div.product-manage-view {
            margin-top: 15px;
            margin-left: 5px;
            margin-right: 5px;
            margin-bottom: 15px;
            padding: 5px;
            border: 1px solid #D0D0D0;
            box-shadow: 0 0 8px #D0D0D0;
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
        
        th.product-fields {
            width: 80px;
            height: auto;
            text-align: center;
            padding: 5px;
        }
        
        td.product-fields {
            width: 80px;
            height: auto;
            text-align: center;
            padding: 0px;
        }
        
        th.product-fields-name {
            width:580px; 
            height: auto;
            text-align: center;
            padding: 0px;
        }
        
        td.product-fields-name {
            width:580px; 
            height: auto;
            text-align: center;
            padding: 0px;
        }
        
        textarea {
            margin:5px;
            padding: 10px; 
            height:120px; 
            width:60%; 
            border-radius: 5px; 
            border: 1px solid #D0D0D0; 
            font-size: 12px;
        }
        
        div.product-manage-view-list {
            width: auto;
            height: auto;
        }
        
        div.product-manage-item {
            margin: 10px;
            width: auto;
            height: auto;
            padding: 5px;
            border: 1px solid #D0D0D0;
            box-shadow: 0 0 8px #D0D0D0;
            border-radius: 10px;
        }
        
        div.product-manage-item-media {
            width: auto;
            height: auto;
        }
        
        div.product-manage-item-media-add {
            float:left;
            width:240px; 
            height:300px; 
            text-align:center;
        }
        
        table.product-manage-item-data-table {
            width: auto;
            height: auto;
            border-collapse:collapse;
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
        
        input.product-fields-input {
            margin: 5px;
            padding: 3px;
            width: inherit;
            height: inherit;
            text-align: center;
            font-size: 12px;
            border-radius: 5px;
            border: 1px solid #D0D0D0;
        }
        
        div.mediaItemDiv {
            position: relative;
            float: left;
        }
        img.deleteIcon {
            position: absolute;
            top: 0px;
            right: 0px;
            width: 20px;
            height: 20px;
            z-index: 9;
        }
        
	</style>
    <script type="text/javascript">
        function addMedia(cnode) {
            var product_type = cnode.id.split('_')[0];
            var product_code = cnode.id.split('_')[1];
            var mediaSelector = document.createElement('input');
            mediaSelector.setAttribute('id', product_type+'_'+product_code+'_mediaSelector');
            mediaSelector.setAttribute('type','file');
            mediaSelector.setAttribute('name', 'add_medias[]');
            mediaSelector.setAttribute("style",'visibility:hidden');
            mediaSelector.setAttribute('multiple','multiple');
            mediaSelector.setAttribute('accept','image/gif, image/jpeg, image/png, video/mp4');
            mediaSelector.setAttribute('onchange', 'uploadFiles(this)');
            cnode.parentNode.appendChild(mediaSelector);
            mediaSelector.click();   
        }
        
        function listFiles(inputNode) {
            var tableNode = document.createElement('table');
            tableNode.setAttribute('style', 'margin-left:10%; border-collapse:collapse; width:inherit;');
            for (i=0; i<inputNode.files.length; i++) {
                var trNode = document.createElement('tr');
                var textNode = document.createTextNode(inputNode.files[i].name);
                var progressBar = document.createElement('progress');
                progressBar.setAttribute('value', 1);
                progressBar.setAttribute('max', 100);
                progressBar.setAttribute('id', inputNode.files[i].name);
                var tdNode1 = document.createElement('td');
                var tdNode2 = document.createElement('td');
                tdNode1.appendChild(textNode);
                tdNode2.appendChild(progressBar);
                trNode.appendChild(tdNode1);
                trNode.appendChild(tdNode2);
                tableNode.appendChild(trNode);
            }
            document.getElementById('status_bar').parentNode.appendChild(tableNode);
        }
        
        function uploadFiles(cnode) {
            listFiles(cnode);
            var product_type = cnode.id.split('_')[0];
            var product_code = cnode.id.split('_')[1];
            
            for (i=0; i<cnode.files.length; i++) {
                var formdata = new FormData;
                var fileName = cnode.files[i].name;
                var fileObj = cnode.files[i];
                formdata.append('type', product_type);
                formdata.append('code', product_code);
                //this file formdata will be post to var $_FILES['file'] in backend php codes.
                formdata.append('file', fileObj, fileName);
                
                var xmlhttp = new XMLHttpRequest();
                //add event listener before sending request.
                xmlhttp.upload.onprogress = function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total * 100;
                        document.getElementById(fileName).setAttribute('value', percentComplete);
                    } else {
                        console.log("Unable to compute progress information since the total size is unknown.");
                    }
                }
                xmlhttp.upload.onload = function(evt) {
                    //document.getElementById('status_bar').innerHTML = '';
                    //var r = document.createTextNode(this.responseText);
                    //document.getElementById('status_bar').appendChild(r);
                    //setTimeout("document.getElementById('status_bar').innerHTML = '';", 5000);
                    console.log("The transfer is complete.");
                }
                xmlhttp.upload.onerror = function(evt) {
                    console.log("An error occurred while transferring the file.");
                }
                xmlhttp.upload.onabort = function(evt) {
                    console.log("The transfer has been canceled by the user.");
                }
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        if(this.responseText.match("成功|失败")) {
                            
                            document.getElementById('status_bar').innerHTML = '';
                            var r = document.createTextNode(this.responseText);
                            document.getElementById('status_bar').appendChild(r);
                            var file_name = /[\w-\d]+.(jpeg|png|gif|mp4)/.exec(this.responseText)[0];
                            var mediaItemDiv = document.createElement('div');
                            mediaItemDiv.setAttribute('class', 'mediaItemDiv');
                            mediaItemDiv.setAttribute('id', file_name);
                            mediaItemDiv.setAttribute('onmouseover', 'showDelPic(this)');
                            mediaItemDiv.setAttribute('onmouseout', 'hideDelPic(this)');
                            
                            if (fileObj.type.match('image')) {
                                var pics_div_node = document.getElementById(product_code+'_pics');
                                var new_pic_link_node = document.createElement('a');
                                var new_pic_node = document.createElement('img');
                                new_pic_link_node.setAttribute('href', 'http://'+document.domain+'/product/get_media/'+product_type+'/'+file_name);
                                new_pic_link_node.setAttribute('target', '_blank');
                                new_pic_node.setAttribute('class', 'productMedia');
                                new_pic_node.setAttribute('draggable', 'true');
                                new_pic_node.setAttribute('dropzone', 'move');
                                new_pic_node.setAttribute('alt', '点击可打开大图');
                                new_pic_node.setAttribute('src', 'http://'+document.domain+'/product/get_media/'+product_type+'/'+file_name);
                                new_pic_link_node.appendChild(new_pic_node);
                                mediaItemDiv.appendChild(new_pic_link_node);
                                pics_div_node.appendChild(mediaItemDiv);
                            } else if (fileObj.type.match('video')) {
                                var videos_div_node = document.getElementById(product_code+'_videos');
                                var new_video_node = document.createElement('video');
                                new_video_node.setAttribute('class', 'productMedia');
                                new_video_node.setAttribute('draggable', 'true');
                                new_video_node.setAttribute('dropzone', 'move');
                                new_video_node.setAttribute('controls', 'controls');
                                new_video_node.setAttribute('src', 'http://'+document.domain+'/product/get_media/'+product_type+'/'+file_name);
                                mediaItemDiv.appendChild(new_video_node);
                                videos_div_node.appendChild(mediaItemDiv);
                            }
                            
                            setTimeout("document.getElementById('status_bar').innerHTML = '';", 5000);
                        }
                    }
                };
                xmlhttp.open("POST", 'http://'+document.domain+'/product/upload_files', true);
                xmlhttp.send(formdata);
            }
            setTimeout("document.getElementById('status_bar').parentNode.removeChild(document.getElementById('status_bar').parentNode.getElementsByTagName('table')[0]);", 3000);
        }
        
        function showDelPic(cnode) {
            var delNode = cnode.getElementsByClassName('deleteIcon')[0];
            delNode.removeAttribute('hidden');
        }
        
        function hideDelPic(cnode) {
            var delNode = cnode.getElementsByClassName('deleteIcon')[0];
            delNode.setAttribute('hidden', 'hidden');
        }
        
        function deleteMedia(cnode) {
            var mediaItemDivNode = cnode.parentNode;
            var mediaName = mediaItemDivNode.id;
            
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        if(this.responseText.match("成功|失败")) {
                            document.getElementById('status_bar').innerHTML = '';
                            var r = document.createTextNode(this.responseText);
                            document.getElementById('status_bar').appendChild(r);
                            setTimeout("document.getElementById('status_bar').innerHTML = '';", 3000);
                            mediaItemDivNode.parentNode.removeChild(mediaItemDivNode);
                        }
                    }
            };
            xmlhttp.open("GET", 'http://'+document.domain+'/product/remove_files/'+mediaName, true);
            xmlhttp.send();
        }
                        
        
        function modifyItemData(cnode) {
            var product_code = cnode.id.split('_')[0];
            console.log(product_code);
            var product_id = document.getElementById(product_code+'_id').value;
            var product_type = document.getElementById(product_code+'_type').getAttribute('class').split(' ')[1];
            var product_totalSoldOut = document.getElementById(product_code+'_totalSoldOut').value;
            var product_inventory = document.getElementById(product_code+'_inventory').value;
            var product_cost = document.getElementById(product_code+'_cost').value;
            var product_price = document.getElementById(product_code+'_price').value;
            var product_state = document.getElementById(product_code+'_state').value;
            var product_name = document.getElementById(product_code+'_name').value;
            var product_description = document.getElementById(product_code+'_description').value;
            
            var formdata = new FormData();
            formdata.append('code', product_code);
            formdata.append('totalSoldOut', product_totalSoldOut);
            formdata.append('inventory', product_inventory);
            formdata.append('cost', product_cost);
            formdata.append('price', product_price);
            formdata.append('state', product_state);
            formdata.append('name', product_name);
            formdata.append('description', product_description);
            
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if(this.responseText.match("成功|失败")) {
                        document.getElementById('status_bar').innerHTML = '';
                        var r = document.createTextNode(this.responseText);
                        document.getElementById('status_bar').appendChild(r);
                        setTimeout("document.getElementById('status_bar').innerHTML = '';", 3000);
                    } else {
                        document.body.innerHTML = this.responseText;
                    }
                }
            };
            xmlhttp.open("POST", 'http://'+document.domain+'/product/modify_submit/'+product_type+'/'+product_id, true);
            xmlhttp.send(formdata);
        }
        
        function deleteItem(cnode) {
            var product_code = cnode.id.split('_')[0];
            var product_type = document.getElementById(product_code+'_type').getAttribute('class').split(' ')[1];
            
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if(this.responseText.match("成功|失败")) {
                        document.getElementById('status_bar').innerHTML = '';
                        var r = document.createTextNode(this.responseText);
                        document.getElementById('status_bar').appendChild(r);
                        document.getElementById(product_code).parentNode.removeChild(document.getElementById(product_code));
                        setTimeout("document.getElementById('status_bar').innerHTML = '';", 3000);
                    } else {
                        document.body.innerHTML = this.responseText;
                    }
                }
            };
            xmlhttp.open("GET", 'http://'+document.domain+'/product/delete/'+product_type+'/'+product_code, true);
            xmlhttp.send();
        }
    </script>
</head>
<body>

    <div style="width:auto; height:auto;">
        <h1 style="margin-left:10%; border-bottom: 1px solid #D0D0D0; width:80%;"></h1>
        <h1 style="text-align: center;"><?php echo $product_type_map[$product_type_en]; ?></h1>
        <h1 style="margin-left:10%; border-top: 1px solid #D0D0D0; width:80%;"></h1>
        <p id="status_bar" style="text-align:center; width: inherit; height:auto; vertical-align: middle;"></p>
    </div>

    <div class="product-manage-view">
        <p>您可以直接在方框中修改相应的数据，完成后直接点击每一行末尾的“提交修改”按钮。</p>
        <div class="product-manage-view-list" id="<?php echo $product_type_en; ?>_list" name="<?php echo $product_type_en; ?>_list">
        <?php foreach($product_data as $index => $product_row) : ?>
            <div class="product-manage-item" id="<?php echo $product_row->code; ?>" name="<?php echo $product_row->name; ?>">
                <div class="product-manage-item-media">
                    <div class="product-manage-item-pics" id="<?php echo $product_row->code; ?>_pics" style="float: left;">
                    <?php $product_type = $product_row->type; ?>
                    <?php $product_code = $product_row->code; ?>
                    <?php foreach($product_row->pics as $index => $pic_name): ?>
                        <div class="mediaItemDiv" id="<?php echo "$pic_name"; ?>" onmouseover="showDelPic(this)" onmouseout="hideDelPic(this)">
                            <img class="deleteIcon Icon" src="<?php echo base_url("product/get_icon/icon_close_alt.png"); ?>" hidden="hidden" onclick="deleteMedia(this)" />
                            <a href="<?php echo base_url("product/get_media/$product_type/$pic_name"); ?>" target="_blank">
                                <img class="productMedia" draggable="true" dropzone="move" src="<?php echo base_url("product/get_media/$product_type/$pic_name"); ?>" alt="点击可打开大图" />
                            </a>
                        </div>
                    <?php endforeach; ?>
                    </div>
                    <div class="product-manage-item-videos" id="<?php echo $product_row->code; ?>_videos"style="float: left;">
                    <?php foreach($product_row->videos as $index => $video_name): ?>
                        <div class="mediaItemDiv" id="<?php echo "$video_name"; ?>" onmouseover="showDelPic(this)" onmouseout="hideDelPic(this)">
                            <img class="deleteIcon Icon" src="<?php echo base_url("product/get_icon/icon_close_alt.png"); ?>" hidden="hidden" onclick="deleteMedia(this)" />
                            <video class="productMedia" draggable="true" dropzone="move" src="<?php echo base_url("product/get_media/$product_type/$video_name"); ?>" controls="controls"></video>
                        </div>
                    <?php endforeach; ?>
                    </div>
                    <div class="product-manage-item-media-add">
                        <img style="margin-top:38%;" id="<?php echo $product_row->type; ?>_<?php echo $product_row->code; ?>_addMedia" src="<?php echo base_url("product/get_icon/icon_folder_upload.png"); ?>" onclick="addMedia(this)"/>
                    </div>
                </div>
                <?php $product_id = $product_row->id; ?>
                <?php $product_type = $product_row->type; ?>
                    <table class="product-manage-item-data-table">
                        <tr>
                            <th class="product-fields">序号</th>
                            <th class="product-fields">品种</th>
                            <th class="product-fields-name">产品名称</th>
                            <th class="product-fields">产品编码</th>
                            <th class="product-fields">售出数量</th>
                            <th class="product-fields">库存数量</th>
                            <th class="product-fields">成本</th>
                            <th class="product-fields">售价</th>
                            <th class="product-fields">状态</th>
                        </tr>
                        <tr>
                            <td class="product-fields"><input id="<?php echo $product_row->code; ?>_id" class="product-fields-input" maxlength="8" name="product_id" value="<?php echo $product_row->id; ?>" disabled="disabled"/></td>
                            <td class="product-fields"><input id="<?php echo $product_row->code; ?>_type" class="product-fields-input <?php echo $product_row->type;?>" maxlength="12" name="product_type" value="<?php echo $product_type_map[$product_row->type]; ?>" disabled="disabled"/></td>
                            <td class="product-fields-name"><input id="<?php echo $product_row->code; ?>_name" class="product-fields-input" maxlength="64" name="product_name" value="<?php echo $product_row->name; ?>" /></td>
                            <td class="product-fields"><input id="<?php echo $product_row->code; ?>_code" class="product-fields-input" maxlength="32" name="product_code" value="<?php echo $product_row->code; ?>" /></td>
                            <td class="product-fields"><input id="<?php echo $product_row->code; ?>_totalSoldOut" class="product-fields-input" maxlength="8" name="product_totalSoldOut" value="<?php echo $product_row->totalSoldOut; ?>" /></td>
                            <td class="product-fields"><input id="<?php echo $product_row->code; ?>_inventory" class="product-fields-input" maxlength="8" name="product_inventory" value="<?php echo $product_row->inventory; ?>" /></td>
                            <td class="product-fields"><input id="<?php echo $product_row->code; ?>_cost" class="product-fields-input" maxlength="8" name="product_cost" value="<?php echo $product_row->cost; ?>" /></td>
                            <td class="product-fields"><input id="<?php echo $product_row->code; ?>_price" class="product-fields-input" maxlength="8" name="product_price" value="<?php echo $product_row->price; ?>" /></td>
                            <td class="product-fields"><input id="<?php echo $product_row->code; ?>_state" class="product-fields-input" maxlength="16" name="product_state" value="<?php echo $product_row->state; ?>" /></td>
                        </tr>
                        <tr>
                            <th class="product-fields">产品描述</th>
                        </tr>
                        <tr>
                            <td class="product-fields-description" colspan="9">
                                <textarea id="<?php echo $product_row->code; ?>_description" maxlength="512" name="product_description" ><?php echo $product_row->description; ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="product-fields"><button id="<?php echo $product_row->code; ?>_modify-submit" type="button" value="submit" onclick="modifyItemData(this)">提交修改</button></td>
                            <td class="product-fields"><button id="<?php echo $product_row->code; ?>_delete" type="button" value="delete" onclick="deleteItem(this)">删除</button></td>
                        </tr>
                    </table>
            </div>
        <?php endforeach; ?>
            <pre><?php if(! empty($post_data)) {print_r($post_data);} ?></pre>
        </div>
        <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
    </div>

</body>
</html>
