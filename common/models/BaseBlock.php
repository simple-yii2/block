<?php

namespace cms\block\common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

use creocoder\nestedsets\NestedSetsBehavior;
use creocoder\nestedsets\NestedSetsQueryBehavior;

class BaseBlock extends ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'Block';
	}

	/**
	 * @inheritdoc
	 */
	public static function instantiate($row)
	{
		if ($row['depth'] == 0)
			return new Group;

		return new Block;
	}

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'tree' => [
				'class' => NestedSetsBehavior::className(),
				'treeAttribute' => 'tree',
			],
		];
	}

	/**
	 * @inheritdoc
	 */
	public static function find()
	{
		return new BlockQuery(get_called_class());
	}

}

class BlockQuery extends ActiveQuery
{

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			NestedSetsQueryBehavior::className(),
		];
	}

}
