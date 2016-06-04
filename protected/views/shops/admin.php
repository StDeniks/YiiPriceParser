<?php
/* @var $this ShopsController */
/* @var $model Shops */

$this->breadcrumbs=array(
	'Shops'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Добавить магазин', 'url'=>array('create'), 'linkOptions' => array('class' => "button")),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#shops-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="good-card">
<h1>Управление магазинами</h1>

<p>
Можно использовать операторы  (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
или <b>=</b>) в полях поиска.
</p>

<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'shops-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'cssFile'=>false,
	'columns'=>array(
		'id',
		/*array(
			'class' => 'CLinkColumn',
			'name' => 'title',
			'labelExpression' => '$data->title',
		),*/
		'title',
		'domain',
		'block_exp',
		'price_exp',
		'new_price_exp',
		/*
		'old_price_exp',
		'title_exp',
		'image_exp',
		*/
		array(
			'class'=> 'CButtonColumn',
			'template' => '{view} {update}',
			/*'viewButtonLabel' => 'Просмотр',
			'viewButtonImageUrl' => false,
			'viewButtonOptions' => array('class'=>'button'),
			'updateButtonLabel' => 'Редактировать',
			'updateButtonImageUrl' => false,
			'updateButtonOptions' => array('class'=>'button'),*/
		),
	),
)); ?>

</div>