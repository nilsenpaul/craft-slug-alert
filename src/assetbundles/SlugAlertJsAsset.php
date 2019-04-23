<?php

namespace nilsenpaul\slugalert\assetbundles;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class SlugAlertJsAsset extends AssetBundle
{
    public function init()
    {
        $this->sourcePath = '@nilsenpaul/slugalert/resources';
        $this->js = [
            'slug-alert.js',
        ];

        $this->depends = [
            CpAsset::class,
        ];

        parent::init();
    }
}
