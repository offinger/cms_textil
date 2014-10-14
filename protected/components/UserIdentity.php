<?php
/**
 * fCMS
 * UserIdentity.php
 * @author Filip Ajdacic <ajdasoft@gmail.com>
 */
class UserIdentity extends CUserIdentity {

 	 /* const ERROR_NONE=0;
    	const ERROR_USERNAME_INVALID=1;
    	const ERROR_PASSWORD_INVALID=2;
    	const ERROR_UNKNOWN_IDENTITY=100;*/
   const ERROR_INACTIVE=3;
	private $_id;

	public function authenticate() {
		$attribute = strpos($this->username, '@') ? 'email' : 'username';
		$user = User::model()->find(array('condition' => $attribute . '=:loginname', 'params' => array(':loginname' => $this->username)));

		if ($user === null) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		} else if (!$user->verifyPassword($this->password)) {
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		}
        else if ($user->status==User::STATUS_INACTIVE) {
        			$this->errorCode = self::ERROR_INACTIVE;
        		}
        else {
			$user->regenerateValidationKey();
			$this->_id = $user->id;
			$this->username =  $user->username;

			$this->setState('vkey', $user->validation_key);
			$this->errorCode = self::ERROR_NONE;
		}
		return !$this->errorCode;

	}

	public static function createAuthenticatedIdentity($id, $username) {
		$identity = new self($username, '');
		$identity->_id = $id;
		$identity->errorCode = self::ERROR_NONE;
		return $identity;
	}

	public function getId() {
		return $this->_id;
	}
}