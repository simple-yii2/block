<?php

namespace cms\block\backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

use cms\block\backend\models\GroupForm;
use cms\block\common\models\BaseBlock;
use cms\block\common\models\Group;

class GroupController extends Controller
{

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					['allow' => true, 'roles' => ['Block']],
				],
			],
		];
	}

	/**
	 * Tree
	 * @param integer|null $id Initial item id
	 * @return string
	 */
	public function actionIndex($id = null)
	{
		$initial = BaseBlock::findOne($id);

		$dataProvider = new ActiveDataProvider([
			'query' => BaseBlock::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'initial' => $initial,
		]);
	}

	/**
	 * Creating
	 * @return void
	 */
	public function actionCreate()
	{
		$model = new GroupForm;

		if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
			Yii::$app->session->setFlash('success', Yii::t('block', 'Changes saved successfully.'));
			return $this->redirect(['index']);
		}

		return $this->render('create', [
			'model' => $model,
		]);
	}

	/**
	 * Updating
	 * @param integer $id
	 * @return void
	 */
	public function actionUpdate($id)
	{
		$object = Group::findOne($id);
		if ($object === null)
			throw new BadRequestHttpException(Yii::t('block', 'Item not found.'));

		$model = new GroupForm($object);

		if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
			Yii::$app->session->setFlash('success', Yii::t('block', 'Changes saved successfully.'));
			return $this->redirect(['index']);
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * Deleting
	 * @param integer $id
	 * @return void
	 */
	public function actionDelete($id)
	{
		$object = Group::findOne($id);
		if ($object === null || !$object->isRoot())
			throw new BadRequestHttpException(Yii::t('block', 'Item not found.'));

		//blocks
		foreach ($object->blocks as $block) {
			$block->deleteWithChildren();
			Yii::$app->storage->removeObject($block);
		}

		//object
		if ($object->deleteWithChildren())
			Yii::$app->session->setFlash('success', Yii::t('block', 'Item deleted successfully.'));

		return $this->redirect(['index']);
	}

	/**
	 * Move
	 * @param integer $id 
	 * @param integer $target 
	 * @param integer $position 
	 * @return string
	 */
	public function actionMove($id, $target, $position)
	{
		$object = BaseBlock::findOne($id);
		if ($object === null)
			throw new BadRequestHttpException(Yii::t('block', 'Item not found.'));
		if ($object->isRoot())
			return;

		$t = BaseBlock::findOne($target);
		if ($t === null)
			throw new BadRequestHttpException(Yii::t('block', 'Item not found.'));
		if ($t->isRoot())
			return;

		if ($object->tree != $t->tree)
			return;

		switch ($position) {
			case 0:
				$object->insertBefore($t);
				break;
			
			case 2:
				$object->insertAfter($t);
				break;
		}
	}

}
