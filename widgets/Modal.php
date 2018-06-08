<?php
/**
 * @copyright Copyright (c) 2014 icron.org
 * @license http://yii2metronic.icron.org/license.html
 */

namespace dlds\metronic\widgets;

use Yii;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use dlds\metronic\bundles\ModalAsset;

/**
 * Modal renders a modal window that can be toggled by clicking on a button.
 *
 * The following example will show the content enclosed between the [[begin()]]
 * and [[end()]] calls within the modal window:
 *
 * ~~~php
 * Modal::begin([
 *     'title' => 'Configuration',
 *     'toggleButton' => [
 *          'type' => Button::TYPE_M_GREEN,
 *          'label' => 'Modal',
 *          'icon' => 'fa fa-bell-o',
 *          'fullWidth' => true,
 *          'stackable' => true,
 *      ],
 * ]);
 *
 * echo 'Say hello...';
 *
 * Modal::end();
 * ~~~
 *
 * @see http://twitter.github.io/bootstrap/javascript.html#modals
 */
class Modal extends Widget {

  /**
   * @var string the title in the modal window.
   */
  public $title;

  /**
   * @var string the subtitle in the modal window.
   */
  public $subtitle;

  /**
   * @var string the footer content in the modal window.
   */
  public $footer;

  public $customHeader;

  /**
   * @var array the options for rendering the close button tag.
   * The close button is displayed in the header of the modal window. Clicking
   * on the button will hide the modal window. If this is null, no close button
   *   will be rendered.
   *
   * The following special options are supported:
   *
   * - tag: string, the tag name of the button. Defaults to 'button'.
   * - label: string, the label of the button. Defaults to '&times;'.
   * - onFooter: if set, close Button is rendered on footer.
   *
   * The rest of the options will be rendered as the HTML attributes of the
   *   button tag. Please refer to the [Modal plugin
   *   help](http://twitter.github.com/bootstrap/javascript.html#modals) for
   *   the supported HTML attributes.
   */
  public $closeButton = [];

  /**
   * @var array the options for rendering the submit button tag in case of a
   *   form. The submit button is displayed in the header of the modal window.
   *   Clicking on the button will submit the form of the modal window. If this
   *   is null, no submit button will be rendered.
   *
   * The following special options are supported:
   *
   * - tag: string, the tag name of the button. Defaults to 'button'.
   * - label: string, the label of the button. Defaults to '&times;'.
   * - onFooter: if set, submit Button is rendered on footer.
   *
   * The rest of the options will be rendered as the HTML attributes of the
   *   button tag. Please refer to the [Modal plugin
   *   help](http://twitter.github.com/bootstrap/javascript.html#modals) for
   *   the supported HTML attributes.
   */
  public $submitButton = [];

  public $additionalButtons = [];
  /**
   * @var array the configuration array for [[Button]].
   */
  public $toggleButton = [];

  /**
   * @var bool indicates whether the modal in full screen width.
   */
  public $fullWidth = FALSE;

  /**
   * @var bool indicates whether the modal is stacked.
   */
  public $stackable = FALSE;

  /**
   * @var bool set on init
   */
  private $closeButtonOnFooter = FALSE;

  /**
   * @var bool set on init
   */
  private $submitButtonOnFooter = FALSE;

  /**
   * Initializes the widget.
   */
  public function init() {
    parent::init();

    if (isset($this->closeButton['onFooter'])) {
      $this->closeButtonOnFooter = $this->closeButton['onFooter'] === TRUE;
      unset($this->closeButton['onFooter']);
    }

    if (isset($this->submitButton['onFooter'])) {
      $this->submitButtonOnFooter = $this->submitButton['onFooter'] === TRUE;
      unset($this->submitButton['onFooter']);
    }

    $this->initOptions();

    echo $this->renderToggleButton() . "\n";
    echo Html::beginTag('div', $this->options) . "\n";
    echo $this->renderHeader() . "\n";
    echo $this->renderBodyBegin() . "\n";
  }

  /**
   * Renders the widget.
   */
  public function run() {
    echo "\n" . $this->renderBodyEnd();
    echo "\n" . $this->renderFooter();
    echo "\n" . Html::endTag('div');

    ModalAsset::register($this->view);
    //$this->registerPlugin('spinner');
  }

  /**
   * Renders the header HTML markup of the modal
   *
   * @return string the rendering result
   */
  protected function renderHeader() {
    $html = '';

    $button = '';
    if (!$this->closeButtonOnFooter) {
      $button .= $this->renderCloseButton();
    }

    if (!$this->submitButtonOnFooter) {
      $button .= $this->renderSubmitButton();
    }

    $button .= $this->renderAdditionalButtons();

    if (!empty($button)) {
      $html = $button;
    }

    if ($this->title !== NULL && !empty($this->title)) {
      $html .= Html::tag('h4', $this->title, ['class' => 'modal-title']);
    }

    if ($this->subtitle !== NULL && !empty($this->subtitle)) {
      $html .= Html::tag('p', $this->subtitle, ['class' => 'modal-subtitle']);
    }

    $html = Html::tag('div', $html, ['class' => 'row']);
    $html = Html::tag('div', $html, ['class' => 'col-xs-12']);

    if ( $this->customHeader !== NULL && !empty($this->customHeader)) {
      $html .= Html::tag( 'div', "\n" . $this->customHeader . "\n", ['class' => 'modal-header']);
    }

    if ($html) {
      return Html::tag('div', "\n" . $html . "\n", ['class' => 'modal-header']);
    }

    return NULL;
  }

  /**
   * Renders the opening tag of the modal body.
   *
   * @return string the rendering result
   */
  protected function renderBodyBegin() {
    return Html::beginTag('div', ['class' => 'modal-body']);
  }

  /**
   * Renders the closing tag of the modal body.
   *
   * @return string the rendering result
   */
  protected function renderBodyEnd() {
    return Html::endTag('div');
  }

  /**
   * Renders the HTML markup for the footer of the modal
   *
   * @return string the rendering result
   */
  protected function renderFooter() {
    if ($this->footer == NULL) {
      $this->footer = '';
    }

    if ($this->closeButtonOnFooter) {
      $this->footer .= $this->renderCloseButton();
    }

    if ($this->submitButtonOnFooter) {
      $this->footer .= $this->renderSubmitButton();
    }

    if (!empty($this->footer)) {
      return Html::tag('div', "\n" . $this->footer . "\n", ['class' => 'modal-footer']);
    }
    else {
      return NULL;
    }
  }

  /**
   * Renders the toggle button.
   *
   * @return string the rendering result
   */
  protected function renderToggleButton() {
    if (!empty($this->toggleButton)) {
      return Button::widget($this->toggleButton);
    }
    else {
      return NULL;
    }
  }

  /**
   * Renders the close button.
   *
   * @return string the rendering result
   */
  protected function renderCloseButton() {
    if (!empty($this->closeButton)) {
      $tag = ArrayHelper::remove($this->closeButton, 'tag', 'button');
      $label = ArrayHelper::remove($this->closeButton, 'label', '&times;');
      if ($tag === 'button' && !isset($this->closeButton['type'])) {
        $this->closeButton['type'] = 'button';
      }
      return Html::tag($tag, $label, $this->closeButton);
    }

    return NULL;
  }

  /**
   * Renders additional buttons.
   *
   * @return string the rendering result
   */
  protected function renderAdditionalButtons() {
    if (empty($this->additionalButtons)) {
      return NULL;
    }

    $cssContainerClass = 'custom-buttons';
    if (isset($this->additionalButtons['class'])){
      $cssContainerClass = $this->additionalButtons['class'];
      unset($this->additionalButtons['class']);
    }

    $buttons = '';
    foreach ($this->additionalButtons as $button){
      $buttons .= $this->renderAdditionalButton($button);
    }

    $buttons = Html::tag('div', $buttons, ['class' => $cssContainerClass]);

    return $buttons;
  }

  protected function renderAdditionalButton($button){
    if (!isset($button['title'])){
      throw new Exception(Yii::t('widget', 'Button title must be set.'));
    }

    if (isset($button['url'])) {
      return Html::a($button['title'], $button['url'], $button['options'] ?? []);
    }

    return Html::tag('span', $button['title'], $button['options'] ?? []);
  }

  /**
   * Renders the submit button.
   *
   * @return string the rendering result
   */
  protected function renderSubmitButton() {
    if (!empty($this->submitButton)) {
      $tag = ArrayHelper::remove($this->submitButton, 'tag', 'button');
      $label = ArrayHelper::remove($this->submitButton, 'label', 'Save');
      if ($tag === 'button' && !isset($this->submitButton['type'])) {
        $this->closeButton['type'] = 'button';
      }
      return Html::tag($tag, $label, $this->submitButton);
    }

    return NULL;
  }

  /**
   * Initializes the widget options.
   * This method sets the default values for various options.
   */
  protected function initOptions() {
    if ($this->fullWidth) {
      Html::addCssClass($this->options, 'container');
    }
    if ($this->stackable) {
      $this->options = array_merge($this->options, ['data-focus-on' => 'input:first']);
    }
    if ($this->clientOptions !== FALSE) {
      $this->clientOptions = array_merge(['show' => FALSE], $this->clientOptions);
    }

    if ($this->closeButton !== NULL) {
      $this->closeButton = array_merge([
        'data-dismiss' => 'modal',
        'aria-hidden'  => 'true',
        'class'        => 'close',
      ], $this->closeButton);
    }

    if (!empty($this->toggleButton)) {
      $this->toggleButton = array_merge([
        'options' => ['data-toggle' => 'modal'],
      ], $this->toggleButton);
      if (!isset($this->toggleButton['options']['data-target']) && !isset($this->toggleButton['options']['href'])) {
        $this->toggleButton['options']['data-target'] = '#' . $this->options['id'];
      }
    }
  }
}