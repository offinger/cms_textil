<?php
return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
			/* skini komentar za testiranje konekcije sa bazom
			'db'=>array(
				'connectionString'=>'DSN za test baze',
			),
			*/
		),
	)
);
