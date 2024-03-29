<?php

/**
 * This is the model class for table "shops".
 *
 * The followings are the available columns in table 'shops':
 * @property integer $id
 * @property string $title
 * @property string $domain
 * @property string $block_exp
 * @property string $price_exp
 * @property string $new_price_exp
 * @property string $old_price_exp
 * @property string $title_exp
 * @property string $image_exp
 */
class Shops extends CActiveRecord
{
	public $image;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'shops';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('domain', 'required'),
			array('domain', 'length', 'max'=>255),
			array('charset', 'length', 'max'=>20),
			array('title, block_exp, price_exp, new_price_exp, old_price_exp, title_exp, image_exp', 'safe'),
			array('image', 'file', 'types'=>'gif jpeg jpg png', 'allowEmpty' => 1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, domain, block_exp, price_exp, new_price_exp, old_price_exp, title_exp, image_exp', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'title' => 'Заголовок',
			'domain' => 'Домен',
			'image' => 'Логотип магазина',
			'charset' => 'Кодировка сайта',
			'block_exp' => 'Регулярка для блока с ценой',
			'price_exp' => 'Регулярка для цены',
			'new_price_exp' => 'Регулярка для новой цены',
			'old_price_exp' => 'Регулярка для старой цены',
			'title_exp' => 'Регулярка для заголовка',
			'image_exp' => 'Регулярка для картинки',
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
		$criteria->compare('domain',$this->domain,true);
		$criteria->compare('block_exp',$this->block_exp,true);
		$criteria->compare('price_exp',$this->price_exp,true);
		$criteria->compare('new_price_exp',$this->new_price_exp,true);
		$criteria->compare('old_price_exp',$this->old_price_exp,true);
		$criteria->compare('title_exp',$this->title_exp,true);
		$criteria->compare('image_exp',$this->image_exp,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Shops the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function saveImage()
	{
		if ($this->image) {
			$path=$this->getDataDir();
			if (!file_exists($path)) {
				mkdir($path, 0777, true);
			}
			//$name= $path."/orig.".$this->image->getExtensionName();
			$name= $path."/".$this->image;
			$this->image->saveAs($name, true);
			
			$image = new EasyImage($name);
			$image->resize(50, 50);
			$image->save($path."/logo_50x50.png");
		}
	}
	
	public function getDataDir()
	{
		return Yii::getPathOfAlias('webroot').'/data/'.$this->tableName()."/".$this->id;
	}
	
	public function getImagePath()
	{
		return $this->getDataDir().'/'.$this->image;
	}

}
