<?php

use yii\helpers\Html;

$title = Yii::t('blocks', 'Create block');

$this->title = $title . ' | ' . Yii::$app->name;

$this->params['breadcrumbs'] = [
	['label' => Yii::t('blocks', 'Block groups'), 'url' => ['groups/index']],
	['label' => $group->title, 'url' => ['index']],
	$title,
];

?>
<h1><?= Html::encode($title) ?></h1>

<?= $this->render('_form', [
	'model' => $model,
	'group' => $group,
]) ?>
