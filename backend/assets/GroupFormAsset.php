<?php

namespace cms\block\backend\assets;

use yii\web\AssetBundle;

class GroupFormAsset extends AssetBundle
{

    public $js = [
        'group-form.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        parent::init();

        $this->sourcePath = __DIR__ . '/group-form';
    }

}
