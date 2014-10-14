<?php
/**
 * fCMS
 * Modeli.php
 * @author Filip Ajdacic <ajdasoft@gmail.com>
 */
class Modeli extends CActiveRecord {

	public function tableName() {
		return 'modeli';
	}

	public function rules() {
		return array(
			array('foto', 'ext.DstImageField.DstImageValidator'),
			array('foto_banner', 'ext.DstImageField.DstImageValidator'),
			array('ime, status, proizvod_id', 'required', 'on' => 'create'),
			array('status, views', 'numerical', 'integerOnly'=>true),
			array('ime, foto', 'length', 'max'=>255),
			array('id, ime, foto, status, proizvod_id, views', 'safe', 'on'=>'search'),
		);
	}

	public function getStatusOptions() {
		return array("1" => 'Aktivan', '0' => 'Nije aktivan');
	}

	public function getProizvodiOptions() {
		$proizvods = Proizvodi::model()->findAll();
		$proizvodi = array();
		foreach($proizvods as $proizvod) {
			$proizvodi[$proizvod->id] = $proizvod->naziv;
		}
		return $proizvodi;
	}

	protected function saveFormPostprocess($data) {
		Yii::import('ext.DstImageField.DstImageField');
        $state = Yii::app()->request->getPost(DstImageField::getStateHiddenFieldName('foto'));
        if($state == DstImageField::STATE_CHOSEN) {
            $image_path = CUploadedFile::getInstanceByName(DstImageField::getFileFieldName('foto'));
            $image_path->saveAs('/home/tgroupco/public_html/clientpub/images/content-modeli/' . $image_path, false);
            $image = Yii::app()->image->load('/home/tgroupco/public_html/clientpub/images/content-modeli/' . $image_path);
            $image->resize(532, 324)->quality(80);
            $image->save();  
        }

        $state_1 = Yii::app()->request->getPost(DstImageField::getStateHiddenFieldName('foto_banner'));
        if($state == DstImageField::STATE_CHOSEN) {
            $image_path_1 = CUploadedFile::getInstanceByName(DstImageField::getFileFieldName('foto_banner'));
            $image_path_1->saveAs('/home/tgroupco/public_html/clientpub/images/content-modeli/' . $image_path_1, false);
            $image_1 = Yii::app()->image->load('/home/tgroupco/public_html/clientpub/images/content-modeli/' . $image_path_1);
            $image_1->resize(960, 400)->quality(80);
            $image_1->save();  
        }
    }

    protected function beforeDelete() {
        $this->deleteImageFiles();
        return true;
    }
    
    protected function deleteImageFiles() {
    	$fileNameToDelete = '/home/tgroupco/public_html/clientpub/images/content-modeli/'.$this->foto;
        if(file_exists($fileNameToDelete)) {
        unlink('/home/tgroupco/public_html/clientpub/images/content-modeli/'. $this->foto);
        return true;
        } else {
        return true;
        }
        /*
        $gelleryImages = $this->galerija;
        foreach ($gelleryImages as $img) {
            unlink(getenv('/Applications/MAMP/htdocs/private/tgroup/clientpub/images/content-modeli/'. $img->foto);
        }
        */
    }

	public function relations() {
		return array(
		'proizvod' => array(self::BELONGS_TO, 'Proizvodi', 'proizvod_id'),

		);
	}

	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'ime' => 'Ime modela',
			'foto' => 'Fotografija',
			'status' => 'Status',
			'views' => 'Broj pregleda',
			'proizvod_id' => 'Proizvod'
		);
	}

	public function search() {
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('ime',$this->ime,true);
		$criteria->compare('foto',$this->foto,true);
		$criteria->compare('proizvod_id', $this->proizvod_id, true);
		$criteria->compare('status',$this->status);
		return new CActiveDataProvider($this, array(
        			'pagination' => array(
             						'pageSize' => 20,
        	),
        	'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}