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
class Hybrid_Providers_Renren extends Hybrid_Provider_Model
{
	// default permissions, and alot of them. You can change them from the configuration by setting the scope to what you want/need
	public $scope = "email, user_about_me, user_birthday, user_hometown, user_website, read_stream, offline_access, publish_stream, read_friendlists";

	/**
	* IDp wrappers initializer 
	*/
	function initialize() 
	{
		if ( ! $this->config["keys"]["id"] || ! $this->config["keys"]["secret"] ){
			throw new Exception( "Your application id and secret are required in order to connect to {$this->providerId}.", 4 );
		}

		if ( ! class_exists('RennClientBase') ) {
			require_once Hybrid_Auth::$config["path_libraries"] . "Renren/RennClientBase.php";
			require_once Hybrid_Auth::$config["path_libraries"] . "Renren/RennClient.php";
			require_once Hybrid_Auth::$config["path_libraries"] . "Renren/RennClientExd.php";
		}

		$this->api = new RennClientExd( $this->config["keys"]["id"], $this->config["keys"]["secret"] ); 
		//$this->api->getUser();
	}

	/**
	* begin login step
	* 
	* simply call Renren::require_login(). 
	*/
	function loginBegin()
	{
		$state = uniqid ( null, true );
		$this->api->setPersistentData('state', $state);
		// get the login url 
		$url = $this->api->getAuthorizeURL( $this->endpoint, 'code', $state, "page" );

		// redirect to Renren
		Hybrid_Auth::redirect( $url );
	}

	/**
	* finish login step 
	*/
	function loginFinish()
	{ 
		// in case we get error_reason=user_denied&error=access_denied
		if ( isset( $_REQUEST['error'] ) && $_REQUEST['error'] == "access_denied" ){ 
			throw new Exception( "Authentification failed! The user denied your request.", 5 );
		}
		if ( ! isset ( $_REQUEST ['code']) || !isset ( $_REQUEST ['state']) ){
			throw new Exception( "Authentification failed! The user denied your request.", 5 );
		}
		$code = $_REQUEST ['code'];
		$state = $_REQUEST ['state'];
		$user_id = 0;
		// try to get the UID of the connected user from fb, should be > 0 
		try{
			$user_id = $this->api->getUser($code, $state, $this->endpoint);
		}
		catch (Exception $e ){
			Hybrid_Logger::error( "Authentification failed! Renren returned an invalide user id.");
			Hybrid_Logger::error( "Exception:" . $e->getMessage(), $e );
		}
		
		if ( ! $user_id ) {
			throw new Exception( "Authentification failed! {$this->providerId} returned an invalide user id.", 5 );
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
			$data = $this->api->getUserData(); 
		}
		catch( RenrenApiException $e ){
			throw new Exception( "User profile request failed! {$this->providerId} returned an error: $e", 6 );
		} 

		// if the provider identifier is not recived, we assume the auth has failed
		if ( ! isset( $data["id"] ) ){ 
			throw new Exception( "User profile request failed! {$this->providerId} api returned an invalid response.", 6 );
		}

		# store the user profile.
		$this->user->profile->identifier    = (array_key_exists('id',$data))?$data['id']:"";
		$this->user->profile->displayName   = (array_key_exists('name',$data))?$data['name']:"";
		$this->user->profile->firstName     = (array_key_exists('first_name',$data))?$data['first_name']:"";
		$this->user->profile->lastName      = (array_key_exists('last_name',$data))?$data['last_name']:"";
		//$this->user->profile->photoURL      = "https://graph.facebook.com/" . $this->user->profile->identifier . "/picture?type=square";
		$this->user->profile->profileURL    = (array_key_exists('link',$data))?$data['link']:""; 
		$this->user->profile->webSiteURL    = (array_key_exists('website',$data))?$data['website']:""; 
		$this->user->profile->gender        = (array_key_exists('gender',$data))?$data['gender']:"";
		$this->user->profile->description   = (array_key_exists('bio',$data))?$data['bio']:"";
		$this->user->profile->email         = (array_key_exists('email',$data))?$data['email']:"";
		$this->user->profile->emailVerified = (array_key_exists('email',$data))?$data['email']:"";
		//$this->user->profile->region        = (array_key_exists("hometown",$data)&&array_key_exists("name",$data['hometown']))?$data['hometown']["name"]:"";

		if( array_key_exists('birthday',$data) ) {
			list($birthday_month, $birthday_day, $birthday_year) = explode( "/", $data['birthday'] );

			$this->user->profile->birthDay   = (int) $birthday_day;
			$this->user->profile->birthMonth = (int) $birthday_month;
			$this->user->profile->birthYear  = (int) $birthday_year;
		}

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
