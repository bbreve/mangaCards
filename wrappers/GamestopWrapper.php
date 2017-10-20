<?php 

	header("Content-type: application/xml");
	
<<<<<<< HEAD
	global $xpath;
	
=======
	global $ch, $url;

>>>>>>> f629c32b126a7674fd7ee2d01f9e115e7da72992
	//Platform 10 PC
	//Platform 27 PS4
	//Platform 18 PSVITA
	//Platform 28 XBOXONE
	//Platform 37 SWITCH
	
	libxml_use_internal_errors(true);
	
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
	$search = "batman";

	//XBOX ONE
	$url = "https://www.gamestop.it/SearchResult/QuickSearch?q=".urlencode($search)."&platform=28";
<<<<<<< HEAD
	$dom = new DomDocument;
	$dom->loadHTMLFile($url);
	$xpath = new DomXPath($dom);
=======

	$dom = new DomDocument();
	$dom->loadHTMLFile($url);
	/* Create a new XPath object */
	$xpath = new DomXPath($dom);
	      
>>>>>>> f629c32b126a7674fd7ee2d01f9e115e7da72992

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
	$url = "https://www.gamestop.it/SearchResult/QuickSearch?q=".urlencode($search)."&platform=27";
	$dom = new DomDocument();
	$dom->loadHTMLFile($url);
	$xpath = new DomXPath($dom); 

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
	$url = "https://www.gamestop.it/SearchResult/QuickSearch?q=".urlencode($search)."&platform=10";
	$dom = new DomDocument();
	$dom->loadHTMLFile($url);
	$xpath = new DomXPath($dom); 

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
	$url = "https://www.gamestop.it/SearchResult/QuickSearch?q=".urlencode($search)."&platform=37";
	$dom = new DomDocument();
	$dom->loadHTMLFile($url);
	$xpath = new DomXPath($dom); 

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
	$url = "https://www.gamestop.it/SearchResult/QuickSearch?q=".urlencode($search)."&platform=18";
	$dom = new DomDocument();
	$dom->loadHTMLFile($url);
	$xpath = new DomXPath($dom); 

	extractImage();
	extractLink();	
	extractTitle();
	extractDate();
	extractProducer();
	extractPlatform();
	extractPrices();
	extractPEGI();
	extractOtherInfos();	
	
	/* DEBUG
	echo "<pre>";
	var_dump(count($images)." ".count($links)." ".count($titles)." ".count($pDates)." ".count($producers)." ".count($platforms)." ".count($prices)." ".count($usedPrices)." ".count($pegi)." ".count($other_infos));
	die();
	*/
				
	writeXML();
	echo $xml->asXML();
	
	function writeXML()
	{					
			global $images, $links, $titles, $prices, $usedPrices, $pegi, $platforms, $producers, $pDates, $other_infos, $xml;
			
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
					$prodotto->addChild("release_date", $pDates[$n]);
				
				$prodotto->addChild("pegi", $pegi[$n]);
				
				if (count($other_infos) > 0)
				{
					$other = $prodotto->addChild("other_infos");
					for($k=0; $k < count($other_infos[$n]); $k++)
							$other->addChild("info", $other_infos[$n][$k]);
				}
				
				if ($images[$n] <> "")
					$prodotto->addChild("image", $images[$n]);
				
				$prodotto->addChild("prod_link", $links[$n]);
			}
			
			$arr = array();
			foreach($xml->product as $prod)
			{
				$arr[] = $prod;
			}
			
			usort($arr, function($a, $b){
				return strcmp($a->name, $b->name);
			});
			
			$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><offers></offers>');
			foreach($arr as $product)
			{
				$value = $xml->addChild('offer');
				$value->addChild('title',(string)$product->name);
				$value->addChild('producer',(string)$product->producer);
				$value->addChild('platform',(string)$product->platform);
				
				if (((string) $product->price) != NULL)
					$value->addChild('price',(string)$product->price);
				if (((string) $product->usedPrice) != NULL)
					$value->addChild('used_price',(string)$product->usedPrice);	

				$value->addChild('release_date',(string)$product->release_date);
				$value->addChild('pegi',(string)$product->pegi);
				
				if ($product->other_infos != NULL)
				{
					$infos = $product->other_infos;
					$other = $value->addChild("other_infos");
					foreach($infos->info as $in)
					{
						$other->addChild("info", (string) $in);	
					}					
				}
				
				$value->addChild('cover',(string)$product->image);
				$value->addChild('url_to_product',(string)$product->prod_link);
			}
	}
	
	function extractImage()
	{
			global $images, $xpath;
			$res = $xpath->query('//div[@class="singleProduct" and div/p/a/span/strong != "Prenotalo" and div/p/a/span/strong != "Digitale" and contains(div/p/a/@class, "cartAddNoRadio")]');
			foreach ($res as $curr)
			{
				$img = $xpath->query('./a/img/@data-llsrc', $curr);
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
					$string = trim($price->item(1)->nodeValue);
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
					$string = trim($used->item(1)->nodeValue);
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
				$li = $xpath->query('.//div[@class="singleProdInfo"]//ul/li[not(contains(string(.), "Data")) and not(contains(string(.), "digitale"))]', $curr);
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
?>
