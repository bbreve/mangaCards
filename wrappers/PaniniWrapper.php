<?php
	header("Content-type: application/xml");

	//Dichiaro gli array per le informazioni
	$editions = array();
	$images = array();
	$links = array();
	$titles = array();
	$volume_numbers = array();
	$prices = array();
	$currPrices = array();
	$volume_infos = array();
	$pDates = array();
	
	//Parametri di ricerca
	$search = "naruto";
	$prod = "comic";
	
	$ch = curl_init();
	$url = "http://comics.panini.it/store/pub_ita_it/catalogsearch/result/index/?p=1&q=".urlencode($search)."";
	setCurl();
	$content = curl_exec($ch);
				
	$dom = new DomDocument();
	@$dom->loadHTML($content);
	$xpath = new DOMXPath($dom);         
	$res1 = $xpath->query('//div[@class="text-center"]');      

	//Dichiaro l'XML di ritorno
	$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><list_products></list_products>');			
	
	if ($res1->length != 0)
	{
		//Ottengo il numero di pagine della ricerca
		$total = $res1->item(0)->nodeValue;
		$parts = explode(" ", trim($total));
		$num_pages = ceil(intval($parts[count($parts)-2])/25);
	
		if ($num_pages == 0)
			$num_pages = 1;

		//Estraggo le informazioni
		for ($pag = 1; $pag <= $num_pages; $pag++)
		{
			$url = "http://comics.panini.it/store/pub_ita_it/catalogsearch/result/index/?p=".$pag."&q=".urlencode($search)."";
			$ch = curl_init();
			setCurl();
			$content = curl_exec($ch);
			$dom = new DomDocument();
			@$dom->loadHTML($content);
			$xpath = new DOMXPath($dom); 
			
			//Estraggo info della pagina corrente
			extractImage();
			extractEdition();
			extractLink();	
			extractTitle();
			extractVolNumber();
			extractOldPrice();
			extractReleaseDate();
			extractCurrentPrice();
			extractVolumeInfo();			
		}
		
		writeXML();
	}
	
	echo $xml->asXML();
	
	function writeXML()
	{
		global $images, $links, $titles, $volume_numbers, $volume_infos, $editions, $pDates, $prices, $currPrices, $prod, $xml;
		for ($n = 0; $n < count($titles); $n++)
		{
			$prodotto = $xml->addChild("product");
				
			$prodotto->addChild("title", $titles[$n]);
			$prodotto->addChild("product_type", $prod);
			$prodotto->addChild("productNumber", $volume_numbers[$n]);
			
			if ($editions[$n] <> "Edizione Originale")
				$prodotto->addChild("edition", $editions[$n]);
			if ($volume_infos[$n] <> "")
				$prodotto->addChild("info_volume", $volume_infos[$n]);
			
			$prodotto->addChild("old_price", $prices[$n]);
			$prodotto->addChild("curr_price", $currPrices[$n]);
			$prodotto->addChild("release_date", $pDates[$n]);
			$prodotto->addChild("cover", $images[$n]);
			$prodotto->addChild("url_to_product", $links[$n]);
		}
			
		$arr = array();
		foreach($xml->product as $product){
			$arr[] = $product;
}

		usort($arr,function($a,$b){
			return $a->productNumber - $b->productNumber;
		});
		
		$xml=new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><offers></offers>');
		foreach($arr as $product){
			$value=$xml->addChild('offer');
			$value->addChild('title',(string)$product->title);
			$value->addChild('product_type',(string)$product->product_type);
			$value->addChild('productNumber',(string)$product->productNumber);
			if ($product->edition != NULL)
				$value->addChild('edition',(string)$product->edition);
			if ($product->info_volume != NULL)
				$value->addChild('info_volume',(string)$product->info_volume);
			$value->addChild('price',(string)$product->curr_price);
			$value->addChild('old_price',(string)$product->old_price);
			$value->addChild('date',(string)$product->release_date);
			$value->addChild('cover',(string)$product->cover);
			$value->addChild('url_to_product',(string)$product->url_to_product);
		}
	}
	
	function extractImage()
	{
			global $images, $search, $xpath;
			
			$res = $xpath->query('//div[contains(@class,"list-group-item row item") and div/div/div/div/div/button/@title = "Aggiungi al carrello"]');
			foreach ($res as $curr)
			{
				
				$string = $xpath->query('.//h3/a/text()', $curr)->item(0)->nodeValue;
				$string = trim($string);
				if (stripos($string, $search) === FALSE && stripos($search, $string) === FALSE)
					continue;
				
				$queryResult = $xpath->query('.//a[@class="product-image"]/img/@src', $curr);
				
				if ($queryResult->length != 0)
				{
					$img = trim($queryResult->item(0)->nodeValue);
				
					if ($img == "" || $img == " " || $img == NULL)
						continue;
					else 
						$images[] = $img;
				}
				else 
					$images[] = "";
			}
	}
	
	function extractLink()
	{
			global $links, $search, $xpath;
			
			$res = $xpath->query('//div[contains(@class,"list-group-item row item") and div/div/div/div/div/button/@title = "Aggiungi al carrello"]');
			
			foreach ($res as $curr)
			{
				$string = $xpath->query('.//h3/a/text()', $curr)->item(0)->nodeValue;
				$string = trim($string);
				if (stripos($string, $search) === FALSE && stripos($search, $string) === FALSE)
					continue;
				
				$queryResult = $xpath->query('.//h3/a/@href', $curr);
				if ($queryResult->length != 0)
				{
					$anchor = trim($queryResult->item(0)->nodeValue);
				
					if ($anchor == "" || $anchor == " " || $anchor == NULL)
						continue;
					else 
						$links[] = $anchor;
				}
			}
	}

	function extractTitle()
	{
			global $titles, $search, $xpath;
			
			$res = $xpath->query('//div[contains(@class,"list-group-item row item") and div/div/div/div/div/button/@title = "Aggiungi al carrello"]');
			
			foreach ($res as $curr)
			{
				$string = $xpath->query('.//h3/a/text()', $curr)->item(0)->nodeValue;
				$string = trim($string);
				if (stripos($string, $search) === FALSE && stripos($search, $string) === FALSE)
					continue;
				
				if ($string == "" || $string == " " || $string == NULL)
						continue;
				else 
					$titles[] = $string;
			}
	}
	
	function extractVolNumber()
	{
			global $volume_numbers, $search, $xpath;
			
			$res = $xpath->query('//div[contains(@class,"list-group-item row item") and div/div/div/div/div/button/@title = "Aggiungi al carrello"]');			foreach ($res as $curr)
			
			foreach($res as $curr)
			{
				$string = $xpath->query('.//h3/a/text()', $curr)->item(0)->nodeValue;
				$string = trim($string);
				if (stripos($string, $search) === FALSE && stripos($search, $string) === FALSE)
					continue;
				
				$arrays = explode(" ", $string);
				$volume_numbers[] = intval($arrays[count($arrays)-1]);
			}
	}
	
	function extractOldPrice()
	{
			global $prices, $search, $xpath;
			
			$res = $xpath->query('//div[contains(@class,"list-group-item row item") and div/div/div/div/div/button/@title = "Aggiungi al carrello"]');			foreach ($res as $curr)
			
			foreach($res as $curr)
			{
				$string = $xpath->query('.//h3/a/text()', $curr)->item(0)->nodeValue;
				$string = trim($string);
				if (stripos($string, $search) === FALSE && stripos($search, $string) === FALSE)
					continue;
				
				$queryResult = $xpath->query('.//p[@class="old-price"]', $curr);
				if ($queryResult->length != 0)
				{
					$price = trim($queryResult->item(0)->nodeValue);
				
					if ($price == "" || $price == " " || $price == NULL)
						continue;
					else 
						$prices[] = $price;
				}
			}
	}
	
	function extractCurrentPrice()
	{
			global $currPrices, $search, $xpath;
			
			$res = $xpath->query('//div[contains(@class,"list-group-item row item") and div/div/div/div/div/button/@title = "Aggiungi al carrello"]');
			foreach ($res as $curr)
			{
				$string = $xpath->query('.//h3/a/text()', $curr)->item(0)->nodeValue;
				$string = trim($string);
				if (stripos($string, $search) === FALSE && stripos($search, $string) === FALSE)
					continue;
				
				$queryResult = $xpath->query('.//p[@class="special-price"]', $curr);
				if ($queryResult->length != 0)
				{
					$price = trim($queryResult->item(0)->nodeValue);
				
					if ($price == "" || $price == " " || $price == NULL)
						continue;
					else 
						$currPrices[] = $price;
				}
			}
	}
	
	function extractReleaseDate()
	{
			global $pDates, $search, $xpath;
			
			$res = $xpath->query('//div[contains(@class,"list-group-item row item") and div/div/div/div/div/button/@title = "Aggiungi al carrello"]');
			foreach ($res as $curr)
			{
				$string = $xpath->query('.//h3/a/text()', $curr)->item(0)->nodeValue;
				$string = trim($string);
				if (stripos($string, $search) === FALSE && stripos($search, $string) === FALSE)
					continue;
				
				$queryResult = $xpath->query('.//h4[@class="publication-date"]', $curr);
				
				if ($queryResult->length != 0)
				{
					$releaseDate = trim($queryResult->item(0)->nodeValue);
				
					if ($releaseDate == "" || $releaseDate == " " || $releaseDate == NULL)
						continue;
					else 
						$pDates[] = $releaseDate;
				}
			}
	}

	function extractEdition()
	{
			global $editions, $search, $xpath;
			
			$res = $xpath->query('//div[contains(@class,"list-group-item row item") and div/div/div/div/div/button/@title = "Aggiungi al carrello"]');
			foreach ($res as $curr)
			{
				$string = $xpath->query('.//h3/a/text()', $curr)->item(0)->nodeValue;
				$string = trim($string);
				if (stripos($string, $search) === FALSE && stripos($search, $string) === FALSE)
					continue;
				
				$queryResult = $xpath->query('.//h5[@class="reprint"]', $curr);
				if ($queryResult->length != 0)
				{
					$reprint = trim($queryResult->item(0)->nodeValue);
				
					if ($reprint == "" || $reprint == " " || $reprint == NULL)
						continue;
					else 
						$editions[] = $reprint;
				}
				else
					$editions[] = "Edizione Originale";
			}
	}
	
	function extractVolumeInfo()
	{
			global $volume_infos, $search, $xpath;
			
			$res = $xpath->query('//div[contains(@class,"list-group-item row item") and div/div/div/div/div/button/@title = "Aggiungi al carrello"]');
			foreach ($res as $curr)
			{
				$string = $xpath->query('.//h3/a/text()', $curr)->item(0)->nodeValue;
				$string = trim($string);
				if (stripos($string, $search) === FALSE && stripos($search, $string) === FALSE)
					continue;
				
				$queryResult = $xpath->query('.//small[@class="subtitle lightText" or @class="serie"]', $curr);
				if ($queryResult->length != 0)
				{
					$info = trim($queryResult->item(0)->nodeValue);
				
					if ($info == "" || $info == " " || $info == NULL)
						continue;
					else 
						$volume_infos[] = $info;
				}
				else
					$volume_infos[] = "";
			}
	}
	
	function setCurl()
	{
		global $ch, $url;
		
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/html'));
	}
?>	