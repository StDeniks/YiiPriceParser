<?php
/* @var $this ShopsController */
/* @var $model Shops */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'shops-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны к заполнению.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textArea($model,'title',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'domain'); ?>
		<?php echo $form->textField($model,'domain',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'domain'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'block_exp'); ?>
		<?php echo $form->textArea($model,'block_exp',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'block_exp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price_exp'); ?>
		<?php echo $form->textArea($model,'price_exp',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'price_exp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'new_price_exp'); ?>
		<?php echo $form->textArea($model,'new_price_exp',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'new_price_exp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'old_price_exp'); ?>
		<?php echo $form->textArea($model,'old_price_exp',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'old_price_exp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title_exp'); ?>
		<?php echo $form->textArea($model,'title_exp',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'title_exp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'image_exp'); ?>
		<?php echo $form->textArea($model,'image_exp',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'image_exp'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->