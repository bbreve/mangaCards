<?php
	include "curl.php";
	
	header("Content-type: application/xml");

	//Dichiaro gli array per le informazioni
	$editions = array();
	$images = array();
	$links = array();
	$names = array();
	$prices = array();
	$specials = array();
	$pDates = array();
	
	//Parametri di ricerca
	$search = "bleach";

	$url = "http://comics.panini.it/store/pub_ita_it/catalogsearch/result/index/?p=1&q=".urlencode($search);
	$ch1 = new CurlExecution($url);	//crei l'esecutore dello scraper

	$data = $ch1->curl($url);          //prepari l'esecutore per il curl 
	$res1 = $ch1->returnData('//div[@class="text-center"]');      //estrai dati usando un XPATH
	
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
			$url = "http://comics.panini.it/store/pub_ita_it/catalogsearch/result/index/?p=".$pag."&q=".urlencode($search);
			$ch2 = new CurlExecution($url);	//crei l'esecutore dello scraper
			$data = $ch2->curl($url);          //prepari l'esecutore per il curl 
			
			
			//Estraggo info della pagina corrente
			$images = extractImages($images, $ch2);
			$editions = extractEdition($editions, $ch2);
			$links = extractLink($links, $ch2);	
			$names = extractNames($names, $ch2);
			$prices = extractPrices($prices, $ch2);
			$pDates = extractDates($pDates, $ch2);
			$specials = extractSpecials($specials, $ch2);
		}
		
		$xml = writeXML($images, $links, $names, $prices, $specials, $pDates, $editions, $search, $xml);
	}
	
	//var_dump(count($images)." ".count($links)." ".count($names)." ".count($prices)." ".count($specials)." ".count($pDates)." ".count($editions));
	echo $xml->asXML();
	
	function extractImages($images, $ch2)
	{
			$res = $ch2->returnData('//div[contains(@class,"list-group-item row item") and div/div/div/div/div/button/@title = "Aggiungi al carrello"]//a[@class="product-image"]/img/@src');
			foreach ($res as $curr)
			{
				$string = $curr->nodeValue;
				if ($string == "" || $string == " " || $string == NULL)
					continue;
				else $images[] = trim($curr->nodeValue);
			}
			
			$res = $ch2->returnData('//div[contains(@class,"list-group-item row item") and div/div/div/div/div/button/@title = "Aggiungi al carrello" and contains(div/div/div/div/h5, "ristampa")]//a[@class="product-image"]/img/@src');
			foreach ($res as $curr)
			{
				$string = $curr->nodeValue;
				if ($string == "" || $string == " " || $string == NULL)
					continue;
				else $images[] = trim($curr->nodeValue);
			}
			
			return $images;
	}
	
	function extractLink($links, $ch2)
	{
			$res = $ch2->returnData('//div[contains(@class,"list-group-item row item") and div/div/div/div/div/button/@title = "Aggiungi al carrello"]//h3/a/@href');
			foreach ($res as $curr)
			{
				$string = $curr->nodeValue;
				if ($string == "" || $string == " " || $string == NULL)
					continue;
				else $links[] = trim($curr->nodeValue);
			}
			
			$res = $ch2->returnData('//div[contains(@class,"list-group-item row item") and div/div/div/div/div/button/@title = "Aggiungi al carrello" and contains(div/div/div/div/h5, "ristampa")]//h3/a/@href');
			foreach ($res as $curr)
			{
				$string = $curr->nodeValue;
				if ($string == "" || $string == " " || $string == NULL)
					continue;
				else $links[] = trim($curr->nodeValue);
			}
			
			return $links;
	}

	function extractNames($names, $ch2)
	{
			$res = $ch2->returnData('//div[contains(@class,"list-group-item row item") and div/div/div/div/div/button/@title = "Aggiungi al carrello"]//h3/a/text()');
			foreach ($res as $curr)
			{
				$string = $curr->nodeValue;
				if ($string == "" || $string == " " || $string == NULL)
					continue;
				else $names[] = trim($curr->nodeValue);
			}
			
			$res = $ch2->returnData('//div[contains(@class,"list-group-item row item") and div/div/div/div/div/button/@title = "Aggiungi al carrello" and contains(div/div/div/div/h5, "ristampa")]//h3/a/text()');
			foreach ($res as $curr)
			{
				$string = $curr->nodeValue;
				if ($string == "" || $string == " " || $string == NULL)
					continue;
				else $names[] = trim($curr->nodeValue);
			}
			
			return $names;
	}
	
	function extractPrices($prices, $ch2)
	{
			$res = $ch2->returnData('//div[contains(@class,"list-group-item row item") and div/div/div/div/div/button/@title = "Aggiungi al carrello"]//p[@class="old-price"]');
			foreach ($res as $curr)
			{
				$string = $curr->nodeValue;
				if ($string == "" || $string == " " || $string == NULL)
					continue;
				else $prices[] = trim($curr->nodeValue);
			}
			
			$res = $ch2->returnData('//div[contains(@class,"list-group-item row item") and div/div/div/div/div/button/@title = "Aggiungi al carrello" and contains(div/div/div/div/h5, "ristampa")]//p[@class="old-price"]');
			foreach ($res as $curr)
			{
				$string = $curr->nodeValue;
				if ($string == "" || $string == " " || $string == NULL)
					continue;
				else $prices[] = trim($curr->nodeValue);
			}
			 
			return $prices;
	}
	
	function extractSpecials($specials, $ch2)
	{
			$res = $ch2->returnData('//div[contains(@class,"list-group-item row item") and div/div/div/div/div/button/@title = "Aggiungi al carrello"]//p[@class="special-price"]');
			foreach ($res as $curr)
			{
				$string = $curr->nodeValue;
				if ($string == "" || $string == " " || $string == NULL)
					continue;
				else $specials[] = trim($curr->nodeValue);
			}
			
			$res = $ch2->returnData('//div[contains(@class,"list-group-item row item") and div/div/div/div/div/button/@title = "Aggiungi al carrello" and contains(div/div/div/div/h5, "ristampa")]//p[@class="special-price"]');
			foreach ($res as $curr)
			{
				$string = $curr->nodeValue;
				if ($string == "" || $string == " " || $string == NULL)
					continue;
				else $specials[] = trim($curr->nodeValue);
			}
			 
			return $specials;
	}
	
	function extractDates($pDates, $ch2)
	{
			$res = $ch2->returnData('//div[contains(@class,"list-group-item row item") and div/div/div/div/div/button/@title = "Aggiungi al carrello"]//h4[@class="publication-date"]');
			foreach ($res as $curr)
			{
				$string = $curr->nodeValue;
				if ($string == "" || $string == " " || $string == NULL)
					continue;
				else $pDates[] = trim($curr->nodeValue);
			}
			
			$res = $ch2->returnData('//div[contains(@class,"list-group-item row item") and div/div/div/div/div/button/@title = "Aggiungi al carrello" and contains(div/div/div/div/h5, "ristampa")]//h4[@class="publication-date"]');
			foreach ($res as $curr)
			{
				$string = $curr->nodeValue;
				if ($string == "" || $string == " " || $string == NULL)
					continue;
				else $pDates[] = trim($curr->nodeValue);
			}
			 
			return $pDates;
	}
	
	function extractSeries($series, $ch2)
	{
			$res = $ch2->returnData('//div[contains(@class,"list-group-item row item") and div/div/div/div/div/button/@title = "Aggiungi al carrello"]//a[@class="product-image"]/@title');
			foreach ($res as $curr)
			{
				$string = $curr->nodeValue;
				if ($string == "" || $string == " " || $string == NULL)
					continue;
				else $series[] = trim($curr->nodeValue);
			}
			
			$res = $ch2->returnData('//div[contains(@class,"list-group-item row item") and div/div/div/div/div/button/@title = "Aggiungi al carrello" and contains(div/div/div/div/h5, "ristampa")]//a[@class="product-image"]/@title');
			foreach ($res as $curr)
			{
				$string = $curr->nodeValue;
				if ($string == "" || $string == " " || $string == NULL)
					continue;
				else $pDates[] = trim($curr->nodeValue);
			}
			
			return $series;
	}
	
	function extractEdition($editions, $ch2)
	{
			$res = $ch2->returnData('//div[contains(@class,"list-group-item row item") and div/div/div/div/div/button/@title = "Aggiungi al carrello"]//a[@class="product-image"]/@title');
			foreach ($res as $curr)
				$editions[] = "Edizione originale";
			
			$res = $ch2->returnData('//div[contains(@class,"list-group-item row item") and div/div/div/div/div/button/@title = "Aggiungi al carrello" and contains(div/div/div/div/h5, "ristampa")]//h5[@class="reprint"]');
			foreach ($res as $curr)
			{
				$string = $curr->nodeValue;
				if ($string == "" || $string == " " || $string == NULL)
					continue;
				else $editions[] = trim($curr->nodeValue);
			}
			
			return $editions;
	}
	
	function writeXML($images, $links, $names, $prices, $specials, $pDates, $editions, $search, $xml)
	{
			for ($n = 0; $n < count($links); $n++)
			{
				//echo $n." ".$names[$n]." ".$search."<br />";
				if (stripos($names[$n], $search) === false)
					continue;
				$prodotto = $xml->addChild("product");
				
				$prodotto->addChild("name", $names[$n]);
				
				if ($editions[$n] <> "Edizione originale")
					$prodotto->addChild("edition", $editions[$n]);
				
				$prodotto->addChild("old_price", $prices[$n]);
				$prodotto->addChild("curr_price", $specials[$n]);
				$prodotto->addChild("date", $pDates[$n]);
				$prodotto->addChild("image", $images[$n]);
				$prodotto->addChild("link", $links[$n]);
			}
			
			return $xml;
	}
?>	