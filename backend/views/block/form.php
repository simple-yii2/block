<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use dkhlystov\uploadimage\widgets\UploadImage;

$imageSize = '<br><span class="label label-default">' . $parent->imageWidth . '&times' . $parent->imageHeight . '</span>';

//options
$optionsImage = ['class' => 'form-group'];
if (!$parent->enableImage) {
    Html::addCssClass($optionsImage, 'hidden');
}
$optionsAlias = ['class' => 'form-group'];
if (!$parent->enableAlias) {
    Html::addCssClass($optionsAlias, 'hidden');
}
$optionsLead = ['class' => 'form-group'];
if (!$parent->enableLead) {
    Html::addCssClass($optionsLead, 'hidden');
}
$optionsText = ['class' => 'form-group'];
if (!$parent->enableText) {
    Html::addCssClass($optionsText, 'hidden');
}
$optionsLink = ['class' => 'form-group'];
if (!$parent->enableLink) {
    Html::addCssClass($optionsLink, 'hidden');
}

?>
<?php $form = ActiveForm::begin([
    'layout' => 'horizontal',
    'enableClientValidation' => false,
    'options' => ['class' => 'block-form'],
]); ?>

    <fieldset>
        <?= $form->field($model, 'active')->checkbox() ?>
        <?= $form->field($model, 'image', ['options' => $optionsImage])->label($model->getAttributeLabel('image') . $imageSize)->widget(UploadImage::className(), [
            'thumbAttribute' => 'thumb',
            'maxImageWidth' => 1000,
            'maxImageHeight' => 1000,
            'thumbWidth' => $parent->imageWidth,
            'thumbHeight' => $parent->imageHeight,
            'maxFileSize' => 2048,
        ]) ?>
        <?= $form->field($model, 'alias', ['options' => $optionsAlias]) ?>
        <?= $form->field($model, 'title') ?>
        <?= $form->field($model, 'lead', ['options' => $optionsLead])->textarea(['rows' => 3]) ?>
        <?= $form->field($model, 'text', ['options' => $optionsText])->textarea(['rows' => 5]) ?>
        <?= $form->field($model, 'url', ['options' => $optionsLink]) ?>
        <?= $form->field($model, 'linkLabel', ['options' => $optionsLink]) ?>
    </fieldset>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-6">
            <?= Html::submitButton(Yii::t('block', 'Save'), ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('block', 'Cancel'), ['group/index', 'id' => $id], ['class' => 'btn btn-default']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>
