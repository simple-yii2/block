<?php

use yii\grid\GridView;
use yii\helpers\Html;

$title = $group->title;

$this->title = $title . ' | ' . Yii::$app->name;

$this->params['breadcrumbs'] = [
	['label' => Yii::t('blocks', 'Block groups'), 'url' => ['group/index']],
	$title,
];

?>
<h1><?= Html::encode($title) ?></h1>

<div class="btn-toolbar" role="toolbar">
	<?= Html::a(Yii::t('blocks', 'Create block'), ['create', 'group_id' => $group->id], ['class' => 'btn btn-primary']) ?>
</div>

<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'summary' => '',
	'tableOptions' => ['class' => 'table table-condensed'],
	'rowOptions' => function ($model, $key, $index, $grid) {
		return !$model->active ? ['class' => 'warning'] : [];
	},
	'columns' => [
		[
			'attribute' => 'title',
			'format' => 'raw',
			'value' => function($model, $key, $index, $column) {
				$title = Html::encode($model->title);
				$url = Html::a(Html::encode($model->url), $model->url, ['target' => '_blank']);
				// $url = Html::tag('span', Html::encode($model->url), ['class' => 'text-muted']);

				return $title . '&nbsp;' . $url;
			}
		],
		[
			'class' => 'yii\grid\ActionColumn',
			'options' => ['style' => 'width: 50px;'],
			'template' => '{update} {delete}',
		],
	],
]) ?>
