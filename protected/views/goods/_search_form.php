<?php
/* @var $this GoodsController */
/* @var $model Goods */
/* @var $form CActiveForm */
?>

<div class="form">


	<?php
	$shops = Shops::model()->findAll(array('select'=>"id, title"));
	?>

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'goods-form',
		'method' => 'get',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
	)); ?>


	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textArea($model,'title',array('rows'=>3, 'cols'=>50)); ?>
		<?php echo $form->error($model,'title'); ?>
		<?php// echo CHtml::ajaxButton('Спарсить заголовок', array('parsetitle','id'=>$model->id), array('success' => 'function(res){$("[name=\'Goods[title]\']").val(res)}')); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'shop_id'); ?>
		<?php echo $form->dropDownList($model, "shop_id", CHtml::listData($shops, 'id', 'title')); ?>
		<?php echo $form->error($model,'shop_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('class'=> 'long-input active')); ?>
		<?php echo $form->error($model,'url'); ?>
	</div>

	<? /*<div class="row">
		<?php echo $form->labelEx($model,'notshow'); ?>
		<?php echo $form->checkBox($model,'notshow'); ?>
		<?php echo $form->error($model,'notshow'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'notparse'); ?>
		<?php echo $form->checkBox($model,'notparse'); ?>
		<?php echo $form->error($model,'notparse'); ?>
	</div>
 */ ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Найти', array('class' => 'button')); ?>
	</div>

	<?php $this->endWidget(); ?>

</div><!-- form -->