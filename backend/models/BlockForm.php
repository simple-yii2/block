<?php

namespace cms\block\backend\models;

use Yii;
use yii\base\Model;

use cms\block\common\models\Block;
use cms\block\common\models\Group;

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
	 * @var Block
	 */
	private $_object;

	/**
	 * @inheritdoc
	 * @param Block|null $object 
	 */
	public function __construct(Block $object = null, $config = [])
	{
		if ($object === null)
			$object = new Block;

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
	 * Object getter
	 * @return Block
	 */
	public function getObject()
	{
		return $this->_object;
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
	 * Object saving
	 * @param Group|null $parent 
	 * @return boolean
	 */
	public function save(Group $parent = null)
	{
		if (!$this->validate())
			return false;

		$object = $this->_object;

		//attributes
		$object->active = $this->active == 1;
		$object->image = empty($this->image) ? null : $this->image;
		$object->thumb = empty($this->thumb) ? null : $this->thumb;
		$object->title = $this->title;
		$object->lead = $this->lead;
		$object->text = $this->text;
		$object->url = $this->url;
		$object->linkLabel = $this->linkLabel;

		//files
		Yii::$app->storage->storeObject($object);

		//saving object
		if ($object->getIsNewRecord()) {
			if (!$object->appendTo($parent, false))
				return false;
		} else {
			if (!$object->save(false))
				return false;
		}

		return true;
	}

}
