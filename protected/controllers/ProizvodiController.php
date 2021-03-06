<?php
/**
 * fCMS
 * ProizvodiController.php
 * @author Filip Ajdacic <ajdasoft@gmail.com>
 */
class ProizvodiController extends BaseFCMSController {

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
		$model=new Proizvodi;
		// $this->performAjaxValidation($model);
		if (isset($_POST['Proizvodi'])) {
			$model->attributes=$_POST['Proizvodi'];
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
	                    $new_image_path = '../cms/clientpub/cms/images/proizvodi/' . $new_image_subpath;
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
	                    //unlink('/Applications/MAMP/htdocs/private/tgroup/clientpub/images/content-proizvod/' . $image_temp);
			    //$this->redirect(array('view','id'=>$model->id));
				
			}
				
			
			////
			 if($state_1 == DstImageField::STATE_CHOSEN) {
	                    $image_temp = CUploadedFile::getInstanceByName(DstImageField::getFileFieldName('foto_modal'));
	                    $new_image_ext = pathinfo($image_temp, PATHINFO_EXTENSION);
	
	                    $new_image_subpath = uniqid(rand (),true) . '.' . $new_image_ext;
	                    $new_image_subpath = substr($new_image_subpath, 0, 1) . '/' . substr($new_image_subpath, 1, 1) . '/' . $new_image_subpath;
	                    $new_image_path = '../cms/clientpub/cms/images/proizvodi/' . $new_image_subpath;
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
	                    //unlink('/Applications/MAMP/htdocs/private/tgroup/clientpub/images/content-proizvod/' . $image_temp);
			    $this->redirect(array('view','id'=>$model->id));
				
			}
				Yii::app()->user->setFlash('notification','Uspesno ste kreirali novi proizvod!');
             	$this->redirect(array('proizvodi/admin'));	
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id) {
		$model=$this->loadModel($id);
		
		// $this->performAjaxValidation($model);
		if (isset($_POST['Proizvodi'])) {
			$model->attributes=$_POST['Proizvodi'];
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
	                    $new_image_path = '../cms/clientpub/cms/images/proizvodi/' . $new_image_subpath;
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
	                    //unlink('/Applications/MAMP/htdocs/private/tgroup/clientpub/images/content-proizvod/' . $image_temp);
			    //$this->redirect(array('view','id'=>$model->id));
				
			}
				
			
			////
			 if($state_1 == DstImageField::STATE_CHOSEN) {
	                    $image_temp = CUploadedFile::getInstanceByName(DstImageField::getFileFieldName('foto_modal'));
	                    $new_image_ext = pathinfo($image_temp, PATHINFO_EXTENSION);
	
	                    $new_image_subpath = uniqid(rand (),true) . '.' . $new_image_ext;
	                    $new_image_subpath = substr($new_image_subpath, 0, 1) . '/' . substr($new_image_subpath, 1, 1) . '/' . $new_image_subpath;
	                    $new_image_path = '../cms/clientpub/cms/images/proizvodi/' . $new_image_subpath;
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
	                    //unlink('/Applications/MAMP/htdocs/private/tgroup/clientpub/images/content-proizvod/' . $image_temp);
			    //$this->redirect(array('view','id'=>$model->id));
				
			}
		
		
		////	
		    // 
		     Yii::app()->user->setFlash('notification','Uspesno ste osvezili proizvod!');
             $this->redirect(array('proizvodi/admin'));
		}

		}

			

		$this->render('update',array(
			'model'=>$model,
		));
	}
	public function actionDelete($id) {
		if (Yii::app()->request->isPostRequest) {
			$this->loadModel($id)->delete();

			/*Brisanje svih velicina vezanih za ovaj model*/
			$Criteria = new CDbCriteria();
			$Criteria->condition = "proizvod_id = $id";
			$modeli = Modeli::model()->findAll($Criteria);
			foreach ($modeli as $model) {
				// brisanje velicina za sve modele ovog proizvoda iz tabele dimenzije
				$Criteria = new CDbCriteria();
				$Criteria->condition = "model_id = $model->id";
				$modeliDimenzije = dimenzije::model()->findAll($Criteria);
				foreach ($modeliDimenzije as $modelDimenzije) {
					$modelDimenzije->delete();
				}
				// kraj
			$model->delete();
			}
			/*Kraj*/

			if (!isset($_GET['ajax'])) {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
		} else {
			throw new CHttpException(400,'Pogrešan zahtev.');
		}
	}


	public function actionIndex() {
		$dataProvider=new CActiveDataProvider('Proizvodi');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin() {
		$model=new Proizvodi('search');
		$model->unsetAttributes();
		if (isset($_GET['Proizvodi'])) {
			$model->attributes=$_GET['Proizvodi'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel($id) {
		$model=Proizvodi::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'Zatraženi proizvod nemože biti pronađen.');
		}
		return $model;
	}

	protected function performAjaxValidation($model) {
		if (isset($_POST['ajax']) && $_POST['ajax']==='proizvodi-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}