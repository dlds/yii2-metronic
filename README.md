# yii2-metronic
Yii2 [Metronic theme](http://www.keenthemes.com/) integration. Currently is supported the version 4.6


Installation
------------

The extension is in development and the only way to use this fork is through through [composer](http://getcomposer.org/download/).


So add it to your composer.json with this composer command:
```
php composer.phar require dlds/yii2-metronic dev-master
```

 
Then You've to unzip the contents of your metronic Zip theme inside the ```@webroot/metronic``` folder. Check [Aliases](http://www.yiiframework.com/doc-2.0/guide-concept-aliases.html).

You should have a folder structure like this:

* app/
    * web/
        * metronic/
            * _documentation
            * _resources
            * _start
            * theme
            * theme_rtl
      


Quick Start
-----------
Edit your ```config/web.php``` configuration file and add the metronic component:

```
'components' => [
    'metronic'=>[
        'class'=>'dlds\metronic\Metronic',
        'resources'=>'[path to my web]/web/metronic/assets/theme/assets',
        'style'=>\dlds\metronic\Metronic::STYLE_MATERIAL,
        'theme'=>\dlds\metronic\Metronic::THEME_LIGHT,
        'layoutOption'=>\dlds\metronic\Metronic::LAYOUT_FLUID,
        'headerOption'=>\dlds\metronic\Metronic::HEADER_FIXED,
        'sidebarPosition'=>\dlds\metronic\Metronic::SIDEBAR_POSITION_LEFT,
        'sidebarOption'=>\dlds\metronic\Metronic::SIDEBAR_MENU_ACCORDION,
        'footerOption'=>\dlds\metronic\Metronic::FOOTER_FIXED,

    ],
]
```

**WARNING**
Check the "resources" key. This component field is used to locate the content of the zip theme.
The component try to create a symlink to this directory inside it's folder. **Eventually this may not work!**
In the case the link is invalid, you've to build it by yourself :)

My vendor folder looks like this:

* app/
    * [...]
    * vendor/
        * dlds/
            * yii2-metronic/
                * assets -> symlink to /var/www/project/web/metronic/assets/theme/assets
                * builders/
                * bundles/
                * helpers/
                * layouts/
                * widgets/


I suggest also to configure the assetManager. My actual configuration is this:
```
'assetManager' => [
        'linkAssets' => true,
        'bundles' => [
            'yii\web\JqueryAsset' => [
                'sourcePath' => null,   // do not publish the bundle
                'js' => [
                    '//code.jquery.com/jquery-1.11.2.min.js',  // use custom jquery
                ]
            ],
            
            'dlds\metronic\bundles\ThemeAsset' => [
                'addons'=>[
                    'default/login'=>[
                        'css'=>[
                            'pages/css/login-4.min.css',
                        ],
                        'js'=>[
                            'global/plugins/backstretch/jquery.backstretch.min.js',

                        ]
                    ],
                ]
            ],
        ],
    ],
```

In the ThemeAsset class i've added the support for addons. You can specify additional css/js for specific controller/action.

In the example is visible the way to add login-4.min.css and jquery.backstretch.min.js to the login page (in my case, the actionLogin is managed by a controller named DefaultController).

Configuring the layout for your views is the last step. 

The metronic component contains a sample layout view. I've not checked it. I'm working on my layout :)

Here is my sample ```views/layout/main.php```:

```
<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use dlds\metronic\helpers\Layout;
use dlds\metronic\Metronic;

$asset = Metronic::registerThemeAsset($this);

$directoryAsset = Yii::$app->assetManager->getPublishedUrl($asset->sourcePath);
?>
<?php $this->beginPage() ?>
<!--[if IE 8]> <html lang="<?= Yii::$app->language ?>" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="<?= Yii::$app->language ?>" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<!--<![endif]-->
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body <?= Layout::getHtmlOptions('body',['class'=>'page-container-bg-solid'],true) ?>>
<?php $this->beginBody() ?>

<?= $this->render('parts/header.php', ['directoryAsset' => $directoryAsset]) ?>

<!-- BEGIN CONTAINER -->
<div class="page-container">
<?= $this->render('parts/sidebar.php', ['directoryAsset' => $directoryAsset]) ?>

<?= $this->render('parts/content.php', ['content' => $content, 'directoryAsset' => $directoryAsset]) ?>
</div>
<?= $this->render('parts/footer.php', ['directoryAsset' => $directoryAsset]) ?>

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
```

Metronic theme require that you replace yii\helpers\Html with it's helper. So, you have to add a ```config/bootstrap.php``` with the following content:

```
<?php
Yii::$classMap['yii\helpers\Html'] = '@vendor/dlds/yii2-metronic/helpers/Html.php';
?>
```

The file bootstrap.php should be loaded before the web application is created. So you need to edit your ```web/index.php``` file 
and adjust it, and add a require directive. The file content should look like this:

```
<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');
require(__DIR__ . '/../config/bootstrap.php');
(new yii\web\Application($config))->run();
```

Things to notice:

* I've moved the rendering of the main parts to separate files (parts/*). You can build this files and add them to your project.
* I pass everywhere the $directoryAsset variable: this contain the path to the assets. Useful to load images bundled with the metronic theme.
* the BODY tag is managed with a Layout::getHtmlOptions(). This method is able to build all the Metronic required classes.
* Always check to use $this->beginPage(), $this->beginBody() and relatives $this->endBody() and $this->endPage() in the proper places :)

