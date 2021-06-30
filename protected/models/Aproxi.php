<?php

/**
 * This is the model class for table "aproxi".
 *
 * The followings are the available columns in table 'aproxi':
 * @property string $date
 * @property integer $good_id
 * @property double $infl
 * @property double $a
 * @property double $b
 * @property integer $x0
 * @property double $y0
 * @property integer $xn
 * @property double $yn
 * @property double $sumX
 * @property double $sumXX
 * @property double $sumY
 * @property double $sumXY
 * @property integer $n
 */
class Aproxi extends CActiveRecord
{

	private $datetx0;
	private $datetxn;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'aproxi';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date, good_id, infl, a, b, x0, y0, xn, yn, sumX, sumXX, sumY, sumXY, n', 'required'),
			//array('good_id, x0, xn, n', 'numerical', 'integerOnly'=>true),
			//array('infl, a, b, y0, yn, sumX, sumXX, sumY, sumXY', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			//array('date, good_id, infl, a, b, x0, y0, xn, yn, sumX, sumXX, sumY, sumXY, n', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'date' => 'Date',
			'good_id' => 'Good',
			'infl' => 'Infl',
			'a' => 'A',
			'b' => 'B',
			'x0' => 'X0',
			'y0' => 'Y0',
			'xn' => 'Xn',
			'yn' => 'Yn',
			'sumX' => 'Sum X',
			'sumXX' => 'Sum Xx',
			'sumY' => 'Sum Y',
			'sumXY' => 'Sum Xy',
			'n' => 'N',
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

		$criteria->compare('date',$this->date,true);
		$criteria->compare('good_id',$this->good_id);
		$criteria->compare('infl',$this->infl);
		$criteria->compare('a',$this->a);
		$criteria->compare('b',$this->b);
		$criteria->compare('x0',$this->x0);
		$criteria->compare('y0',$this->y0);
		$criteria->compare('xn',$this->xn);
		$criteria->compare('yn',$this->yn);
		$criteria->compare('sumX',$this->sumX);
		$criteria->compare('sumXX',$this->sumXX);
		$criteria->compare('sumY',$this->sumY);
		$criteria->compare('sumXY',$this->sumXY);
		$criteria->compare('n',$this->n);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Aproxi the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getDatet($n, $incr = 0, $multi = 1)
	{
		if ($n == 0) {
			if (!$this->datetx0) {
				$this->datetx0 = ($this->x0 + $incr) * $multi;
			}
			return $this->datetx0;
		} else {
			if (!$this->datetxn) {
				$this->datetxn = ($this->xn + $incr) * $multi;
			}
			return $this->datetxn;
		}
	}
	
	public function getStartDate(){
		return date("Y-m-d", $this->x0);
	}
	
	public function getEndDate(){
		return date("Y-m-d", $this->xn);
	}

	public function getTrust()
	{
		return round($this->n*100/365, 0);
	}
}
