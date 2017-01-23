<?php

namespace cms\block\backend\models;

use Yii;
use yii\base\Model;

use cms\block\common\models\Group;

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
	 * @var Group
	 */
	private $_object;

	/**
	 * @inheritdoc
	 * @param Group|null $object 
	 */
	public function __construct(Group $object = null, $config = [])
	{
		if ($object === null)
			$object = new Group;

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
	 * Object getter
	 * @return Group
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
			'alias' => Yii::t('block', 'Alias'),
			'title' => Yii::t('block', 'Title'),
			'imageWidth' => Yii::t('block', 'Image width'),
			'imageHeight' => Yii::t('block', 'Image height'),
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
		$object->imageHeight = (integer) $this->imageHeight;

		//saving object
		if ($object->getIsNewRecord()) {
			if (!$object->makeRoot(false))
				return false;
		} else {
			if (!$object->save(false))
				return false;
		}

		return true;
	}

}
