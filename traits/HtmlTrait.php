<?php

/**
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals.cz/license/
 */

namespace dlds\metronic\traits;

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use dlds\metronic\bundles\Select2Asset;

/**
 * Html helper
 */
trait HtmlTrait
{

    /**
     * Clases names
     */
    private static $_clsSelect2 = 'select2me';

    /**
     * Generates a link tag that refers to an external CSS file.
     * @param array|string $url the URL of the external CSS file. This parameter will be processed by [[\yii\helpers\Url::to()]].
     * @param array $options the tag options in terms of name-value pairs. These will be rendered as
     * the attributes of the resulting tag. The values will be HTML-encoded using [[encode()]].
     * If a value is null, the corresponding attribute will not be rendered.
     * See [[renderTagAttributes()]] for details on how attributes are being rendered.
     * @return string the generated link tag
     * @see \yii\helpers\Url::to()
     */
    public static function cssFile($url, $options = [])
    {
        if (!isset($options['rel'])) {
            $options['rel'] = 'stylesheet';
        }
        $options['href'] = Url::to($url);
        if (!empty($options['conditions'])) {
            foreach ($options['conditions'] as $file => $condition) {
                if (strpos($url, $file) !== false) {
                    unset($options['conditions']);
                    return static::conditionalComment(static::tag('link', '', $options), $condition);
                }
            }
        }
        unset($options['conditions']);

        return static::tag('link', '', $options);
    }

    /**
     * Generates a script tag that refers to an external JavaScript file.
     * @param  string $url the URL of the external JavaScript file. This parameter will be processed by [[\yii\helpers\Url::to()]].
     * @param  array $options the tag options in terms of name-value pairs. These will be rendered as
     *                         the attributes of the resulting tag. The values will be HTML-encoded using [[encode()]].
     *                         If a value is null, the corresponding attribute will not be rendered.
     *                         See [[renderTagAttributes()]] for details on how attributes are being rendered.
     * @return string the generated script tag
     * @see \yii\helpers\Url::to()
     */
    public static function jsFile($url, $options = [])
    {
        $options['src'] = Url::to($url);
        if (!empty($options['conditions'])) {
            foreach ($options['conditions'] as $file => $condition) {
                if (strpos($url, $file) !== false) {
                    unset($options['conditions']);
                    return static::conditionalComment(static::tag('script', '', $options), $condition);
                }
            }
        }
        unset($options['conditions']);

        return static::tag('script', '', $options);
    }

    /**
     * Generates conditional comments such as '<!--[if...]>' or '<!--[if...]<!-->'.
     * @param $content string the commented content
     * @param $condition string condition. Can contain 'if...' or '<!--[if...]<!-->'
     * @return string the generated result
     */
    public static function conditionalComment($content, $condition)
    {
        $condition = strpos($condition, '<!--') !== false ? $condition : '<!--[' . $condition . ']>';
        $lines = [];
        $lines[] = $condition;
        $lines[] = $content;
        $lines[] = (strpos($condition, '-->') !== false ? '<!--' : '') . '<![endif]-->';

        return implode("\n", $lines);
    }

    /**
     * @inheritdoc
     */
    public static function dropDownList($name, $selection = null, $items = [], $options = [], $standardSelect = false)
    {
        if (!$standardSelect) {
            Select2Asset::register(\Yii::$app->view);

            self::addCssClass($options, static::$_clsSelect2);

            self::addData($options, 'placeholder', '-');
        }

        return parent::dropDownList($name, $selection, $items, $options);
    }

    /**
     * @inheritdoc
     */
    public static function activeDropDownList($model, $attribute, $items, $options = [], $standardSelect = false)
    {
        if (!$standardSelect) {
            Select2Asset::register(\Yii::$app->view);

            self::addCssClass($options, static::$_clsSelect2);

            self::addData($options, 'placeholder', '-');
        }

        return parent::activeDropDownList($model, $attribute, $items, $options);
    }

    /**
     * Adds data attribute to element options
     * @param type $key
     * @param type $value
     * @param type $replace
     */
    protected static function addData(&$options, $key, $value, $replace = false)
    {
        $placeholder = ArrayHelper::getValue($options, sprintf('data.%s', $key), null);

        if (null === $placeholder || $replace) {
            $options['data'][$key] = $value;
        }
    }

}
