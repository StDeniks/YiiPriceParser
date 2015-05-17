<?php
/* @var $this GoodsController */
/* @var $data Goods */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('shop.title')); ?>:</b>
	<?php echo CHtml::encode($data->shop->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('url')); ?>:</b>
	<?php echo CHtml::encode($data->url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notshow')); ?>:</b>
	<?php echo CHtml::encode($data->notshow); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('notparse')); ?>:</b>
	<?php echo CHtml::encode($data->notparse); ?>
	<br />



</div>