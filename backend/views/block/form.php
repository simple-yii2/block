<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

use dkhlystov\uploadimage\widgets\UploadImage;

$imageSize = '<br><span class="label label-default">' . $parent->imageWidth . '&times' . $parent->imageHeight . '</span>';

?>
<?php $form = ActiveForm::begin([
	'layout' => 'horizontal',
	'enableClientValidation' => false,
	'options' => ['class' => 'block-form'],
]); ?>

	<?= $form->field($model, 'active')->checkbox() ?>

	<?= $form->field($model, 'image')->label($model->getAttributeLabel('image') . $imageSize)->widget(UploadImage::className(), [
		'thumbAttribute' => 'thumb',
		'maxImageWidth' => 1000,
		'maxImageHeight' => 1000,
		'thumbWidth' => $parent->imageWidth,
		'thumbHeight' => $parent->imageHeight,
		'maxFileSize' => 2048,
	]) ?>

	<?= $form->field($model, 'title') ?>

	<?= $form->field($model, 'lead')->textarea(['rows' => 3]) ?>

	<?= $form->field($model, 'text')->textarea(['rows' => 5]) ?>

	<?= $form->field($model, 'url') ?>

	<?= $form->field($model, 'linkLabel') ?>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-6">
			<?= Html::submitButton(Yii::t('block', 'Save'), ['class' => 'btn btn-primary']) ?>
			<?= Html::a(Yii::t('block', 'Cancel'), ['group/index', 'id' => $id], ['class' => 'btn btn-default']) ?>
		</div>
	</div>

<?php ActiveForm::end(); ?>
