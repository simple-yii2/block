<?php

namespace simple\blocks\backend\models;

use Yii;
use yii\base\Model;

use simple\blocks\common\models\Block;

/**
 * Block editing form
 */
class BlockForm extends Model
{

	/**
	 * @var boolean Active
	 */
	public $active;

	/**
	 * @var string Image
	 */
	public $image;

	/**
	 * @var string Image thumb
	 */
	public $thumb;

	/**
	 * @var string Title
	 */
	public $title;

	/**
	 * @var string Text
	 */
	public $text;

	/**
	 * @var string Url
	 */
	public $url;

	/**
	 * @var ActiveRecord Assigned object.
	 */
	public $object;

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();

		//default
		$this->active = true;

		if (($object = $this->object) !== null) {
			$this->setAttributes($object->getAttributes(['active', 'image', 'thumb', 'title', 'text', 'url']), false);

			Yii::$app->storage->cacheObject($object);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'active' => Yii::t('blocks', 'Active'),
			'image' => Yii::t('blocks', 'Image'),
			'title' => Yii::t('blocks', 'Title'),
			'text' => Yii::t('blocks', 'Text'),
			'url' => Yii::t('blocks', 'Url'),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['active', 'boolean'],
			[['image', 'thumb', 'text', 'url'], 'string', 'max' => 200],
			[['title'], 'string', 'max' => 100],
			['title', 'required'],
			['url', 'url'],
		];
	}

	/**
	 * Creates new object using model attributes
	 * @param simple\blocks\common\models\Group $group Parent block group
	 * @return boolean
	 */
	public function create($group)
	{
		if (!$this->validate())
			return false;

		$this->object = $object = new Block([
			'group_id' => $group->id,
			'active' => (boolean) $this->active,
			'image' => empty($this->image) ? null : $this->image,
			'thumb' => empty($this->thumb) ? null : $this->thumb,
			'title' => $this->title,
			'text' => $this->text,
			'url' => $this->url,
		]);

		Yii::$app->storage->storeObject($object);

		if (!$object->save(false))
			return false;

		return true;
	}

	/**
	 * Object updating
	 * @return boolean
	 */
	public function update() {
		if ($this->object === null)
			return false;

		if (!$this->validate())
			return false;

		$object = $this->object;

		$object->setAttributes([
			'active' => (boolean) $this->active,
			'image' => empty($this->image) ? null : $this->image,
			'thumb' => empty($this->thumb) ? null : $this->thumb,
			'title' => $this->title,
			'text' => $this->text,
			'url' => $this->url,
		], false);

		Yii::$app->storage->storeObject($object);

		if (!$object->save(false))
			return false;

		return true;
	}

}
