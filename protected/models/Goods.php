<?php

/**
 * This is the model class for table "goods".
 *
 * The followings are the available columns in table 'goods':
 * @property integer $id
 * @property string $title
 * @property integer $shop
 * @property string $url
 * @property integer $notshow
 * @property integer $notparse
 */
class Goods extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'goods';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('shop_id, url', 'required', 'message' => "не может быть пустым"),
			array('shop_id, notshow, notparse', 'numerical', 'integerOnly'=>true),
			array('title, url', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, shop, url, notshow, notparse', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'shop' => array(self::BELONGS_TO, 'Shops', 'shop_id'),
			'prices' =>array(self::HAS_MANY, 'Prices', 'good_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Название',
			'shop.title' => 'Магазин',
			'url' => 'Ссылка',
			'notshow' => 'Скрыть',
			'notparse' => 'НеПарсить',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('shop_id',$this->shop);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('notshow',$this->notshow);
		$criteria->compare('notparse',$this->notparse);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Goods the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function echotitle(){
		echo $this->url;
	}

	public function parseprice(){
		$parser = new Parser();
		$prices = $parser->getPrices($this);
		if ($prices) {
			$price_model = new Prices;
			$data = array(
				'good_id' => $this->id,
				'price' => $prices['new'],
				'price_old' => $prices['old'],
				'date' => date("Y-m-d")
			);
			$price_model->attributes = $data;
			try {
				return $price_model->save();
			}catch (Exception $e){
				return false;
			}
		}
	}

}
