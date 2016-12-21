<?php

use yii\helpers\Html;

$title = Yii::t('block', 'Create group');

$this->title = $title . ' | ' . Yii::$app->name;

$this->params['breadcrumbs'] = [
	['label' => Yii::t('block', 'Block groups'), 'url' => ['index']],
	$title,
];

?>
<h1><?= Html::encode($title) ?></h1>

<?= $this->render('_form', [
	'model' => $model,
]) ?>
