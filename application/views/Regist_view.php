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


        p.footer {
            text-align: right;
            font-size: 11px;
            border-top: 1px solid #D0D0D0;
            line-height: 32px;
            padding: 0 10px 0 10px;
            margin: 20px 0 0 0;
        }
        
        p.error_message {
            text-indent: 30px;
            color: red;
            font-size: 14px;
        }

        p {
                color:dimgray;
                font-size: 14px;
            }

        #container {
            margin: 10px;
            border: 1px solid #D0D0D0;
            box-shadow: 0 0 8px #D0D0D0;
        }
        
        #regist_box {
            margin: 10px;
        }
        
        button {
            margin: 5px;
            font-size: 14px;
            border-radius: 5px;
            max-width: 180px;
            padding: 8px;
        }
        
        input {
            margin: 5px;
            padding: 5px;
            font-size: 12px;
            border: 1px solid #D0D0D0;
            border-radius: 5px;
            width:  240px;
            color: #D0D0D0;
        }
        
	</style>
    <script type="text/javascript" src="/scripts/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="/scripts/jquery.md5.js"></script>
    <script type="text/javascript">
        function encrypt(cnode) {
            var passwd = cnode.value;
            var new_pw = $.md5(passwd);
            cnode.value = new_pw;
            console.log(new_pw);
        }
    
    </script>
</head>
<body>

<div id="container">
	<h1>欢迎进入【花之依恋】用户注册系统。</h1>

	<div id="regist_box">
        <p id="user_pw_comments">* 用户名和密码仅限字母，数字或下划线‘_’，并且只能以字母或下划线‘_’开头，字符之间不能有空格.</p>
		<form action="<?php echo base_url("login/regist_submit"); ?>" name="regist_form" method="post" target="_self" enctype="multipart/form-data">
            <table>
                <tr><td>*</td><td><b>用户名</b></td><td>：</td><td><input id="username" maxlength="16" name="username" type="text" value="" placeholder="请在此输入用户名，长度6-16个字符，必填" pattern="[_A-Za-z]{1}[_A-Za-z0-9]{5,15}" required="required"/></td></tr>
                <tr><td>*</td><td><b>密 码</b></td><td>：</td><td><input id="password" maxlength="16" name="password" type="password" value="" placeholder="请在此输入密码，长度8-16个字符，必填" pattern="[_A-Za-z0-9]{8,32}" required="required" onblur="encrypt(this)" /></td></tr>
                <tr><td>*</td><td><b>手机号</b></td><td>：</td><td><input id="phone" maxlength="11" name="tel" type="tel" value="" placeholder="请在此输入手机号，长度11个字符，必填" pattern="[0-9]{11}" required="required"/></td></tr>
                <tr><td></td><td><b>地 址</b></td><td>：</td><td><input id="address" maxlength="128" name="address" type="text" value="" placeholder="请在此输入收货地址，最大长度64个字符, 可选填" style="width: 980px;"/></td></tr>
            </table>
            <button type="submit" autofocus="autofocus"><a>立即注册</a></button>
            <button type="button" class="back_home_btn" style="position: relative; right:-85%;">
                <a class="back_home_link" href="<?php echo base_url(); ?>" target="_self">返回首页</a>
            </button>
        </form>
	</div>
    <div>
		<p class="error_message"><?php if (! is_null($error)) {echo "! - "; echo $error;} ?></p>
	</div>
	<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?></p>
</div>

</body>
</html>
