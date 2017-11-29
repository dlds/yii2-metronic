<?php

/**
 * @copyright Copyright (c) 2014 icron.org
 * @license http://yii2metronic.icron.org/license.html
 */

namespace dlds\metronic\widgets;

use dlds\metronic\Metronic;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Portlet renders a metronic portlet.
 * Any content enclosed between the [[begin()]] and [[end()]] calls of Portlet
 * is treated as the content of the portlet.
 * For example,
 *
 * ```php
 * // Simple portlet
 * Portlet::begin([
 *   'icon' => 'fa fa-bell-o',
 *   'title' => 'Title Portlet',
 * ]);
 * echo 'Body portlet';
 * Portlet::end();
 *
 * // Portlet with tools, actions, scroller, events and remote content
 * Portlet::begin([
 *   'title' => 'Extended Portlet',
 *   'scroller' => [
 *     'height' => 150,
 *     'footer' => ['label' => 'Show all', 'url' => '#'],
 *   ],
 *   'clientOptions' => [
 *     'loadSuccess' => new \yii\web\JsExpression('function(){ console.log("load success"); }'),
 *     'remote' => '/?r=site/about',
 *   ],
 *   'clientEvents' => [
 *     'close.mr.portlet' => 'function(e) { console.log("portlet closed"); e.preventDefault(); }'
 *   ],
 *   'tools' => [
 *     Portlet::TOOL_RELOAD,
 *     Portlet::TOOL_MINIMIZE,
 *     Portlet::TOOL_CLOSE,
 *   ],
 * ]);
 * ```
 *
 * @see http://yii2metronic.icron.org/components.html#portlet
 * @author icron.org <arbuscula@gmail.com>
 * @since 1.0
 */
class Portlet extends Widget
{

    /**
     * Types
     */
    const TYPE_LIGHT = 'light';
    const TYPE_NONE = '';

    /**
     * Tools
     */
    const TOOL_MINIMIZE = 'collapse';
    const TOOL_MODAL = 'modal';
    const TOOL_RELOAD = 'reload';
    const TOOL_CLOSE = 'remove';

    /**
     * @var string The portlet title
     */
    public $title;

    /**
     * @var string The portlet title helper
     */
    public $helper;

    /**
     * @var string The portlet icon
     */
    public $icon;

    /**
     * @var string The portlet type
     * Valid values are 'box', 'solid', ''
     */
    public $type = self::TYPE_LIGHT;

    /**
     * @var string The portlet color
     * Valid values are 'light-blue', 'blue', 'red', 'yellow', 'green', 'purple', 'light-grey', 'grey'
     */
    public $color = '';

    /**
     * @var string The portlet background color
     */
    public $background = '';

    /**
     * @var array List of actions, where each element must be specified as a string.
     */
    public $actions = [];

    /**
     * @var array The portlet tools
     * Valid values are 'collapse', 'modal', 'reload', 'remove'
     */
    public $tools = [];

    /**
     * @var array Scroller options
     * is an array of the following structure:
     * ```php
     * [
     *   // required, height of the body portlet as a px
     *   'height' => 150,
     *   // optional, HTML attributes of the scroller
     *   'options' => [],
     *   // optional, footer of the scroller. May contain string or array(the options of Link component)
     *   'footer' => [
     *     'label' => 'Show all',
     *   ],
     * ]
     * ```
     */
    public $scroller = [];

    /**
     * @var Ribbon[]
     */
    public $ribbons = [];

    /**
     * @var bool Whether the portlet should be bordered
     */
    public $bordered = false;

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
     * @var string tag title name
     */
    public $tagTitle = 'h1';

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        Html::addCssClass($this->options, trim(sprintf('portlet %s %s', $this->type, $this->background)));
        if (count($this->ribbons)>0) {
            Html::addCssClass($this->options, 'mt-element-ribbon portlet-fit');
        }
        echo Html::beginTag('div', $this->options);


        if (count($this->ribbons)>0) {
            $this->renderRibbon();
        }

        $this->renderTitle();

        Html::addCssClass($this->bodyOptions, 'portlet-body');
        echo Html::beginTag('div', $this->bodyOptions);

        $this->renderScrollerBegin();
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->renderScrollerEnd();

        echo Html::endTag('div'); // End portlet body
        echo Html::endTag('div'); // End portlet div
        //$loader = Html::img(Metronic::getAssetsUrl($this->view) . '/img/loading-spinner-grey.gif');
        //$this->clientOptions['loader'] = ArrayHelper::getValue($this->clientOptions, 'loader', $loader);
        //$this->registerPlugin('portlet');
    }

    protected function renderRibbon()
    {
        /** @var Ribbon $r */
        foreach($this->ribbons as $r) {
            print $r->run();
        }
    }

    /**
     * Renders portlet title
     */
    protected function renderTitle()
    {
        if (false !== $this->title) {

            Html::addCssClass($this->headerOptions, 'portlet-title');

            echo Html::beginTag('div', $this->headerOptions);

            echo Html::beginTag('div', ['class' => 'caption']);

            if ($this->icon) {
                echo Html::tag('i', '', ['class' => $this->pushFontColor($this->icon)]);
            }

            echo Html::tag($this->tagTitle, $this->title, ['class' => $this->pushFontColor('caption-subject')]);

            if ($this->helper) {
                echo Html::tag('span', $this->helper, ['class' => 'caption-helper']);
            }

            echo Html::endTag('div');

            echo Html::endTag('div');
        }
    }

    /**
     * Renders portlet tools
     */
    protected function renderTools()
    {
        if (!empty($this->tools)) {
            $tools = [];
            foreach ($this->tools as $tool) {
                $class = '';
                switch ($tool) {
                    case self::TOOL_CLOSE :
                        $class = 'remove';
                        break;

                    case self::TOOL_MINIMIZE :
                        $class = 'collapse';
                        break;

                    case self::TOOL_RELOAD :
                        $class = 'reload';
                        break;
                }
                $tools[] = Html::tag('a', '', ['class' => $class, 'href' => '']);
            }

            echo Html::tag('div', implode("\n", $tools), ['class' => 'tools']);
        }
    }

    /**
     * Renders portlet actions
     */
    protected function renderActions()
    {
        if (!empty($this->actions)) {
            echo Html::tag('div', implode("\n", $this->actions), ['class' => 'actions']);
        }
    }

    /**
     * Renders scroller begin
     * @throws InvalidConfigException
     */
    protected function renderScrollerBegin()
    {
        if (!empty($this->scroller)) {
            if (!isset($this->scroller['height'])) {
                throw new InvalidConfigException("The 'height' option of the scroller is required.");
            }
            $options = ArrayHelper::getValue($this->scroller, 'options', []);
            echo Html::beginTag(
                'div', ArrayHelper::merge(
                    ['class' => 'scroller', 'data-always-visible' => '1', 'data-rail-visible' => '0'], $options, ['style' => 'height:' . $this->scroller['height'] . 'px;']
                )
            );
        }
    }

    /**
     * Renders scroller end
     */
    protected function renderScrollerEnd()
    {
        if (!empty($this->scroller)) {
            echo Html::endTag('div');
            $footer = ArrayHelper::getValue($this->scroller, 'footer', '');
            if (!empty($footer)) {
                echo Html::beginTag('div', ['class' => 'scroller-footer']);
                if (is_array($footer)) {
                    echo Html::tag('div', Link::widget($footer), ['class' => 'pull-right']);
                } elseif (is_string($footer)) {
                    echo $footer;
                }
                echo Html::endTag('div');
            }
        }
    }

    /**
     * Retrieves font color
     */
    protected function getFontColor()
    {
        if ($this->color) {
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

        if ($color) {
            return sprintf('%s %s', $string, $color);
        }

        return $string;
    }

}
