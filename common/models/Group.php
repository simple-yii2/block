<?php

namespace simple\blocks\common\models;

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
	 * Blocks relation
	 * @return yii\db\ActiveQueryInterface
	 */
	public function getBlocks()
	{
		return $this->hasMany(Block::className(), ['group_id' => 'id'])->inverseOf('group');
	}

}
