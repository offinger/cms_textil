<?php
/**
 * fCMS
 * Kolekcije.php
 * @author Filip Ajdacic <ajdasoft@gmail.com>
 */
class Kolekcije extends CActiveRecord {

	public function tableName() {
		return 'kolekcije';
	}

	public function rules() {
		return array(
			array('foto', 'ext.DstImageField.DstImageValidator'),
			array('ime, foto, status', 'required'),
			array('status, views', 'numerical', 'integerOnly'=>true),
			array('ime, foto', 'length', 'max'=>255),
			array('id, ime, foto, status, views', 'safe', 'on'=>'search'),
		);
	}

	public function getStatusOptions() {
		return array("1" => 'Aktivan', '0' => 'Nije aktivan');
	}

	protected function saveFormPostprocess($data) {
		Yii::import('ext.DstImageField.DstImageField');
        $state = Yii::app()->request->getPost(DstImageField::getStateHiddenFieldName('foto'));
        if($state == DstImageField::STATE_CHOSEN) {
            $image_path = CUploadedFile::getInstanceByName(DstImageField::getFileFieldName('foto'));
            $image_path->saveAs('/home/tgroupco/public_html/clientpub/images/content-kolekcije/' . $image_path, false);
            $image = Yii::app()->image->load('/home/tgroupco/public_html/clientpub/images/content-kolekcije/' . $image_path);
            $image->resize(532, 324)->quality(80);
            $image->save();  
        }
    }

    protected function beforeDelete() {
        $this->deleteImageFiles();
        return true;
    }
    
    protected function deleteImageFiles() {
        unlink('/home/tgroupco/public_html/clientpub/images/content-kolekcije/'. $this->foto);
        /*
        $gelleryImages = $this->galerija;
        foreach ($gelleryImages as $img) {
            unlink(getenv('/Applications/MAMP/htdocs/private/tgroup/clientpub/images/content-kolekcije/'. $img->foto);
        }
        */
    }

	public function relations() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'ime' => 'Ime kolekcije',
			'foto' => 'Fotografija',
			'status' => 'Status',
			'views' => 'Broj pregleda',
		);
	}

	public function search() {
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('ime',$this->ime,true);
		$criteria->compare('foto',$this->foto,true);
		$criteria->compare('status',$this->status);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}
