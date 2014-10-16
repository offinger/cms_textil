<?php
/**
 * fCMS
 * ModeliController.php
 * @author Filip Ajdacic <ajdasoft@gmail.com>
 */

class ModeliController extends BaseFCMSController {

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
				'actions'=>array('create','update', 'obrisiDimenziju'),
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
		$model=new Modeli;
		$modelDimenzije = new Dimenzije;
		
		// $this->performAjaxValidation($model);
		if (isset($_POST['Modeli'], $_POST['Dimenzije'])) {
			$model->attributes=$_POST['Modeli'];
			$model->proizvod_id = $_POST['Modeli']['proizvod_id'];
			
			if ($model->save()) {
			$model->slug = $this->slugGenerate($model->ime);


				Yii::import('ext.DstImageField.DstImageField');
                		$state = Yii::app()->request->getPost(DstImageField::getStateHiddenFieldName('foto'));
                		$state_1 = Yii::app()->request->getPost(DstImageField::getStateHiddenFieldName('foto_banner'));
	                if($state == DstImageField::STATE_CHOSEN) {
	                    $image_temp = CUploadedFile::getInstanceByName(DstImageField::getFileFieldName('foto'));
	                    $new_image_ext = pathinfo($image_temp, PATHINFO_EXTENSION);
	
	                    $new_image_subpath = uniqid(rand (),true) . '.' . $new_image_ext;
	                    $new_image_subpath = substr($new_image_subpath, 0, 1) . '/' . substr($new_image_subpath, 1, 1) . '/' . $new_image_subpath;
	                    $new_image_path = '/home/tgroupco/public_html/clientpub/images/content-modeli/' . $new_image_subpath;
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
	                    $image_temp = CUploadedFile::getInstanceByName(DstImageField::getFileFieldName('foto_banner'));
	                    $new_image_ext = pathinfo($image_temp, PATHINFO_EXTENSION);
	
	                    $new_image_subpath = uniqid(rand (),true) . '.' . $new_image_ext;
	                    $new_image_subpath = substr($new_image_subpath, 0, 1) . '/' . substr($new_image_subpath, 1, 1) . '/' . $new_image_subpath;
	                    $new_image_path = '/home/tgroupco/public_html/clientpub/images/content-modeli/' . $new_image_subpath;
	                    if(!file_exists(dirname($new_image_path))) {
	                        mkdir(dirname($new_image_path), 0777, true);
	                    }
	                    $model->foto_banner = $new_image_subpath;
	                    $model->save();
	                    //ne mozemo da pristupimo polju imena fajla u cuploadedfile, tako da koristimo taj model za snimanje, ali drugo ime prosledjujemo
	                    $image_temp->saveAs($new_image_path, false);
	                    $image = Yii::app()->image->load($new_image_path);
	                    if(!$image) {
	                        $model->addError('slika', 'Neispravna ekstenzija');
	                    }
	                    $image->resize(960, 960)->quality(80);
	                    $image->save();
	                    //unlink('/Applications/MAMP/htdocs/private/tgroup/clientpub/images/content-brend/' . $image_temp);
			    // $this->redirect(array('view','id'=>$model->id));
				
			}

				// ===
				$insert_id = Yii::app()->db->getLastInsertID();
				$numOfFieldsInDimensionModel = 2;
				$numOfInterations = count($_POST['Dimenzije']) / $numOfFieldsInDimensionModel;
				for($i = 1; $i <= $numOfInterations; $i++) {
					$modelDimenzije = new Dimenzije;
					if($i == 1) {
						$modelDimenzije->velicina = $_POST['Dimenzije']["velicina_1"];
						$modelDimenzije->cena = $_POST['Dimenzije']["cena_1"];
					} else {
						$modelDimenzije->velicina = $_POST['Dimenzije']["velicina_" . $i];
						$modelDimenzije->cena = $_POST['Dimenzije']["cena_" . $i];
					} 
					$modelDimenzije->model_id = $insert_id;
					$modelDimenzije->save(false);
				}

				Yii::app()->user->setFlash('notification','Uspesno ste kreirali model!');
             	$this->redirect(array('modeli/admin'));
			}
	}

		$this->render('create',array(
			'model'=>$model,
			'modelDimenzije'=>isset($modelDimenzije) ? $modelDimenzije : null,
		));
	}

	public function actionUpdate($id) {

		$model=$this->loadModel($id);

		$Criteria = new CDbCriteria();
		$Criteria->condition = "model_id = $id";
		$modelDimenzijeUpdate = Dimenzije::model()->findAll($Criteria);
		// $this->performAjaxValidation($model);
		if (isset($_POST['Modeli'])) {


			$model->attributes=$_POST['Modeli'];
			$model->proizvod_id = $_POST['Modeli']['proizvod_id'];
			if ($model->save()) {
			$model->slug = $this->slugGenerate($model->ime);

				Yii::import('ext.DstImageField.DstImageField');
                		$state = Yii::app()->request->getPost(DstImageField::getStateHiddenFieldName('foto'));
                		$state_1 = Yii::app()->request->getPost(DstImageField::getStateHiddenFieldName('foto_banner'));
	                if($state == DstImageField::STATE_CHOSEN) {
	                    $image_temp = CUploadedFile::getInstanceByName(DstImageField::getFileFieldName('foto'));
	                    $new_image_ext = pathinfo($image_temp, PATHINFO_EXTENSION);
	
	                    $new_image_subpath = uniqid(rand (),true) . '.' . $new_image_ext;
	                    $new_image_subpath = substr($new_image_subpath, 0, 1) . '/' . substr($new_image_subpath, 1, 1) . '/' . $new_image_subpath;
	                    $new_image_path = '/home/tgroupco/public_html/clientpub/images/content-modeli/' . $new_image_subpath;
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
	                    $image_temp = CUploadedFile::getInstanceByName(DstImageField::getFileFieldName('foto_banner'));
	                    $new_image_ext = pathinfo($image_temp, PATHINFO_EXTENSION);
	
	                    $new_image_subpath = uniqid(rand (),true) . '.' . $new_image_ext;
	                    $new_image_subpath = substr($new_image_subpath, 0, 1) . '/' . substr($new_image_subpath, 1, 1) . '/' . $new_image_subpath;
	                    $new_image_path = '/home/tgroupco/public_html/clientpub/images/content-modeli/' . $new_image_subpath;
	                    if(!file_exists(dirname($new_image_path))) {
	                        mkdir(dirname($new_image_path), 0777, true);
	                    }
	                    $model->foto_banner = $new_image_subpath;
	                    $model->save();
	                    //ne mozemo da pristupimo polju imena fajla u cuploadedfile, tako da koristimo taj model za snimanje, ali drugo ime prosledjujemo
	                    $image_temp->saveAs($new_image_path, false);
	                    $image = Yii::app()->image->load($new_image_path);
	                    if(!$image) {
	                        $model->addError('slika', 'Neispravna ekstenzija');
	                    }
	                    $image->resize(960, 960)->quality(80);
	                    $image->save();
	                    //unlink('/Applications/MAMP/htdocs/private/tgroup/clientpub/images/content-brend/' . $image_temp);
			    // $this->redirect(array('view','id'=>$model->id));
				
			}

				Yii::app()->user->setFlash('notification','Uspesno ste osvezili model!');
             	$this->redirect(array('modeli/admin'));
		}

		}

		$this->render('update',array(
			'model'=>$model, 'modelDimenzijeUpdate'=>$modelDimenzijeUpdate
		));
	}

	public function actionObrisiDimenziju(){
		$dimenzija = $_GET['dimenzija'];
		$id = $_GET['id'];

		$criteria = new CDbCriteria( array(
		    'condition' => "velicina LIKE :dimenzija AND model_id = $id",
		    'params'    => array(':dimenzija' => "%$dimenzija%")
		) );
		 
		Dimenzije::model()->deleteAll($criteria);
		

	}


	public function actionDelete($id) {
		if (Yii::app()->request->isPostRequest) {
			$this->loadModel($id)->delete();

			/*Brisanje svih velicina vezanih za ovaj model*/
			$Criteria = new CDbCriteria();
			$Criteria->condition = "model_id = $id";
			$modeli = Dimenzije::model()->findAll($Criteria);
			foreach ($modeli as $model) {
				$model->delete();
			}
			/*Kraj*/

			if (!isset($_GET['ajax'])) {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
		} else {
			throw new CHttpException(400,'Pogresan zahtev.');
		}
	}

	public function actionIndex() {
		$dataProvider=new CActiveDataProvider('Modeli');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin() {
		$model=new Modeli('search');
		$model->unsetAttributes(); 
		if (isset($_GET['Modeli'])) {
			$model->attributes=$_GET['Modeli'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel($id) {
		$model=Modeli::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'Zatraženi model nije pronađena.');
		}
		return $model;
	}

	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax']==='modeli-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}