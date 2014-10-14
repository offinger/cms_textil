<?php
/**
 * fCMS
 * ContactForm.php
 * @author Filip Ajdacic <ajdasoft@gmail.com>
 */
class ContactForm extends CFormModel {
	public $name;
	public $email;
	public $subject;
	public $body;
	public $verify_code;


	public function rules() {
		return array(
			array('name, email, subject, body', 'required'),
			array('email', 'email'),
            array('verify_code', 'validateCaptcha'),
		);
	}

    public function validateCaptcha($attribute, $params) {
    		if ($this->getRequireCaptcha())
    			CValidator::createValidator('application.extensions.recaptcha.EReCaptchaValidator',
                                                                            $this, $attribute
                                                                             ,array(  'privateKey'=>Yii::app()->params['recaptcha_private_key']))
                                                                            ->validate($this);
    	}

    public function getRequireCaptcha() {
	   	return Yii::app()->params['contactRequireCaptcha'];
   	}

	public function attributeLabels() {
		return array(
			'verify_code'=>'Verifikacioni kod',
		);
	}
}