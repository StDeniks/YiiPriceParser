<?php
/**
 * Created by PhpStorm.
 * User: Денис
 * Date: 17.04.2016
 * Time: 1:23
 */
class UpdateShopsCommand extends CConsoleCommand
{

	public function run($args)
	{
		$shops = Shops::model()->findAll('`id`=2');
		if ($shops) {
			foreach ($shops as $shop) {
				$pars = new Parser();
				$pars->updateGoods($shop);
			}
		}

	}


}