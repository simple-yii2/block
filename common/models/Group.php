<?php

namespace cms\block\common\models;

use yii\db\ActiveRecord;

/**
 * Blocks group active record
 */
class Group extends ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'BlockGroup';
	}

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();

		$this->active = true;
		$this->imageWidth = 100;
		$this->imageHeight = 100;
		$this->blockCount = 0;
	}

	/**
	 * Blocks relation
	 * @return yii\db\ActiveQueryInterface
	 */
	public function getBlocks()
	{
		return $this->hasMany(Block::className(), ['group_id' => 'id'])->inverseOf('group');
	}

	/**
	 * Find by alias
	 * @param sring $alias Alias or id
	 * @return Group
	 */
	public static function findByAlias($alias) {
		$model = static::findOne(['alias' => $alias]);
		if ($model === null)
			$model = static::findOne(['id' => $alias]);

		return $model;
	}

	/**
	 * Updates block count
	 * @return void
	 */
	public function updateBlockCount()
	{
		$this->blockCount = $this->getBlocks()->count();
		$this->update(false, ['blockCount']);
	}

}
