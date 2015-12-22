<?php

/**
 * @copyright Copyright (c) 2014 icron.org
 * @license http://yii2metronic.icron.org/license.html
 */

namespace dlds\metronic\widgets;

use dlds\metronic\Metronic;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use Yii;
use yii\helpers\Url;
use yii\widgets\ActiveForm as CoreActiveForm;

/**
 * Metronic menu displays a multi-level menu using nested HTML lists.
 *
 * The main property of Menu is [[items]], which specifies the possible items in the menu.
 * A menu item can contain sub-items which specify the sub-menu under that menu item.
 *
 * Menu checks the current route and request parameters to toggle certain menu items
 * with active state.
 *
 * Note that Menu only renders the HTML tags about the menu. It does do any styling.
 * You are responsible to provide CSS styles to make it look like a real menu.
 *
 * The following example shows how to use Menu:
 *
 * ```php
 * echo Menu::widget([
 *     'items' => [
 *         // Important: you need to specify url as 'controller/action',
 *         // not just as 'controller' even if default action is used.
 *         [
 *           'icon' => '',
 *           'label' => 'Home',
 *           'url' => ['site/index']
 *         ],
 *         // 'Products' menu item will be selected as long as the route is 'product/index'
 *         ['label' => 'Products', 'url' => ['product/index'], 'items' => [
 *             ['label' => 'New Arrivals', 'url' => ['product/index', 'tag' => 'new']],
 *             ['label' => 'Most Popular', 'url' => ['product/index', 'tag' => 'popular']],
 *         ]],
 *         ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
 *     ],
 *     'search' => [
 *         // required, whether search box is visible. Defaults to 'true'.
 *         'visible' => true,
 *         // optional, the configuration array for [[ActiveForm]].
 *         'form' => [],
 *         // optional, input options with default values
 *         'input' => [
 *             'name' => 'search',
 *             'value' => '',
 *             'options' => [
 *             'placeholder' => 'Search...',
 *         ]
 *     ],
 * ]
 * ]);
 * ```
 *
 */
class Menu extends \yii\widgets\Menu {

    /**
     * @var boolean whether to activate parent menu items when one of the corresponding child menu items is active.
     * The activated parent menu items will also have its CSS classes appended with [[activeCssClass]].
     */
    public $activateParents = true;

    /**
     * @var string the CSS class that will be assigned to the first item in the main menu or each submenu.
     */
    public $firstItemCssClass = 'start';

    /**
     * @var string the CSS class that will be assigned to the last item in the main menu or each submenu.
     */
    public $lastItemCssClass = 'last';

    /**
     * @var string the template used to render a list of sub-menus.
     * In this template, the token `{items}` will be replaced with the renderer sub-menu items.
     */
    public $submenuTemplate = "\n<ul class='sub-menu'>\n{items}\n</ul>\n";

    /**
     * @var string the template used to render the body of a menu which is a link.
     * In this template, the token `{url}` will be replaced with the corresponding link URL;
     * while `{label}` will be replaced with the link text.
     * The token `{icon}` will be replaced with the corresponding link icon.
     * The token `{arrow}` will be replaced with the corresponding link arrow.
     * This property will be overridden by the `template` option set in individual menu items via [[items]].
     */
    public $linkTemplate = '<a href="{url}">{icon}{label}{badge}{arrow}</a>';

    /**
     * @var bool Indicates whether menu is visible.
     */
    public $visible = true;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        Metronic::registerThemeAsset($this->getView());

        $this->_initOptions();
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo Html::beginTag('div', ['class' => 'page-sidebar-wrapper']);
        echo Html::beginTag('div', ['class' => 'page-sidebar navbar-collapse collapse']);

        parent::run();

        echo Html::endTag('div');
        echo Html::endTag('div');
    }

    /**
     * Recursively renders the menu items (without the container tag).
     * @param array $items the menu items to be rendered recursively
     * @param integer $level the item level, starting with 1
     * @return string the rendering result
     */
    protected function renderItems($items, $level = 1)
    {
        $n = count($items);
        $lines = [];
        foreach ($items as $i => $item)
        {
            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $tag = ArrayHelper::remove($options, 'tag', 'li');
            $class = [];
            if ($item['active'])
            {
                $class[] = $this->activeCssClass;
            }
            if ($i === 0 && $this->firstItemCssClass !== null)
            {
                $class[] = $this->firstItemCssClass;
            }
            if ($i === $n - 1 && $this->lastItemCssClass !== null)
            {
                $class[] = $this->lastItemCssClass;
            }
            if (!empty($class))
            {
                if (empty($options['class']))
                {
                    $options['class'] = implode(' ', $class);
                }
                else
                {
                    $options['class'] .= ' ' . implode(' ', $class);
                }
            }

            // set parent flag
            $item['level'] = $level;
            $menu = $this->renderItem($item);
            if (!empty($item['items']))
            {
                $menu .= strtr($this->submenuTemplate, [
                    '{items}' => $this->renderItems($item['items'], $level + 1),
                ]);
            }
            $lines[] = Html::tag($tag, $menu, $options);
        }
        return implode("\n", $lines);
    }

    /**
     * Renders the content of a menu item.
     * Note that the container and the sub-menus are not rendered here.
     * @param array $item the menu item to be rendered. Please refer to [[items]] to see what data might be in the item.
     * @return string the rendering result
     */
    protected function renderItem($item)
    {
        return strtr(ArrayHelper::getValue($item, 'template', $this->linkTemplate), [
            '{url}' => $this->_pullItemUrl($item),
            '{label}' => $this->_pullItemLabel($item),
            '{icon}' => $this->_pullItemIcon($item),
            '{arrow}' => $this->_pullItemArrow($item),
            '{badge}' => $this->_pullItemBadge($item),
        ]);
    }

    /**
     * Pulls out item url
     * @param array $item given item
     * @return string item url
     */
    private function _pullItemUrl($item)
    {
        $url = ArrayHelper::getValue($item, 'url', '#');

        if ('#' === $url)
        {
            return 'javascript:;';
        }

        return Url::toRoute($item['url']);
    }

    /**
     * Pulls out item label
     * @param array $item given item
     * @return string item label
     */
    private function _pullItemLabel($item)
    {
        $label = ArrayHelper::getValue($item, 'label', '');

        $level = ArrayHelper::getValue($item, 'level', 1);

        if (1 == $level)
        {
            return Html::tag('span', $label, ['class' => 'title']);
        }

        return sprintf(' %s', $label);
    }

    /**
     * Pulls out item icon
     * @param array $item given item
     * @return string item icon
     */
    private function _pullItemIcon($item)
    {
        $icon = ArrayHelper::getValue($item, 'icon', null);

        if ($icon)
        {
            return Html::tag('i', '', ['class' => $icon]);
        }

        return '';
    }

    /**
     * Pulls out item arrow
     * @param array $item given item
     * @return string item arrow
     */
    private function _pullItemArrow($item)
    {
        $active = ArrayHelper::getValue($item, 'active', false);

        $level = ArrayHelper::getValue($item, 'level', 1);

        $items = ArrayHelper::getValue($item, 'items', []);

        if (!empty($items))
        {
            return Html::tag('span', '', ['class' => 'arrow' . ($active ? ' open' : '')]);
        }

        return '';
    }

    /**
     * Pulls out item badge
     * @param array $item given item
     * @return string item badge
     */
    private function _pullItemBadge($item)
    {
        return ArrayHelper::getValue($item, 'badge', '');
    }

    /**
     * Inits options
     */
    private function _initOptions()
    {
        Html::addCssClass($this->options, 'page-sidebar-menu');

        if (Metronic::getComponent() && Metronic::SIDEBAR_MENU_HOVER === Metronic::getComponent()->sidebarMenu)
        {
            Html::addCssClass($this->options, 'page-sidebar-menu-hover-submenu');
        }

        $this->options['data-slide-speed'] = 200;
        $this->options['data-auto-scroll'] = 'true';
        $this->options['data-keep-expanded'] = 'false';
        $this->options['data-height'] = 261;
    }

}
