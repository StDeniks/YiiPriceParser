<?php


class LoadPricesCommand extends CConsoleCommand
{

	public function run($args)
	{
		$goods = Goods::model()->findAll('`notparse`=0');
		if ($goods) {
			foreach ($goods as $good) {
				$good->parseprice();
				$good->calculateaproxi();
			}
		}

	}


} 