<?php
/**
 * fCMS
 * Modeli.php
 * @author Filip Ajdacic <ajdasoft@gmail.com>
 */
class Modeli extends CActiveRecord{

	public function tableName() {
		return 'modeli';
	}

	public function rules() {
		return array(
			array('foto', 'ext.DstImageField.DstImageValidator'),
			array('sifra, brend_id, foto, kategorija, kolekcija_id, status', 'required'),
			array('kolekcija_id, status, cena, views', 'numerical', 'integerOnly'=>true),
			array('ime, sifra, mehanizam, velicina_kucista, foto, kategorija', 'length', 'max'=>255),
			array('brend_id', 'length', 'max'=>11),
			array('id, ime, sifra, brend_id, foto, kategorija, kolekcija_id, status, views', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'brend' => array(self::BELONGS_TO, 'Brendovi', 'brend_id'),
			'kolekcija' => array(self::BELONGS_TO, 'Kolekcije', 'kolekcija_id'),

		);
	}

	public function getStatusOptions() {
		return array("1" => 'Aktivan', '0' => 'Nije aktivan');
	}

	public function getKategorijaOptions() {
		return array("1" => 'Za muškarce', '0' => 'Za žene');
	}


	public function getBrendOptions() {
		$brends = Brendovi::model()->findAll();
		$brendovi = array();
		foreach($brends as $brend) {
			$brendovi[$brend->id] = $brend->naziv;
		}
		return $brendovi;
	}

	public function getKolekcijaOptions() {
		$collections = Kolekcije::model()->findAll();
		$kolekcije = array();
		foreach($collections as $collection) {
			$kolekcije[$collection->id] = $collection->ime;
		}
		return $kolekcije;
	}
	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'sifra' => 'Šifra modela',
			'brend_id' => 'Brend',
			'foto' => 'Fotografija',
			'kategorija' => 'Kategorija',
			'kolekcija_id' => 'Kolekcija',
			'cena' => 'Cena',
			'velicina_kucista' => 'Veličina kućišta',
			'mehanizam' => 'Mehanizam',
			'status' => 'Status',
			'views' => 'Broj pregleda',
		);
	}

	protected function saveFormPostprocess($data) {
		Yii::import('ext.DstImageField.DstImageField');
        $state = Yii::app()->request->getPost(DstImageField::getStateHiddenFieldName('foto'));
        if($state == DstImageField::STATE_CHOSEN) {
            $image_path = CUploadedFile::getInstanceByName(DstImageField::getFileFieldName('foto'));
            $image_path->saveAs('/Applications/MAMP/htdocs/private/tgroup/clientpub/images/content-model/' . $image_path, false);
            $image = Yii::app()->image->load('/Applications/MAMP/htdocs/private/tgroup/clientpub/images/content-model/' . $image_path);
            $image->resize(532, 324)->quality(80);
            $image->save();  
        }
    }

    protected function beforeDelete() {
        $this->deleteImageFiles();
        return true;
    }
    
    protected function deleteImageFiles() {   
        $fileNameToDelete = '/home/tgroupco/public_html/clientpub/images/content-model/'.$this->foto;
        if(file_exists($fileNameToDelete)) {
        unlink('/home/tgroupco/public_html/clientpub/images/content-model/'. $this->foto);
        return true;
        } else {
        return true;
        }
        
       /*
        $gelleryImages = $this->galerija;
        foreach ($gelleryImages as $img) {
            unlink(getenv('/Applications/MAMP/htdocs/private/tgroup/clientpub/images/content-model/'. $img->foto);
        }
        */
    }

	public function search() {
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id);
		$criteria->compare('ime',$this->ime,true);
		$criteria->compare('sifra',$this->sifra,true);
		$criteria->compare('brend_id',$this->brend_id,true);
		$criteria->compare('foto',$this->foto,true);
		$criteria->compare('kategorija',$this->kategorija,true);
		$criteria->compare('kolekcija_id',$this->kolekcija_id);
		$criteria->compare('cena', $this->cena, true);
		$criteria->compare('status',$this->status);
		$criteria->compare('views',$this->views);
		return new CActiveDataProvider($this, array(
        			'pagination' => array(
             						'pageSize' => 40,
        	),
        	'criteria'=>$criteria,
		));
	}

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}