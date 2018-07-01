<?php

namespace cms\block\backend;

use Yii;

use cms\components\BackendModule;

/**
 * Blocks backend module
 */
class Module extends BackendModule
{

    /**
     * @inheritdoc
     */
    public static function moduleName()
    {
        return 'block';
    }

    /**
     * @inheritdoc
     */
    protected static function cmsSecurity()
    {
        $auth = Yii::$app->getAuthManager();
        if ($auth->getRole('Block') === null) {
            //role
            $role = $auth->createRole('Block');
            $auth->add($role);
        }
    }

    /**
     * @inheritdoc
     */
    public function cmsMenu()
    {
        if (!Yii::$app->user->can('Block')) {
            return [];
        }

        return [
            'label' => Yii::t('block', 'Blocks'),
            'url' => ['/block/group/index'],
        ];
    }

}
