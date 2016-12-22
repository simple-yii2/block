<?php

namespace cms\block\common\models;

use yii\db\ActiveRecord;

use Yii;
use storage\components\StoredInterface;

/**
 * Block active record
 */
class Block extends ActiveRecord implements StoredInterface
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
	public function init()
	{
		parent::init();

		$this->active = true;
		$this->url = '#';
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'title' => Yii::t('block', 'Title'),
		];
	}

	/**
	 * Group relation
	 * @return yii\db\ActiveQueryInterface
	 */
	public function getGroup()
	{
		return $this->hasOne(Group::className(), ['id' => 'group_id']);
	}

	/**
	 * Return files from attributes
	 * @param array $attributes 
	 * @return array
	 */
	private function getFilesFromAttributes($attributes)
	{
		$files = [];

		if (!empty($attributes['image']))
			$files[] = $attributes['image'];

		if (!empty($attributes['thumb']))
			$files[] = $attributes['thumb'];

		return $files;
	}

	/**
	 * @inheritdoc
	 */
	public function getOldFiles()
	{
		return $this->getFilesFromAttributes($this->getOldAttributes());
	}

	/**
	 * @inheritdoc
	 */
	public function getFiles()
	{
		return $this->getFilesFromAttributes($this->getAttributes());
	}

	/**
	 * @inheritdoc
	 */
	public function setFiles($files)
	{
		if (array_key_exists($this->image, $files))
			$this->image = $files[$this->image];

		if (array_key_exists($this->thumb, $files))
			$this->thumb = $files[$this->thumb];
	}

}
