<?php
/**
 * @copyright Copyright (c) 2014 icron.org
 * @license http://yii2metronic.icron.org/license.html
 */

namespace dlds\metronic\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use dlds\metronic\widgets\TextInputWidget;
use dlds\metronic\bundles\TagInputAsset;

/**
 * TextInputWidget renders text input widget.
 *
 * An input widget can be associated with a data model and an attribute,
 * or a name and a value. If the former, the name and the value will
 * be generated automatically.
 */
class TagInput extends TextInputWidget {

    /**
     * @var array plugin options
     */
    public $pluginOptions = [];

    /**
     * @var array plugin default options
     */
    protected $pluginDefaults = [
        'width' => 'auto',
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->pluginOptions = ArrayHelper::merge($this->pluginDefaults, $this->pluginOptions);

        parent::init();
    }

    /**
     * Executes the widget.
     */
    public function run()
    {
        $this->registerJs();

        TagInputAsset::register($this->view);

        return parent::run();
    }

    /**
     * Registeres JS
     */
    protected function registerJs()
    {
        $this->view->registerJs("
                !(function($){
                    var el = $('#{$this->options['id']}');
         
                    el.tagsInput(".Json::encode($this->pluginOptions).");

                })(jQuery);
                ", \yii\web\View::POS_READY);
    }
}