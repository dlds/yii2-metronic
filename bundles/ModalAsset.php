<?php
/**
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals/license/
 */

namespace  dlds\metronic\widgets;

use yii\web\AssetBundle;

/**
 * SpinnerAsset for spinner widget.
 */
class ModalAsset extends AssetBundle
{
    public $sourcePath = '@dlds/metronic/assets';
    public $js = [
        'plugins/bootstrap-modal/js/bootstrap-modalmanager.js',
        'plugins/bootstrap-modal/js/bootstrap-modal.js',
    ];

    public  $css = [
        'plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css',
        'plugins/bootstrap-modal/css/bootstrap-modal.css',
    ];

    public $depends = [
        'dlds\metronic\CoreAsset',
    ];
}
