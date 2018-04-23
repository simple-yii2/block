<?php

namespace cms\block\common\models;

/**
 * Blocks group active record
 */
class Group extends BaseBlock
{

    /**
     * @inheritdoc
     */
    public function __construct($config = [])
    {
        parent::__construct(array_replace([
            'active' => true,
            'enableAlias' => false,
            'enableImage' => false,
            'enableLead' => false,
            'enableText' => false,
            'enableLink' => false,
            'imageWidth' => 100,
            'imageHeight' => 100,
        ], $config));
    }

    /**
     * Blocks
     * @return Block[]
     */
    public function getBlocks()
    {
        return $this->children()->all();
    }

    /**
     * Find by alias
     * @param sring $alias Alias or id
     * @return Group
     */
    public static function findByAlias($alias) {
        $model = static::findOne(['alias' => $alias]);
        if ($model === null)
            $model = static::findOne(['id' => $alias]);

        return $model;
    }

}
