<html xmlns:wb="http://open.weibo.com/wb">
<script type="text/javascript"
	src="http://qzonestyle.gtimg.cn/qzone/openapi/qc_loader.js"
	data-appid="101165869" charset="utf-8"></script>
<script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js?appkey=3194664931" type="text/javascript" charset="utf-8"></script>
<div class="zh-login">
<div><span id="qqLoginBtn"></span></div>
<div id="wb_connect_btn"></div>
<div><fb:login-button scope="public_profile,email" onlogin="zhLogin.zh_fb.checkLoginState();"></fb:login-button></div>
</div>
<?php
elgg_load_js("zhsocial.login");