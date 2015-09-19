<?php
elgg_load_js("slogin.jsbn");
elgg_load_js("slogin.rsa");
elgg_load_js("slogin.sha1");
?>
<script>
var $pem="-----BEGIN PUBLIC KEY-----MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwiuLtSIfdT1XagmM3UPomBWXaHuAwjAsVAEu/kJl6NYEkCgUlfCcXal+2tE4VGX6Ms08hi3lUpWikAO06cON3eFasmKR5z9Ch5dk2Qlq77Hw86d7dFu5H6zMj9R9E+rnT2bxx9a/OA8vNaAkV3dUOjY8kRjLSnQsVWsPHZ6/2ggMt8d21yCRQw/rCFwA0B6fezrnzrt6KCom3dF94x1KWfhEweqw3ElcWtawOpybVwceZ++ju10nFWDon7o3r40NHOAdHkMvOVz9+ciKEGM+5U8COT+KH3IkFR4TD5FEDqZBDiZX1l/+USj5PiooJEWtQK94vyhQn6zjLE/xMV1YuwIDAQAB-----END PUBLIC KEY-----";
var $key = RSA.getPublicKey($pem);
var encrypted = false;
	
	$(".elgg-form-login").submit(function() {
		if(!encrypted){
			var pvalue = this.password.value;
			var en=RSA.encrypt(pvalue, $key);
			this.password.value = en;
			encrypted = true;
			//fordebug	alert("en "+en);
		}
	});	

</script>
