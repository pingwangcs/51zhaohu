<?php
$content = "<div id='wechat_qrcode' class='zhaohu-homepage-right-sidebar-div'>";
$content .= '<a href="'. elgg_get_site_url().'mod/zhaohu_theme/images/wechat.png"><img id="wechat_qrcode_image" src="'. elgg_get_site_url(). 'mod/zhaohu_theme/images/wechat.png"/></a>';
$content .= '</div>';

echo $content;