<?php

use yii\grid\GridView;
use yii\helpers\Html;

$title = Yii::t('blocks', 'Block groups');

$this->title = $title . ' | ' . Yii::$app->name;

$this->params['breadcrumbs'] = [
	$title,
];

?>
<h1><?= Html::encode($title) ?></h1>

<div class="btn-toolbar" role="toolbar">
	<?= Html::a(Yii::t('blocks', 'Create group'), ['create'], ['class' => 'btn btn-primary']) ?>
</div>

<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'summary' => '',
	'tableOptions' => ['class' => 'table table-condensed'],
	'columns' => [
		[
			'attribute' => 'title',
			'label' => Yii::t('blocks', 'Title'),
			'format' => 'html',
			'value' => function($model, $key, $index, $column) {
				$title = Html::a(Html::encode($model->title), ['block/index', 'group_id' => $model->id]);
				$alias = Html::tag('span', Html::encode($model->alias), ['class' => 'label label-default']);
				return $title . ' ' . $alias;
			}
		],
		[
			'class' => 'yii\grid\ActionColumn',
			'options' => ['style' => 'width: 50px;'],
			'template' => '{update} {delete}',
		],
	],
]) ?>
