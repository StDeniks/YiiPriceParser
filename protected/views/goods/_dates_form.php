<?php
/* @var $this GoodsController */
/* @var $model Goods */
/* @var $form CActiveForm */
?>

<div class="form">
Показать цены
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
	$aproxi_model= new Aproxi();
	
	
	?>


	<?php  echo $form->errorSummary($aproxi_model); ?>

	От
	<div class="row">
		<?php echo $form->labelEx($aproxi_model, 'date'); ?>
		<?php echo $form->dateField($aproxi_model, 'date',); ?>
		<?php echo $form->error($aproxi_model, 'date'); ?>
		<?php // echo CHtml::ajaxButton('Спарсить заголовок', array('parsetitle','id'=>$model->id), array('success' => 'function(res){$("[name=\'Goods[title]\']").val(res)}')); ?>
	</div>
	До
	<? /*
	<div class="row">
		<?php echo $form->labelEx($model,'shop_id'); ?>
		<?php echo $form->dropDownList($model, "shop_id", CHtml::listData($shops, 'id', 'title'), array('prompt'=>'Все магазины')); ?>
		<?php echo $form->error($model,'shop_id'); ?>
	</div>
	
	<? */?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Найти', array('class' => 'button')); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->