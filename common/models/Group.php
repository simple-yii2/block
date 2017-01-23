<?php

namespace cms\block\common\models;

/**
 * Blocks group active record
 */
class Group extends BaseBlock
{

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();

		if ($this->active === null)
			$this->active = true;

		if ($this->imageWidth === null)
			$this->imageWidth = 100;

		if ($this->imageHeight === null)
			$this->imageHeight = 100;
	}

	/**
	 * Blocks
	 * @return Block[]
	 */
	public function getBlocks()
	{
		return $this->children()->all();
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

}
