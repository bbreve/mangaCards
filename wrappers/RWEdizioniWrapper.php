<?php 
	header("Content-type: application/xml");

	//Dichiaro gli array per le informazioni
	$images = array();
	$links = array();
	$titles = array();
	$prices = array();
	$innerChapters = array();
	$descriptions = array();
	$pDates = array();
	$authors = array();
	$imprints = array();
	$collections = array();
	$series = array();
	
	libxml_use_internal_errors(true);
	
	//Dichiaro l'XML di ritorno
	$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><list_products></list_products>');
	
	//Parametri di ricerca
	$title = $_POST['title'];
	
	//Modifica parametro di ricerca
	if (stripos($title, "(") !== FALSE)
	{
		$search = trim(explode("(", $title)[0]);
		$search = str_replace(":", "", $search);
	}
	else
	{
		$search = str_replace(":", "", $title);
	}
	
	$pag = 1;

	//Chiamata prima pagina
	$url = "http://www.rwedizioni.it/search/".urlencode($search);
	$dom = new DomDocument;
	$dom->loadHTMLFile($url);
	$xpath = new DomXPath($dom);
	
	//Estraggo info della prima pagina
	extractLink();	
	extractTitle();
	extractPrice();
	extractDate();
	extractImprint();
	extractCollection();
	extractSeries();
	extractInPage();
	
	//Cerco se ci sono pagine successive ed estraggo
	while(1)
	{	
		//Verifico se esiste una nuova pagina
		$dom->loadHTMLFile($url);
		$xpath = new DomXPath($dom);
		$res1 = $xpath->query('//a[contains(string(.), "Articoli più vecchi")]');
		
		if ($res1->length == 0)
          break;
	  
	    $pag += 1;
		$url = "http://www.rwedizioni.it/search/".urlencode($search)."/page/".$pag."/";
		$dom->loadHTMLFile($url);
		$xpath = new DomXPath($dom);
		
		//Estraggo info della pagina corrente	
		extractLink();	
		extractTitle();
		extractPrice();
		extractDate();
		extractImprint();
		extractCollection();
		extractSeries();
		extractInPage();
	}
	
	/*
	var_dump(count($images)." ".count($descriptions)." ".count($innerChapters)." ".count($authors)." ".count($titles)." ".count($pDates)." ".count($links)." ".count($prices)." ".count($imprints)." ".count($series)." ".count($collections));
	die();
	*/
	
	writeXML();
	echo $xml->asXML();
	
		
	function writeXML()
	{
			global $images, $links, $titles, $prices, $descriptions, $innerChapters, $pDates, $authors, $imprints, $collections, $series, $xml;
			for ($n = 0; $n < count($links); $n++)
			{
				$prodotto = $xml->addChild("product");
				
				$prodotto->addChild("title", $titles[$n]);
				if ($series[$n] <> "")
					$prodotto->addChild("editorial_series", $series[$n]);
			
				if ($collections[$n] <> "")
					$prodotto->addChild("collection", $collections[$n]);
		
				if ($imprints[$n] <> "")
					$prodotto->addChild("imprint", $imprints[$n]);
		
				if ($authors[$n] <> "")
					$prodotto->addChild("authors", $authors[$n]);
		
				if ($prices[$n] <> "")
					$prodotto->addChild("price", $prices[$n]);
				
				if ($pDates[$n] <> "")
					$prodotto->addChild("release_date", $pDates[$n]);
				
				if ($innerChapters[$n] <> "")
					$prodotto->addChild("containedChapters", $innerChapters[$n]);
		
				if ($descriptions[$n] <> "")	
					$prodotto->addChild("description", $descriptions[$n]);
				
				if ($images[$n] <> "")
					$prodotto->addChild("image", $images[$n]);
				$prodotto->addChild("prod_link", $links[$n]);
			}
			
			$arr = array();
			foreach($xml->product as $prod)
				$arr[] = $prod;
				
			usort($arr, function($a, $b){
				return strcmp($a->name, $b->name);
			});
			
			$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><offers></offers>');
			foreach($arr as $product)
			{
				$value = $xml->addChild('offer');
				$value->addChild('title',(string)$product->title);
				
				if (((string) $product->editorial_series) != NULL)
					$value->addChild('ed_series',(string)$product->editorial_series);
				if (((string) $product->collection) != NULL)
					$value->addChild('collection',(string)$product->collection);
				if (((string) $product->imprint) != NULL)
					$value->addChild('imprint',(string)$product->imprint);
				
				if (((string) $product->authors) != NULL)
					$value->addChild('authors',(string)$product->authors);
				
				if (((string) $product->price) != NULL)
					$value->addChild('price',(string)$product->price);
				
				if (((string) $product->release_date) != NULL)
					$value->addChild('release_date',(string)$product->release_date);
				
				if (((string) $product->containedChapters) != NULL)
					$value->addChild('containedChapters',(string)$product->containedChapters);	
				
				if (((string) $product->description) != NULL)
					$value->addChild('description',(string)$product->description);	
				
				if (((string) $product->image) != NULL)
					$value->addChild('cover',(string)$product->image);
				$value->addChild('url_to_product',(string)$product->prod_link);
			}
	}
	
	function extractInPage()
	{
			global $images, $innerChapters, $descriptions, $authors, $search, $title, $xpath;
			$dom1 = new DomDocument;
				
			$res = $xpath->query('//tbody/tr[contains(td[4], "Disponibile") and not(contains(td[4], "Non")) and count(td/img) > 0]');
			foreach ($res as $curr)
			{
				$name = $xpath->query('.//td[2]//a', $curr);
				$string = trim($name->item(0)->nodeValue);
				if (stripos($string, $search) === FALSE && stripos($search, $string) === FALSE && stripos($string, $title) === FALSE && stripos($title, $string) === FALSE)
					continue;
				
				$link = $xpath->query('.//td[2]//a/@href', $curr);
				$dom1->loadHTMLFile($link->item(0)->nodeValue);
				$innerXPath = new DomXPath($dom1);
				
				$img = $innerXPath->query('//div[@id="content"]//div[@class="images"]//img/@src');
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
				
				$aut = $innerXPath->query('//div[@id="content"]//span[contains(@class, "autori")]');
				if ($aut->length != 0)
				{
					$string = trim($aut->item(0)->nodeValue);
					if ($string == "" || $string == " " || $string == NULL)
						$authors[] = "";
					else 
						$authors[] = $string;
				}
				else
					$authors[] = "";
				
				$chapters = $innerXPath->query('//div[@id="content"]//span[contains(@class, "albi")]');
				if ($chapters->length != 0)
				{
					$string = trim($chapters->item(0)->nodeValue);
					if ($string == "" || $string == " " || $string == NULL)
						$innerChapters[] = "";
					else 
						$innerChapters[] = $string;
				}
				else
					$innerChapters[] = "";
				
				$descr = $innerXPath->query('//div[@id="tab-description"]//p');
				if ($descr->length != 0)
				{
					$string = trim($descr->item(0)->nodeValue);
					if ($string == "" || $string == " " || $string == NULL)
						$descriptions[] = "";
					else 
						$descriptions[] = $string;
				}
				else
					$descriptions[] = "";
			}
	}
	
	function extractLink()
	{
			global $links, $xpath, $title, $search;
			$res = $xpath->query('//tbody/tr[contains(td[4], "Disponibile") and not(contains(td[4], "Non")) and count(td/img) > 0]');
			
			foreach ($res as $curr)
			{
				$name = $xpath->query('.//td[2]//a', $curr);
				$string = trim($name->item(0)->nodeValue);
				if (stripos($string, $search) === FALSE && stripos($search, $string) === FALSE && stripos($string, $title) === FALSE && stripos($title, $string) === FALSE)
					continue;
				
				$link = $xpath->query('.//td[2]//a/@href', $curr);
				$string = trim($link->item(0)->nodeValue);
				if ($string == "" || $string == " " || $string == NULL)
					$links[] = "";
				else 
					$links[] = $string;
			}
	}

	function extractTitle()
	{
			global $titles, $xpath, $title, $search;
			$res = $xpath->query('//tbody/tr[contains(td[4], "Disponibile") and not(contains(td[4], "Non")) and count(td/img) > 0]');
			foreach ($res as $curr)
			{
				$name = $xpath->query('.//td[2]//a', $curr);
				$string = trim($name->item(0)->nodeValue);
				if (stripos($string, $search) === FALSE && stripos($search, $string) === FALSE && stripos($string, $title) === FALSE && stripos($title, $string) === FALSE)
					continue;
				
				if ($string == "" || $string == " " || $string == NULL)
					$titles[] = "";
				else 
					$titles[] = $string;
			}
	}
	
	function extractPrice()
	{
			global $prices, $xpath, $title, $search;
			$res = $xpath->query('//tbody/tr[contains(td[4], "Disponibile") and not(contains(td[4], "Non")) and count(td/img) > 0]');
			foreach ($res as $curr)
			{
				$name = $xpath->query('.//td[2]//a', $curr);
				$string = trim($name->item(0)->nodeValue);
				if (stripos($string, $search) === FALSE && stripos($search, $string) === FALSE && stripos($string, $title) === FALSE && stripos($title, $string) === FALSE)
					continue;
				
				$pr = $xpath->query('.//td[3]', $curr);
				if ($pr->length != 0)
				{
					$string = trim($pr->item(0)->nodeValue);
					if ($string == "" || $string == " " || $string == NULL)
						$prices[] = "";
					else 
						$prices[] = $string;
				}
			}
	}
	
	function extractDate()
	{
			global $pDates, $xpath, $title, $search;
			$res = $xpath->query('//tbody/tr[contains(td[4], "Disponibile") and not(contains(td[4], "Non")) and count(td/img) > 0]');
			foreach ($res as $curr)
			{
				$name = $xpath->query('.//td[2]//a', $curr);
				$string = trim($name->item(0)->nodeValue);
				if (stripos($string, $search) === FALSE && stripos($search, $string) === FALSE && stripos($string, $title) === FALSE && stripos($title, $string) === FALSE)
					continue;
				
				$day = $xpath->query('.//td[5]', $curr);
				if ($day->length != 0)
				{
					$string = transformDate(trim($day->item(0)->nodeValue));
					if ($string == "" || $string == " " || $string == NULL)
						$pDates[] = "";
					else 
						$pDates[] = $string;
				}
			}
	}
	
	function extractImprint()
	{
			global $imprints, $xpath, $title, $search;
			$res = $xpath->query('//tbody/tr[contains(td[4], "Disponibile") and not(contains(td[4], "Non")) and count(td/img) > 0]');
			foreach ($res as $curr)
			{
				$name = $xpath->query('.//td[2]//a', $curr);
				$string = trim($name->item(0)->nodeValue);
				if (stripos($string, $search) === FALSE && stripos($search, $string) === FALSE && stripos($string, $title) === FALSE && stripos($title, $string) === FALSE)
					continue;
				
				$impr = $xpath->query('.//td[7]', $curr);
				if ($impr->length != 0)
				{
					$string = trim($impr->item(0)->nodeValue);
					if ($string == "" || $string == " " || $string == NULL)
						$imprints[] = "";
					else 
						$imprints[] = $string;
				}
			}
	}
	
	function extractCollection()
	{
			global $collections, $xpath, $title, $search;
			$res = $xpath->query('//tbody/tr[contains(td[4], "Disponibile") and not(contains(td[4], "Non")) and count(td/img) > 0]');
			foreach ($res as $curr)
			{
				$name = $xpath->query('.//td[2]//a', $curr);
				$string = trim($name->item(0)->nodeValue);
				if (stripos($string, $search) === FALSE && stripos($search, $string) === FALSE && stripos($string, $title) === FALSE && stripos($title, $string) === FALSE)
					continue;
				
				$coll = $xpath->query('.//td[8]', $curr);
				if ($coll->length != 0)
				{
					$string = trim($coll->item(0)->nodeValue);
					if ($string == "" || $string == " " || $string == NULL)
						$collections[] = "";
					else 
						$collections[] = $string;
				}
			}
	}
	
	function extractSeries()
	{
			global $series, $xpath, $title, $search;
			$res = $xpath->query('//tbody/tr[contains(td[4], "Disponibile") and not(contains(td[4], "Non")) and count(td/img) > 0]');
			foreach ($res as $curr)
			{
				$name = $xpath->query('.//td[2]//a', $curr);
				$string = trim($name->item(0)->nodeValue);
				if (stripos($string, $search) === FALSE && stripos($search, $string) === FALSE && stripos($string, $title) === FALSE && stripos($title, $string) === FALSE)
					continue;
				
				$ser = $xpath->query('.//td[9]', $curr);
				if ($ser->length != 0)
				{
					$string = trim($ser->item(0)->nodeValue);
					if ($string == "" || $string == " " || $string == NULL)
						$series[] = "";
					else 
						$series[] = $string;
				}
			}
	}
	
	//funzione ausiliaria per la correzione della data
	function transformDate($string)
	{
			if ($string == "" || $string == " " || $string == NULL)
				return "";
			else {
				$current_date = explode(" ", $string);
				switch($current_date[0])
				{
					case "1" : $current_date[0] = "01"; break;
					case "2" : $current_date[0] = "02"; break;
					case "3" : $current_date[0] = "03"; break;
					case "4" : $current_date[0] = "04"; break;
					case "5" : $current_date[0] = "05"; break;
					case "6" : $current_date[0] = "06"; break;
					case "7" : $current_date[0] = "07"; break;
					case "8" : $current_date[0] = "08"; break;
					case "9" : $current_date[0] = "09"; break;
				}
				
				switch($current_date[1])
				{
					case "gennaio" : return $current_date[0]."/01/".$current_date[2]; break;
					case "febbraio" : return $current_date[0]."/02/".$current_date[2]; break;
					case "marzo" : return $current_date[0]."/03/".$current_date[2]; break;
					case "aprile" : return $current_date[0]."/04/".$current_date[2]; break;
					case "maggio" : return $current_date[0]."/05/".$current_date[2]; break;
					case "giugno" : return $current_date[0]."/06/".$current_date[2]; break;
					case "luglio" : return $current_date[0]."/07/".$current_date[2]; break;
					case "agosto" : return $current_date[0]."/08/".$current_date[2]; break;
					case "settembre" : return $current_date[0]."/09/".$current_date[2]; break;
					case "ottobre" : return $current_date[0]."/10/".$current_date[2]; break;
					case "novembre" : return $current_date[0]."/11/".$current_date[2]; break;
					case "dicembre" : return $current_date[0]."/12/".$current_date[2]; break;
				}
			}
	}
?>
