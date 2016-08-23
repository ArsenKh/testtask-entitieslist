<?php
namespace testtask\entitieslist;

use Yii;
use yii\base\BootstrapInterface;

/**
 * This is the main module class for the Entities List module.
 *
 * To use Entities List, include it as a module in the application configuration like the following:
 *
 * ~~~
 * return [
 *     'bootstrap' => ['entitieslist'],
 *     'modules' => [
 *         'entitieslist' => ['class' => 'testtask\entitieslist\Module'],
 *     ],
 * ]
 * ~~~
 *
 * With the above configuration, you will be able to access Entities List in your browser using
 * the URL `http://localhost/path/to/index.php?r=entitieslist`
 *
 * If your application enables [[\yii\web\UrlManager::enablePrettyUrl|pretty URLs]],
 * you can then access Entities List via URL: `http://localhost/path/to/index.php/entitieslist`
 *
 */

class Module extends \yii\base\Module implements BootstrapInterface
{
	public $controllerNamespace = 'testtask\entitieslist\controllers';


	/**
	 * @inheritdoc
	 */
	public function bootstrap($app)
	{
		if ($app instanceof \yii\web\Application) {
			$app->getUrlManager()->addRules([
				['class' => 'yii\web\UrlRule', 'pattern' => $this->id, 'route' => $this->id . '/default/index'],
				['class' => 'yii\web\UrlRule', 'pattern' => $this->id . '/<id:\w+>', 'route' => $this->id . '/default/view'],
				['class' => 'yii\web\UrlRule', 'pattern' => $this->id . '/<controller:[\w\-]+>/<action:[\w\-]+>', 'route' => $this->id . '/<controller>/<action>'],
			], false);
		} elseif ($app instanceof \yii\console\Application) {
			$this->controllerNamespace = 'testtask\entitieslist\commands';
		}
	}
}