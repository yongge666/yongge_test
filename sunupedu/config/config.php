<?php
return array(
	'logs'=>array(
		'path'=>'logs/log',
		'type'=>'file'
	),
	'DB'=>array(
		'type'=>'mysqli',
        'tablePre'=>'sunup_',
		'read'=>array(
			array('host'=>'localhost:3306','user'=>'root','passwd'=>'spsqlmima','name'=>'sunupedu_shop'),
		),

		'write'=>array(
			'host'=>'localhost:3306','user'=>'root','passwd'=>'root','name'=>'sunupedu_shop',
		),
	),
	'interceptor' => array('themeroute@onCreateController','layoutroute@onCreateView','hookCreateAction@onCreateAction','hookFinishAction@onFinishAction'),
	'langPath' => 'language',
	'viewPath' => 'views',
	'skinPath' => 'skin',
    'classes' => 'classes.*',
    'rewriteRule' =>'url',
	'theme' => array('pc' => 'default','mobile' => 'mobile'),
	'skin' => array('pc' => 'default','mobile' => 'default'),
	'timezone'	=> 'Etc/GMT-8',
	'upload' => 'upload',
	'dbbackup' => 'backup/database',
	'safe' => 'cookie',
	'lang' => 'zh_sc',
	'debug'=> true,
	'configExt'=> array('site_config'=>'config/site_config.php'),
	'encryptKey'=>'c677aa3993fea922f63070abb53f36af',
);
?>