<?php

namespace cms\block\common\models;

use Yii;

use dkhlystov\storage\components\StoredInterface;

/**
 * Block active record
 */
class Block extends BaseBlock implements StoredInterface
{

    /**
     * @inheritdoc
     */
    public function __construct($config = [])
    {
        parent::__construct(array_replace([
            'active' => true,
            'url' => '#',
        ], $config));
    }

    /**
     * Find by alias
     * @param sring $alias Alias or id
     * @return Block
     */
    public static function findByAlias($alias) {
        $model = static::findOne(['alias' => $alias]);
        if ($model === null)
            $model = static::findOne(['id' => $alias]);

        return $model;
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
