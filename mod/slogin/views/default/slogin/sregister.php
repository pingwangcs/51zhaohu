<?php
elgg_load_js("slogin.jsbn");
elgg_load_js("slogin.rsa");
elgg_load_js("slogin.sha1");

?>
<script>
$(window).load(initPwd);
function initPwd(){
	$("#password").val('');
	$("#password2").val('');
}
var $pem="-----BEGIN PUBLIC KEY-----MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwiuLtSIfdT1XagmM3UPomBWXaHuAwjAsVAEu/kJl6NYEkCgUlfCcXal+2tE4VGX6Ms08hi3lUpWikAO06cON3eFasmKR5z9Ch5dk2Qlq77Hw86d7dFu5H6zMj9R9E+rnT2bxx9a/OA8vNaAkV3dUOjY8kRjLSnQsVWsPHZ6/2ggMt8d21yCRQw/rCFwA0B6fezrnzrt6KCom3dF94x1KWfhEweqw3ElcWtawOpybVwceZ++ju10nFWDon7o3r40NHOAdHkMvOVz9+ciKEGM+5U8COT+KH3IkFR4TD5FEDqZBDiZX1l/+USj5PiooJEWtQK94vyhQn6zjLE/xMV1YuwIDAQAB-----END PUBLIC KEY-----";

var $key = RSA.getPublicKey($pem);
	
$(".elgg-form-register").submit(function() {
	
	var pvalue = this.password.value;
	var en=RSA.encrypt(pvalue, $key);
	this.password.value = en;

	var pvalue2=this.password2.value;
	var en2=RSA.encrypt(pvalue2, $key);
	this.password2.value = en2;	
	
	//fordebug alert("en "+en+"\n en2 "+en2);
});

$('#email').unbind(); 
$('#email').bind('paste', checkEmail);
$('#email').keypress(checkEmail);
$('#agreement_checkbox').bind('click', enableSubmit(self));

var stoppedTyping;

function checkEmail(){
	  if (stoppedTyping) clearTimeout(stoppedTyping);
	  stoppedTyping = setTimeout(function(){
	    // code to trigger once timeout has elapsed
	    var outlook = 'outlook.com';
	    var hotmail = 'hotmail.com';
	    if($('#email').val().indexOf(outlook)!=-1 || $('#email').val().indexOf(hotmail)!=-1 )
		    alert('哇，客官用的是高冷的outlook/hotmail邮箱，在点击注册前，需要把site@51zhaohu.com加到Options>Safe and blocked senders>Safe senders才能收到注册验证邮件哦');
	    }, 750);
}

function enableSubmit(val)
{
    var registerButton = document.getElementById("register");

    if (val.checked == true)
    {
    	registerButton.disabled = false;
    }
    else
    {
    	registerButton.disabled = true;
    }
}
</script>
