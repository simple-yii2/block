<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<?php $form = ActiveForm::begin([
	'layout' => 'horizontal',
	'enableClientValidation' => false,
	'options' => ['class' => 'group-form'],
]); ?>

	<?= $form->field($model, 'alias') ?>

	<?= $form->field($model, 'title') ?>

	<?= $form->field($model, 'imageWidth') ?>

	<?= $form->field($model, 'imageHeight') ?>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-6">
			<?= Html::submitButton(Yii::t('blocks', 'Save'), ['class' => 'btn btn-primary']) ?>
			<?= Html::a(Yii::t('blocks', 'Cancel'), ['index'], ['class' => 'btn btn-default']) ?>
		</div>
	</div>

<?php ActiveForm::end(); ?>
