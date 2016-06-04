<?php
/* @var $this ShopsController */
/* @var $model Shops */

$this->breadcrumbs=array(
	'Shops'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Shops', 'url'=>array('index')),
	array('label'=>'Manage Shops', 'url'=>array('admin')),
);
?>

<h1>Create Shops</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>