<?php ?>
//<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId: '1493337114213955',
      xfbml: true,
      version: 'v2.2'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

$(document).ready(function() {
    zhLogin.init();
});

var zhLogin = {
    init: function() {
    	zhLogin.paramReset();
        zhLogin.qzone();
        zhLogin.weibo();
    },  
    param: {  
        id: '',
        email:'',
        username: '',
        nickname: '',
        gender: '',//性别（1：男、2：女）
        //birthYear: '',
        city:'',
        province:'',
        figureurl: '',
        rec: false,
    },  
    paramReset: function() {
    	zhLogin.param.id = '';
    	zhLogin.param.email = '';
    	zhLogin.param.username = '';
    	zhLogin.param.nickname = '';
    	//zhLogin.param.birthYear = '';
    	zhLogin.param.gender = '';
    	zhLogin.param.city = '';
    	zhLogin.param.province = '';
    	zhLogin.param.figureurl = '';
    	zhLogin.param.rec=false;
    }, 
    zhauth: function(provider){
 		$.ajax({
 			url: "http://"+window.location.hostname+'/mod/zhsocial/auth.php',
 			type: 'post',
 			data: {"user" : JSON.stringify(zhLogin.param), "provider" : provider},
 			success: function() {
     			//alert('login with '+provider+' succeed ');
 				window.location.href = "http://"+window.location.hostname;
 			}
 		}); 
    },
    //QQ空间    
    zh_fb: {
    	checkLoginState: function(){
    		 FB.getLoginStatus(function(response) {
    		 	if (response.status === 'connected') {
    		 		zhLogin.zh_fb.getUser();
    		 		//alert('登录Facebook');
                } else if (response.status === 'not_authorized') {
                	alert('请授权登录51招呼');
                } else {
                	alert('请登录Facebook');
                }
    		 });
    	},
    	getUser:  function () {
    	    FB.api('/me', function(ret) {
              if(zhLogin.param.rec==false){
              	//zhLogin.param.rec = true;
              	zhLogin.param.id = ret.id;
              	zhLogin.param.email = ret.email;
                zhLogin.param.nickname = ret.name;
                zhLogin.param.gender = ret.gender;
                //zhLogin.param.province = ret.province;
                //zhLogin.param.city = ret.city;
                zhLogin.zhauth("FB");
              }
    	    });
    	  }
    },
    //QQ空间
    qzone: function() {
        QC.Login(
            {
                btnId: "qqLoginBtn",
                size: "A_L"
            },
            function(ret, opts) {
                if(zhLogin.param.rec==false){
                    zhLogin.param.rec = true;
                    zhLogin.param.nickname = ret.nickname;
                    //zhLogin.param.figureurl = ret.figureurl_qq_2;
                    zhLogin.param.gender = ret.gender;
                    //zhLogin.param.province = ret.province;
                    zhLogin.param.city = ret.city;
                	QC.Login.getMe(function(openId, accessToken) {
                    	zhLogin.param.id = openId;
                    	zhLogin.zhauth("QQ");
                    })
                }
            },  
            function(opts) {
                alert('QQ登录 注销成功');
            }
        );
    },
    weibo: function() {
    	WB2.anyWhere(function (W) {
    	    W.widget.connectButton({
    	        id: "wb_connect_btn",
    	        type: '2,2',
    	        callback: {
    	            login: function (ret) {
                        zhLogin.param.id = ret.id;
                        zhLogin.param.username = ret.name;
                        zhLogin.param.nickname = ret.screen_name;
                        //zhLogin.param.figureurl = ret.profile_image_url;
                        zhLogin.param.gender = ret.gender;
                        zhLogin.zhauth("WB");
    	            },
    	            logout: function () { //退出后的回调函数
    	            	alert('新浪登录 注销成功');
    	            }
    	        }
    	    });
    	});
    },
};
