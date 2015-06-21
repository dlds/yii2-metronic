<?php
/**
 * @copyright Copyright (c) 2014 icron.org
 * @license http://yii2metronic.icron.org/license.html
 */

namespace dlds\metronic\widgets;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dlds\metronic\bundles\GridViewSortableAsset;

class GridView extends \kartik\grid\GridView {

    /**
     * @var string grid view layout
     */
    //public $layout = "{items}\n{summary}\n{pager}";
    public $layout = "{items}\n<div class=\"row\"><div class=\"col-md-5 col-sm-12\">{summary}</div>\n<div class=\"col-md-7 col-sm-12 text-right\">{pager}</div></div>";

    /**
     * @var boolean indicates if grid is sortable
     */
    public $sortable = false;

    /**
     * Inits widget
     */
    public function init()
    {
        parent::init();

        $this->initPager();

        $this->initVisible();

        $this->initSortable();

        //GridViewAsset::register($this->view);
    }

    /**
     * Renders the data models for the grid view.
     */
    public function renderItems()
    {
        /*
          $content = array_filter([
          $this->renderCaption(),
          $this->renderColumnGroup(),
          $this->showHeader ? $this->renderTableHeader() : false,
          $this->showFooter ? $this->renderTableFooter() : false,
          $this->renderTableBody(),
          ]);

          $table = Html::tag('table', implode("\n", $content), $this->tableOptions);
          if ($this->responsive)
          {
          $table = Html::tag('div', $table, ['class' => 'table-responsive']);
          }
          else
          {
          $table = Html::tag('div', $table, ['class' => 'table-scrollable']);
          }

          return $table;
         *
         */
        return parent::renderItems();
    }

    /**
     * Inits pager
     */
    protected function initPager()
    {
        $this->pager['firstPageLabel'] = Html::tag('i', '', [
                'class' => 'fa fa-angle-double-left',
        ]);

        $this->pager['lastPageLabel'] = Html::tag('i', '', [
                'class' => 'fa fa-angle-double-right',
        ]);

        $this->pager['prevPageLabel'] = Html::tag('i', '', [
                'class' => 'fa fa-angle-left',
        ]);

        $this->pager['nextPageLabel'] = Html::tag('i', '', [
                'class' => 'fa fa-angle-right',
        ]);
    }

    protected function initVisible()
    {
        $columns = $this->getStorageColumns();
        if (empty($columns))
        {
            return;
        }
        foreach ($this->columns as $i => $column)
        {
            if (array_search($i, $columns) === false)
            {
                unset($this->columns[$i]);
            }
        }
    }

    /**
     * Inits sortable behavior on gridview
     */
    protected function initSortable()
    {
        $route = ArrayHelper::getValue($this->sortable, 'url', false);

        if ($route)
        {
            $url = Url::toRoute($route);

            $options = json_encode(ArrayHelper::getValue($this->sortable, 'options', []));

            $view = $this->getView();
            $view->registerJs("jQuery('#{$this->id}').SortableGridView('{$url}', {$options});");
            GridViewSortableAsset::register($view);
        }
    }

    protected function getStorageColumns()
    {
        return [];
    }
}