<?php
/**
 * @copyright Copyright (c) 2014 icron.org
 * @license http://yii2metronic.icron.org/license.html
 */

namespace dlds\metronic\widgets;

use yii\helpers\Url;
use \yii\helpers\ArrayHelper;
use dlds\metronic\bundles\ListViewAsset;
use dlds\metronic\bundles\ListViewSortableAsset;

class ListView extends \yii\widgets\ListView {

    const SORTABLE_ITEM_CLASS = 'sortable-item';

    /**
     * @var boolean indicates if grid is sortable
     */
    public $sortable = [];

    /**
     * @var string pjax container
     */
    public $clientOptions;

    /**
     * Inits widget
     */
    public function init()
    {
        parent::init();

        $this->initSortable();
    }

    /**
     * Inits sortable behavior
     */
    protected function initSortable()
    {
        $route = ArrayHelper::getValue($this->sortable, 'url', false);

        if ($route)
        {
            $url = Url::toRoute($route);

            if (ArrayHelper::keyExists('class', $this->itemOptions))
            {
                $this->itemOptions['class'] = sprintf('%s %s', $this->itemOptions['class'], self::SORTABLE_ITEM_CLASS);
            }
            else
            {
                $this->itemOptions['class'] = self::SORTABLE_ITEM_CLASS;
            }

            $options = json_encode(ArrayHelper::getValue($this->sortable, 'options', []));

            $view = $this->getView();
            $view->registerJs("jQuery('#{$this->id}').SortableListView('{$url}', {$options});");

            $reload = ArrayHelper::getValue($this->sortable, 'reload', false);

            if ($reload)
            {
                $view->registerJs("jQuery('#{$this->id}').on('sortableSuccess', $reload)", \yii\web\View::POS_END);
            }

            ListViewSortableAsset::register($view);
        }
    }
}