<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>

<body>
    <div class="user_nav_bar">
            <h1 style="vertical-align: middle;">
                <a class="back_home_link" href="<?php echo base_url(); ?>" target="_self">首页</a> | 欢迎回来，尊贵的VIP用户：
                <?php if (! is_null($user)): ?>
                    <a href="<?php echo base_url('user'); ?>" target="_self"><?php echo $user; ?></a>
                    <text> | </text> 
                    <a href="<?php echo base_url('user'); ?>" target="_self">
                        <img class="Cart Icon" src="<?php echo base_url("product/get_icon/icon_cart_alt.png"); ?>" style="max-height: 18px; margin: 0; padding: 0;" />
                    </a>
                <?php else: ?>
                     <a href="<?php echo base_url('login'); ?>" target="_self">请登录</a>
                <?php endif; ?>
                
            </h1>
    </div>
</body>
