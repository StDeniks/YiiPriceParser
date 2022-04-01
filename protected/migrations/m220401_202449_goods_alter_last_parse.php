<?php

class m220401_202449_goods_alter_last_parse extends CDbMigration
{
	public function up()
	{
		 $this->addColumn('Goods', 'last_parse', 'date');
	}

	public function down()
	{
		dropColumn('Goods', 'last_parse');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}