<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use cms\block\backend\assets\GroupFormAsset;

GroupFormAsset::register($this);

$count = $model->getObject()->children()->count();

$options = ['class' => 'form-group'];
if ($model->enableImage == 0) {
    Html::addCssClass($options, 'hidden');
}

?>
<?php $form = ActiveForm::begin([
    'layout' => 'horizontal',
    'enableClientValidation' => false,
    'options' => ['class' => 'group-form'],
]); ?>

    <fieldset>
        <?= $form->field($model, 'active')->checkbox() ?>
        <?= $form->field($model, 'title') ?>
        <?= $form->field($model, 'alias') ?>
    </fieldset>

    <fieldset>
        <legend><?= Html::encode(Yii::t('block', 'Blocks')) ?></legend>
        <?= $form->field($model, 'enableAlias')->checkbox() ?>
        <?= $form->field($model, 'enableImage')->checkbox() ?>
        <?= $form->field($model, 'enableLead')->checkbox() ?>
        <?= $form->field($model, 'enableText')->checkbox() ?>
        <?= $form->field($model, 'enableLink')->checkbox() ?>

        <?php if ($count) {
            echo $form->field($model, 'imageWidth', ['options' => $options])->staticControl();
        } else {
            echo $form->field($model, 'imageWidth', ['options' => $options]);   
        } ?>

        <?php if ($count) {
            echo $form->field($model, 'imageHeight', ['options' => $options])->staticControl();
        } else {
            echo $form->field($model, 'imageHeight', ['options' => $options]);  
        } ?>
    </fieldset>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-6">
            <?= Html::submitButton(Yii::t('block', 'Save'), ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('block', 'Cancel'), ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>
