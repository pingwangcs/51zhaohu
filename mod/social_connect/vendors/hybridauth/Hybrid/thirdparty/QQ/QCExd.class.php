<?php
require_once("QC.class.php");

/*
 * @brief QC类，api外部对象，调用接口全部依赖于此对象
* */
class QCExd extends QC{
	private $kesArr, $APIMap;
	
	public function __construct($appid, $appkey, 
			$scope, $callback, $errorReport){
		parent::__construct();	
		
		$this->recorder->write("appid", $appid);
		$this->recorder->write("appkey", $appkey);
		$this->recorder->write("scope", $scope);
		$this->recorder->write("callback", $callback);
		$this->recorder->write("errorReport", $errorReport);

        $this->keysArr = array(
            "oauth_consumer_key" => (int)$this->recorder->readInc("appid"),
            "access_token" => null,
            "openid" => null
        );
	}
	

	public function auth_login(){
		$appid = $this->recorder->readInc("appid");
		$callback = $this->recorder->readInc("callback");
		$scope = $this->recorder->readInc("scope");
	
		//-------生成唯一随机串防CSRF攻击
		$state = md5(uniqid(rand(), TRUE));
		$this->recorder->write('state',$state);
	
		//-------构造请求参数列表
		$keysArr = array(
				"response_type" => "code",
				"client_id" => $appid,
				"redirect_uri" => $callback,
				"state" => $state,
				"scope" => $scope
		);
	
		return $this->urlUtils->combineURL(self::GET_AUTH_CODE_URL, $keysArr);
	
		//header("Location:$login_url");
	}	
}