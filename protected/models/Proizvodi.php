<?php
/**
 * fCMS
 * Proizvodi.php
 * @author Filip Ajdacic <ajdasoft@gmail.com>
 */
class Proizvodi extends CActiveRecord {

	public function tableName() {
		return 'proizvodi';
	}

	public function rules() {
		return array(
			//array('foto', 'ext.DstImageField.DstImageValidator'),
			//array('foto_modal', 'ext.DstImageField.DstImageValidator'),

			array('naziv, status', 'required'),
			array('status, views', 'numerical', 'integerOnly'=>true),
			array('naziv, foto, alt', 'length', 'max'=>255),
			array('opis', 'length', 'max'=>2000),
			array('id, naziv, opis, foto, alt, status, views', 'safe', 'on'=>'search'),
		);
	}

	public function getStatusOptions() {
		return array("1" => 'Aktivan', '0' => 'Nije aktivan');
	}

	public function relations() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'naziv' => 'Naziv proizvoda',
			'opis' => 'Opis proizvoda',
			'foto' => 'Fotografija/Logo',
			'alt' => 'Alternativni naziv',
			'status' => 'Status',
			'views' => 'Broj pregleda',
		);
	}

	protected function saveFormPostprocess($data) {
		Yii::import('ext.DstImageField.DstImageField');
        $state = Yii::app()->request->getPost(DstImageField::getStateHiddenFieldName('foto'));
        if($state == DstImageField::STATE_CHOSEN) {
            $image_path = CUploadedFile::getInstanceByName(DstImageField::getFileFieldName('foto'));
            $image_path->saveAs('/home/tgroupco/public_html/clientpub/images/content-proizvod/' . $image_path, false);
            $image = Yii::app()->image->load('/home/tgroupco/public_html/clientpub/images/content-proizvod/' . $image_path);
            $image->resize(532, 324)->quality(80);
            $image->save();  
        }

        $state_1 = Yii::app()->request->getPost(DstImageField::getStateHiddenFieldName('foto_modal'));
        if($state_1 == DstImageField::STATE_CHOSEN) {
            $image_path_1 = CUploadedFile::getInstanceByName(DstImageField::getFileFieldName('foto_modal'));
            $image_path_1->saveAs('/home/tgroupco/public_html/clientpub/images/content-proizvod/' . $image_path_1, false);
            $image_1 = Yii::app()->image->load('/home/tgroupco/public_html/clientpub/images/content-proizvod/' . $image_path_1);
            $image_1->resize(532, 324)->quality(80);
            $image_1->save();  
        }
    }

    protected function beforeDelete() {
        $this->deleteImageFiles();
        return true;
    }
    
    protected function deleteImageFiles() {
    
    	$fileNameToDelete = '/home/tgroupco/public_html/clientpub/images/content-proizvod/'.$this->foto;
        if(file_exists($fileNameToDelete)) {
        unlink('/home/tgroupco/public_html/clientpub/images/content-proizvod/'. $this->foto);
        return true;
        } else {
        return true;
        }
    
        /*
        $gelleryImages = $this->galerija;
        foreach ($gelleryImages as $img) {
            unlink(getenv('/Applications/MAMP/htdocs/private/tgroup/clientpub/images/content-proizvod/'. $img->foto);
        }
        */
    }

	public function search() {
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('naziv',$this->naziv,true);
		$criteria->compare('opis',$this->opis,true);
		$criteria->compare('foto',$this->foto,true);
		$criteria->compare('alt',$this->alt,true);
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