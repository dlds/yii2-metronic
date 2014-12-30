<?php
/**
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals/license/
 */

namespace dlds\metronic\helpers;

use dlds\metronic\Metronic;
use yii\helpers\Html;

/**
 * Layout helper
 */
class Layout
{
    public static function getHtmlOptions($tag, $asString = true)
    {
        $tag = strtolower($tag);
        $options = [];
        switch ($tag) {
            case 'body':
                if (strcasecmp(Metronic::getComponent()->headerOption, 'fixed') === 0) {
                    Html::addCssClass($options, 'page-header-fixed');
                }

                switch(Metronic::getComponent()->layoutOption)
                {
                    case Metronic::LAYOUT_FULL_WIDTH :
                        Html::addCssClass($options, Metronic::LAYOUT_FULL_WIDTH);
                        break;
                    case Metronic::LAYOUT_BOXED:
                        Html::addCssClass($options, Metronic::LAYOUT_BOXED);
                        break;
                }

                break;
            case 'header':
                Html::addCssClass($options, 'header navbar');
                if (strcasecmp(Metronic::getComponent()->headerOption, 'fixed') === 0) {
                    Html::addCssClass($options, 'navbar-fixed-top');
                } else {
                    Html::addCssClass($options, 'navbar-static-top');
                }
                break;
        }

        return  $asString ? Html::renderTagAttributes($options) : $options;
    }
}