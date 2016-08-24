<?php

namespace testtask\entitieslist;

use yii\web\AssetBundle;

class EntitieslistAsset extends AssetBundle
{
	public $sourcePath = '@testtask/entitieslist/assets';
	public $css = [
		'css/style.css',
	];
	public $depends = [
		'yii\bootstrap\BootstrapAsset',
		'yii\bootstrap\BootstrapPluginAsset',
	];
}