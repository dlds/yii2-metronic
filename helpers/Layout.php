<?php

/**
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals.cz/license/
 */

namespace dlds\metronic\helpers;

use dlds\metronic\Metronic;
use yii\helpers\Html;

/**
 * Layout helper
 */
class Layout {

    /**
     * Retrieves Html options
     * @param string $tag given tag
     * @param boolean $asString if return as string
     * @return type
     */
    public static function getHtmlOptions($tag, $options = [], $asString = false)
    {
        $callback = sprintf('static::_%sOptions', strtolower($tag));

        $htmlOptions = call_user_func($callback, $options);

        return $asString ? Html::renderTagAttributes($htmlOptions) : $htmlOptions;
    }

    /**
     * Adds body tag options
     * @param array $options given options
     */
    private static function _bodyOptions($options)
    {
        Html::addCssClass($options, 'page-sidebar-closed-hide-logo');

        if (Metronic::getComponent() && Metronic::STYLE_MATERIAL === Metronic::getComponent()->style)
        {
            Html::addCssClass($options, 'page-md');
        }

        if (Metronic::getComponent() && Metronic::LAYOUT_BOXED === Metronic::getComponent()->layoutOption)
        {
            Html::addCssClass($options, 'page-boxed');
        }

        if (Metronic::getComponent() && Metronic::HEADER_FIXED === Metronic::getComponent()->headerOption)
        {
            Html::addCssClass($options, 'page-header-fixed');
        }

        if (Metronic::getComponent() && Metronic::SIDEBAR_POSITION_RIGHT === Metronic::getComponent()->sidebarPosition)
        {
            Html::addCssClass($options, 'page-sidebar-reversed');
        }

        if (Metronic::getComponent() && Metronic::SIDEBAR_FIXED === Metronic::getComponent()->sidebarOption)
        {
            Html::addCssClass($options, 'page-sidebar-fixed');
        }

        if (Metronic::getComponent() && Metronic::FOOTER_FIXED === Metronic::getComponent()->footerOption)
        {
            Html::addCssClass($options, 'page-footer-fixed');
        }

        return $options;
    }

    /**
     * Adds header tag options
     * @param array $options given options
     */
    private static function _headerOptions($options)
    {
        Html::addCssClass($options, 'page-header navbar');

        if (Metronic::getComponent() && Metronic::HEADER_FIXED === Metronic::getComponent()->headerOption)
        {
            Html::addCssClass($options, 'navbar-fixed-top');
        }
        else
        {
            Html::addCssClass($options, 'navbar-static-top');
        }

        return $options;
    }

    /**
     * Adds actions tag options
     * @param array $options given options
     */
    private static function _actionsOptions($options)
    {
        Html::addCssClass($options, 'page-actions');

        return $options;
    }

    /**
     * Adds top tag options
     * @param array $options given options
     */
    private static function _topOptions($options)
    {
        Html::addCssClass($options, 'page-top');

        return $options;
    }

    /**
     * Adds topmenu tag options
     * @param array $options given options
     */
    private static function _topmenuOptions($options)
    {
        Html::addCssClass($options, 'top-menu');

        return $options;
    }

    /**
     * Adds container tag options
     * @param array $options given options
     */
    private static function _containerOptions($options)
    {
        Html::addCssClass($options, 'container');

        return $options;
    }

    /**
     * Adds clearfix tag options
     * @param array $options given options
     */
    private static function _clearfixOptions($options)
    {
        Html::addCssClass($options, 'clearfix');

        return $options;
    }

}
