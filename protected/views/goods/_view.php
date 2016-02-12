<?php
/* @var $this GoodsController */
/* @var $data Goods */
?>
<div class="good-card" id="good<?=$data->id?>">
	<div class="good-info">
		<div class="good-title"><?=CHtml::link(CHtml::encode($data->title), array('view', 'id'=>$data->id));?> <a href="#good<?=$data->id?>">#</a></div>
		<?/*Выборка цен от <b><?=$good['prices_from']?></b> до <b><?=$good['prices_to']?></b><br />*/?>
		<img src="/data/shops/<?=$data->shop_id?>/logo_50x50.png" /><br/>
		<?if(!Yii::app()->user->isGuest):?><?=CHtml::link('Изменить', array('update', 'id'=>$data->id), array('class'=>"button"));?><br/><?endif;?>
	</div>
	<script type="text/javascript">
		$(function () {
			var set = hicharts_settings;
			set.series=[{

				name: '<?=addslashes($data->title);?>',
				data: [
					<?
					foreach($data->prices as $price){
						if(intval($price['price'])>0){
							$date=$price->parseDate();
							echo "[Date.UTC({$date[0]},{$date[1]}-1,{$date[2]}), {$price->price}],";
						}
					}
					?>
				]

			}]
			$('#plot<?=$data->id?>').highcharts(set);
		});
	</script>
	<div id="plot<?=$data->id?>" class="good-price-plot"></div>
</div>

<? /*

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



</div>*/?>