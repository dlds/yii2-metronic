<?php

/**
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals.cz/license/
 */

namespace dlds\metronic\helpers;

use dlds\metronic\Metronic;
use yii\helpers\Html;

/**
 * Font helper
 */
class Font {

    /**
     * Font awesome pattern
     */
    const PATTERN_FA = '/fa-(.*)/';
    const PATTERN_GLYPH = '/glyphicon-(.*)/';

    /**
     * Fontawesome icons
     */
    const FA_VOLUME_UP = 'fa-volume-up';
    const FA_VOLUME_DOWN = 'fa-volume-down';
    const FA_VIDEO_CAM = 'fa-video-camera';
    const FA_PICTURE_O = 'fa-picture-o';
    const FA_DOLLAR = 'fa-dollar';
    const FA_UNLOCK = 'fa-unlock';
    const FA_LOCK = 'fa-lock';

    /**
     * Retrieves icon based on given type
     * @param string $name icon type
     * @param array $options given options
     * @return string icon hrml
     */
    public static function icon($name, array $options = [])
    {
        Html::addCssClass($options, self::getClass($name));

        return Html::tag('i', '', $options);
    }

    /**
     * Retrieves class for given name
     * @param string $name
     */
    protected static function getClass($name)
    {
        if (preg_match(self::PATTERN_FA, $name))
        {
            return sprintf('fa %s', $name);
        }

        if (preg_match(self::PATTERN_GLYPH, $name))
        {
            return sprintf('glyphicon %s', $name);
        }

        return $name;
    }

}
