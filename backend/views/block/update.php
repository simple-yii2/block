<?php

use yii\helpers\Html;

$title = $model->title;

$this->title = $title . ' | ' . Yii::$app->name;

$this->params['breadcrumbs'] = [
	['label' => Yii::t('blocks', 'Block groups'), 'url' => ['groups/index']],
	['label' => $group->title, 'url' => ['index', 'group_id' => $group->id]],
	$title,
];

?>
<h1><?= Html::encode($title) ?></h1>

<?= $this->render('_form', [
	'model' => $model,
	'group' => $group,
]) ?>
