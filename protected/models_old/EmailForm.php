<?php
/**
 * fCMS
 * EmailForm.php
 * @author Filip Ajdacic <ajdasoft@gmail.com>
 */

class EmailForm extends CFormModel {

	public $email;

	public function rules() {
		return array(
			array('email', 'required'),
			array('email', 'email'),
			array('email', 'length', 'max' =>User::EMAIL_MAX),
			array('email', 'exist', 'className' => 'User'),
		);
	}

	public function attributeLabels() {
		return array(
			'email' => Yii::t('labels', 'Email adresa'),
		);
	}

}
