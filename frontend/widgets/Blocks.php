<?php

namespace simple\blocks\frontend\widgets;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;

use simple\blocks\common\models;

class Blocks extends Widget
{

	/**
	 * @var string Blocks alias
	 */
	public $alias;

	/**
	 * @var array Container tag options
	 */
	public $options = ['class' => 'row'];

	/**
	 * @var string Block template
	 */
	public $itemTemplate = '{image}{title}{text}{link}';

	/**
	 * @var string Item CSS class
	 */
	public $itemCssClass = 'col-md-4';

	/**
	 * @var string Link Css class
	 */
	public $linkCssClass = 'btn btn-default';

	/**
	 * @var boolean Title encode
	 */
	public $encodeTitle = true;

	/**
	 * @var boolean Text encode
	 */
	public $encodeText = true;

	/**
	 * @var simple\common\models\Group Group model
	 */
	private $model;

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();

		if ($this->alias === null)
			throw new InvalidConfigException('Property "alias" must be set.');

		$this->model = models\Group::findByAlias($this->alias);

		if (!$this->model->active)
			$this->model = null;
	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		echo Html::beginTag('div', $this->options);

		if ($this->model !== null) {
			foreach ($this->model->blocks as $item) {
				if ($item->active)
					echo $this->renderItem($item);
			}
		}

		echo Html::endTag('div');
	}

	/**
	 * Item rendering
	 * @param \simple\blocks\common\models\Block $item 
	 * @return string
	 */
	protected function renderItem($item)
	{
		$replace = [
			'{image}' => $this->renderImage($item),
			'{title}' => $this->renderTitle($item),
			'{text}' => $this->renderText($item),
			'{link}' => $this->renderLink($item),
		];

		return Html::tag('div', strtr($this->itemTemplate, $replace), [
			'class' => $this->itemCssClass,
		]);
	}

	/**
	 * Image rendering
	 * @param \simple\blocks\common\models\Block $item 
	 * @return string
	 */
	protected function renderImage($item)
	{
		$title = strip_tags($item->title);

		$image = Html::img($item->thumb, [
			'alt' => $title,
			'title' => $title,
		]);

		return Html::tag('div', $image, ['class' => 'block-image']);
	}

	/**
	 * Title rendering
	 * @param \simple\blocks\common\models\Block $item 
	 * @return string
	 */
	protected function renderTitle($item)
	{
		$title = $item->title;

		if ($this->encodeTitle)
			$title = Html::encode($title);

		return Html::tag('div', $title, ['class' => 'block-title h1']);
	}

	/**
	 * Text rendering
	 * @param \simple\blocks\common\models\Block $item 
	 * @return string
	 */
	protected function renderText($item)
	{
		$text = $item->text;

		if ($this->encodeText)
			$text = Html::encode($text);

		return Html::tag('p', $text, ['class' => 'block-text']);
	}

	/**
	 * Link rendering
	 * @param \simple\blocks\common\models\Block $item 
	 * @return string
	 */
	protected function renderLink($item)
	{
		$options = [];
		Html::addCssClass($options, $this->linkCssClass);

		$label = Html::encode($item->linkLabel);
		if (empty($label))
			$label = strip_tags($item->title) . ' &raquo;';

		return Html::a($label, $item->url, $options);
	}

}
