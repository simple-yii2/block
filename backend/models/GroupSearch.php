<?php

namespace cms\block\backend\models;

use Yii;
use yii\data\ActiveDataProvider;

use cms\block\common\models\Group;

/**
 * Group search model
 */
class GroupSearch extends Group {

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			['title', 'string'],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'title' => Yii::t('block', 'Title'),
		];
	}

	/**
	 * Search function
	 * @param array $params Attributes array
	 * @return yii\data\ActiveDataProvider
	 */
	public function search($params) {
		//ActiveQuery
		$query = static::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		//return data provider if no search
		if (!($this->load($params) && $this->validate()))
			return $dataProvider;

		//search
		$query->andFilterWhere(['like', 'title', $this->title]);

		return $dataProvider;
	}

}
