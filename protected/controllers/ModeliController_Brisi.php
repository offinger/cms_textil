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




	public function actionView($id) {
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	public function actionGetKolekcije() {
		$brend = $_GET['brend'];
		$model = new Kolekcije;
		$criteria = new CDbCriteria;
		$criteria->condition = "brend_id = :brend_param";
		$criteria->params = array(":brend_param" => $brend);

		$kolekcijeCount = $model->count($criteria);
		if($kolekcijeCount > 0) {
			$kolekcije = $model->findAll($criteria);
			echo "
			<br><b>Kolekcija:<b><br>
			<select name='Modeli[kolekcija_id]' id='Modeli_kolekcija_id'>";
			foreach($kolekcije as $kolekcija) {
				echo "<option value='".$kolekcija->id."'> ".$kolekcija->ime."</option>";
			}
			echo "</select>";
		}
	}

	public function actionCreate() {
		$model=new Modeli;
		// $this->performAjaxValidation($model);
		if (isset($_POST['Modeli'])) {
			$model->attributes=$_POST['Modeli'];
			$model->mehanizam = $_POST['Modeli']['mehanizam'];
			$model->velicina_kucista = $_POST['Modeli']['velicina_kucista'];
			if ($model->save()) {
				$model->slug = $this->slugGenerate($model->ime);
				 Yii::import('ext.DstImageField.DstImageField');
                $state = Yii::app()->request->getPost(DstImageField::getStateHiddenFieldName('foto'));
                if($state == DstImageField::STATE_CHOSEN) {
                    $image_temp = CUploadedFile::getInstanceByName(DstImageField::getFileFieldName('foto'));
                    $new_image_ext = pathinfo($image_temp, PATHINFO_EXTENSION);

                    $new_image_subpath = uniqid(rand (),true) . '.' . $new_image_ext;
                    $new_image_subpath = substr($new_image_subpath, 0, 1) . '/' . substr($new_image_subpath, 1, 1) . '/' . $new_image_subpath;
                    $new_image_path = '/home/tgroupco/public_html/clientpub/images/content-model/' . $new_image_subpath;
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
                    //unlink('/home/tgroupco/public_html/clientpub/images/content-model/' . $image_temp);
				$this->redirect(array('view','id'=>$model->id));
			}
		}
	}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id) {
		$model=$this->loadModel($id);
		// $this->performAjaxValidation($model);
		if (isset($_POST['Modeli'])) {
			$model->attributes=$_POST['Modeli'];
			$model->mehanizam = $_POST['Modeli']['mehanizam'];
			$model->velicina_kucista = $_POST['Modeli']['velicina_kucista'];
			if ($model->save()) {
				$model->slug = $this->slugGenerate($model->ime);
				Yii::import('ext.DstImageField.DstImageField');
                $state = Yii::app()->request->getPost(DstImageField::getStateHiddenFieldName('foto'));
                if($state == DstImageField::STATE_CHOSEN) {
                    $image_temp = CUploadedFile::getInstanceByName(DstImageField::getFileFieldName('foto'));
                    $new_image_ext = pathinfo($image_temp, PATHINFO_EXTENSION);

                    $new_image_subpath = uniqid(rand (),true) . '.' . $new_image_ext;
                    $new_image_subpath = substr($new_image_subpath, 0, 1) . '/' . substr($new_image_subpath, 1, 1) . '/' . $new_image_subpath;
                    $new_image_path = '/home/tgroupco/public_html/clientpub/images/content-model/' . $new_image_subpath;
                    if(!file_exists(dirname($new_image_path))) {
                        mkdir(dirname($new_image_path), 0777, true);
                    }
                    $model->foto = $new_image_subpath;
                    $model->save();
                    //ne mozemo da pristupimo polju imena fajla u cuploadedfile, tako da koristimo taj model za snimanje, ali drugo ime prosledjujemo
                    $image_temp->saveAs($new_image_path, false);
                    $image = Yii::app()->image->load($new_image_path);
                    if(!$image) {
                        $model->addError('foto', 'Neispravna ekstenzija');
                    }
                    $image->resize(536, 536)->quality(80);
                    $image->save();
                    //unlink('/Applications/MAMP/htdocs/private/tgroup/clientpub/images/content-model/' . $image_temp);
				$this->redirect(array('view','id'=>$model->id));
			}
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
			throw new CHttpException(404,'Zatraženi model ne postoji u bazi podataka.');
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