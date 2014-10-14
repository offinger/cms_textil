<?php
/**
 * fCMS
 * Clear_inactiveCommand.php
 * @author Filip Ajdacic <ajdasoft@gmail.com>
 * @description Brise neaktivne korisnike posle X dana. Ovo treba staviti da se pokrece u Cron Jobs.
 */

class Clear_inactiveCommand extends CConsoleCommand {

    public function init() {
        echo "Brisanje neaktivnih korisnika.. \n";
        parent::init();
    }

    public function actionDelete($days='1'){

                             $criteria = new CDbCriteria;
                             $criteria->condition = 'DATE_SUB(CURDATE(),INTERVAL '. $days.'  DAY) >= create_time AND status=:status';
                             $criteria->params = array(':status' => User::STATUS_INACTIVE);
                              $users = User::model()->findAll($criteria);
                              $result=array();
                              foreach ($users as $user) $result[]=$user->attributes;
                              print_r($result);
                              $users_deleted = User::model()->deleteAll($criteria);
                               echo ($users_deleted .' neaktivnih korisnika obrisano duzih od '.$days. ' dana od registracije.');
    }

}
