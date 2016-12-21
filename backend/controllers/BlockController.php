<?php

namespace cms\block\backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

use cms\block\backend\models\BlockForm;
use cms\block\common\models\Group;
use cms\block\common\models\Block;

/**
 * Blocks manage controller
 */
class BlockController extends Controller
{

	/**
	 * Access control
	 * @return array
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
	 * List
	 * @param integer $group_id
	 * @return void
	 */
	public function actionIndex($group_id)
	{
		$group = Group::findOne($group_id);
		if ($group === null)
			throw new BadRequestHttpException(Yii::t('block', 'Group not found.'));

		$dataProvider = new ActiveDataProvider([
			'query' => $group->getBlocks(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'group' => $group,
		]);
	}

	/**
	 * Creating
	 * @return void
	 */
	public function actionCreate($group_id)
	{
		$group = Group::findOne($group_id);
		if ($group === null)
			throw new BadRequestHttpException(Yii::t('block', 'Group not found.'));

		$object = new Block(['group_id' => $group->id]);

		$model = new BlockForm($object);

		if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
			Yii::$app->session->setFlash('success', Yii::t('block', 'Changes saved successfully.'));
			return $this->redirect(['index', 'group_id' => $group->id]);
		}

		return $this->render('create', [
			'model' => $model,
			'group' => $group,
		]);
	}

	/**
	 * Updating
	 * @param integer $id
	 * @return void
	 */
	public function actionUpdate($id)
	{
		$object = Block::findOne($id);
		if ($object === null)
			throw new BadRequestHttpException(Yii::t('block', 'Block not found.'));

		$group = $object->group;
		if ($group === null)
			throw new BadRequestHttpException(Yii::t('block', 'Group not found.'));

		$model = new BlockForm($object);

		if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
			Yii::$app->session->setFlash('success', Yii::t('block', 'Changes saved successfully.'));
			return $this->redirect(['index', 'group_id' => $group->id]);
		}

		return $this->render('update', [
			'model' => $model,
			'group' => $group,
		]);
	}

	/**
	 * Deleting
	 * @param integer $id
	 * @return void
	 */
	public function actionDelete($id)
	{
		$object = Block::findOne($id);
		if ($object === null)
			throw new BadRequestHttpException(Yii::t('block', 'Block not found.'));

		$group = $object->group;
		if ($group === null)
			throw new BadRequestHttpException(Yii::t('block', 'Group not found.'));

		if ($object->delete()) {
			Yii::$app->storage->removeObject($object);
			
			Yii::$app->session->setFlash('success', Yii::t('block', 'Block deleted successfully.'));
		}

		$group->updateBlockCount();

		return $this->redirect(['index', 'group_id' => $group->id]);
	}

}
