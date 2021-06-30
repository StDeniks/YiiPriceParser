<?php
/* @var $this GoodsController */
/* @var $model Goods */
/* @var $prices_model Prices */
/* @var $form CActiveForm */
?>

<div class="form">
Показать цены:
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'date-form',
		'method' => 'get',
		'action'=> Yii::app()->createUrl('/goods/view', array('id'=>$model->id)),
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
	)); 
	
	if ($model->getFirstDate()) {
		$prices_model->date_start = $model->getFirstDate();
	}
	if ($model->getLastDate()) {
		$prices_model->date_end = $model->getLastDate();
	}
	
	?>


	<?php  echo $form->errorSummary($prices_model); ?>

	<div class="row">
		<?php echo $form->labelEx($prices_model, 'date_start'); ?>
		<?php echo $form->dateField($prices_model, 'date_start'); ?>
		<?php echo $form->error($prices_model, 'date_start'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($prices_model, 'date_end'); ?>
		<?php echo $form->dateField($prices_model, 'date_end'); ?>
		<?php echo $form->error($prices_model, 'date_end'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Показать', array('class' => 'button', 'name'=>'go')); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->