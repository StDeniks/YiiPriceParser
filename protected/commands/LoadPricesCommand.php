<?php


class LoadPricesCommand extends CConsoleCommand
{

	public function run($args)
	{
		$goods = Goods::model()->findAll(array('limit' => 10, 'condition' => 'shop_id=2'));
		foreach ($goods as $good) {
			$parser = new Parser();
			$prices = $parser->getPrices($good);
			if ($prices) {
				$price_model = new Prices;
				$data = array(
					'good_id' => $good->id,
					'price' => $prices['new'],
					'price_old' => $prices['old'],
					'date' => date("Y-m-d")
				);
				$price_model->attributes = $data;
				if ($price_model->save()) {
					echo $good->title . "-> ok \r\n";
				}

			}


		}

	}


} 