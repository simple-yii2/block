<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

use uploadimage\widgets\UploadImage;

?>
<?php $form = ActiveForm::begin([
	'layout' => 'horizontal',
	'enableClientValidation' => false,
	'options' => ['class' => 'block-form'],
]); ?>

	<?= $form->field($model, 'active')->checkbox() ?>

	<?= $form->field($model, 'image')->widget(UploadImage::className(), [
		'thumbAttribute' => 'thumb',
		'maxImageWidth' => 1000,
		'maxImageHeight' => 1000,
		'thumbWidth' => $group->imageWidth,
		'thumbHeight' => $group->imageHeight,
		'maxFileSize' => 2048,
	]) ?>

	<?= $form->field($model, 'title') ?>

	<?= $form->field($model, 'text')->textarea(['rows' => 5]) ?>

	<?= $form->field($model, 'url')->textInput(['placeholder' => 'http://example.com']) ?>

	<?= $form->field($model, 'linkLabel') ?>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-6">
			<?= Html::submitButton(Yii::t('blocks', 'Save'), ['class' => 'btn btn-primary']) ?>
			<?= Html::a(Yii::t('blocks', 'Cancel'), ['index', 'group_id' => $group->id], ['class' => 'btn btn-default']) ?>
		</div>
	</div>

<?php ActiveForm::end(); ?>
