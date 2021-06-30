<?php

class GoodsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view', 'search'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'parseprice', 'parsetitle', 'loadimage'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$prices_model = new Prices('data_range');
		$prices_model->attributes=$_GET['Prices'];
		$prices_model->validate();
		//$start = date("Y-m-d", (time()-31622400-24*60*60));
		//$end = date("Y-m-d", (time()-2*24*60*60));
		//$end='2021-06-25" AND prices.date<"2021-02-23';
		$model=Goods::model()->with(array('prices'=>array('scopes'=>array("inDateRange"=> array($prices_model->date_start, $prices_model->date_end)))))->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');

		
		$this->render('view',array(
			'model'=>$model,
			'prices_model' => $prices_model
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Goods('create');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Goods'])) {
			$data = $_POST['Goods'];

			$parser = new Parser();

			$shop_domain = $parser->fetchDomain($data['url']);
			$shop = Shops::model()->findByAttributes(array('domain' => $shop_domain));
			if ($shop) {
				$data['shop_id'] = $shop->id;
			}

			$title = $parser->getTitle($_POST['Goods']['url'], $shop);

			if ($title) {
				$data['title'] = $title;
			}
			$model->attributes = $data;

			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Goods']))
		{
			$model->attributes=$_POST['Goods'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}




		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Parse price
	 */
	public function actionParseprice($id)
	{
		if ($this->loadModel($id)->parseprice()) {
			$this->redirect(array('view','id'=>$id));
		}
	}

	public function actionLoadImage($id)
	{
		if ($this->loadModel($id)->loadimage()) {
			$this->redirect(array('view','id'=>$id));
		}
	}

	/**
	 * Parse title
	 */
	public function actionParsetitle($id)
	{

		echo $this->loadModel($id)->parsetitle();

	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Goods', array(
			'criteria'=>array(
				'with'=>array(
					'prices'=>array(
						'condition'=>"prices.date > :start_date", 
						'params'=> array(':start_date'=>date("Y-m-d", (time()-31622400-24*60*60)))
						), 
					'aproxi'),
				'condition' => 'notshow = 0',
				'order' => 'id ASC'
				//'params' => array('notssshow' => "0")
			),
			'pagination'=>array(
				'pageSize'=>10,
			),
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionSearch(){

		$model=new Goods('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Goods']))
			$model->attributes=$_GET['Goods'];
		$this->render('search',array(
			'model'=>$model,
		));
	}


	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Goods('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Goods']))
			$model->attributes=$_GET['Goods'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Goods the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Goods::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Goods $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='goods-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
