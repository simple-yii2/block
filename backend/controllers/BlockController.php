<?php

namespace cms\block\backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

use cms\block\common\models\Group;
use cms\block\common\models\Block;
use cms\block\backend\models\BlockForm;

class BlockController extends Controller
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
	 * Creating
	 * @param integer $id
	 * @return string
	 */
	public function actionCreate($id)
	{
		$parent = Group::findOne($id);
		if ($parent === null)
			throw new BadRequestHttpException(Yii::t('block', 'Item not found.'));

		$model = new BlockForm;

		if ($model->load(Yii::$app->getRequest()->post()) && $model->save($parent)) {
			Yii::$app->session->setFlash('success', Yii::t('block', 'Changes saved successfully.'));
			return $this->redirect([
				'group/index',
				'id' => $model->getObject()->id,
			]);
		}

		return $this->render('create', [
			'model' => $model,
			'id' => $id,
			'parent' => $parent,
		]);
	}

	/**
	 * Updating
	 * @param string $id
	 * @return void
	 */
	public function actionUpdate($id)
	{
		$object = Block::findOne($id);
		if ($object === null || $object->isRoot())
			throw new BadRequestHttpException(Yii::t('block', 'Item not found.'));

		$model = new BlockForm($object);

		if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
			Yii::$app->session->setFlash('success', Yii::t('block', 'Changes saved successfully.'));
			return $this->redirect([
				'group/index',
				'id' => $model->getObject()->id,
			]);
		}

		return $this->render('update', [
			'model' => $model,
			'id' => $object->id,
			'parent' => $object->parents(1)->one(),
		]);
	}

	/**
	 * Deleting
	 * @param string $id
	 * @return void
	 */
	public function actionDelete($id)
	{
		$object = Block::findOne($id);
		if ($object === null || $object->isRoot())
			throw new BadRequestHttpException(Yii::t('block', 'Item not found.'));

		$sibling = $object->prev()->one();
		if ($sibling === null)
			$sibling = $object->next()->one();

		if ($object->deleteWithChildren()) {
			Yii::$app->storage->removeObject($object);

			Yii::$app->session->setFlash('success', Yii::t('block', 'Item deleted successfully.'));
		}

		return $this->redirect(['group/index', 'id' => $sibling ? $sibling->id : null]);
	}

}
