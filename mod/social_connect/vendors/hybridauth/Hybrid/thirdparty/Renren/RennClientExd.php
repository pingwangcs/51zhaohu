<?php
/**
 * Copyright 2011 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

require_once "RennClient.php";

/**
 * Extends the RennClient class with the intent of using
 * PHP sessions to store user ids and access tokens.
 */
class RennClientExd extends RennClient
{
  /**
   * Identical to the parent constructor, except that
   * we start a PHP session to store the user ID and
   * access token if during the course of execution
   * we discover them.
   *
   * @param Array $config the application configuration.
   * @see RennClient::__construct in RennClient.php
   */
  public function __construct($clientId, $clientSecret) {
    if (!session_id()) {
      session_start();
    }
    parent::__construct($clientId, $clientSecret);
  }

  protected static $kSupportedKeys =
    array('state', 'code', 'access_token', 'user_id');
  
  /**
   * The ID of the user, or 0 if the user is logged out.
   *
   * @var integer
   */
  protected $user;  
  
  /**
   * Get the UID of the connected user, or 0
   * if the Facebook user is not connected.
   *
   * @return string the UID if available.
   */
  public function getUser($code, $state, $redirect_uri) {
  	$this->clearPersistentData('user_id');
  	$user_id = $this->getUserIdFromTokenEndpoint($code, $state, $redirect_uri);
  	$this->setPersistentData('user_id', $user_id);
  	return $user_id;
  }
  
  public function getUserIdFromTokenEndpoint($code, $state, $redirect_uri) {
  	
  		$keys = array ();  	
  		
  		if (empty ( $state ) ||
  		$state !== $this->getPersistentData('state')) {
  			echo 'Invalid request';
  			exit ();
  		}  		
  		$this->clearPersistentData('state');
  	
  		$keys ['code'] = $code;
  		$keys ['redirect_uri'] = $redirect_uri;

  			//
  			$user = $this->getUserFromTokenEndpoint ( 'code', $keys );
  			if($user)  			
  				return $user['id'];  			
  			else
  				return 0;		 
  }
  
  public function getUserData(){
        $this->authWithStoredToken ();
  	$user_id = $this->getPersistentData('user_id');
  	//echo "id".$user_id;
  	$user_service = $this->getUserService ();
  	return $user_service->getUser ( $user_id );  	 
  }
  

  /**
   * Destroy the current session
   */
  public function destroySession() {
  	//$this->accessToken = null;  	
  	//$this->user = null;
  	$this->clearAllPersistentData();  
  }
  

  /**
   * Provides the implementations of the inherited abstract
   * methods.  The implementation uses PHP sessions to maintain
   * a store for authorization codes, user ids, CSRF states, and
   * access tokens.
   */
  public function setPersistentData($key, $value) {
    if (!in_array($key, self::$kSupportedKeys)) {
      self::errorLog('Unsupported key passed to setPersistentData.');
      return;
    }

    $session_var_name = $this->constructSessionVariableName($key);
    $_SESSION[$session_var_name] = $value;
  }

  public function getPersistentData($key, $default = false) {
    if (!in_array($key, self::$kSupportedKeys)) {
      self::errorLog('Unsupported key passed to getPersistentData.');
      return $default;
    }

    $session_var_name = $this->constructSessionVariableName($key);
    return isset($_SESSION[$session_var_name]) ?
      $_SESSION[$session_var_name] : $default;
  }

  public function clearPersistentData($key) {
    if (!in_array($key, self::$kSupportedKeys)) {
      self::errorLog('Unsupported key passed to clearPersistentData.');
      return;
    }

    $session_var_name = $this->constructSessionVariableName($key);
    unset($_SESSION[$session_var_name]);
  }

  protected function clearAllPersistentData() {
    foreach (self::$kSupportedKeys as $key) {
      $this->clearPersistentData($key);
    }
  }

  protected function constructSessionVariableName($key) {
    return implode('_', array('renren',
                              $this->getClientId(),
                              $key));
  }
}
