<?php

use yii\helpers\Html;
use yii\web\JsExpression;

use dkhlystov\widgets\NestedTreeGrid;
use cms\block\common\models\Group;

$title = Yii::t('block', 'Blocks');

$this->title = $title . ' | ' . Yii::$app->name;

$this->params['breadcrumbs'] = [
    $title,
];

?>
<h1><?= Html::encode($title) ?></h1>

<div class="btn-toolbar" role="toolbar">
    <?= Html::a(Yii::t('block', 'Create group'), ['create'], ['class' => 'btn btn-primary']) ?>
</div>

<?= NestedTreeGrid::widget([
    'dataProvider' => $dataProvider,
    'showRoots' => true,
    'initialNode' => $initial,
    'moveAction' => ['move'],
    'pluginOptions' => [
        'onMoveOver' => new JsExpression('function (item, helper, target, position) {
            if (item.data("depth") == 0 || target.data("depth") == 0)
                return false;

            if (item.data("tree") != target.data("tree"))
                return false;

            return position != 1;
        }'),
    ],
    'rowOptions' => function ($model, $key, $index, $grid) {
        $options = ['data' => [
            'depth' => $model->depth,
            'tree' => $model->tree,
        ]];

        if (!$model->active)
            Html::addCssClass($options, 'warning');

        return $options;
    },
    'columns' => [
        [
            'attribute' => 'title',
            'format' => 'html',
            'header' => Html::encode(Yii::t('block', 'Title')),
            'value' => function($model, $key, $index, $column) {
                if ($model instanceof Group) {
                    $title = Html::encode($model->title);
                    $alias = Html::tag('span', Html::encode($model->alias), ['class' => 'label label-primary']);
                    $count = Html::tag('span', $model->children()->count(), ['class' => 'badge']);

                    return trim($title . ' ' . $alias . ' ' . $count);
                } else {
                    $image = empty($model->thumb) ? '' : Html::img($model->thumb, ['height' => 20]);
                    $title = Html::encode($model->title);
                    $alias = empty($model->alias) ? '' : Html::tag('span', Html::encode($model->alias), ['class' => 'label label-primary']);
                    $url = $model->url == '#' ? '' : Html::tag('span', Html::encode($model->url), ['class' => 'text-info']);

                    return trim($image . ' ' . $title . ' ' . $alias . ' ' . $url);
                }
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'options' => ['style' => 'width: 75px;'],
            'template' => '{update} {delete} {create}',
            'buttons' => [
                'create' => function ($url, $model, $key) {
                    if (!$model->isRoot())
                        return '';

                    $title = Yii::t('block', 'Create block');

                    return Html::a('<span class="glyphicon glyphicon-plus"></span>', $url, [
                        'title' => $title,
                        'aria-label' => $title,
                        'data-pjax' => 0,
                    ]);
                },
            ],
            'urlCreator' => function ($action, $model, $key, $index) {
                if ($action == 'create' || !$model->isRoot())
                    $action = 'block/' . $action;

                return [$action, 'id' => $model->id];
            },
        ],
    ],
]) ?>
