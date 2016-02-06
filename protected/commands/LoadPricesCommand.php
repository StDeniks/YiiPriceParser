<?php


class LoadPricesCommand extends CConsoleCommand
{

	public function run($args)
	{
		$goods = Goods::model()->findAll();
		foreach ($goods as $good) {
			/*$parser = new Parser();
			$prices = $parser->getPrices($good);
			if ($prices) {
				$price_model = new Prices;
				$data = array(
					'good_id' => $good->id,
					'price' => $prices['new'],
					'old_price' => $prices['old'],
					'date' => date("Y-m-d")
				);
				$price_model->attributes = $data;
				if ($price_model->save()) {
					echo $good->title . "-> ok \r\n";
				}

			}
*/
			$good->parseprice();

		}

	}


} 