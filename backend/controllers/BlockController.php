<?php

namespace simple\blocks\backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

use simple\blocks\backend\models\BlockForm;
use simple\blocks\common\models\Group;
use simple\blocks\common\models\Block;

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
					['allow' => true, 'roles' => ['Blocks']],
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
			throw new BadRequestHttpException(Yii::t('blocks', 'Group not found.'));

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
			throw new BadRequestHttpException(Yii::t('blocks', 'Group not found.'));

		$object = new Block(['group_id' => $group->id]);

		$model = new BlockForm($object);

		if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
			Yii::$app->session->setFlash('success', Yii::t('blocks', 'Changes saved successfully.'));
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
			throw new BadRequestHttpException(Yii::t('blocks', 'Block not found.'));

		$group = $object->group;
		if ($group === null)
			throw new BadRequestHttpException(Yii::t('blocks', 'Group not found.'));

		$model = new BlockForm($object);

		if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
			Yii::$app->session->setFlash('success', Yii::t('blocks', 'Changes saved successfully.'));
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
			throw new BadRequestHttpException(Yii::t('blocks', 'Block not found.'));

		$group = $object->group;
		if ($group === null)
			throw new BadRequestHttpException(Yii::t('blocks', 'Group not found.'));

		if ($object->delete()) {
			Yii::$app->storage->removeObject($object);
			
			Yii::$app->session->setFlash('success', Yii::t('blocks', 'Block deleted successfully.'));
		}

		$group->updateBlockCount();

		return $this->redirect(['index', 'group_id' => $group->id]);
	}

}
