<?php
/**
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals.cz/license/
 */

namespace dlds\metronic\builders;

use yii\helpers\Html;

class TreeBuilder {

    /**
     * @var string items level attribute
     */
    public $levelAttr = 'level';

    /**
     * @var string item tree tag
     */
    public $treeTag = 'ul';

    /**
     * @var string item tag
     */
    public $itemTag = 'li';

    /**
     * @var string item tag
     */
    public $contentTag = '';

    /**
     * @var Closure function generates tree html options
     */
    public $treeHtmlOptions;

    /**
     * @var Closure function generates item html options
     */
    public $itemHtmlOptions;

    /**
     * @var Closure function generates content html options
     */
    public $contentHtmlOptions;

    /**
     * @var \Closure callback for generating contentF
     */
    public $contentCallback;

    /**
     * @var array given items to traverse
     */
    private $_items = array();

    /**
     * Private constructor
     * @param array $items
     */
    private function __construct($items, $params = array())
    {
        $this->_items = $items;

        $this->setParams($params);
    }

    /**
     * Retrieves new instance of MTreeBuilder
     * @param array $items given items to traverse
     */
    public static function instance($items, $params = array())
    {
        return new self($items, $params);
    }

    /**
     * Build tree from given items
     */
    public function build()
    {
        return $this->renderTree();
    }

    /**
     * Sets class params
     * @param array $params given params
     * @throws Exception if param does not exists
     */
    public function setParams($params)
    {
        foreach ($params as $param => $value)
        {
            if (!property_exists($this, $param))
            {
                throw new Exception(Yii::t('app', 'Class {class} has no param called "{param}."', array(
                    '{class}' => get_class($this),
                    '{param}' => $param
                )));
            }

            $this->{$param} = $value;
        }
    }

    /**
     * Renders tree
     * @return string html
     */
    protected function renderTree()
    {
        $html = '';

        $level = -1;

        foreach ($this->_items as $model)
        {
            if ($model->{$this->levelAttr} == $level)
            {
                $html .= $this->renderItemClose();
            }
            else if ($model->{$this->levelAttr} > $level)
            {
                $html .= $this->renderTreeOpen();
            }
            else
            {
                $html .= $this->renderItemClose();

                for ($i = $level - $model->{$this->levelAttr}; $i; $i--)
                {
                    $html .= $this->renderTreeClose();

                    $html .= $this->renderItemClose();
                }
            }

            $html .= $this->renderItemOpen($model->primaryKey);

            if (is_callable($this->contentCallback))
            {
                $html .= $this->renderContent(call_user_func($this->contentCallback, $model, $level));
            }
            else
            {
                $html .= $this->renderContent($model);
            }


            $level = $model->{$this->levelAttr};
        }

        for ($i = $level; $i; $i--)
        {
            $html .= $this->renderItemClose();
            $html .= $this->renderTreeClose();
        }

        return $html;
    }

    /**
     * Renders tree open tag
     * @return string html
     */
    protected function renderTreeOpen()
    {
        $options = $this->getHtmlOptions($this->treeHtmlOptions);

        return Html::beginTag($this->treeTag, $options);
    }

    /**
     * Renders item open tag
     * @return string html
     */
    protected function renderItemOpen($id)
    {
        $options = $this->getHtmlOptions($this->itemHtmlOptions, $id);

        return Html::beginTag($this->itemTag, $options);
    }

    /**
     * Renders item content
     */
    protected function renderContent($content)
    {
        if ($this->contentTag)
        {
            $options = $this->getHtmlOptions($this->contentHtmlOptions);

            return Html::tag($this->contentTag, $options, $content);
        }

        return $content;
    }

    /**
     * Renders item close tag
     * @return string html
     */
    protected function renderItemClose()
    {
        return Html::endTag($this->itemTag);
    }

    /**
     * Renders tree close tag
     * @return string html
     */
    protected function renderTreeClose()
    {
        return Html::endTag($this->treeTag);
    }

    /**
     * Retrieves html options for given property
     * @return array html options
     */
    protected function getHtmlOptions($property, $attr = null)
    {
        if (is_callable($property))
        {
            return (array) $property->__invoke($attr);
        }

        return (array) $property;
    }
}