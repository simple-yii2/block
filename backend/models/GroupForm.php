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
	 * @var ActiveRecord Assigned object.
	 */
	public $object;

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();

		$this->imageWidth = 100;
		$this->imageHeight = 100;

		if (($object = $this->object) !== null) {
			$this->setAttributes($object->getAttributes(['alias', 'title', 'imageWidth', 'imageHeight']), false);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
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
			[['alias', 'title'], 'string', 'max' => 100],
			[['imageWidth', 'imageHeight'], 'integer', 'min' => 32, 'max' => 1000],
			[['alias', 'title', 'imageWidth', 'imageHeight'], 'required'],
		];
	}

	/**
	 * Creates new object using model attributes
	 * @return boolean
	 */
	public function create()
	{
		if (!$this->validate())
			return false;

		$this->object = $object = new Group([
			'alias' => $this->alias,
			'title' => $this->title,
			'imageWidth' => $this->imageWidth,
			'imageHeight' => $this->imageHeight,
		]);

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
			'alias' => $this->alias,
			'title' => $this->title,
			'imageWidth' => $this->imageWidth,
			'imageHeight' => $this->imageHeight,
		], false);

		if (!$object->save(false))
			return false;

		return true;
	}

}
