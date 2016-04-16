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
/*
 *
 * 366 = 31622400
 * 365 = 31536000
 */
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'shop' => array(self::BELONGS_TO, 'Shops', 'shop_id'),
			'prices' => array(self::HAS_MANY, 'Prices', 'good_id', 'order'=>'`date` ASC', 'condition' => 'prices.date > "'.date("Y-m-d", (time()-31622400-24*60*60)).'"' ),
			'aproxi' => array(self::HAS_MANY, 'Aproxi', 'good_id', 'order'=>'`date` DESC', 'limit'=>1),
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
		$criteria->compare('shop_id',$this->shop_id);
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

	public function echotitle()
	{
		echo $this->url;
	}

	public function parseprice()
	{
		$parser = new Parser();
		$prices = $parser->getPrices($this);
		if ($prices) {
			return $this->saveprice($prices['new'], $prices['old']);
		} else {
			return false;
		}
	}

	public function saveprice($price, $old_price=NULL)
	{
		$price_model = new Prices;
		$data = array(
			'good_id' => $this->id,
			'price' => $price,
			'old_price' => $old_price,
			'date' => date("Y-m-d"),
		);
		$price_model->attributes = $data;
		try {
			return $price_model->save();
		}catch (Exception $e){
			return false;
		}

	}

	public function calculateaproxi()
	{
		$n = 0;
		$sumX = 0;
		$sumXX = 0;
		$sumY = 0;
		$sumXY = 0;
		if (!$this->prices) {
			return false;
		}

		foreach ($this->prices as $price) {
			if (floatval($price->price) > 0) {
				$sumX += $price->getDatet();
				$sumXX += $price->getDatet() * $price->getDatet();
				$sumY += $price->price;
				$sumXY += $price->getDatet() * $price->price;
				$n++;
			}
		}
		$zn = $n * $sumXX - $sumX * $sumX;
		if ($zn > 0 && $n > 30) {
			$a = ($n * $sumXY - $sumX * $sumY) / $zn;
			$b = ($sumY - $a * $sumX) / $n;
			$x0 = $this->prices[0]->getDatet();
			$y0 = $a * $x0 + $b;
			$xn = $this->prices[$n - 1]->getDatet();
			$yn = $a * $xn + $b;


			$infl = ($yn - $y0) * 100 / $y0;
			/*echo "a:$a \r\nb:$b\r\n";
			echo "A0[$x0:$y0]\r\n";
			echo "An[$xn:$yn]\r\n";
			echo "Dy=$infl%\r\n";*/

			$aproxi_model = new Aproxi;
			$data = array(
				'good_id' => $this->id,
				'date' => date("Y-m-d"),
				'infl' => $infl,
				'a' => $a,
				'b' => $b,
				'x0' => $x0,
				'y0' => $y0,
				'xn' => $xn,
				'yn' => $yn,
				'sumX' => $sumX,
				'sumXX' => $sumXX,
				'sumY' => $sumY,
				'sumXY' => $sumXY,
				'n' => $n,
			);

			$aproxi_model->attributes = $data;

			try {
				$aproxi_model->save();
			}catch (Exception $e){

			}
			/*return array(
				array('x' => $this->prices[0], 'y' => $y0),
				array('x' => $this->prices[$n - 1], 'y' => $yn),
			);*/


		}
	}

	public function loadimage()
	{
		$parser = new Parser();
		$image_url = $parser->getImageUrl($this->url, $this->shop);
		$imag = file_get_contents($image_url);
		$path = YiiBase::getPathOfAlias('webroot') . "/data/" . $this->tableName() . "/" . $this->id;
		$path_1 = explode("/", $image_url);
		$path_2 = explode("?", end($path_1));
		$path_3 = explode(".", $path_2[0]);
		$file_ext = end($path_3);
		mkdir($path);
		file_put_contents($path . "/imag." . $file_ext, $imag);
		return $image_url;
	}

	public function getFirstDate()
	{
		if (!$this->prices) return false;
		return $this->prices[0]['date'];
	}

	public function getLastDate()
	{
		if (!$this->prices) return false;
		return $this->prices[count($this->prices)-1]['date'];
	}

}
