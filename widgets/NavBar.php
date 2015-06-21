<?php

/**
 * @copyright Copyright (c) 2014 icron.org
 * @license http://yii2metronic.icron.org/license.html
 */

namespace dlds\metronic\widgets;

use dlds\metronic\Metronic;
use yii\helpers\Html;
use Yii;

/**
 * NavBar renders a navbar HTML component.
 *
 * Any content enclosed between the [[begin()]] and [[end()]] calls of NavBar
 * is treated as the content of the navbar. You may use widgets such as [[Nav]]
 * or [[\yii\widgets\Menu]] to build up such content. For example,
 *
 * ```php
 * use yii\bootstrap\NavBar;
 * use yii\widgets\Menu;
 *
 * NavBar::begin([
 *     'brandLabel' => 'NavBar Test',
 *     'brandLogoUrl' => '/img/logo.png',
 * ]);
 * echo Nav::widget([
 *     'items' => [
 *         ['label' => 'Home', 'url' => ['/site/index']],
 *         ['label' => 'About', 'url' => ['/site/about']],
 *     ],
 * ]);
 * NavBar::end();
 * ```
 *
 * @see http://twitter.github.io/bootstrap/components.html#navbar
 */
class NavBar extends \yii\bootstrap\NavBar {

    /**
     * @var string the url to logo of the brand.
     */
    public $brandLogoUrl;

    /**
     * @var string the url to logo of the brand.
     */
    public $brandWrapperOptions;
    
    /**
     * Initializes the widget.
     */
    public function init()
    {
        if (!isset($this->options['id']))
        {
            $this->options['id'] = $this->getId();
        }

        echo Html::beginTag('div', $this->options);
        echo Html::beginTag('div', ['class' => 'page-header-inner']);

        Html::addCssClass($this->brandWrapperOptions, 'page-logo');
        echo Html::beginTag('div', $this->brandWrapperOptions);
        echo $this->renderBrand();
        echo $this->renderToggleButton();
        echo Html::endTag('div');
    }

    /**
     * Executes the widget.
     */
    public function run()
    {
        echo Html::endTag('div');
        echo Html::endTag('div');
    }

    /**
     * Renders toggle button
     * @return string the rendering result
     */
    protected function renderToggleButton()
    {
        return Html::tag('div', '', ['class' => 'menu-toggler sidebar-toggler']);
    }

    /**
     * Renders Brand
     * @return string the rendering result
     */
    protected function renderBrand()
    {
        if ($this->brandLogoUrl)
        {
            $content = Html::img($this->brandLogoUrl, ['class' => 'logo-default', 'alt' => $this->brandLabel]);
        }
        else
        {
            $content = $this->brandLabel;
        }

        $this->brandOptions['href'] = $this->brandUrl;

        return Html::tag('a', $content, $this->brandOptions);
    }

}
