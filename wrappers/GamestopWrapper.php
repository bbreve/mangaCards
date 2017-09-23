<?php 
	include "curl.php";
	
	//Platform 10 PC
	//Platform 27 PS4
	//Platform 18 PSVITA
	//Platform 28 XBOXONE
	//Platform 37 SWITCH

	//Dichiaro gli array per le informazioni
	$images = array();
	$links = array();
	$names = array();
	$prices = array();
	$infos = array();
	$platforms = array();
	$pDates = array();
	$producers = array();
	$type = array();
	
	//Parametri di ricerca
	$pag = 1;
	$search = "assassin's creed";

	//XBOX ONE
	$url = "https://www.gamestop.it/SearchResult/QuickSearch?q=".urlencode($search)."&platform=28";
	$ch2 = new CurlExecution($url);	//crei l'esecutore dello scraper
	$data = $ch2->curl($url);          //prepari l'esecutore per il curl 

	$images = extractImages($images, $ch2);
	$links = extractLink($links, $url, $ch2);	
	$names = extractNames($names, $ch2);
	$pDates = extractDates($pDates, $ch2);
	$producers = extractProducers($producers, $ch2);
	$platforms = extractPlatform($platforms, $ch2);
	$prices = extractPrices($prices, $ch2);
	$type = extractType($type, $ch2);		
	$infos = extractInfo($infos, $ch2);
	
	//PS4
	$url = "https://www.gamestop.it/SearchResult/QuickSearch?q=".urlencode($search)."&platform=27";
	$ch2 = new CurlExecution($url);	//crei l'esecutore dello scraper
	$data = $ch2->curl($url);          //prepari l'esecutore per il curl 

	$images = extractImages($images, $ch2);
	$links = extractLink($links, $url, $ch2);	
	$pDates = extractDates($pDates, $ch2);
	$names = extractNames($names, $ch2);
	$producers = extractProducers($producers, $ch2);
	$platforms = extractPlatform($platforms, $ch2);
	$prices = extractPrices($prices, $ch2);
	$type = extractType($type, $ch2);		
	$infos = extractInfo($infos, $ch2);
	
	//PC
	$url = "https://www.gamestop.it/SearchResult/QuickSearch?q=".urlencode($search)."&platform=10";
	$ch2 = new CurlExecution($url);	//crei l'esecutore dello scraper
	$data = $ch2->curl($url);          //prepari l'esecutore per il curl 

	$images = extractImages($images, $ch2);
	$links = extractLink($links, $url, $ch2);	
	$names = extractNames($names, $ch2);
	$producers = extractProducers($producers, $ch2);
	$platforms = extractPlatform($platforms, $ch2);
	$prices = extractPrices($prices, $ch2);
	$type = extractType($type, $ch2);
	$infos = extractInfo($infos, $ch2);
	$pDates = extractDates($pDates, $ch2);
	
	//SWITCH
	$url = "https://www.gamestop.it/SearchResult/QuickSearch?q=".urlencode($search)."&platform=37";
	$ch2 = new CurlExecution($url);	//crei l'esecutore dello scraper
	$data = $ch2->curl($url);          //prepari l'esecutore per il curl 

	$images = extractImages($images, $ch2);
	$links = extractLink($links, $url, $ch2);	
	$names = extractNames($names, $ch2);
	$producers = extractProducers($producers, $ch2);
	$platforms = extractPlatform($platforms, $ch2);
	$prices = extractPrices($prices, $ch2);
	$type = extractType($type, $ch2);
	$infos = extractInfo($infos, $ch2);
	$pDates = extractDates($pDates, $ch2);
	
	//PSVITA
	$url = "https://www.gamestop.it/SearchResult/QuickSearch?q=".urlencode($search)."&platform=18";
	$ch2 = new CurlExecution($url);	//crei l'esecutore dello scraper
	$data = $ch2->curl($url);          //prepari l'esecutore per il curl 

	$images = extractImages($images, $ch2);
	$links = extractLink($links, $url, $ch2);	
	$names = extractNames($names, $ch2);
	$infos = extractInfo($infos, $ch2);
	$producers = extractProducers($producers, $ch2);
	$platforms = extractPlatform($platforms, $ch2);
	$prices = extractPrices($prices, $ch2);
	$type = extractType($type, $ch2);	
	$pDates = extractDates($pDates, $ch2);	
	
	$xml = writeXML($images, $links, $names, $prices, $infos, $platforms, $producers, $type, $pDates);
	var_dump($xml);
	
	function extractImages($images, $ch2)
	{
			$res = $ch2->returnData('//div[@class="singleProduct" and div/p/a/span/strong != "Prenotalo" and contains(div/p/a/@class, "cartAddNoRadio")]/a/img/@src');
			foreach ($res as $curr)
			{
				$string = $curr->nodeValue;
				if ($string == "" || $string == " " || $string == NULL)
					$images[] = "";
				else $images[] = trim($curr->nodeValue);
			}
			
			return $images;
	}
	
	function extractLink($links, $url, $ch2)
	{
			$res = $ch2->returnData('//div[@class="singleProduct" and div/p/a/span/strong != "Prenotalo" and contains(div/p/a/@class, "cartAddNoRadio")]//div[@class="singleProdInfo"]//h3/a');
			foreach ($res as $curr)
				$links[] = $url;
			
			return $links;
	}

	function extractNames($names, $ch2)
	{
			$res = $ch2->returnData('//div[@class="singleProduct" and div/p/a/span/strong != "Prenotalo" and contains(div/p/a/@class, "cartAddNoRadio")]//div[@class="singleProdInfo"]//h3/a');
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
			$res = $ch2->returnData('//div[@class="singleProduct" and div/p/a/span/strong != "Prenotalo" and contains(div/p/a/@class, "cartAddNoRadio")]/div[@class="prodBuy"]/p[1]/a/span/text()');
			foreach ($res as $curr)
			{
			 $string = $curr->nodeValue;
			 if ($string == "" || $string == " " || $string == NULL)
				continue;
			 else $prices[] = trim($curr->nodeValue);
			}
			 
			return $prices;
	}
	
	function extractPlatform($platforms, $ch2)
	{
			$res = $ch2->returnData('//div[@class="singleProduct" and div/p/a/span/strong != "Prenotalo" and contains(div/p/a/@class, "cartAddNoRadio")]//div[@class="singleProdInfo"]//h4/text()');
			foreach ($res as $curr)
			{
				$string = $curr->nodeValue;
				if ($string == "" || $string == " " || $string == NULL)
					continue;
				else $platforms[] = trim($curr->nodeValue);
			}
			 
			return $platforms;
	}
	
	function extractProducers($producers, $ch2)
	{
			$res = $ch2->returnData('//div[@class="singleProduct" and div/p/a/span/strong != "Prenotalo" and contains(div/p/a/@class, "cartAddNoRadio")]//div[@class="singleProdInfo"]/h4//strong');
			foreach ($res as $curr)
			{
				$string = $curr->nodeValue;
				if ($string == "" || $string == " " || $string == NULL)
					continue;
				else $producers[] = trim($curr->nodeValue);
			}
			
			return $producers;
	}
	
	function extractInfo($infos, $ch2)
	{
			$res = $ch2->returnData('//div[@class="singleProduct" and div/p/a/span/strong != "Prenotalo" and contains(div/p/a/@class, "cartAddNoRadio")]//div[@class="singleProdInfo"]//p');
			foreach ($res as $curr)
			{
				$string = $curr->nodeValue;
				if ($string == "" || $string == " " || $string == NULL)
					continue;
				else $infos[] = trim($curr->nodeValue);
			}
			
			return $infos;
	}
	
	function extractDates($pDates, $ch2)
	{
			$res = $ch2->returnData('//div[@class="singleProduct" and div/p/a/span/strong != "Prenotalo" and contains(div/p/a/@class, "cartAddNoRadio")]//div[@class="singleProdInfo"]//ul/li/strong[contains(string(.), "Data di uscita")]');
			foreach ($res as $curr)
			{
				$arrays = explode(":", $curr->nodeValue);
				if ($arrays[1] == "" || $arrays[1] == " " || $arrays[1] == NULL)
					continue;
				else $pDates[] = trim($arrays[1]);
			}
			
			return $pDates;
	}
	
	function extractType($type, $ch2)
	{
			$res = $ch2->returnData('//div[@class="singleProduct" and div/p/a/span/strong != "Prenotalo" and contains(div/p/a/@class, "cartAddNoRadio")]//div[@class="prodBuy"]/p[1]/a//strong');
			foreach ($res as $curr)
			{
				$string = $curr->nodeValue;
				if ($string == "" || $string == " " || $string == NULL)
					continue;
				if (stripos($string, "Digitale") !== false)
					$type[] = "Digitale";
				else $type[] = "Classico";
			}
			
			return $type;
	}
	
	function writeXML($images, $links, $names, $prices, $infos, $platforms, $producers, $type, $pDates)
	{
			//Dichiaro l'XML di ritorno
			$xml = '<?xml version="1.0"><list_products>';
			
			$len = count($links);
			
			for ($n = 0; $n < $len; $n++)
			{
				$xml = $xml.'<product><name>'.$names[$n].'</name><platform>'.$platforms[$n].'</platforms><producer>'.$producers[$n].'</producer>';
				$xml = $xml.'<price>'.$prices[$n].'</price><date>'.$pDates[$n].'</date><info_extra>'.$infos[$n].'</info><purchaseType>'.$type[$n].'</publication_date><image>'.$images[$n].'</image><link>'.$links[$n].'</link></product>';
			}
			
			$xml = $xml.'</list_products>';	
			return $xml;
	}
?>
