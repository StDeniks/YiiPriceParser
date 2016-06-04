<?php
/* @var $this ShopsController */
/* @var $data Shops */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('domain')); ?>:</b>
	<?php echo CHtml::encode($data->domain); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('block_exp')); ?>:</b>
	<?php echo CHtml::encode($data->block_exp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price_exp')); ?>:</b>
	<?php echo CHtml::encode($data->price_exp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('new_price_exp')); ?>:</b>
	<?php echo CHtml::encode($data->new_price_exp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('old_price_exp')); ?>:</b>
	<?php echo CHtml::encode($data->old_price_exp); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('title_exp')); ?>:</b>
	<?php echo CHtml::encode($data->title_exp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('image_exp')); ?>:</b>
	<?php echo CHtml::encode($data->image_exp); ?>
	<br />

	*/ ?>

</div>