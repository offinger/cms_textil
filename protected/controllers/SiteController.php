<?php
/**
 * fCMS
 * SiteController.php
 * @author Filip Ajdacic <ajdasoft@gmail.com>
 */

class SiteController extends Controller {


    public function actions() {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function actionIndex() {
        if(Yii::app()->user->isGuest) {
        $this->redirect('site/login');
        } else {

        $brojBrendova = Brendovi::model()->count();
        $brojModela = Modeli::model()->count();
        $brojKolekcija = Kolekcije::model()->count();
        $brojProizvoda = Proizvodi::model()->count();

        $this->render('index_'.app()->layout, array(
                                                    'brojBrendova' => $brojBrendova, 
                                                    'brojModela' => $brojModela, 
                                                    'brojKolekcija' => $brojKolekcija,
                                                    'brojProizvoda' => $brojProizvoda,
        ));

        }
    }

    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

   
    public function actionRegistracija() {
        $model = new RegisterForm();

        if (isset($_POST['ajax']) && $_POST['ajax'] === 'register-form') {
            echo CActiveForm::validate($model, array('username', 'password','new_password', 'password_confirm','verify_code'));
            Yii::app()->end();
        }

        if (isset($_POST['RegisterForm'])) {
            $model->attributes = $_POST['RegisterForm'];
            if ($model->validate(array('email', 'username', 'new_password', 'password_confirm','verify_code'))) {
                $user = new User();
                $user->email = $_POST['RegisterForm']['email'];
                $user->username = $_POST['RegisterForm']['username'];
                $user->password = $_POST['RegisterForm']['new_password'];

                if ($user->save()) {
                    //slanje email-a     aktivacioni kljuc je generisan u  beforeValidate funkciji u User klasi
                    $activation_url = $this->createAbsoluteUrl('/site/activate', array('key' => $user->activation_key, 'email' => $user->email));

                    if (sendHtmlEmail(
                        $user->email,
                        Yii::app()->name . ' Administrator',
                        null,
                        Yii::t('register', 'Aktivacija naloga'),
                        array('username' => $user->username, 'activation_url' => $activation_url),
                        'activation',
                        'main2'
                    )
                    ) {
                        $msg = Yii::t('register', 'Proverite Vas email na koji Vam je poslat aktivacioni link. Aktivacioni link je validan 24h.');
                        Yii::app()->user->setFlash('success', $msg);
                        $this->redirect(bu() . '/site/login');
                    } else {
                        $user->delete();
                        $msg = Yii::t('register', 'Greska. E-mail sa aktivacionim linkom nije poslat. Pokusajte ponovo.');
                        Yii::app()->user->setFlash('danger', $msg);
                        $this->redirect(bu() . '/site/registracija');
                    }
                }
            }
        }
        $this->render('register', array('model' => $model));
    }

    public function actionEmail_for_reset() {

        if (isset($_POST['EmailForm'])) {
            $user_email = $_POST['EmailForm']['email'];
            $criteria = new CDbCriteria;
            $criteria->condition = 'email=:email';
            $criteria->params = array(':email' => $user_email);
            $user = User::model()->find($criteria);
            if (!$user) {
                $errormsg = Yii::t('passwordreset', 'Korisnik sa datom e-mail adresom ne postoji.');
                Yii::app()->user->setFlash('danger', $errormsg);
                $this->refresh();
            }
            $key = $user->generate_activation_key();
            $user->reset_token = $key;
            $reset_url = $this->createAbsoluteUrl('/site/password_reset', array('key' => $key, 'email' => $user_email));
            $user->save();

            if (sendHtmlEmail(
                $user->email,
                Yii::app()->name . ' Administrator',
                null,
                Yii::t('reset', 'Resetovanje lozinke'),
                array('username' => $user->username, 'reset_url' => $reset_url),
                'pwd_reset',
                'main'
            )
            ) {
                $infomsg = Yii::t('passwordreset', 'Na Vas email je poslat link za reset lozinke.');
                Yii::app()->user->setFlash('info', $infomsg);
                $this->refresh();
            } else {
                $errormsg = Yii::t('passwordreset', 'Greska. Email sa linkom za reset lozinke nije poslat. Pokusajte ponovo.');
                Yii::app()->user->setFlash('danger', $errormsg);
                $this->refresh();
            }
        }
        $model = new EmailForm;
        $this->render('email_for_reset', array('model' => $model));
    }

    public function actionPassword_reset($key, $email) {

        if (isset($_POST['PasswordResetForm'])) {
            $new_password = $_POST['PasswordResetForm']['password'];
            $key = $_POST['PasswordResetForm']['key'];
            $email = $_POST['PasswordResetForm']['email'];


            $criteria = new CDbCriteria;
            $criteria->condition = 'reset_token=:reset_token AND email=:email';
            $criteria->params = array(':reset_token' => $key, ':email' => $email);
            $user = User::model()->find($criteria);

            if (!$user) {
                $errormsg = Yii::t('passwordreset', 'Greska. Informacije o Vasem nalogu nisu pronadjene.
                Vas kljuc za reset lozinke je iskoriscen ili je istekao.Molimo Vas da ponovite proceduru resetovanja lozinke.');
                Yii::app()->user->setFlash('danger', $errormsg);
                $this->refresh();
            }
            $user->password = $new_password;
            $user->reset_token = NULL;

            if ($user->save()) {
                $msg = Yii::t('passwordreset', 'Vasa lozinka je resetovana.Sada se mozete prijaviti sa Vasom novom lozinkom.');
                Yii::app()->user->setFlash('success', $msg);
                $this->redirect(bu() . '/site/login');
            } else {
                $error = Yii::t('passwordreset', 'Greska. Ne mogu resetovati lozinku. Pokusajte ponovo.');
                Yii::app()->user->setFlash('danger', $error);
                $this->refresh();
            }
        }
        $model = new PasswordResetForm;
        $this->render('password_reset', array('model' => $model, 'key' => $key, 'email' => $email));
    }


    public function actionActivate($key, $email) {
        $criteria = new CDbCriteria;
        $criteria->condition = 'activation_key=:activation_key AND email=:email';
        $criteria->params = array(':activation_key' => $key, ':email' => $email);
        $user = User::model()->find($criteria);
        if ($user) {
            $user->activation_key = NULL;
            $user->status = User::STATUS_ACTIVE;
            $user->save(false); //korisnik je u ovom slucaju vec validiran zato je validacija iskljcena..
            $successmsg = Yii::t('registration', ',dobrodosao! Vas nalog je sada aktiviran.');
            Yii::app()->user->setFlash('success', $user->username . $successmsg);
            $this->redirect(bu() . '/site/login');
        } else {
            $errormsg = Yii::t('registration', ' Greska. Vas nalog nemoze biti aktiviran. Pokusajte ponovo sa registracijom.');
            $criteria = new CDbCriteria;
            $criteria->condition = ' email=:email';
            $criteria->params = array(':email' => $email);
            $user = User::model()->find($criteria);
            $user->delete();
            Yii::app()->user->setFlash('danger', $errormsg);
            $this->redirect(bu() . '/site/register');
        }
    }


    public function actionLogin() {
        $model = new LoginForm();
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model, array('username', 'password', 'verify_code'));
            Yii::app()->end();
        }

        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];
            if ($model->validate(array('username', 'password', 'verify_code')) && $model->login()) {
                Yii::app()->user->setFlash('success', 'Dobrodošao nazad,  ' . app()->user->name);
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        $this->render('login', array('model' => $model));
    }

    public function actionLogout() {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }


    public function actionGmail() {
            $mailer = Yii::createComponent('application.extensions.mailer.EMailer');
            if (APP_DEPLOYED) {
                $mailer->Host = 'smtp.gmail.com';
                $mailer->IsSMTP();
                $mailer->SMTPAuth = true;
                $mailer->SMTPSecure = 'tls';
                $mailer->Port = '587';
                $mailer->Username =app()->params['myEmail'];
                $mailer->Password =  app()->params['gmail_password'];
            }

            $mailer->From = app()->params['fromEmail'];
            $mailer->AddReplyTo( app()->params['replyEmail']);
            $mailer->AddAddress(app()->params['myEmail']);
            $mailer->FromName = 'Testiranje - GMAIL';

            $mailer->CharSet = 'UTF-8';
            $mailer->Subject = Yii::t('demo', 'Fercera');
            $message = 'Radi!';
            $mailer->Body = $message;
            $mailer->SMTPDebug = true;
            fb($mailer, "mailer OBJECT");
            $mailer->Send();
        }

}