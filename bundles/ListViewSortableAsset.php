<?php

/**
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals.cz/license/
 */

namespace dlds\metronic\bundles;

use yii\web\AssetBundle;

/**
 * SpinnerAsset for spinner widget.
 */
class ListViewSortableAsset extends AssetBundle {

    public $sourcePath = '@dlds/metronic/assets';

    /**
     * @var array JS
     */
    public $js = [
        'global/scripts/sortable.listview.js',
    ];

    /**
     * @var array depends
     */
    public $depends = [
        'yii\jui\JuiAsset',
    ];

}
