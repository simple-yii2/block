<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$count = $model->getObject()->children()->count();

?>
<?php $form = ActiveForm::begin([
	'layout' => 'horizontal',
	'enableClientValidation' => false,
	'options' => ['class' => 'group-form'],
]); ?>

	<?= $form->field($model, 'active')->checkbox() ?>

	<?= $form->field($model, 'title') ?>

	<?= $form->field($model, 'alias') ?>

	<?php if ($count) {
		echo $form->field($model, 'imageWidth')->staticControl();
	} else {
		echo $form->field($model, 'imageWidth');	
	} ?>

	<?php if ($count) {
		echo $form->field($model, 'imageHeight')->staticControl();
	} else {
		echo $form->field($model, 'imageHeight');	
	} ?>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-6">
			<?= Html::submitButton(Yii::t('block', 'Save'), ['class' => 'btn btn-primary']) ?>
			<?= Html::a(Yii::t('block', 'Cancel'), ['index'], ['class' => 'btn btn-default']) ?>
		</div>
	</div>

<?php ActiveForm::end(); ?>
