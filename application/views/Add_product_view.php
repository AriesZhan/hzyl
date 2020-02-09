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
	#product_title {
		height: 18px;
        width: 50%;
	}
	#product_description {
		height: 120px;
        width: 60%;
	}
    #product_code {
		height: 18px;
        width: 50%;
	}
	</style>
    <script type="text/javascript">
        function listFiles() {
            var upload_files = document.getElementById('product_pictures').files;
            console.log(upload_files);
            var ulnode = document.getElementById('picture_list');
            console.log(ulnode);
            for (i=0; i<ulnode.childNodes.length; i++) {
                ulnode.removeChild(ulnode.childNodes[i])
            }
            for (i=0; i<upload_files.length; i++) {
                var linode = document.createElement('li');
                var textnode = document.createTextNode(upload_files[i].name);
                linode.appendChild(textnode);
                ulnode.appendChild(linode);
            }
        }
        function listVideos() {
            var upload_files = document.getElementById('product_videos').files;
            console.log(upload_files);
            var ulnode = document.getElementById('video_list');
            console.log(ulnode);
            for (i=0; i<ulnode.childNodes.length; i++) {
                ulnode.removeChild(ulnode.childNodes[i])
            }
            for (i=0; i<upload_files.length; i++) {
                var linode = document.createElement('li');
                var textnode = document.createTextNode(upload_files[i].name);
                linode.appendChild(textnode);
                ulnode.appendChild(linode);
            }
            
        }
    </script>
</head>
<body>

<div id="container">
	<h1>管理员您好，您可以通过本页面添加新的产品信息，包括产品名称，描述，图片和视频。</h1>

	<div id="body">
		<p>您可参照各部分的说明进行产品信息的添加操作，所有选项完成后可以点击页面下方的 <button type="button">预览</button> 按钮进行产品信息预览，最后点击 <button type="button">提交</button> 按钮完成产品信息的上传。</p>
		<form action="<?php echo base_url('product/submit') ?>" name="add_product" method="post" target="_self" enctype="multipart/form-data">
			<div id="title">
				<p>请在下面的方框中输入产品的标题，字数限制为64个字符。</p>
				<p>产品标题：<br><input id="product_title"  maxlength="64" name="product_title" required/></p>	
			</div>
            <div id="type">
                <p>请在下面的下拉菜单中选择产品的类型。</p>
                <select id="product_type" name="product_type" required>
                    <option value=""></option>
                    <?php foreach ($product_type_map as $en => $cn) :?>
                        <option value="<?php echo $en; ?>"><?php echo $cn ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div id="code">
				<p>请在下面的方框中输入您上传产品的出厂编码，字数限制为32个字符。</p>
				<p>产品编码：<br><input id="product_code"  maxlength="32" name="product_code" required/></p>	
			</div>
			<div id="description">
				<p>请在下面的方框下输入产品的具体描述，字数限制为512个字符。</p>
				<p>产品描述：<br><textarea id="product_description" maxlength="512" name="product_description" required></textarea></p>
			</div>
			<div id="pictures">
				<p>请点击 <button type="button">+</button> 按钮添加你指定的产品图片，可以一次选定多个图片添加；添加过程中如需删除已添加的图片，可以点击下方图片列表中每一行末尾的 <button type="button">-</button> 按钮删除相应图片。</p>
                <input id="product_pictures" type="file" name="product_pictures[]" onchange="listFiles()" multiple="multiple" accept="image/gif, image/jpeg, image/png"/>
                <ul id="picture_list"></ul>
			</div>
			<div id="videos">
				<p>请点击 <button type="button">+</button> 按钮添加你指定的产品视频，可以一次选定多个视频添加；添加过程中如需删除已添加的视频，可以点击下方视频列表中每一行末尾的 <button type="button">-</button> 按钮删除相应视频。</p>
                <input id="product_videos" type="file" name="product_videos[]" onchange="listVideos()"  multiple="multiple" accept="video/mp4"/>
                <ul id="video_list"></ul>
			</div>
			<input style="margin:15px; width: 80px;" id="submit" type="submit" value="提交"/>
            <button style="margin:15px; width: 80px;" type="button" class="back_home_btn">
                    <a class="back_home_link" href="<?php echo base_url(); ?>" target="_blank">返回首页</a>
            </button>
		</form>
	</div>

	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>
