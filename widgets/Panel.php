<?php

/**
 * @copyright Copyright (c) 2014 icron.org
 * @license http://yii2metronic.icron.org/license.html
 */

namespace dlds\metronic\widgets;

use yii\helpers\Html;

/**
 * Panel renders a metronic panel.
 * Any content enclosed between the [[begin()]] and [[end()]] calls of Panel
 * is treated as the content of the portlet.
 * For example,
 *
 * ```php
 * // Simple portlet
 * Panel::begin([
 *   'icon' => 'fa fa-bell-o',
 *   'title' => 'Title Panel',
 * ]);
 * echo 'Body portlet';
 * Panel::end();
 *
 *
 * @see http://yii2metronic.icron.org/components.html#portlet
 * @author icron.org <arbuscula@gmail.com>
 * @since 1.0
 */
class Panel extends Widget {

    /**
     * Types
     */
    const TYPE_DEFAULT = 'panel-default';
    
    /**
     * @var string The portlet title
     */
    public $title;

    /**
     * @var string The portlet icon
     */
    public $icon;

    /**
     * @var string The portlet type
     * Valid values are 'box', 'solid', ''
     */
    public $type = self::TYPE_DEFAULT;

    /**
     * @var string The portlet color
     * Valid values are 'light-blue', 'blue', 'red', 'yellow', 'green', 'purple', 'light-grey', 'grey'
     */
    public $color = '';

    /**
     * @var array The HTML attributes for the widget container
     */
    public $options = [];

    /**
     * @var array The HTML attributes for the widget body container
     */
    public $bodyOptions = [];

    /**
     * @var array The HTML attributes for the widget body container
     */
    public $headerOptions = [];

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->options, trim(sprintf('panel %s', $this->type)));
        echo Html::beginTag('div', $this->options);

        $this->_renderTitle();

        Html::addCssClass($this->bodyOptions, 'panel-body');
        echo Html::beginTag('div', $this->bodyOptions);
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo Html::endTag('div'); // End panel body
        echo Html::endTag('div'); // End panel div
    }

    /**
     * Renders portlet title
     */
    private function _renderTitle()
    {
        if (false !== $this->title)
        {
            Html::addCssClass($this->headerOptions, 'panel-heading');

            echo Html::beginTag('div', $this->headerOptions);

            echo Html::beginTag('div', ['class' => $this->pushFontColor('panel-title')]);

            if ($this->icon)
            {
                echo Html::tag('i', '', ['class' => $this->icon]);
            }

            echo Html::tag('span', $this->title);

            echo Html::endTag('div');

            echo Html::endTag('div');
        }
    }

    /**
     * Retrieves font color
     */
    protected function getFontColor()
    {
        if ($this->color)
        {
            return sprintf('font-%s', $this->color);
        }

        return '';
    }

    /**
     * Pushes font color to given string
     */
    protected function pushFontColor($string)
    {
        $color = $this->getFontColor();

        if ($color)
        {
            return sprintf('%s %s', $string, $color);
        }

        return $string;
    }

}
