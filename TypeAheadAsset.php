<?php

namespace testtask\entitieslist;

use yii\web\AssetBundle;

class TypeAheadAsset extends AssetBundle
{
	public $sourcePath = '@bower/typeahead.js/dist';
	public $js = [
		'typeahead.bundle.js',
	];
	public $depends = [
		'yii\bootstrap\BootstrapAsset',
		'yii\bootstrap\BootstrapPluginAsset',
	];
}