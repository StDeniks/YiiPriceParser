<?php

class Parser
{

	public $cookie_file_name = "/cookies.txt";
	public $user_agent = "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17";
	public $user_agent2 = "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0";

	function __construct()
	{

	}

	public function getPrices($good)
	{
		$html = $this->get($good->url);

		if (!$html) {
			$this->Error("Неудалось получить страницу для:" . $good->title);
		}


		$html = $this->cutHtml($html, $good->shop->block_exp);

		$price = array();
		$price['new'] = $this->fetchPrice($html, $good->shop->price_exp);
		if (!$price['new']) {
			$price['new'] = $this->fetchPrice($html, $good->shop->new_price_exp);
		}
		$price['old'] = $this->fetchPrice($html, $good->shop->old_price_exp);
		if (!$price['new']) {
			$this->Error("Не удалось получить цену товара:" . $good->title);
			return false;
		}
		return $price;
	}

	public function get($url)
	{

		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, $url);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($c, CURLOPT_HEADER, 1);
		curl_setopt($c, CURLOPT_COOKIEJAR, dirname(__FILE__) . $this->cookie_file_name);
		curl_setopt($c, CURLOPT_COOKIEFILE, dirname(__FILE__) . $this->cookie_file_name);
		curl_setopt($c, CURLOPT_USERAGENT, $this->user_agent2);
		$r = curl_exec($c);
		curl_close($c);
		return $r;
	}

	private function Error($str)
	{
		echo $str."\n";
	}

	public function cutHtml($html, $exp)
	{
		if (!$exp) return $html;
		$exp = "#" . preg_quote($exp) . "#mis";
		$exp = preg_replace("#\\\{block\\\}#", "(.*?)", $exp);
		//$exp = preg_replace('#\s#', '.*?', $exp);
		$exp = iconv("windows-1251", "utf-8", $exp);

		if (preg_match($exp, $html, $p)) {
			return $p[0];
		} else {
			$this->Error("Не удалось получить Блок с ценой");
			return $html;
		}

	}

	public function fetchPrice($html, $exp)
	{
		if (!$exp)
			return false;

		$exp = "#" . preg_quote($exp) . "#mis";
		$exp = preg_replace("#\\\{rub\\\}#", "(.*?)", $exp);
		$exp = preg_replace("#\\\{kop\\\}#", "(.*?)", $exp);
		$exp = preg_replace('#\s#', '.*?', $exp);
		if (preg_match($exp, $html, $p)) {
			$price = floatval(str_replace(" ", "", $p[1] . "." . $p[2]));
			return $price;
		} else
			return false;
	}

	public function getTitle($url, $shop)
	{
		$html = $this->get($url);
		$exp = "#" . preg_quote($shop['title_exp']) . "#";
		$exp = preg_replace("#\\\{title\\\}#", "(.*?)", $exp);
		$exp = preg_replace("#\s#", ".*?", $exp);
		if (preg_match($exp, $html, $p)) {
			return $p[1];
		} else return false;

	}

}