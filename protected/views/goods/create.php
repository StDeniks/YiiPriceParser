<?php
/* @var $this GoodsController */
/* @var $model Goods */

$this->breadcrumbs=array(
	'Goods'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'На главную', 'url'=>array('index')),
	/*array('label'=>'Manage Goods', 'url'=>array('admin')),*/
);
?>


<div class="good-card">
<h1>Добавить товар</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>