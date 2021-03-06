<?php 

	header("Content-type: application/xml");

	//Platform 10 PC
	//Platform 27 PS4
	//Platform 18 PSVITA
	//Platform 28 XBOXONE
	//Platform 37 SWITCH
	
	libxml_use_internal_errors(true);
	$title = $_POST['title'];
	preg_match('!(((\w+ )|(\w+)|( \w+))(\'?)(:?))*!ui',$title, $title_cleaned);
	$title=$title_cleaned[0];
	
	$conn = new mysqli("localhost", "root", "", "db_mangacards");//database connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
						}
						
					
    $conn->set_charset("utf8");
	$querySQL="SELECT * FROM `gamestop` WHERE Serie='$title'";
	$resultQuery=mysqli_query($conn,$querySQL);
	if($resultQuery->num_rows !=0){
		   $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><offers></offers>');
		while ($row=$resultQuery->fetch_object()){
			$value = $xml->addChild('offer');
			$value->addChild('title',$row->NomeOfferta);
			$value->addChild('producer',$row->Produttore);
			$value->addChild('platform',$row->Piattaforma);
			if($row->Prezzo)
			$value->addChild('price',$row->Prezzo);
		    if($row->PrezzoUsato!="")
			$value->addChild('used_price',$row->PrezzoUsato);	
		    
			$value->addChild('release_date',$row->DataUscita);
			$value->addChild('pegi',$row->PEGI);
			$value->addChild('cover',$row->Immagine);
			$value->addChild('url_to_product',$row->LinkAcquisto);
			
			
		}
			echo $xml->asXML();
			$conn->close();
	}else{
	   $conn->close();
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
	
	//Parametri di ricerca
	$pag = 1;
	
	$origin = $_POST['origin'];
	$type = $_POST['type'];
	$en_name = $_POST['english'];
	
	$searchTitle = transform($title);
	if (stripos($searchTitle, ":") !== FALSE)
	{
		$searchTitle = trim(explode(":", $searchTitle)[0]);	
	}
	else if (stripos($searchTitle, "(") !== FALSE)
	{
		$searchTitle = trim(explode("(", $searchTitle)[0]);
	}
	
	//Cerco per i manga nel titolo italiano (modificato) e quello inglese
	if ($type == "manga")
		$search_names = array($searchTitle, $en_name);
	//Faccio lo stesso per i comic
	else
		$search_names = array($searchTitle, $origin); 
	
	//Variabile di uscita dal ciclo
	$value = TRUE;
	
	//Per ogni titolo da provare
	for ($counter = 0; $counter < count($search_names); $counter++)
	{
			//Si splitta sui caratteri particolari di ricerca
			if (stripos($search_names[$counter], ":") !== FALSE) 
				$arr = explode(":", $search_names[$counter]);
			else
				$arr = explode("-", $search_names[$counter]);
			
			for ($i = 0; $i < count($arr); $i++)
			{
				$search = trim($arr[$i]);
				
				//XBOX ONE
				$url = "https://www.gamestop.it/SearchResult/QuickSearch?q=".urlencode($search)."&platform=28";
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
	
				//XBOX 360
				$url = "https://www.gamestop.it/SearchResult/QuickSearch?q=".urlencode($search)."&platform=4";
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

				//PS3
				$url = "https://www.gamestop.it/SearchResult/QuickSearch?q=".urlencode($search)."&platform=2";
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
	
				//PS2
				$url = "https://www.gamestop.it/SearchResult/QuickSearch?q=".urlencode($search)."&platform=1";
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
	
				//PSP
				$url = "https://www.gamestop.it/SearchResult/QuickSearch?q=".urlencode($search)."&platform=7";
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
	
				//3DS
				$url = "https://www.gamestop.it/SearchResult/QuickSearch?q=".urlencode($search)."&platform=17";
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
	
				//NDS
				$url = "https://www.gamestop.it/SearchResult/QuickSearch?q=".urlencode($search)."&platform=8";
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
	
				//WIIU
				$url = "https://www.gamestop.it/SearchResult/QuickSearch?q=".urlencode($search)."&platform=23";
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
	
				//WII
				$url = "https://www.gamestop.it/SearchResult/QuickSearch?q=".urlencode($search)."&platform=6";
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
				
				writeXML();
				
				if ($xml->count() > 0)
				{
					$value = FALSE;
					break;
				}
			}
			
			if ($value == FALSE)
				break;
	}
	
	echo $xml->asXML();
}
	function writeXML()
	{					
			global $images, $links, $titles, $prices, $usedPrices, $pegi, $platforms, $producers, $pDates, $xml;
			
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
	
				if ($images[$n] <> "")
					$prodotto->addChild("image", $images[$n]);
				
				$prodotto->addChild("prod_link", htmlspecialchars($links[$n]));
			}
			
			$arr = array();
			foreach($xml->product as $prod)
			{
				$arr[] = $prod;
			}
			
			usort($arr, function($a, $b){
				return strcmp($a->name, $b->name);
			});
			
			$conn = new mysqli("localhost", "root", "", "db_mangacards");//database connection
				if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
						}
						
		    $conn->set_charset("utf8");
			
			$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><offers></offers>');
			foreach($arr as $product)
			{
				$nomeProdotto="";
				$serieProdotto="";
				$piattaformaProdotto="";
				$produttoreProdotto="";
				$prezzoProdotto="";
				$prezzoUsatoProdotto="";
				$dataUscitaProdotto="";
				$pegiProdotto="";
				$immagineProdotto="";
				$linkAcquistoProdotto="";
				
				$value = $xml->addChild('offer');
				$value->addChild('title',(string)$product->name);
				$nomeProdotto=(string)$product->name;
				$value->addChild('producer',(string)$product->producer);
				$produttoreProdotto=(string)$product->producer;
				$value->addChild('platform',(string)$product->platform);
				$piattaformaProdotto=(string)$product->platform;
				
				if (((string) $product->price) != NULL){
					$value->addChild('price',(string)$product->price);
					$prezzoProdotto=(string)$product->price;
				}
				if (((string) $product->usedPrice) != NULL){
					$value->addChild('used_price',(string)$product->usedPrice);	
					$prezzoUsatoProdotto=(string)$product->usedPrice;
				}

				$value->addChild('release_date',(string)$product->release_date);
				$dataUscitaProdotto=(string)$product->release_date;
				$value->addChild('pegi',(string)$product->pegi);
				$pegiProdotto=(string)$product->pegi;
				
				
				$value->addChild('cover',(string)$product->image);
				$immagineProdotto=(string)$product->image;
				$value->addChild('url_to_product',(string)$product->prod_link);
				$linkAcquistoProdotto=(string)$product->prod_link;
				$serieProdotto=$_POST['title'];
				
				$nomeProdotto=str_replace(array("\"","\'"),"",$nomeProdotto);
				$produttoreProdotto=str_replace(array("\"","\'"),"",$produttoreProdotto);
				
				$toinsert = 'INSERT INTO gamestop
							(NomeOfferta, Serie, Piattaforma, Produttore, Prezzo, PrezzoUsato, DataUscita, PEGI, Immagine, LinkAcquisto)
							VALUES
							("'.$nomeProdotto.'", "'.$serieProdotto.'", "'.$piattaformaProdotto.'", "'.$produttoreProdotto.'", "'.$prezzoProdotto.'", "'.$prezzoUsatoProdotto.'", "'.$dataUscitaProdotto.'", "'.$pegiProdotto.'", "'.$immagineProdotto.'", "'.$linkAcquistoProdotto.'")';
							
							if ($conn->query($toinsert) === TRUE) {
									//echo "New record created successfully";
									} else {
										//echo "Error: " . $sql . "<br>" . $conn->error;
												}
				
			}
			$conn->close();
	}
	
	function extractImage()
	{
			global $images, $xpath, $search;
			$res = $xpath->query('//div[@class="singleProduct" and div/p/a/span/strong != "Prenotalo" and div/p/a/span/strong != "Digitale" and contains(div/p/a/@class, 
"cartAddNoRadio")]');
			if ($res->length != 0)
			{
				foreach ($res as $curr)
				{
					$title = $xpath->query('.//div[@class="singleProdInfo"]//h3/a', $curr);
				
					$string = trim($title->item(0)->nodeValue);
					if (checkProduct($string) == FALSE)
						continue;
				
					$link = $xpath->query('.//div[@class="singleProdInfo"]//h3/a/@href', $curr);
					$dom1 = new DomDocument;
					$dom1->loadHTMLFile("https://www.gamestop.it".trim($link->item(0)->nodeValue));
					$innerXPath = new DomXPath($dom1);
					
					$img = $innerXPath->query('//a[contains(@class, "prodImg")]/img/@src');
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
			else
			{
				$res = $xpath->query('//div[@class="prodDet"]//h1/span[@itemprop="name"]');
				
				if ($res->length == 0)
					return;
				
				$string = trim($res->item(0)->nodeValue);
				if (checkProduct($string) == FALSE)
					return;
				
				$res = $xpath->query('//a[contains(@class, "prodImg")]/img/@src');
				if ($res->length != 0)
				{
					$string = trim($res->item(0)->nodeValue);
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
			global $links, $xpath, $search, $url;
			$res = $xpath->query('//div[@class="singleProduct" and div/p/a/span/strong != "Prenotalo" and div/p/a/span/strong != "Digitale" and contains(div/p/a/@class, 
"cartAddNoRadio")]');
			if ($res->length != 0)
			{
				foreach ($res as $curr)
				{
					$title = $xpath->query('.//div[@class="singleProdInfo"]//h3/a', $curr);
					$string = trim($title->item(0)->nodeValue);
					if (checkProduct($string) == FALSE)
						continue;
				
					$anchor = $xpath->query('.//h3/a/@href', $curr);
					$string = trim($anchor->item(0)->nodeValue);
					if ($string == "" || $string == " " || $string == NULL)
						$links[] = "";
					else 
						$links[] = "http://www.gamestop.it".$string;
				}
			}
			else
			{
				$res = $xpath->query('//div[@class="prodDet"]//h1/span[@itemprop="name"]');
				
				if ($res->length == 0)
					return;
				
				$string = trim($res->item(0)->nodeValue);
				if (checkProduct($string) == FALSE)
					return;
				
				$links[] = htmlspecialchars($url);
			}
	}

	function extractTitle()
	{
			global $titles, $xpath, $search;
			$res = $xpath->query('//div[@class="singleProduct" and div/p/a/span/strong != "Prenotalo" and div/p/a/span/strong != "Digitale" and contains(div/p/a/@class, 
"cartAddNoRadio")]');
			if ($res->length != 0)
			{
				foreach ($res as $curr)
				{
					$title = $xpath->query('.//div[@class="singleProdInfo"]//h3/a', $curr);
					$string = trim($title->item(0)->nodeValue);
					if (checkProduct($string) == FALSE)
						continue;
					else 
						$titles[] = $string;
				}
			}
			else
			{
				$res = $xpath->query('//div[@class="prodDet"]//h1/span[@itemprop="name"]');
				if ($res->length != 0)
				{
					$string = trim($res->item(0)->nodeValue);
					if (checkProduct($string) == FALSE)
						return;
					else
						$titles[] = $string;	
				}
			}
	}
	
	function extractPrices()
	{
			global $prices, $usedPrices, $xpath, $search;
			$res = $xpath->query('//div[@class="singleProduct" and div/p/a/span/strong != "Prenotalo" and div/p/a/span/strong != "Digitale" and contains(div/p/a/@class, 
"cartAddNoRadio")]');
			if ($res->length != 0)
			{
				foreach ($res as $curr)
				{
					$title = $xpath->query('.//div[@class="singleProdInfo"]//h3/a', $curr);
					$string = trim($title->item(0)->nodeValue);
					if (checkProduct($string) == FALSE)
						continue;
				
					//Estraggo il prezzo nuovo 
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
			else{
				$res = $xpath->query('//div[@class="prodDet"]//h1/span[@itemprop="name"]');
				
				if ($res->length == 0)
					return;
				
				$string = trim($res->item(0)->nodeValue);
				if (checkProduct($string) == FALSE)
					return;
				
				$res = $xpath->query('//div[@class="pricetext"]//span[@itemprop="price"]');
				if ($res->length != 0)
				{
					$string = trim($res->item(0)->nodeValue);
					if ($string == "" || $string == " " || $string == NULL)
						$prices[] = "";
					else 
						$prices[] = $string;
				}
				else
					$prices[] = "";
				
				$res = $xpath->query('//div[@class="pricetext1"]//span[@itemprop="price"]');
				if ($res->length != 0)
				{
					$string = trim($res->item(0)->nodeValue);
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
			global $platforms, $xpath, $search;
			$res = $xpath->query('//div[@class="singleProduct" and div/p/a/span/strong != "Prenotalo" and div/p/a/span/strong != "Digitale" and contains(div/p/a/@class, 
"cartAddNoRadio")]');
			if ($res->length != 0)
			{
				foreach ($res as $curr)
				{
					$title = $xpath->query('.//div[@class="singleProdInfo"]//h3/a', $curr);
					$string = trim($title->item(0)->nodeValue);
					if (checkProduct($string) == FALSE)
						continue;
				
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
			else
			{
				$res = $xpath->query('//div[@class="prodDet"]//h1/span[@itemprop="name"]');
				
				if ($res->length == 0)
					return;
				
				$string = trim($res->item(0)->nodeValue);
				if (checkProduct($string) == FALSE)
					return;
				
				$res = $xpath->query('//div[@class="prodDet"]//span[contains(@class, "platLogo")]');
				if ($res->length != 0)
				{
					$string = trim($res->item(0)->nodeValue);
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
			global $producers, $xpath, $search;
			$res = $xpath->query('//div[@class="singleProduct" and div/p/a/span/strong != "Prenotalo" and div/p/a/span/strong != "Digitale" and contains(div/p/a/@class, 
"cartAddNoRadio")]');
			if ($res->length != 0)
			{
				foreach ($res as $curr)
				{
					$title = $xpath->query('.//div[@class="singleProdInfo"]//h3/a', $curr);
					$string = trim($title->item(0)->nodeValue);
					if (checkProduct($string) == FALSE)
						continue;
				
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
			else
			{
				$res = $xpath->query('//div[@class="prodDet"]//h1/span[@itemprop="name"]');
				
				if ($res->length == 0)
					return;
				
				$string = trim($res->item(0)->nodeValue);
				if (checkProduct($string) == FALSE)
					return;
				
				$res = $xpath->query('//div[@class="prodDet"]//strong[@itemprop="brand"]');
				if ($res->length != 0)
				{
					$string = trim($res->item(0)->nodeValue);
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
			global $pegi, $xpath, $search;
			$res = $xpath->query('//div[@class="singleProduct" and div/p/a/span/strong != "Prenotalo" and div/p/a/span/strong != "Digitale" and contains(div/p/a/@class, 
"cartAddNoRadio")]');
			if ($res->length != 0)
			{
				foreach ($res as $curr)
				{
					$title = $xpath->query('.//div[@class="singleProdInfo"]//h3/a', $curr);
					$string = trim($title->item(0)->nodeValue);
					if (checkProduct($string) == FALSE)
						continue;
				
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
			else
			{
				$res = $xpath->query('//div[@class="prodDet"]//h1/span[@itemprop="name"]');
				
				if ($res->length == 0)
					return;
				
				$string = trim($res->item(0)->nodeValue);
				if (checkProduct($string) == FALSE)
					return;

				$pegi[] = "N/A";	
			}
	}
	
	function extractDate()
	{
			global $pDates, $xpath, $search;
			$res = $xpath->query('//div[@class="singleProduct" and div/p/a/span/strong != "Prenotalo" and div/p/a/span/strong != "Digitale" and contains(div/p/a/@class, 
"cartAddNoRadio")]');
			if ($res->length != 0)
			{
				foreach ($res as $curr)
				{
					$title = $xpath->query('.//div[@class="singleProdInfo"]//h3/a', $curr);
					$string = trim($title->item(0)->nodeValue);
					if (checkProduct($string) == FALSE)
						continue;
				
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
			else
			{
				$res = $xpath->query('//div[@class="prodDet"]//h1/span[@itemprop="name"]');
				
				if ($res->length == 0)
					return;
				
				$string = trim($res->item(0)->nodeValue);
				if (checkProduct($string) == FALSE)
					return;

				$res = $xpath->query('//div[@class="addedDetInfo"]//p/label[contains(text(), "Rilascio")]/following-sibling::span[1]/text()');	
				if ($res->length != 0)
				{
					$string = trim($res->item(0)->nodeValue);
					if ($string == "" || $string == " " || $string == NULL)
						$pDates[] = "";
					else 
						$pDates[] = $string;
				}
				else
					$pDates[] = "";
			}
	}
	
	function transform($string)
	{
		if (stripos($string, "×") !== FALSE)
			$string = str_replace("×", "x", $string);

		return $string;
	}
	
	function checkProduct($string)
	{
		global $searchTitle, $en_name, $origin;
		
		$modString = str_replace("-", " ", $string);
		
		if (stripos($searchTitle, $string) !== FALSE || stripos($string, $searchTitle) !== FALSE || stripos($searchTitle, $modString) !== FALSE || stripos($modString, $searchTitle) !== FALSE)
			return TRUE;
		
		if (stripos($en_name, $string) !== FALSE || stripos($string, $en_name) !== FALSE || stripos($en_name, $modString) !== FALSE || stripos($modString, $en_name) !== FALSE)
			return TRUE;
		
		if (stripos($origin, $string) !== FALSE || stripos($string, $origin) !== FALSE || stripos($origin, $modString) !== FALSE || stripos($modString, $origin) !== FALSE)
			return TRUE;
		
		return FALSE;
	}
?>
