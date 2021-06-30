<?php

/**
 * This is the model class for table "prices".
 *
 * The followings are the available columns in table 'prices':
 * @property integer $good_id
 * @property string $date
 * @property string $price
 * @property string $old_price
 */
class Prices extends CActiveRecord
{
	public $datet;
	public $date_start;
	public $date_end;
	/**
	 * @return string the associated database table name
	 */
	public function tableName(){
		return 'prices';
	}

	public function primaryKey(){
		return array('good_id', 'date');
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('good_id', 'numerical', 'integerOnly'=>true),
			array('price, old_price', 'length', 'max'=>10),
			array('date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('good_id, date, price, old_price', 'safe', 'on'=>'search'),
			array('date_start, date_end', 'date', 'on'=>'data_range', 'format'=>'yyyy-MM-dd'),
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
			'good'=>array(self::BELONGS_TO, 'Goods', 'good_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'good_id' => 'Good',
			'date' => 'Date',
			'price' => 'Price',
			'old_price' => 'Old Price',
			'date_start' => 'От',
			'date_end' => 'До',
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

		/*$criteria=new CDbCriteria;

		$criteria->compare('good_id',$this->good_id);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('old_price',$this->old_price,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));*/
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Prices the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function inDateRange($start="", $end="")
	{
		if ($start=="") {
			$start = date("Y-m-d", (time()-31622400));
		}
		if ($end=="") {
			$end = date("Y-m-d", (time()));
		}
		
		
		$this->getDbCriteria()->mergeWith(array(
			'condition'=>"date >= :start_date AND date <= :end_date", 
			'params'=> array(':start_date'=>$start, ':end_date'=>$end)
	    ));

	    return $this;
	}

	public function getDatet($incr = 0, $multi = 1)
	{
		if (!$this->datet) {
			$this->datet = (strtotime($this->date) + $incr) * $multi;
		}
		return $this->datet;
	}
}
