<?php
/* @var $this ShopsController */
/* @var $model Shops */

$this->breadcrumbs=array(
	'Shops'=>array('index'),
	$model->title,
);

$this->menu=array(
	/*array('label'=>'List Shops', 'url'=>array('index')),
	array('label'=>'Create Shops', 'url'=>array('create')),*/
	array('label'=>'Редактировать', 'url'=>array('update', 'id'=>$model->id), 'linkOptions' => array('class' => "button")),
	array('label'=>'Управление магазинами', 'url'=>array('admin'), 'linkOptions' => array('class' => "button")),
);
?>
<div class="good-card">
<h1>Магазин #<?php echo $model->id; ?></h1>
<?=Yii::app()->easyImage->thumbOf($model->getImagePath(), array('resize' => array('width' => 100, 'height' => 100)));?>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'cssFile'=>false,
	'attributes'=>array(
		'id',
		'title',
		'domain',
		'block_exp',
		'price_exp',
		'new_price_exp',
		'old_price_exp',
		'title_exp',
		'image_exp',
	),
)); ?>
</div>