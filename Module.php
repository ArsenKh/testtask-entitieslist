<?php
namespace testtask\entitieslist;

use Yii;

class Module extends \yii\base\Module
{
	public $controllerNamespace = 'testtask\entitieslist\controllers';

	public $defaultRoute = 'default';

	public function init()
	{
		parent::init();
	}
}