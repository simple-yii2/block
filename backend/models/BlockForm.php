<?php

namespace cms\block\backend\models;

use Yii;
use yii\base\Model;

use cms\block\common\models\Block;

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
	 * @var string Lead
	 */
	public $lead;

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
	 * @var cms\block\common\models\Block
	 */
	private $_object;

	/**
	 * @inheritdoc
	 * @param cms\block\common\models\Block $object 
	 */
	public function __construct(\cms\block\common\models\Block $object, $config = [])
	{
		$this->_object = $object;

		//attributes
		$this->active = $object->active == 0 ? '0' : '1';
		$this->image = $object->image;
		$this->thumb = $object->thumb;
		$this->title = $object->title;
		$this->lead = $object->lead;
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
			'active' => Yii::t('block', 'Active'),
			'image' => Yii::t('block', 'Image'),
			'title' => Yii::t('block', 'Title'),
			'lead' => Yii::t('block', 'Lead'),
			'text' => Yii::t('block', 'Text'),
			'url' => Yii::t('block', 'Url'),
			'linkLabel' => Yii::t('block', 'Link label'),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['active', 'boolean'],
			[['image', 'thumb', 'url', 'lead'], 'string', 'max' => 200],
			['text', 'string', 'max' => 500],
			[['title', 'linkLabel'], 'string', 'max' => 100],
			[['title', 'url'], 'required'],
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
		$object->lead = $this->lead;
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
