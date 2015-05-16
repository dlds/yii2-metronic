<?php
/**
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals.cz/license/
 */

namespace dlds\metronic\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ActionColumn extends \yii\grid\ActionColumn {

    /**
     * @var array the HTML options for the data cell tags.
     */
    public $headerOptions = ['class' => 'text-center'];

    /**
     * @var array the HTML options for the data cell tags.
     */
    public $contentOptions = ['class' => 'text-center'];

    /**
     * @var string the template that is used to render the content in each data cell.
     */
    public $template = '{update}';

    /**
     * @var string the icon for the view button.
     */
    public $viewButtonIcon = 'icon-eye';

    /**
     * @var string the icon for the update button.
     */
    public $updateButtonIcon = 'icon-pencil';

    /**
     * @var string the icon for the delete button.
     */
    public $deleteButtonIcon = 'icon-trash';

    /**
     * @var string the icon for the delete button.
     */
    public $resetButtonIcon = 'icon-close';

    /**
     * @var mixed array pager settings or false to disable pager
     */
    public $pageSizeOptions = [20 => 20, 50 => 50];

    /**
     * @var string btn view class
     */
    public $btnViewClass = 'action-view';

    /**
     * @var string btn update class
     */
    public $btnUpdateClass = 'action-update';

    /**
     * @var string btn delete class
     */
    public $btnDeleteClass = 'action-delete';

    /**
     * @var mixed filter reset route
     */
    public $routeFilterReset = null;

    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['view']))
        {
            $this->buttons['view'] = function ($url, $model, $key) {
                return Html::a('<span class="'.$this->viewButtonIcon.'"></span>', $url, [
                        'title' => \Yii::t('yii', 'View'),
                        'data-pjax' => '0',
                        'class' => $this->btnViewClass,
                ]);
            };
        }
        if (!isset($this->buttons['update']))
        {
            $this->buttons['update'] = function ($url, $model, $key) {
                return Html::a('<span class="'.$this->updateButtonIcon.'"></span>', $url, [
                        'title' => \Yii::t('yii', 'Update'),
                        'data-pjax' => '0',
                        'class' => $this->btnUpdateClass,
                ]);
            };
        }
        if (!isset($this->buttons['delete']))
        {
            $this->buttons['delete'] = function ($url, $model, $key) {
                return Html::a('<span class="'.$this->deleteButtonIcon.'"></span>', $url, [
                        'title' => \Yii::t('yii', 'Delete'),
                        'data-confirm' => \Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                        'data-pjax' => '0',
                        'class' => $this->btnDeleteClass,
                ]);
            };
        }
    }

    /**
     * @inheritdoc
     */
    protected function renderHeaderCellContent()
    {
        if (!$this->routeFilterReset)
        {
            $route = \Yii::$app->controller->getRoute();

            if (!\yii\helpers\StringHelper::startsWith($route, '/'))
            {
                $route = '/'.$route;
            }

            $this->routeFilterReset = [$route];
        }

        return Html::a('<span class="'.$this->resetButtonIcon.'"></span>', $this->routeFilterReset, [
                'title' => \Yii::t('yii', 'Reset filter'),
                'data-pjax' => '0',
        ]);
    }

    /**
     * Renders the filter cell content.
     * The default implementation simply renders a space.
     * This method may be overridden to customize the rendering of the filter cell (if any).
     * @return string the rendering result
     */
    protected function renderFilterCellContent()
    {
        if (!$this->pageSizeOptions)
        {
            return parent::renderFilterCellContent();
        }

        return Html::dropDownList($this->grid->dataProvider->pagination->pageSizeParam, $this->grid->dataProvider->pagination->pageSize, $this->pageSizeOptions);
    }
}