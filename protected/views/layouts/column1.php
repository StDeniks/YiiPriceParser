<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div id="content">
	<?php echo $content; ?>
</div><!-- content -->


<div id="sidebar">
	<?php
	$this->beginWidget('zii.widgets.CPortlet', array(
		'title'=>'',
	));
	$this->widget('zii.widgets.CMenu', array(
		'items'=>$this->menu,
		'htmlOptions'=>array('class'=>'operations'),
	));
	$this->endWidget();
	?>
	<div class="clear"></div>
</div><!-- sidebar -->

<?php $this->endContent(); ?>