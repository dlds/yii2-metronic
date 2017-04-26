<?php
/**
 * @link http://www.digitaldeals.cz/
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals.cz/license/
 */

namespace dlds\metronic;

use dlds\metronic\bundles\IonRangeSliderAsset;
use dlds\metronic\traits\HtmlTrait;
use Yii;
use yii\helpers\Html;
use yii\web\AssetBundle;
use yii\base\InvalidConfigException;
use dlds\metronic\bundles\ThemeAsset;

/**
 * This is the class of Metronic Component
 */
class Metronic extends \yii\base\Component
{

    /**
     * @var AssetBundle
     */
    public static $assetsBundle;

    /**
     * Assets link
     */
    const ASSETS_LINK = __DIR__ . '/assets';

    /**
     * Theme
     */
    const VERSION_1 = 'layout';
    const VERSION_2 = 'layout2';
    const VERSION_3 = 'layout3';
    const VERSION_4 = 'layout4';
    const VERSION_5 = 'layout5';
    const VERSION_6 = 'layout6';
    const VERSION_7 = 'layout7';

    /**
     * Theme
     */
    const THEME_DARK = 'default';
    const THEME_LIGHT = 'light';

    /**
     * Style
     */
    const STYLE_SQUARE = 'default';
    const STYLE_ROUNDED = 'rounded';
    const STYLE_MATERIAL = 'material';

    /**
     * Layout
     */
    const LAYOUT_FLUID = 'default';
    const LAYOUT_BOXED = 'boxed';

    /**
     * Header
     */
    const HEADER_DEFAULT = 'default';
    const HEADER_FIXED = 'fixed';

    /**
     * Header Dropdowns
     */
    const HEADER_DROPDOWN_DARK = 'dark';
    const HEADER_DROPDOWN_LIGHT = 'light';

    /**
     * Sidebar
     */
    const SIDEBAR_DEFAULT = 'default';
    const SIDEBAR_FIXED = 'fixed';

    /**
     * Sidebar menu
     */
    const SIDEBAR_MENU_ACCORDION = 'accordion';
    const SIDEBAR_MENU_HOVER = 'hover';

    /**
     * Sidebar position
     */
    const SIDEBAR_POSITION_LEFT = 'left';
    const SIDEBAR_POSITION_RIGHT = 'right';

    /**
     * Footer
     */
    const FOOTER_DEFAULT = 'default';
    const FOOTER_FIXED = 'fixed';

    /**
     * Search string
     */
    const PARAM_VERSION = '{version}';
    const PARAM_THEME = '{theme}';

    /**
     * UI Colors blue
     */
    const UI_COLOR_BLUE = 'blue';
    const UI_COLOR_BLUE_HOKI = 'blue-hoki';
    const UI_COLOR_BLUE_STEEL = 'blue-steel';
    const UI_COLOR_BLUE_MADISON = 'blue-madison';
    const UI_COLOR_BLUE_CHAMBRAY = 'blue-chambray';
    const UI_COLOR_BLUE_EBONYCLAY = 'blue-ebonyclay';

    /**
     * UI Colors green
     */
    const UI_COLOR_GREEN = 'green';
    const UI_COLOR_GREEN_MEADOW = 'green-meadow';
    const UI_COLOR_GREEN_SEAGREEN = 'green-seagreen';
    const UI_COLOR_GREEN_TORQUOISE = 'green-torquoise';
    const UI_COLOR_GREEN_JUNGLE = 'green-jungle';
    const UI_COLOR_GREEN_HAZE = 'green-haze';

    /**
     * UI Colors red
     */
    const UI_COLOR_RED = 'red';
    const UI_COLOR_RED_PINK = 'red-pink';
    const UI_COLOR_RED_SUNGLO = 'red-sunglo';
    const UI_COLOR_RED_INTENSE = 'red-intense';
    const UI_COLOR_RED_THUNDERBIRD = 'red-thunderbird';
    const UI_COLOR_RED_FLAMINGO = 'red-flamingo';
    const UI_COLOR_RED_HAZE = 'red-haze';

    /**
     * UI Colors yellow
     */
    const UI_COLOR_YELLOW = 'yellow';
    const UI_COLOR_YELLOW_GOLD = 'yellow-gold';
    const UI_COLOR_YELLOW_CASABLANCA = 'yellow-casablanca';
    const UI_COLOR_YELLOW_CRUSTA = 'yellow-crusta';
    const UI_COLOR_YELLOW_LEMON = 'yellow-lemon';
    const UI_COLOR_YELLOW_SAFFRON = 'yellow-saffron';

    /**
     * UI Colors purple
     */
    const UI_COLOR_PURPLE = 'purple';
    const UI_COLOR_PURPLE_PLUM = 'purple-plum';
    const UI_COLOR_PURPLE_MEDIUM = 'purple-medium';
    const UI_COLOR_PURPLE_STUDIO = 'purple-studio';
    const UI_COLOR_PURPLE_WISTERIA = 'purple-wisteria';
    const UI_COLOR_PURPLE_SEANCE = 'purple-seance';

    /**
     * UI Colors grey
     */
    const UI_COLOR_GREY = 'grey';
    const UI_COLOR_GREY_CASCADE = 'grey-cascade';
    const UI_COLOR_GREY_SILVER = 'grey-silver';
    const UI_COLOR_GREY_STEEL = 'grey-steel';
    const UI_COLOR_GREY_CARARRA = 'grey-cararra';
    const UI_COLOR_GREY_GALLERY = 'grey-gallery';

    /**
     * Classes paths
     */
    const CLASS_HTML = '@vendor/dlds/yii2-metronic/helpers/Html.php';

    /**
     * @var string version
     */
    public $version = self::VERSION_4;

    /**
     * @var string Theme
     */
    public $theme = self::THEME_LIGHT;

    /**
     * @var string Theme style
     */
    public $style = self::STYLE_ROUNDED;

    /**
     * @var string Layout mode
     */
    public $layoutOption = self::LAYOUT_FLUID;

    /**
     * @var string Header display
     */
    public $headerOption = self::HEADER_FIXED;

    /**
     * @var string Header dropdowns
     */
    public $headerDropdown = self::HEADER_DROPDOWN_DARK;

    /**
     * @var string Sidebar display
     */
    public $sidebarOption = self::SIDEBAR_DEFAULT;

    /**
     * @var string Sidebar display
     */
    public $sidebarMenu = self::SIDEBAR_MENU_ACCORDION;

    /**
     * @var string Sidebar position
     */
    public $sidebarPosition = self::SIDEBAR_POSITION_LEFT;

    /**
     * @var string Footer display
     */
    public $footerOption = self::FOOTER_DEFAULT;

    /** @var string IonRangeSlider skin */
    public $ionSliderSkin = IonRangeSliderAsset::SKIN_SIMPLE;

    /**
     * @var array resources paths
     */
    public $resources;

    /**
     * @var string Component name used in the application
     */
    public static $componentName = 'metronic';

    /**
     * Inits module
     */
    public function init()
    {
        if (self::SIDEBAR_FIXED === $this->sidebarOption && self::SIDEBAR_MENU_HOVER === $this->sidebarMenu) {
            throw new InvalidConfigException('Hover Sidebar Menu is not compatible with Fixed Sidebar Mode. Select Default Sidebar Mode Instead.');
        }

        if (!$this->resources) {
            throw new InvalidConfigException('You have to specify resources locations to be able to create symbolic links. Specify "admin" and "global" theme folder locations.');
        }

        if (!is_link(self::ASSETS_LINK) && !is_dir(self::ASSETS_LINK)) {
            symlink($this->resources, self::ASSETS_LINK);
        }
    }

    public function parseAssetsParams(&$string)
    {
        if (preg_match('/\{[a-z]+\}/', $string)) {
            $string = str_replace(static::PARAM_VERSION, $this->version, $string);

            $string = str_replace(static::PARAM_THEME, $this->theme, $string);
        }
    }

    /**
     * @return Metronic Get Metronic component
     */
    public static function getComponent()
    {
        try {
            return \Yii::$app->get(static::$componentName);
        } catch (InvalidConfigException $ex) {
            return null;
        }
    }

    /**
     * Get base url to metronic assets
     * @param $view View
     * @return string
     */
    public static function getAssetsUrl($view)
    {
        if (static::$assetsBundle === null) {
            static::$assetsBundle = static::registerThemeAsset($view);
        }

        return (static::$assetsBundle instanceof AssetBundle) ? static::$assetsBundle->baseUrl : '';
    }

    /**
     * Register Theme Asset
     * @param $view View
     * @return AssetBundle
     */
    public static function registerThemeAsset($view)
    {
        return static::$assetsBundle = ThemeAsset::register($view);
    }
}