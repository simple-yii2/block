<?php

namespace cms\block\backend\forms;

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
     * @var boolean
     */
    public $enableAlias;

    /**
     * @var boolean
     */
    public $enableImage;

    /**
     * @var boolean
     */
    public $enableLead;

    /**
     * @var boolean
     */
    public $enableText;

    /**
     * @var boolean
     */
    public $enableLink;

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

        parent::__construct(array_replace([
            'active' => $object->active == 0 ? '0' : '1',
            'alias' => $object->alias,
            'title' => $object->title,
            'enableAlias' => $object->enableAlias == 0 ? '0' : '1',
            'enableImage' => $object->enableImage == 0 ? '0' : '1',
            'enableLead' => $object->enableLead == 0 ? '0' : '1',
            'enableText' => $object->enableText == 0 ? '0' : '1',
            'enableLink' => $object->enableLink == 0 ? '0' : '1',
            'imageWidth' => $object->imageWidth,
            'imageHeight' => $object->imageHeight,
        ], $config));
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
            'enableAlias' => Yii::t('block', 'Enable alias'),
            'enableImage' => Yii::t('block', 'Enable image'),
            'enableLead' => Yii::t('block', 'Enable lead'),
            'enableText' => Yii::t('block', 'Enable text'),
            'enableLink' => Yii::t('block', 'Enable link'),
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
            [['enableAlias', 'enableImage', 'enableLead', 'enableText', 'enableLink'], 'boolean'],
            [['imageWidth', 'imageHeight'], 'integer', 'min' => 32, 'max' => 1000],
            [['alias', 'title', 'enableAlias', 'enableImage', 'enableLead', 'enableText', 'enableLink', 'imageWidth', 'imageHeight'], 'required'],
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
        $object->enableAlias = $this->enableAlias == 1;
        $object->enableImage = $this->enableImage == 1;
        $object->enableLead = $this->enableLead == 1;
        $object->enableText = $this->enableText == 1;
        $object->enableLink = $this->enableLink == 1;
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
