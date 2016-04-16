<?php
/* @var $this GoodsController */
/* @var $model Goods */

/*$this->breadcrumbs=array(
	'Goods'=>array('index'),
	$model->title,
);
*/
if (!Yii::app()->user->isGuest) {
	$this->menu = array(
		//array('label'=>'List Goods', 'url'=>array('index')),
		//array('label'=>'Create Goods', 'url'=>array('create')),
		array('label' => 'Изменить', 'url' => array('update', 'id' => $model->id), 'linkOptions' => array('class' => "button")),
		array('label' => 'Удалить', 'url' => '#', 'linkOptions' => array('class' => "button", 'submit' => array('delete', 'id' => $model->id), 'confirm' => 'Вы действительно хотите удалить этот товар?')),
		array('label' => 'Спарсить цену', 'url' => '#', 'linkOptions' => array('class' => "button", 'submit' => array('parseprice', 'id' => $model->id))),
		//array('label'=>'Manage Goods', 'url'=>array('admin')),
	);
}
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/highcharts.js"></script>
<div class="good-placer">
	<script>
		var hicharts_settings= {
			chart: {
				type: 'spline',
				backgroundColor: 'transparent'
			},
			title: {
				text: ''
			},
			subtitle: {
				text: ''
			},
			xAxis: {
				type: 'datetime',
				dateTimeLabelFormats: { // don't display the dummy year
					millisecond: '%H:%M:%S.%L',
					second: '%H:%M:%S',
					minute: '%H:%M',
					hour: '%H:%M',
					day: '%e.%m.%Y',
					week: '%e. %m',
					month: '%b \'%y',
					year: '%Y'
				},
				title: {
					text: ''
				}
			},
			yAxis: {
				title: {
					text: ''
				},
				min: 0
			},
			tooltip: {
				headerFormat: '<b>{series.name}</b><br>',
				pointFormat: '{point.x:%e.%m.%Y %H:%M}: {point.y:.2f} руб.'
			},
			legend: {
				enabled: false
			}
		};

	</script>

</div>
<div class="good-card">
	<h2><?=$model->title?></h2>
	Магазин: <b><?=$model->shop->title?></b><br/>
	Ссылка: <b><a  href="data:text/html,&lt;html&gt;&lt;meta http-equiv=&quot;refresh&quot; content=&quot;0; url=&#039;<?=$model->url;?>&#039;&quot;&gt;&lt;/html&gt;"><?=$model->url;?></a></b><br />
	Скрыт: <b><?=($model->notshow)?"ДА":"НЕТ";?></b><br/>
	Парсинг: <b><?=($model->notparse)?"НЕТ":"ДА";?></b><br/>
	Выборка цен от <b><?=Yii::app()->utils->formatDate($model->getFirstDate())?></b> до <b><?=Yii::app()->utils->formatDate($model->getLastDate())?></b><br />
	<?if($model->aproxi):?>
		Рост цены: <b><?=round($model->aproxi[0]->infl, 2)?>%</b>
	<?endif;?>
	<script type="text/javascript">

		$(function () {
			var set = hicharts_settings;
			set.series=[{
				name: '<?=addslashes($model->title);?>',
				data: [
					<?
					if ($model->prices) {
						foreach ($model->prices as $price) {
							if (floatval($price->price) > 0) {
								echo "[{$price->getDatet(10800, 1000)}, {$price->price}],";
							}
						}
					}
					?>
				]
			},{
				name: 'Старая цена',
				type: 'scatter',
				color: 'red',
				data: [
					<?
					if ($model->prices) {
						foreach ($model->prices as $price) {
							if (floatval($price->old_price) > 0) {
								echo "[{$price->getDatet(10800, 1000)}, {$price->old_price}],";
							}
						}
					}
					?>
				]
			},
				<? if ($model->aproxi && abs($model->aproxi[0]->infl) > 1):?>
				{
					name: 'Апроксимация',
					color: 'green',
					data: [
						<?
							echo "[{$model->aproxi[0]->getDatet(0, 10800, 1000)}, {$model->aproxi[0]->y0}],";
							echo "[{$model->aproxi[0]->getDatet(1, 10800, 1000)}, {$model->aproxi[0]->yn}],";
						?>
					]
				}
				<?endif;?>
			]
			$('#plot<?=$model->id?>').highcharts(set);
		});
	</script>
	<div id="plot<?=$model->id?>" ></div>

</div>

<?php /*$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'shop.title',
		'url',
		'notshow',
		'notparse',
	),
)); */?>
