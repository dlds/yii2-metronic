<?php
/**
 * User: d4rkstar
 * Date: 10/10/16
 * Time: 14.51
 */

namespace dlds\metronic\widgets;

use yii\helpers\Html;

/**
 * Ribbon renders a metronic ribbon.
 *
 * @author icron.org <bruno@brunosalzano.com>
 * @since 1.1
 */
class Ribbon extends Widget {

    const TYPE_DEFAULT = 'ribbon-color-default';
    const TYPE_PRIMARY = 'ribbon-color-primary';
    const TYPE_INFO = 'ribbon-color-info';
    const TYPE_SUCCESS = 'ribbon-color-success';
    const TYPE_DANGER = 'ribbon-color-danger';
    const TYPE_WARNING = 'ribbon-color-warning';

    public $vertical = false;

    public $right = false;

    public $shadow = false;

    public $rounded = false;

    public $bordered = false;

    public $square_border = false;

    public $dashed = false;

    public $clipped = false;

    public $bookmark = false;

    public $color = self::TYPE_DEFAULT;

    public $title = '';

    public $icon = '';

    public $options = [];

    /**
     * Renders the widget.
     */
    public function run()
    {
        Html::addCssClass($this->options, 'ribbon');

        Html::addCssClass($this->options, $this->color);

        if ($this->vertical) {
            Html::addCssClass($this->options, ($this->right ? 'ribbon-vertical-right' : 'ribbon-vertical-left'));
        } else {
            if ($this->right) {
                Html::addCssClass($this->options,  'ribbon-right');
            }
        }

        if ($this->shadow) {
            Html::addCssClass($this->options, 'ribbon-shadow');
        }

        if ($this->rounded) {
            Html::addCssClass($this->options, 'ribbon-round');
        }
        if ($this->square_border) {
            Html::addCssClass($this->options, 'ribbon-border');
        } else {
            if ($this->bordered) {
                if ($this->vertical) {
                    Html::addCssClass($this->options, $this->dashed ? 'ribbon-border-dash-ver' : 'ribbon-border-ver');
                } else {
                    Html::addCssClass($this->options, $this->dashed ? 'ribbon-border-dash-hor' : 'ribbon-border-hor');
                }
            }
        }

        if ($this->clipped) {
            Html::addCssClass($this->options, 'ribbon-clip ribbon-sub');
        }

        if ($this->bookmark) {
            Html::addCssClass($this->options, 'ribbon-bookmark');
        }

        $content = $this->_renderSub() . $this->_renderTitle();
        echo Html::tag('div', $content, $this->options);
    }

    private function _renderSub() {
        if ($this->clipped) {
            return Html::tag('div', '', ['class'=>'ribbon-sub ribbon-clip']);
        }
        if ($this->bookmark) {
            return Html::tag('div', '', ['class'=>'ribbon-sub ribbon-bookmark']);
        }
    }

    private function _renderTitle() {
        $html = '';
        if ($this->icon)
        {
            $html .= Html::tag('i', '', ['class' => $this->icon]);
            $html .= '&nbsp;';
        }
        $html.= Html::tag('span', $this->title);
        return $html;
    }
}