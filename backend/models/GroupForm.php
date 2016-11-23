<?php

namespace simple\blocks\backend\models;

use Yii;
use yii\base\Model;

use simple\blocks\common\models\Group;

/**
 * Block group editing form
 */
class GroupForm extends Model
{

	/**
	 * @var boolean Active
	 */
	public $active;

	/**
	 * @var string Alias
	 */
	public $alias;

	/**
	 * @var string Title
	 */
	public $title;

	/**
	 * @var integer Block image width
	 */
	public $imageWidth;

	/**
	 * @var integer Block image height
	 */
	public $imageHeight;

	/**
	 * @var \simple\blocks\common\models\Group
	 */
	private $_object;

	/**
	 * @inheritdoc
	 * @param \simple\blocks\common\models\Group $object 
	 */
	public function __construct(\simple\blocks\common\models\Group $object, $config = [])
	{
		$this->_object = $object;

		//attributes
		$this->active = $object->active == 0 ? '0' : '1';
		$this->alias = $object->alias;
		$this->title = $object->title;
		$this->imageWidth = $object->imageWidth;
		$this->imageHeight = $object->imageHeight;

		parent::__construct($config);
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'active' => Yii::t('blocks', 'Active'),
			'alias' => Yii::t('blocks', 'Alias'),
			'title' => Yii::t('blocks', 'Title'),
			'imageWidth' => Yii::t('blocks', 'Image width'),
			'imageHeight' => Yii::t('blocks', 'Image height'),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['active', 'boolean'],
			[['alias', 'title'], 'string', 'max' => 100],
			[['imageWidth', 'imageHeight'], 'integer', 'min' => 32, 'max' => 1000],
			[['alias', 'imageWidth', 'imageHeight'], 'required'],
		];
	}

	/**
	 * Block count getter
	 * @return integer
	 */
	public function getBlockCount()
	{
		return $this->_object->blockCount;
	}

	/**
	 * Saving object using model attributes
	 * @return boolean
	 */
	public function save()
	{
		if (!$this->validate())
			return false;

		$object = $this->_object;

		$object->active = $this->active == 1;
		$object->alias = $this->alias;
		$object->title = $this->title;
		$object->imageWidth = (integer) $this->imageWidth;
		$object->imageWidth = (integer) $this->imageWidth;

		if (!$object->save(false))
			return false;

		return true;
	}

}
