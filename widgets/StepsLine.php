<?php
namespace dlds\metronic\widgets;

use yii\bootstrap\Html;
use dlds\metronic\bundles\StepsLineBundle;
use yii\helpers\ArrayHelper;

class StepsLine extends Widget
{
    public $cssRowClasses = 'step-default';

    public $cssItemTitleClasses = 'uppercase font-grey-cascade';

    public $cssItemIconClasses = 'bg-white';

    public $cssItemContentClasses = 'font-grey-cascade';

    public $cssColClass;

    /**
     * @var array list of items in the steps line widget. Each element
     * represents a single item with the following structure:
     *
     * - itemTitle: string, required, the group header label.
     * - itemContent: array|string|object, required, the content (HTML) of the item
     * - itemIcon: string, optional
     * - itemActive: string, optional (default: item is not active)
     * - itemDone: string, optional (default: item is not done)
     * - options: array, optional, the HTML attributes of the item
     * - contentOptions: optional, the HTML attributes of the items's content
     * - visible: boolean, optional, whether the item should be visible or not.
     *   Defaults to true.
     */
    public $items = [];

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
        StepsLineBundle::register($this->view);
        return implode("\n", [
            Html::beginTag('div', ['class' => 'mt-element-step']),
            Html::beginTag('div', ['class' => "row {$this->cssRowClasses}"]),
            $this->renderItems(),
            Html::endTag('div'),
            Html::endTag('div')
        ]);
    }

    /**
     * Renders wizard items as specified on [[items]].
     * @return string the rendering result.
     * @throws InvalidConfigException.
     */
    public function renderItems()
    {
        $contents = [];
        $n = 1;
        $numberOfItems = count($this->items);

        switch ($numberOfItems){
            case 3:
                $this->cssColClass = 'col-md-4';
                break;
            case 4:
                $this->cssColClass = 'col-md-3';
                break;
            default:
                throw new InvalidConfigException(
                    "Only three and four steps are supported by this widget. Your actual item count is $numberOfItems"
                );
        }

        foreach ($this->items as $key => $item) {
            $itemCssColClass = $this->cssColClass;

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

            if (!array_key_exists('itemIcon', $item)){
                $item['itemIcon'] = $n;
            }

            if (!array_key_exists('itemContent', $item)){
                $item['itemContent'] = '';
            }

            if (array_key_exists('itemUrl', $item) && empty($item['itemUrl'])){
                unset($item['itemUrl']);
            }

            switch ($n){
                case 1:
                    $itemCssColClass .= ' first';
                    break;
                case $numberOfItems:
                    $itemCssColClass .= ' last';
                    break;
                default:
                    $itemCssColClass .= '';

            }

            if (array_key_exists('itemActive', $item)){
                $itemCssColClass .= ' ' . $item['itemActive'];
            }

            if (array_key_exists('itemDone', $item)){
                $itemCssColClass .= ' ' . $item['itemDone'];
            }

            $item['cssClassesCol'] = $itemCssColClass;

            $contents[] = $this->renderItem($item);

            $n++;
        }

        return implode("\n", $contents);
    }

    private function renderItem($item = []){
        $lines = [];

        $lines[] = Html::beginTag('div', [
            'class' => "{$item['cssClassesCol']} mt-step-col"
        ]);

        $iconTag = Html::tag('div', $item['itemIcon'], ['class' => "mt-step-number {$this->cssItemIconClasses}"]);

        if (isset($item['itemUrl'])){
            $iconTag = Html::a($iconTag, $item['itemUrl']);
        }
        
        $lines[] = $iconTag;
        $lines[] = Html::tag('div', $item['itemTitle'], ['class' => "mt-step-title {$this->cssItemTitleClasses}"]);
        $lines[] = Html::tag('div', $item['itemContent'], ['class' => "mt-step-content {$this->cssItemContentClasses}"]);
        $lines[] = Html::endTag('div');

        return implode("\n", $lines);
    }
}