<?php

namespace cms\block\frontend\widgets;

use yii\base\InvalidConfigException;
use yii\data\ArrayDataProvider;
use yii\helpers\Html;
use yii\widgets\ListView;

use cms\block\common\models\Group;

class Blocks extends ListView
{

	/**
	 * @var string Blocks alias
	 */
	public $alias;

	/**
	 * @inheritdoc
	 */
	public $layout = '{items}';

	/**
	 * @inheritdoc
	 */
	public $itemOptions = ['class' => 'col-md-4'];

	/**
	 * @inheritdoc
	 */
	public $options = ['class' => 'row'];

	/**
	 * @inheritdoc
	 */
	public $emptyText = '';

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		if ($this->alias === null)
			throw new InvalidConfigException('The "alias" property must be set.');

		$this->prepareDataProvider();

		if ($this->itemView === null)
			$this->prepareItemView();

		parent::init();
	}

	/**
	 * Preparing data provider
	 * @return void
	 */
	private function prepareDataProvider()
	{
		$blocks = [];

		$group = Group::findByAlias($this->alias);
		if ($group !== null && $group->active) {
			foreach ($group->blocks as $block) {
				if ($block->active)
					$blocks[] = $block;
			}
		}

		$this->dataProvider = new ArrayDataProvider([
			'allModels' => $blocks,
			'pagination' => false,
		]);
	}

	/**
	 * Preparing item view function
	 * @return void
	 */
	private function prepareItemView()
	{
		$this->itemView = function($model, $key, $index, $widget) {
			$image = '';
			if (!empty($model->thumb)) {
				$image = Html::img($model->thumb, ['alt' => $model->title]);
				$image = Html::tag('div', $image);
			}

			$title = Html::tag('h2', Html::encode($model->title));

			$lead = '';
			if (!empty($model->lead))
				$lead = Html::tag('p', Html::encode($model->lead), ['class' => 'lead']);

			$text = '';
			if (!empty($model->text))
				$text = Html::tag('p', Html::encode($model->text));

			$label = empty($model->linkLabel) ? Html::encode($model->title) . '&nbsp;&raquo;' : Html::encode($model->linkLabel);
			$link = Html::a($label, $model->url, ['class' => 'btn btn-default']);
			$link = Html::tag('p', $link);

			return $image . $title . $lead . $text . $link;
		};
	}

}
