<?php
/**
 * fCMS
 * LoginForm.php
 * @author Filip Ajdacic <ajdasoft@gmail.com>
 */
class LoginForm extends CFormModel {
	// Maksimalni broj pokusaja za proveru nakon kojih ce se pojavii captcha kod
	const MAX_LOGIN_ATTEMPTS = 100;

	public $username;
	public $password;
	public $email;
	public $rememberMe;
	public $verify_code;
    public $login_ip;
    public $login_time;
	private $_identity;
	private $_user = null;

	public function rules() {
		return array(
			array('username, password', 'required'),
			array('username', 'length', 'max' => User::USERNAME_MAX,'min'=>User::USERNAME_MIN),
			array('password', 'length', 'max' => User::PASSWORD_MAX, 'min' => User::PASSWORD_MIN),
			array('password', 'authenticate'),
			array('rememberMe', 'boolean'),
           array('verify_code', 'validateCaptcha'),
		);
	}

	/**
	 * Vraca vrednosti atirbut label-a
	 * @return array
	 */
	public function attributeLabels() {
		return array(
			'username' => Yii::t('labels', 'Korisničko ime ili email'),
			'rememberMe' => Yii::t('labels', 'Zapamti me sledeći put'),
			'password' => Yii::t('labels', 'Lozinka'),
		);
	}

	/**
	 * Vrsi autentifikaciju korisnika 
	 * @param $attribute
	 * @param $params
	 */
	public function authenticate($attribute, $params) {
		if (!$this->hasErrors()) {
			$this->_identity = new UserIdentity($this->username, $this->password);

			if (!$this->_identity->authenticate()) {
               $errorCode= $this->_identity->errorCode;

				if (($user = $this->user) !== null && $user->login_attempts < 100)
					$user->saveAttributes(array('login_attempts' => $user->login_attempts + 1));

                    if ($errorCode== UserIdentity::ERROR_INACTIVE){
                      $this->addError('status', Yii::t('errors', 'Vaš nalog je deaktiviran.'));
                    }
                if (($errorCode== UserIdentity::ERROR_PASSWORD_INVALID) ||
                    ($errorCode==UserIdentity::ERROR_USERNAME_INVALID)) {
				$this->addError('username', Yii::t('errors', 'Pogrešno korisničko ime.'));
				$this->addError('password', Yii::t('errors', 'Pogrešna lozinka.'));
                }

			}
		}
	}


	/**
	 * Validira capthca kod
	 * @param $attribute
	 * @param $params
	 */
	public function validateCaptcha($attribute, $params) {
		if ($this->getRequireCaptcha())
			CValidator::createValidator('application.extensions.recaptcha.EReCaptchaValidator',
                                                                        $this, $attribute
                                                                         ,array(  'privateKey'=>Yii::app()->params['recaptcha_private_key']))
                                                                        ->validate($this);
	}

	/**
	 * Prijava korisnika
	 * @return bool
	 */
	public function login() {
		if ($this->_identity === null) {
			$this->_identity = new UserIdentity($this->username, $this->password);
			$this->_identity->authenticate();
		}
		if ($this->_identity->errorCode === UserIdentity::ERROR_NONE) {
			$duration = $this->rememberMe ? 3600 * 24 * 30 : 0; // 30 dana traje kolacic..
            if (($user = $this->user) !== null )
                  $user->saveAttributes(array('login_time' => $user->login_time + 1,'login_ip'=>getUserIP(),'login_attempts'=>NULL));
			Yii::app()->user->login($this->_identity, $duration);
			return true;
		}
	}

	/**
	 * Vraca trenutnog korisnika
	 * @return null
	 */
	public function getUser() {
		if ($this->_user === null) {
			$attribute = strpos($this->username, '@') ? 'email' : 'username';
			$this->_user = User::model()->find(array('condition' => $attribute . '=:loginname', 'params' => array(':loginname' => $this->username)));
		}
		return $this->_user;
	}

	/**
	 * Provera koja zakljucuje da li je captcha neophodna ili ne. Aktivira se nakon vise pogresnih login-a.
	 * @return bool
	 */
	public function getRequireCaptcha() {
		return ($user = $this->user) !== null && $user->login_attempts >= self::MAX_LOGIN_ATTEMPTS;
	}

}
