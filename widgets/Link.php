<?php

/**
 * @copyright Copyright (c) 2014 icron.org
 * @license http://yii2metronic.icron.org/license.html
 */

namespace dlds\metronic\widgets;

use yii\base\InvalidConfigException;
use yii\helpers\Html;

/**
 * Link renders a metronic link.
 *
 * For example,
 *
 * ```php
 * echo Link::widget([
 *     'label' => 'Link',
 *     'url' => 'http://yii2metronic.icron.org/',
 *     'icon' => 'm-icon-swapright m-icon-gray',
 *     'iconPosition' => Link::ICON_POSITION_LEFT,
 * ]);
 * ```
 */
class Link extends Widget {

    // Icon position
    const ICON_POSITION_LEFT = 'left';
    const ICON_POSITION_RIGHT = 'right';

    /**
     * @var string The button label
     */
    public $label;

    /**
     * @var bool Whether the label should be HTML-encoded
     */
    public $encodeLabel = true;

    /**
     * @var string The link url
     */
    public $url = '#';

    /**
     * @var string The button icon
     */
    public $icon = 'm-icon-swapright m-icon-gray';

    /**
     * @var string Icon position
     * Valid values are 'left', 'right'
     */
    public $iconPosition = self::ICON_POSITION_RIGHT;

    /**
     * Label options
     */
    public $labelOptions = [];

    /**
     * Initializes the widget.
     * @throws InvalidConfigException
     */
    public function init()
    {
        if ($this->label === null)
        {
            throw new InvalidConfigException("The 'label' option is required.");
        }

        if ($this->url === null)
        {
            $this->url = '#';
        }
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $icon = ($this->icon === null) ? '' : Html::tag('i', '', ['class' => $this->icon]);
        $label = Html::tag('span', Html::encode($this->label), $this->labelOptions);

        if (strcasecmp($this->iconPosition, self::ICON_POSITION_LEFT) === 0)
        {
            $content = sprintf('%s %s', $icon, $label);
        }
        else
        {
            $content = sprintf('%s %s', $label, $icon);
        }
        echo Html::a($content, $this->url, $this->options);
    }

}
