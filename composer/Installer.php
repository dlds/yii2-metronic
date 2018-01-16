<?php

namespace dlds\metronic\composer;

class Installer
{

    public function updateAssetsSymlink()
    {
        $metronicThemeDir = __DIR__ . '/../../../web/metronic/theme/assets/';
        symlink($metronicThemeDir, __DIR__ . '/../assets/');
    }
}