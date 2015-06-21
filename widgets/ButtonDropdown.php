<?php

/**
 * @copyright Copyright (c) 2014 icron.org
 * @license http://yii2metronic.icron.org/license.html
 */

namespace dlds\metronic\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * ButtonDropdown renders a group or split button dropdown metronic component.
 *
 * For example,
 *
 * ```php
 * // a button group using Dropdown widget
 * echo ButtonDropdown::widget([
 *     'label' => 'Action',
 *     'button' => [
 *         'icon' => 'fa fa-bookmark-o',
 *         'iconPosition' => Button::ICON_POSITION_LEFT,
 *         'size' => Button::SIZE_SMALL,
 *         'disabled' => false,
 *         'block' => false,
 *         'type' => Button::TYPE_M_BLUE,
 *      ],
 *     'dropdown' => [
 *         'items' => [
 *             ['label' => 'DropdownA', 'url' => '/'],
 *             ['label' => 'DropdownB', 'url' => '#'],
 *         ],
 *     ],
 * ]);
 * ```
 *
 * */
class ButtonDropdown extends \yii\bootstrap\ButtonDropdown {

    /**
     * @var array The configuration array for [[Button]].
     */
    public $button = [];

    /**
     * @var bool Indicates whether the dropdown shoud expand on hover.
     */
    public $hover = false;

    /**
     * Inits ButtonDropdown
     */
    public function init()
    {
        parent::init();

        $this->options['data-toggle'] = 'dropdown';

        if ($this->hover === true)
        {
            $this->options['data-hover'] = 'dropdown';
        }

        if ($this->encodeLabel)
        {
            $this->label = Html::encode($this->label);
        }

        $this->options['data-close-others'] = 'true';

        Html::addCssClass($this->options, 'btn');

        Html::addCssClass($this->options, 'dropdown-toggle');
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo Html::tag('div', sprintf('%s%s', $this->renderButton(), $this->renderDropdown()), ['class' => 'btn-group']);
    }

    /**
     * Renders the button.
     * @return string the rendering result
     */
    protected function renderButton()
    {
        $label = Html::tag('span', $this->label, ['class' => 'hidden-sm hidden-xs']);

        if ($this->split)
        {
            $leftBtn = Button::widget($a = ArrayHelper::merge($this->button, [
                                'label' => $label,
                                'encodeLabel' => false,
                                'tagName' => $this->tagName,
            ]));


            $rightBtn = Button::widget(ArrayHelper::merge($this->button, [
                                'label' => '<i class="fa fa-angle-down"></i>',
                                'encodeLabel' => false,
                                'options' => $this->options,
                                'tagName' => $this->tagName,
            ]));
        }
        else
        {
            $label .= ' <i class="fa fa-angle-down"></i>';

            if (!isset($this->options['href']))
            {
                $this->options['href'] = '#';
            }

            $leftBtn = Button::widget(ArrayHelper::merge($this->button, [
                                'label' => $label,
                                'encodeLabel' => false,
                                'options' => $this->options,
                                'tagName' => $this->tagName,
            ]));

            $rightBtn = '';
        }

        return sprintf('%s%s', $leftBtn, $rightBtn);
    }

    /**
     * Renders the dropdown
     * @return string the rendering result
     */
    protected function renderDropdown()
    {
        $config = $this->dropdown;
        $config['clientOptions'] = false;
        return Dropdown::widget($config);
    }

}
