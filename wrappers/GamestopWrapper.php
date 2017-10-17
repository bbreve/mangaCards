<?php 

	header("Content-type: application/xml");
	
	//Platform 10 PC
	//Platform 27 PS4
	//Platform 18 PSVITA
	//Platform 28 XBOXONE
	//Platform 37 SWITCH
	
	//Dichiaro l'XML di ritorno
	$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><list_products></list_products>');

	//Dichiaro gli array per le informazioni
	$images = array();
	$links = array();
	$titles = array();
	$prices = array();
	$usedPrices = array();
	$pegi = array();
	$platforms = array();
	$pDates = array();
	$producers = array();
	$other_infos = array();
	
	//Parametri di ricerca
	$pag = 1;
	$search = "one piece";

	//XBOX ONE
	$ch = curl_init();
	$url = "https://www.gamestop.it/SearchResult/QuickSearch?q=".urlencode($search)."&platform=28";
	setCurl();
	$content = curl_exec($ch);			
	$dom = new DomDocument();
	@$dom->loadHTML($content);
	$xpath = new DOMXPath($dom);         

	extractImage();
	extractLink();	
	extractTitle();
	extractDate();
	extractProducer();
	extractPlatform();
	extractPrices();
	extractPEGI();
	extractOtherInfos();
	
	//PS4
	$ch = curl_init();
	$url = "https://www.gamestop.it/SearchResult/QuickSearch?q=".urlencode($search)."&platform=27";
	setCurl();
	$content = curl_exec($ch);			
	$dom = new DomDocument();
	@$dom->loadHTML($content);
	$xpath = new DOMXPath($dom); 

	extractImage();
	extractLink();	
	extractTitle();
	extractDate();
	extractProducer();
	extractPlatform();
	extractPrices();
	extractPEGI();
	extractOtherInfos();
	
	//PC
	$ch = curl_init();
	$url = "https://www.gamestop.it/SearchResult/QuickSearch?q=".urlencode($search)."&platform=10";
	setCurl();
	$content = curl_exec($ch);			
	$dom = new DomDocument();
	@$dom->loadHTML($content);
	$xpath = new DOMXPath($dom); 

	extractImage();
	extractLink();	
	extractTitle();
	extractDate();
	extractProducer();
	extractPlatform();
	extractPrices();
	extractPEGI();
	extractOtherInfos();
	
	//SWITCH
	$ch = curl_init();
	$url = "https://www.gamestop.it/SearchResult/QuickSearch?q=".urlencode($search)."&platform=37";
	setCurl();
	$content = curl_exec($ch);			
	$dom = new DomDocument();
	@$dom->loadHTML($content);
	$xpath = new DOMXPath($dom); 

	extractImage();
	extractLink();	
	extractTitle();
	extractDate();
	extractProducer();
	extractPlatform();
	extractPrices();
	extractPEGI();
	extractOtherInfos();
	
	//PSVITA
	$ch = curl_init();
	$url = "https://www.gamestop.it/SearchResult/QuickSearch?q=".urlencode($search)."&platform=18";
	setCurl();
	$content = curl_exec($ch);			
	$dom = new DomDocument();
	@$dom->loadHTML($content);
	$xpath = new DOMXPath($dom); 

	extractImage();
	extractLink();	
	extractTitle();
	extractDate();
	extractProducer();
	extractPlatform();
	extractPrices();
	extractPEGI();
	extractOtherInfos();	
	
	writeXML();
	echo $xml->asXML();
	
	function writeXML()
	{					
			global $images, $links, $titles, $prices, $usedPrices, $pegi, $platforms, $producers, $buyType, $pDates, $other_infos, $xml;
			
			for ($n = 0; $n < count($links); $n++)
			{
				$prodotto = $xml->addChild("product");
				
				$prodotto->addChild("name", $titles[$n]);
				
				if ($platforms[$n] <> "")
					$prodotto->addChild("platform", $platforms[$n]);
				
				if ($producers[$n] <> "")
					$prodotto->addChild("producer", $producers[$n]);
				
				if ($prices[$n] <> "")
					$prodotto->addChild("price", $prices[$n]);
				
				if ($usedPrices[$n] <> "")
					$prodotto->addChild("usedPrice", $usedPrices[$n]);
				
				if ($pDates[$n] <> "")
					$prodotto->addChild("date", $pDates[$n]);
				
				$prodotto->addChild("pegi", $pegi[$n]);
				
				if (count($other_infos) > 0)
				{
					$other = $prodotto->addChild("other_infos");
					for ($i = 0; $i < count($other_infos); $i++)
						$other->addChild("info", $other_infos[$n][$i]);	
				}
				
				if ($images[$n] <> "")
					$prodotto->addChild("image", $images[$n]);
				
				$prodotto->addChild("link", $links[$n]);
			}
	}
	
	function extractImage()
	{
			global $images, $url, $xpath;
			$res = $xpath->query('//div[@class="singleProduct" and div/p/a/span/strong != "Prenotalo" and div/p/a/span/strong != "Digitale" and contains(div/p/a/@class, "cartAddNoRadio")]');
			foreach ($res as $curr)
			{
				$img = $xpath->query('./a/img/@src', $curr);
				if ($img->length != 0)
				{
					$string = trim($img->item(0)->nodeValue);
					if ($string == "" || $string == " " || $string == NULL)
						$images[] = "";
					else 
						$images[] = $string;
				}
				else
					$images[] = "";
			}
	}
	
	function extractLink()
	{
			global $links, $xpath;
			$res = $xpath->query('//div[@class="singleProduct" and div/p/a/span/strong != "Prenotalo" and div/p/a/span/strong != "Digitale" and contains(div/p/a/@class, "cartAddNoRadio")]');
			foreach ($res as $curr)
			{
				$anchor = $xpath->query('.//h3/a/@href', $curr);
				$string = trim($anchor->item(0)->nodeValue);
				if ($string == "" || $string == " " || $string == NULL)
					$links[] = "";
				else 
					$links[] = "http://www.gamestop.it".$string;
			}
	}

	function extractTitle()
	{
			global $titles, $xpath;
			$res = $xpath->query('//div[@class="singleProduct" and div/p/a/span/strong != "Prenotalo" and div/p/a/span/strong != "Digitale" and contains(div/p/a/@class, "cartAddNoRadio")]');
			foreach ($res as $curr)
			{
				$title = $xpath->query('.//div[@class="singleProdInfo"]//h3/a', $curr);
				$string = trim($title->item(0)->nodeValue);
				if ($string == "" || $string == " " || $string == NULL)
					continue;
				else 
					$titles[] = $string;
			}
	}
	
	function extractPrices()
	{
			global $prices, $usedPrices, $xpath;
			$res = $xpath->query('//div[@class="singleProduct" and div/p/a/span/strong != "Prenotalo" and div/p/a/span/strong != "Digitale" and contains(div/p/a/@class, "cartAddNoRadio")]');
			foreach ($res as $curr)
			{
				//Estraggo il prezzo nuovo o digitale
				$price = $xpath->query('.//div[@class="prodBuy"]//p[@class="buyNew"]//a/span/text()', $curr);
				if ($price->length != 0)
				{
					$string = trim($price->item(0)->nodeValue);
					if ($string == "" || $string == " " || $string == NULL)
						$prices[] = "";
					else 
						$prices[] = $string;
				}
				else
					$prices[] = "";
				
				//Estraggo l'eventuale prezzo usato
				$used = $xpath->query('.//div[@class="prodBuy"]//p[@class="buyUsed"]//a/span/text()', $curr);
				if ($used->length != 0)
				{
					$string = trim($used->item(0)->nodeValue);
					if ($string == "" || $string == " " || $string == NULL)
						$usedPrices[] = "";
					else 
						$usedPrices[] = $string;
				}
				else
					$usedPrices[] = "";
			}
	}
	
	function extractPlatform()
	{
			global $platforms, $xpath;
			$res = $xpath->query('//div[@class="singleProduct" and div/p/a/span/strong != "Prenotalo" and div/p/a/span/strong != "Digitale" and contains(div/p/a/@class, "cartAddNoRadio")]');
			foreach ($res as $curr)
			{
				$platf = $xpath->query('.//div[@class="singleProdInfo"]//h4/text()', $curr);
				if ($platf->length != 0)
				{
					$string = trim($platf->item(0)->nodeValue);
					if ($string == "" || $string == " " || $string == NULL)
						$platforms[] = "";
					else 
						$platforms[] = $string;
				}
				else
					$platforms[] = "";
			}
	}
	
	function extractProducer()
	{
			global $producers, $xpath;
			$res = $xpath->query('//div[@class="singleProduct" and div/p/a/span/strong != "Prenotalo" and div/p/a/span/strong != "Digitale" and contains(div/p/a/@class, "cartAddNoRadio")]');
			foreach ($res as $curr)
			{
				$house = $xpath->query('.//div[@class="singleProdInfo"]/h4//strong', $curr);
				if ($house->length != 0)
				{
					$string = trim($house->item(0)->nodeValue);
					if ($string == "" || $string == " " || $string == NULL)
						$producers[] = "";
					else 
						$producers[] = $string;
				}
				else
					$producers[] = "";
			}
	}
	
	function extractPEGI()
	{
			global $pegi, $xpath;
			$res = $xpath->query('//div[@class="singleProduct" and div/p/a/span/strong != "Prenotalo" and div/p/a/span/strong != "Digitale" and contains(div/p/a/@class, "cartAddNoRadio")]');
			foreach ($res as $curr)
			{
				$age = $xpath->query('.//div[@class="singleProdInfo"]//p/strong[contains(text(), "PEGI")]', $curr);
				if ($age->length != 0)
				{
					$string = trim($age->item(0)->nodeValue);
					if ($string == "" || $string == " " || $string == NULL || $string == "N/A")
						$pegi[] = "N/A";
					else 
					{
						preg_match_all('#\d+#', $string, $match);
						$s = "";
						foreach($match[0] as $m)
							$s .= $m." ";
						
						$pegi[] = trim($s);
					}
				}
				else
					$pegi[] = "N/A";
			}
	}
	
	function extractDate()
	{
			global $pDates, $xpath;
			$res = $xpath->query('//div[@class="singleProduct" and div/p/a/span/strong != "Prenotalo" and div/p/a/span/strong != "Digitale" and contains(div/p/a/@class, "cartAddNoRadio")]');
			foreach ($res as $curr)
			{
				$release = $xpath->query('.//div[@class="singleProdInfo"]//ul/li/strong[contains(string(.), "Data di uscita")]', $curr);
				if ($release->length != 0)
				{
					$arrays = explode(":", $release->item(0)->nodeValue);
					if ($arrays[1] == "" || $arrays[1] == " " || $arrays[1] == NULL)
						$pDates[] = "";
					else 
						$pDates[] = trim($arrays[1]);
				}
				else
					$pDates[] = "";
			}
	}
	
	function extractOtherInfos()
	{
			global $other_infos, $xpath;
			$res = $xpath->query('//div[@class="singleProduct" and div/p/a/span/strong != "Prenotalo" and div/p/a/span/strong != "Digitale" and contains(div/p/a/@class, "cartAddNoRadio")]');
			foreach ($res as $curr)
			{
				$li = $xpath->query('.//div[@class="singleProdInfo"]//ul/li/strong[not(contains(string(.), "Data di uscita")) and not(contains(string(.), "contenuto digitale"))]', $curr);
				if ($li->length > 0)
				{
					$arr = array();
					foreach($li as $l)
					{
						$arr[] = $l->nodeValue;
					}
					
					$other_infos[] = $arr;
				}
				else
					$other_infos[] = array();
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
