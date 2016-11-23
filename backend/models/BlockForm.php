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
	 * @var string Link label
	 */
	public $linkLabel;

	/**
	 * @var \simple\blocks\common\models\Block
	 */
	private $_object;

	/**
	 * @inheritdoc
	 * @param \simple\blocks\common\models\Block $object 
	 */
	public function __construct(\simple\blocks\common\models\Block $object, $config = [])
	{
		$this->_object = $object;

		//attributes
		$this->active = $object->active == 0 ? '0' : '1';
		$this->image = $object->image;
		$this->thumb = $object->thumb;
		$this->title = $object->title;
		$this->text = $object->text;
		$this->url = $object->url;
		$this->linkLabel = $object->linkLabel;

		//file caching
		Yii::$app->storage->cacheObject($object);

		parent::__construct($config);
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
			'linkLabel' => Yii::t('blocks', 'Link label'),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['active', 'boolean'],
			[['image', 'thumb', 'url'], 'string', 'max' => 200],
			['text', 'string', 'max' => 500],
			[['title', 'linkLabel'], 'string', 'max' => 100],
			[['title', 'url'], 'required'],
			['url', 'url'],
		];
	}

	/**
	 * Save object using model attributes
	 * @return boolean
	 */
	public function save()
	{
		if (!$this->validate())
			return false;

		$object = $this->_object;

		$object->active = $this->active == 1;
		$object->image = empty($this->image) ? null : $this->image;
		$object->thumb = empty($this->thumb) ? null : $this->thumb;
		$object->title = $this->title;
		$object->text = $this->text;
		$object->url = $this->url;
		$object->linkLabel = $this->linkLabel;

		Yii::$app->storage->storeObject($object);

		if (!$object->save(false))
			return false;

		$object->group->updateBlockCount();

		return true;
	}

}
