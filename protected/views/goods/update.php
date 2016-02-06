<?php
/* @var $this GoodsController */
/* @var $model Goods */


$this->breadcrumbs=array(
	'Goods'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Goods', 'url'=>array('index')),
	//array('label'=>'Create Goods', 'url'=>array('create')),
	array('label'=>'Страница товара', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Goods', 'url'=>array('admin')),
);
?>

<div class="good-card">
<h1>Редактирование товара #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>