<?php

class Parser
{

	public $cookie_file_name = "/cookies.txt";
	public $user_agent = "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.52 Safari/537.17";
	public $user_agent2 = "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:35.0) Gecko/20100101 Firefox/35.0";



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
		curl_setopt($c, CURLOPT_TIMEOUT, 40);

		$r = curl_exec($c);
		if (curl_errno($c)){
			$this->Error("Error: " . curl_error($c));
		}
		curl_close($c);


		return $r;
	}

	public function getPrices($good)
	{
		$html = $this->get($good->url);
		if ($good->shop->charset) {
			$html = iconv($good->shop->charset, "utf-8", $html);
		}

		if (!$html) {
			$this->Error("Неудалось получить страницу для:" . $good->id);
		}

		$html = $this->cutHtml($html, $good->shop->block_exp);
		$price = array();

		$price['new'] = $this->fetchPrice($html, $good->shop->price_exp);
		if (!$price['new']) {
			$price['new'] = $this->fetchPrice($html, $good->shop->new_price_exp);
		}
		$price['old'] = $this->fetchPrice($html, $good->shop->old_price_exp);
		if (!$price['new']) {
			$this->Error("Не удалось получить цену товара:" . $good->id);
			return false;
		}
		return $price;
	}

	private function Error($str)
	{
		echo $str."\n";
	}

	private function Trace($str)
	{
		$this->log .= $str. "\r\n-----\r\n";
	}

	public function cutHtml($html, $exp)
	{
		if (!$exp) return $html;
		$exp = "#" . preg_quote($exp) . "#mis";
		$exp = str_replace("\{block\}", "(.*?)", $exp);
		//$exp = preg_replace('#\s#', '.*?', $exp);
		if (preg_match($exp, $html, $p)) {
			return $p[0];
		} else {
			$this->Error("Не удалось получить блок");
			return $html;
		}
	}

	public function fetchPrice($html, $exp)
	{
		if (!$exp)
			return false;
		$exp = "#" . preg_quote($exp) . "#mis";
		$exp = str_replace("\{rub\}", "(.*?)", $exp);
		$exp = str_replace("\{kop\}", "(.*?)", $exp);
		$exp = preg_replace('#\s#', '.', $exp);
		if (preg_match($exp, $html, $p)) {
			if (isset($p[1])){
				$pr = $p[1];
			}
			if(isset($p[2])){
				$pr .=".".$p[2];
			}
			$price = floatval(str_replace(" ", "", $pr));
			return $price;
		} else
			return false;
	}

	public function fetchExpr($html, $exp, $placeholder)
	{
		if (!$exp)
			return false;
		$exp = "#" . preg_quote($exp) . "#";
		if (is_array($placeholder)) {
			foreach ($placeholder as $placeholder_) {
				$exp = str_replace(preg_quote($placeholder_), "([^\"]+?)", $exp);
			}
		} else {
			$exp = str_replace(preg_quote($placeholder), "([^\"]+?)", $exp);
		}

		if (preg_match_all($exp, $html, $p)) {
			array_shift($p);
			return $p;
		}
	}



	public function fetchDomain($url)
	{
		$domain = parse_url($url);
		preg_match_all("/([\w-]+)/i", $domain["host"], $arr, PREG_PATTERN_ORDER);
		$res = array_reverse($arr[0]);
		return "{$res[1]}.{$res[0]}";
	}

	public function getTitle($url, $shop)
	{
		$html = $this->get($url);
		if ($shop->charset) {
			$html = iconv($shop->charset, "utf-8", $html);
		}
		$exp = "#" . preg_quote($shop->title_exp) . "#s";
		$exp = str_replace("\{title\}", "(.*?)", $exp);
		if (preg_match($exp, $html, $p)) {
			if (isset($p[1])) {
				return htmlspecialchars_decode(trim($p[1]));
			} else return false;
		} else return false;
	}

	public function getImageUrl($url, $shop)
	{
		$html = $this->get($url);
		$exp = "#" . preg_quote($shop->image_exp) . "#";
		$exp = preg_replace("#\\\{image\\\}#", "(.*?)", $exp);
		$exp = preg_replace("#\s#", ".*?", $exp);
		if (preg_match($exp, $html, $p)) {
			$url = $p[1];
			$url_data = parse_url($url);
			if (!$url_data['host']) {
				$url = $shop->domain . $url;
			}
			if (!$url_data['scheme']) {
				$url = "http://" . $url;
			}
			return $url;
		} else return false;

	}

	public function updateGoods($shop)
	{
		switch ($shop->id) {
			case 1:
				$this->update7cont($shop);
				break;
			case 2:
				$this->updateUtkonos($shop);
				break;
			default:
				$this->Error("No goods updater function for shop #".$shop->id);
		}

	}

	public function updateUtkonos($shop)
	{
		$cats_ids = [28, 29, 30, 31, 32, 41, 43, 44, 45, 46, 47, 48, 49, 50, 51, 1977, 828,
			54, 954, 55, 56, 57, 58, 59,
			61, 62, 63, 64,
			68, 71, 67, 70, 66, 69, 1692,
			76, 74, 75,
			81, 80, 78, 79,
		];
		$cats_url = "http://www.utkonos.ru/cat/{cat_id}";
		$pages_url = "http://www.utkonos.ru/cat/catalogue/{cat_id}/page/{page}";
		$good_block_expr = 'module_catalogue_layer{block}el_paginate';
		$good_exp = '<a href="{url}" class="goods_caption" title="{title}">';
		foreach ($cats_ids as $cat_id) {
			$page=1;
			do {
				if($page==1)
					$page_html = $this->get(str_replace("{cat_id}", $cat_id, $cats_url));
				else
					$page_html = $this->get(str_replace(array("{cat_id}","{page}"), array($cat_id, $page), $pages_url));

				$good_block = $this->cutHtml($page_html, $good_block_expr);

				$data = $this->fetchExpr($good_block, $good_exp, array("{url}", "{title}"));
				if($data)
					foreach ($data[0] as $k => $url) {
						echo $data[1][$k];
						$good = new Goods();
						$good->url = "http://www.utkonos.ru".$url;
						$good->title = $data[1][$k];
						$good->shop_id = 2;
						try {
							$good->save();
						}catch(Exception $e){

						}
					}
				$page++;
			} while (strpos($page_html, 'HTTP/1.1 200 OK')!==false);

		}

	}

}