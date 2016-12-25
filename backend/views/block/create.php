<?php

use yii\helpers\Html;

$title = Yii::t('block', 'Create block');

$this->title = $title . ' | ' . Yii::$app->name;

$this->params['breadcrumbs'] = [
	['label' => Yii::t('block', 'Block groups'), 'url' => ['group/index']],
	['label' => $group->title, 'url' => ['index']],
	$title,
];

?>
<h1><?= Html::encode($title) ?></h1>

<?= $this->render('form', [
	'model' => $model,
	'group' => $group,
]) ?>
