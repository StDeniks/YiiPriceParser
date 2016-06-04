<?php
/* @var $this ShopsController */
/* @var $model Shops */

$this->breadcrumbs=array(
	'Shops'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Страница магазина', 'url'=>array('view', 'id'=>$model->id), 'linkOptions' => array('class' => "button")),
	array('label'=>'Удалить магазин', 'url'=>'#', 'linkOptions'=>array('class' => "button", 'submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы дефствительно хотите удалить магазин?')),

);
?>
<div class="good-card">
<h1>Редактирование магазина №<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>