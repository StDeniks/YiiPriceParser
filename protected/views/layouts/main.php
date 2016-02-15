<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="top-menu">

	<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'На главную', 'url'=>array('/goods/index')),
				array('label'=>'Добавить', 'url'=>array('create'), 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'Войти', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Выйти ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>

	<div class="search-form">
		<form action="/goods/search">
			<input name="Goods[title]" type="text" />
			<input type="submit" value="Найти"/>
		</form>
	</div>


</div>
<div class="menu-buff"></div>

<div class="content">
	<?php echo $content; ?>
</div>

</body>
</html>
