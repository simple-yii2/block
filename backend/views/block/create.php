<?php

use yii\helpers\Html;

$title = Yii::t('block', 'Create block');

$this->title = $title . ' | ' . Yii::$app->name;

$this->params['breadcrumbs'] = [
    ['label' => Yii::t('block', 'Blocks'), 'url' => ['group/index']],
    $parent->title,
    $title,
];

?>
<h1><?= Html::encode($title) ?></h1>

<?= $this->render('form', [
    'model' => $model,
    'id' => $id,
    'parent' => $parent,
]) ?>
