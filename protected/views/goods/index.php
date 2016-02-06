<?php
/* @var $this GoodsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Goods',
);

/*$this->menu=array(
	array('label'=>'Create Goods', 'url'=>array('create')),
	array('label'=>'Manage Goods', 'url'=>array('admin')),
);*/
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/highcharts.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/modules/exporting.js"></script>
<h1>Просмотр ценовой динамики</h1>
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
				day: '%e. %b',
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
			pointFormat: '{point.x:%e.%m.%Y}: {point.y:.2f} руб.'
		},
		legend: {
			enabled: false
		}
	};
</script>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'template'=>"{items}\n{pager}",
	'ajaxUpdate'=>false,
	'pager'=>array('header'=>'')
)); ?>
