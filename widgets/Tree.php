<?php
/**
 * @copyright Copyright (c) 2014 icron.org
 * @license http://yii2metronic.icron.org/license.html
 */

namespace dlds\metronic\widgets;

use yii\helpers\Html;
use \yii\helpers\ArrayHelper;
use dlds\metronic\bundles\TreeAsset;

class Tree extends InputWidget {

    /**
     * @var array items to be traversed in tree
     */
    public $items = [];

    /**
     * @var boolean indicates if is checkable
     */
    public $checkable = false;

    /**
     * @var array tree options
     */
    public $treeOptions = [];

    /**
     * @var string name of holder where checked items will be stored
     */
    public $holder = 'checkableTreeIds';

    /**
     * @var mixed array when assigned items are loaded, null otherwise
     */
    private $_assignedItems = null;

    /**
     * @var string item list tag
     */
    public $listTag = 'ul';

    /**
     * @var string item tag
     */
    public $itemTag = 'li';

    /**
     * @var string list class
     */
    public $listClass = 'tree';

    /**
     * @var string item class
     */
    public $itemClass = 'item';

    /**
     * @var string item icon class
     */
    public $itemIconClass = '';

    /**
     * @var string item cotent class
     */
    public $contentClass = '';

    /**
     * @var string nestable level attr (depth)
     */
    public $levelAttr = 'level';

    /**
     * @var \Closure callback for generating content
     */
    public $contentCallback;

    /**
     * @var array default tree config
     */
    protected $defaultTreeOptions = [
        'plugins' => [
            'wholerow',
        ],
        'core' => [
            'themes' => [
                'responsive' => false,
                'icons' => false
            ],
        ],
    ];

    /**
     * Inits widget
     */
    public function init()
    {
        $this->jsTree();
    }

    /**
     * Runs widget
     */
    public function run()
    {
        $builder = \dlds\metronic\builders\TreeBuilder::instance($this->items, array(
                'treeTag' => $this->listTag,
                'itemTag' => $this->itemTag,
                'levelAttr' => $this->levelAttr,
                'contentCallback' => $this->contentCallback,
                'treeHtmlOptions' => function() {
                    return $this->getTreeOptions();
                },
                'itemHtmlOptions' => function($id) {
                    return $this->getItemOptions($id);
                },
                'contentHtmlOptions' => function() {
                    return $this->getContentOptions();
                },
        ));

        echo $this->renderTree($builder->build());
    }

    /**
     * Retrieves tree html options
     * @return array tree html options
     */
    protected function getTreeOptions()
    {
        return array(
            'class' => $this->listClass,
        );
    }

    /**
     * Retrieves item html options
     * @param array $id passed item id
     */
    protected function getItemOptions($id)
    {
        return array(
            'class' => $this->itemClass,
            'data-id' => $id,
            'data-jstree' => json_encode([
                'selected' => $this->isItemAssigned($id),
            ]),
        );
    }

    /**
     * Retrieves content html options
     * @return type
     */
    protected function getContentOptions()
    {
        return array(
            'class' => $this->contentClass,
        );
    }

    /**
     * Indicates if item is currently assigned to model
     * @param int $id given item id
     */
    protected function isItemAssigned($id)
    {
        if (null === $this->_assignedItems)
        {
            $this->_assignedItems = $this->pullAssignedItems();
        }

        return in_array($id, $this->_assignedItems);
    }

    /**
     * Pulls assigned items from model
     */
    protected function pullAssignedItems()
    {
        if (is_string($this->model{$this->attribute}))
        {
            return explode(',', $this->model{$this->attribute});
        }

        return (array) $this->model{$this->attribute};
    }

    /**
     * Renders output
     * @param string $tree 
     */
    protected function renderTree($tree)
    {
        $html = Html::beginTag('div', ['id' => $this->id, 'class' => 'dd']);

        $html .= $tree;

        $html .= Html::endTag('div');

        if ($this->checkable)
        {
            $html .= $this->renderHiddenField();
        }

        return $html;
    }

    /**
     * Renders hidden form field
     */
    protected function renderHiddenField()
    {
        if ($this->hasModel())
        {
            return Html::activeInput('hidden', $this->model, $this->attribute, ['id' => $this->getHiddenFieldId()]);
        }

        return Html::input('hidden', $this->name, $this->value, ['id' => $this->getHiddenFieldId()]);
    }

    /**
     * Registres JS files
     */
    protected function jsTree()
    {
        if ($this->checkable)
        {
            $this->defaultTreeOptions = ArrayHelper::merge($this->defaultTreeOptions, [
                    'plugins' => [
                        'checkbox'
                    ],
                    'checkbox' => [
                        'keep_selected_style' => false,
                        'three_state' => false,
                        'cascade' => ''
                    ]
            ]);
        }

        $treeOptions = json_encode(ArrayHelper::merge($this->defaultTreeOptions, $this->treeOptions));

        $view = $this->getView();
        $view->registerJs("jQuery('#{$this->id}').jstree({$treeOptions});");
        $this->registerAdditionalJs();
        TreeAsset::register($view);
    }

    protected function registerAdditionalJs()
    {
        $view = $this->getView();

        if ($this->checkable)
        {
            $view->registerJs("jQuery('#{$this->id}').on('changed.jstree', function (e, data) {
            var i, j, r = [];

            for (i = 0, j = data.selected.length; i < j; i++) {
                r.push(data.instance.get_node(data.selected[i]).data.id);
            }

            jQuery('#{$this->getHiddenFieldId()}').val(r.join(','));
        });");
        }

        $view->registerJs("jQuery('#{$this->id}').on('select_node.jstree', function (e, data) {
            var \$this = $(this);
            \$this.jstree('open_node', data.node);
            var ParentNode = \$this.jstree('get_parent', data.node);
            \$this.jstree('select_node', ParentNode);
        });");

        $view->registerJs("jQuery('#{$this->id}').on('deselect_node.jstree', function (e, data) {
            var \$this = $(this);
            \$this.jstree('open_node', data.node);
            var ChildrenNodes = jQuery.makeArray(\$this.jstree('get_children_dom', data.node));
            \$this.jstree('deselect_node', ChildrenNodes);
            \$this.jstree('close_node', data.node);
        });");
    }

    /**
     * Retrieves hidden field id
     */
    private function getHiddenFieldId()
    {
        return strtolower(sprintf('%s-%s', $this->model->formName(), $this->attribute));
    }
}
?>
