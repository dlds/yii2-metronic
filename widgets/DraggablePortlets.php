<?php
/**
 * Created by PhpStorm.
 * User: sgorzaly
 * Date: 27.09.17
 * Time: 10:39
 */

namespace dlds\metronic\widgets;

use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use dlds\metronic\bundles\DraggablePortletsAssetBundle;

class DraggablePortlets extends Widget
{
    public $cssRowClasses = 'ui-sortable';

    /**
     * @var array list of columns with items in the draggable portlets widget. Each element
     * represents a single column with the information of the items as array and additional options:
     * - items: array, requiredm with:
     *      - itemTitle: string, required, the group header label.
     *      - itemContent: array|string|object, required, the content (HTML) of the item
     *      - itemIcon: string, optional
     * - options: array, optional, the HTML attributes of the column
     * - appendEmptyLastElement: bool, optional. whether or not empty last element should be append
     * - tools: see Portlet widget
     * - visible: boolean, optional, whether the item should be visible or not. Defaults to true.
     */
    public $columns = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }
    /**
     * @inheritdoc
     */
    public function run()
    {
        DraggablePortletsAssetBundle::register($this->view);
        echo Html::beginTag('div', ['class' => "row {$this->cssRowClasses}", 'id' => 'sortable_portlets']);
        $this->renderColumns();
        echo Html::endTag('div');
    }

    private function renderColumns(){
        foreach ($this->columns as $aColumn){
            if (!array_key_exists('items', $aColumn)) {
                throw new InvalidConfigException(
                    "The 'items' option is required."
                );
            }

            echo Html::beginTag('div', ['class' => 'col-md-4 column sortable']);

            $options = [];
            if (array_key_exists('tools', $aColumn)){
                $options['tools'] = $aColumn['tools'];
            }

            $this->renderItems($aColumn['items'], $options);
            if (!(array_key_exists('appendEmptyLastElement', $aColumn) && $aColumn['appendEmptyLastElement'] === false) ){
                $this->renderEmptyPortlet();
            }
            echo Html::endTag('div');
        }
    }

    private function renderItems($items, $options){
        foreach ($items as $key => $item) {
            if (!ArrayHelper::remove($item, 'visible', true)) {
                continue;
            }

            if (!is_string($key) && !array_key_exists('itemTitle', $item)) {
                throw new InvalidConfigException(
                    "The 'itemTitle' option is required."
                );
            }
            if (is_string($item)) {
                $item = ['content' => $item];
            }

            Portlet::begin(array_merge([
                'title' => $item['itemTitle'],
                'options' => [
                    'class' => 'portlet-sortable',
                ],
                'headerOptions' => [
                    'class' => 'ui-sortable-handle',
                ],
            ], $options));

            Portlet::end();
        }
    }

    private function renderEmptyPortlet(){
        echo Html::tag('div', '', ['class' => 'portlet portlet-sortable-empty']);
    }


}