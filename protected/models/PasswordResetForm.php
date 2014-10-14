<?php
/**
 * fCMS
 * PasswordResetForm.php
 * @author Filip Ajdacic <ajdasoft@gmail.com>
 */
class PasswordResetForm extends CFormModel {

	public $password;
    public $key;
    public $email;

	public function rules() {
		return array(
			array('password', 'required'),
            array('password', 'length', 'max' => User::PASSWORD_MAX, 'min' =>User::PASSWORD_MIN),
		);
	}

	public function attributeLabels() {
		return array(
			'email' => Yii::t('labels', 'Email'),
		);
	}
}
