<?php
/**
 * fCMS
 * BrendoviController.php
 * @author Filip Ajdacic <ajdasoft@gmail.com>
 */
class BrendoviController extends BaseFCMSController {

	public function filters() {
		return array(
			'accessControl',
			'postOnly + delete',
		);
	}

	public function accessRules() {
		return array(
			array('allow',  
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', 
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	} 				

	public function actionView($id) {
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionCreate() {
		$model=new Brendovi;
		// $this->performAjaxValidation($model);
		if (isset($_POST['Brendovi'])) {
			$model->attributes=$_POST['Brendovi'];
			if ($model->save()) {
				$model->slug = $this->slugGenerate($model->naziv);
				Yii::import('ext.DstImageField.DstImageField');
                		$state = Yii::app()->request->getPost(DstImageField::getStateHiddenFieldName('foto'));
                		$state_1 = Yii::app()->request->getPost(DstImageField::getStateHiddenFieldName('foto_modal'));
	                if($state == DstImageField::STATE_CHOSEN) {
	                    $image_temp = CUploadedFile::getInstanceByName(DstImageField::getFileFieldName('foto'));
	                    $new_image_ext = pathinfo($image_temp, PATHINFO_EXTENSION);
	
	                    $new_image_subpath = uniqid(rand (),true) . '.' . $new_image_ext;
	                    $new_image_subpath = substr($new_image_subpath, 0, 1) . '/' . substr($new_image_subpath, 1, 1) . '/' . $new_image_subpath;
	                    $new_image_path = '/home/tgroupco/public_html/clientpub/images/content-brend/' . $new_image_subpath;
	                    if(!file_exists(dirname($new_image_path))) {
	                        mkdir(dirname($new_image_path), 0777, true);
	                    }
	                    $model->foto = $new_image_subpath;
	                    $model->save();
	                    //ne mozemo da pristupimo polju imena fajla u cuploadedfile, tako da koristimo taj model za snimanje, ali drugo ime prosledjujemo
	                    $image_temp->saveAs($new_image_path, false);
	                    $image = Yii::app()->image->load($new_image_path);
	                    if(!$image) {
	                        $model->addError('slika', 'Neispravna ekstenzija');
	                    }
	                    $image->resize(536, 536)->quality(80);
	                    $image->save();
	                    //unlink('/Applications/MAMP/htdocs/private/tgroup/clientpub/images/content-brend/' . $image_temp);
			    //$this->redirect(array('view','id'=>$model->id));
				
			}
				
			
			////
			 if($state_1 == DstImageField::STATE_CHOSEN) {
	                    $image_temp = CUploadedFile::getInstanceByName(DstImageField::getFileFieldName('foto_modal'));
	                    $new_image_ext = pathinfo($image_temp, PATHINFO_EXTENSION);
	
	                    $new_image_subpath = uniqid(rand (),true) . '.' . $new_image_ext;
	                    $new_image_subpath = substr($new_image_subpath, 0, 1) . '/' . substr($new_image_subpath, 1, 1) . '/' . $new_image_subpath;
	                    $new_image_path = '/home/tgroupco/public_html/clientpub/images/content-brend/' . $new_image_subpath;
	                    if(!file_exists(dirname($new_image_path))) {
	                        mkdir(dirname($new_image_path), 0777, true);
	                    }
	                    $model->foto_modal = $new_image_subpath;
	                    $model->save();
	                    //ne mozemo da pristupimo polju imena fajla u cuploadedfile, tako da koristimo taj model za snimanje, ali drugo ime prosledjujemo
	                    $image_temp->saveAs($new_image_path, false);
	                    $image = Yii::app()->image->load($new_image_path);
	                    if(!$image) {
	                        $model->addError('slika', 'Neispravna ekstenzija');
	                    }
	                    $image->resize(536, 536)->quality(80);
	                    $image->save();
	                    //unlink('/Applications/MAMP/htdocs/private/tgroup/clientpub/images/content-brend/' . $image_temp);
			    $this->redirect(array('view','id'=>$model->id));
				
			}
			
			
			
			/////
				
				
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id) {
		$model=$this->loadModel($id);
		
		// $this->performAjaxValidation($model);
		if (isset($_POST['Brendovi'])) {
			$model->attributes=$_POST['Brendovi'];
			if ($model->save()) {
				$model->slug = $this->slugGenerate($model->naziv);
				Yii::import('ext.DstImageField.DstImageField');
                $state = Yii::app()->request->getPost(DstImageField::getStateHiddenFieldName('foto'));
                $state_1 = Yii::app()->request->getPost(DstImageField::getStateHiddenFieldName('foto_modal'));
	                if($state == DstImageField::STATE_CHOSEN) {
	                    $image_temp = CUploadedFile::getInstanceByName(DstImageField::getFileFieldName('foto'));
	                    $new_image_ext = pathinfo($image_temp, PATHINFO_EXTENSION);
	
	                    $new_image_subpath = uniqid(rand (),true) . '.' . $new_image_ext;
	                    $new_image_subpath = substr($new_image_subpath, 0, 1) . '/' . substr($new_image_subpath, 1, 1) . '/' . $new_image_subpath;
	                    $new_image_path = '/home/tgroupco/public_html/clientpub/images/content-brend/' . $new_image_subpath;
	                    if(!file_exists(dirname($new_image_path))) {
	                        mkdir(dirname($new_image_path), 0777, true);
	                    }
	                    $model->foto = $new_image_subpath;
	                    $model->save();
	                    //ne mozemo da pristupimo polju imena fajla u cuploadedfile, tako da koristimo taj model za snimanje, ali drugo ime prosledjujemo
	                    $image_temp->saveAs($new_image_path, false);
	                    $image = Yii::app()->image->load($new_image_path);
	                    if(!$image) {
	                        $model->addError('slika', 'Neispravna ekstenzija');
	                    }
	                    $image->resize(536, 536)->quality(80);
	                    $image->save();
	                    //unlink('/Applications/MAMP/htdocs/private/tgroup/clientpub/images/content-brend/' . $image_temp);
			    //$this->redirect(array('view','id'=>$model->id));
				
			}
				
			
			////
			 if($state_1 == DstImageField::STATE_CHOSEN) {
	                    $image_temp = CUploadedFile::getInstanceByName(DstImageField::getFileFieldName('foto_modal'));
	                    $new_image_ext = pathinfo($image_temp, PATHINFO_EXTENSION);
	
	                    $new_image_subpath = uniqid(rand (),true) . '.' . $new_image_ext;
	                    $new_image_subpath = substr($new_image_subpath, 0, 1) . '/' . substr($new_image_subpath, 1, 1) . '/' . $new_image_subpath;
	                    $new_image_path = '/home/tgroupco/public_html/clientpub/images/content-brend/' . $new_image_subpath;
	                    if(!file_exists(dirname($new_image_path))) {
	                        mkdir(dirname($new_image_path), 0777, true);
	                    }
	                    $model->foto_modal = $new_image_subpath;
	                    $model->save();
	                    //ne mozemo da pristupimo polju imena fajla u cuploadedfile, tako da koristimo taj model za snimanje, ali drugo ime prosledjujemo
	                    $image_temp->saveAs($new_image_path, false);
	                    $image = Yii::app()->image->load($new_image_path);
	                    if(!$image) {
	                        $model->addError('slika', 'Neispravna ekstenzija');
	                    }
	                    $image->resize(536, 536)->quality(80);
	                    $image->save();
	                    //unlink('/Applications/MAMP/htdocs/private/tgroup/clientpub/images/content-brend/' . $image_temp);
			    //$this->redirect(array('view','id'=>$model->id));
				
			}
		
		
		////	
		
		}

		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	public function actionDelete($id) {
		if (Yii::app()->request->isPostRequest) {
			$this->loadModel($id)->delete();
			if (!isset($_GET['ajax'])) {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
		} else {
			throw new CHttpException(400,'Pogrešan zahtev.');
		}
	}


	public function actionIndex() {
		$dataProvider=new CActiveDataProvider('Brendovi');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin() {
		$model=new Brendovi('search');
		$model->unsetAttributes();
		if (isset($_GET['Brendovi'])) {
			$model->attributes=$_GET['Brendovi'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel($id) {
		$model=Brendovi::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'Zatraženi brend nemože biti pronađen.');
		}
		return $model;
	}

	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax']==='brendovi-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}