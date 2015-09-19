<?php
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html 
*/

/**
 * Hybrid_Providers_Renren provider adapter based on OAuth2 protocol
 * 
 * Hybrid_Providers_Renren use the Renren PHP SDK created by Renren
 * 
 * http://hybridauth.sourceforge.net/userguide/IDProvider_info_Renren.html
 */
class Hybrid_Providers_QQ extends Hybrid_Provider_Model
{
	// default permissions, and alot of them. You can change them from the configuration by setting the scope to what you want/need
	public $scope = "get_user_info, get_info";

	/**
	* IDp wrappers initializer 
	*/
	function initialize() 
	{
		if ( ! $this->config["keys"]["id"] || ! $this->config["keys"]["secret"] ){
			throw new Exception( "Your application id and secret are required in order to connect to {$this->providerId}.", 4 );
		}

		if ( ! class_exists('QC') ) {			
			//require_once Hybrid_Auth::$config["path_libraries"] . "QQ/Oauth.class.php";
			require_once Hybrid_Auth::$config["path_libraries"] . "QQ/QC.class.php";
		}

		$inc = (object) array('appid' => $this->config["keys"]["id"], 
				'appkey' => $this->config["keys"]["secret"],
				'scope' => $this->scope,
				'callback' => $this->endpoint,
				'errorReport' => true); 
		$this->api = new QC($inc);
	}

	/**
	* begin login step
	* 
	* simply call QCExd::auth_login(). 
	*/
	function loginBegin()
	{
		// get the login url 
		$this->api->qq_login();// "page" 
		die();
		// redirect to Renren
		//Hybrid_Auth::redirect( $url );
	}

	/**
	* finish login step 
	*/
	function loginFinish()
	{ 
		// in case we get error_reason=user_denied&error=access_denied
		if ( isset( $_REQUEST['error'] ) && $_REQUEST['error'] == "access_denied" ){
			Hybrid_Logger::debug( "QQ access_denied" );
			throw new Exception( "Authentification failed! The user denied your request.", 5 );
		}
		if ( ! isset ( $_REQUEST ['code']) || !isset ( $_REQUEST ['state']) ){
			Hybrid_Logger::debug( "QQ no code or state" );
			throw new Exception( "Authentification failed! The user denied your request.", 5 );
		}
		$code = $_REQUEST ['code'];
		$state = $_REQUEST ['state'];
		
		// try to get the UID of the connected user from fb, should be > 0 
		try{			
			$access_token = $this->api->qq_callback();
			$openid = $this->api->get_openid();
			Hybrid_Logger::debug( "Get QQ openid: {$openid}");
		}
		catch (Exception $e ){
			Hybrid_Logger::error( "Authentification failed for {$this->providerId} ");
			Hybrid_Logger::error( "Exception:" . $e->getMessage(), $e );
		}
		
		if ( ! $access_token || !$openid) {
			throw new Exception( "Authentification failed! {$this->providerId} returned invalide access token or openid", 5 );
		}

		// set user as logged in
		$this->setUserConnected();

		// store access token 
		//$this->token( "access_token", $this->api->getAccessToken() );
	}

	/**
	* logout
	*/
	function logout()
	{
		$this->api->destroySession();

		parent::logout();
	}

	/**
	* load the user profile from the IDp api client
	*/
	function getUserProfile()
	{
		// request user profile from fb api
		try{		  	
			$data = $this->api->get_user_info();
			$openid = $this->api->get_openid();
			print_r($data);
		}
		catch( Exception $e ){
			throw new Exception( "User profile request failed! {$this->providerId} returned an error: $e", 6 );
		} 

		// if the provider identifier is not recived, we assume the auth has failed
		if ( ! isset($openid) || empty($openid)){ 
			throw new Exception( "User profile request failed! {$this->providerId} api returned an invalid openid.", 6 );
		}

		# store the user profile.
		$this->user->profile->identifier    = $openid;
		$this->user->profile->displayName   = (array_key_exists('nickname',$data))?$data['nickname']:"";
		$this->user->profile->gender        = (array_key_exists('gender',$data))?$data['gender']:"";
		$this->user->profile->state       = (array_key_exists('province',$data))?$data['province']:"";
		$this->user->profile->city        = (array_key_exists('city',$data))?$data['city']:"";
		$this->user->profile->birthYear       = (array_key_exists('year',$data))?$data['year']:"";		
		$this->user->profile->photoURL      = (array_key_exists('figureurl_2',$data))?$data['figureurl_2']:"";
// 		if( array_key_exists('birthday',$data) ) {
// 			list($birthday_month, $birthday_day, $birthday_year) = explode( "/", $data['birthday'] );

// 			$this->user->profile->birthDay   = (int) $birthday_day;
// 			$this->user->profile->birthMonth = (int) $birthday_month;
// 			$this->user->profile->birthYear  = (int) $birthday_year;
// 		}
		return $this->user->profile;
 	}

	/**
	* load the user contacts
	*/
	function getUserContacts()
	{
		$contacts = ARRAY();

		return $contacts;
 	}

	/**
	* update user status
	*/
	function setUserStatus( $status )
	{
		$parameters = array();

		return $parameters;
 	}

	/**
	* load the user latest activity  
	*    - timeline : all the stream
	*    - me       : the user activity only  
	*/
	function getUserActivity( $stream )
	{
		$activities = ARRAY();

		return $activities;
 	}
}
