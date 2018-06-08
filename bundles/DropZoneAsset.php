<?php
namespace dlds\metronic\bundles;

/**
 * Asset bundle for DropZone Widget
 */
class DropZoneAsset extends BaseAssetBundle
{
    /**
     * @var array css assets
     */
    public $css = [
        'global/plugins/dropzone/dropzone.min.css',
    ];

    /**
     * @var array js assets
     */
    public $js = [
        'global/plugins/dropzone/dropzone.min.js',
    ];
    /**
     * @var array
     */
    public $publishOptions = [
        'forceCopy' => true
    ];
}