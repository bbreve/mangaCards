<?php 
	include "curl.php";

	//Dichiaro gli array per le informazioni
	$images = array();
	$links = array();
	$names = array();
	$prices = array();
	$availables = array();
	$pDates = array();
	$authors = array();
	$imprints = array();
	$collections = array();
	$series = array();
	
	//Parametri di ricerca
	$search = "flash";
	$pag = 1;

	//Chiamata prima pagina
	$url = "http://www.rwedizioni.it/search/".urlencode($search);
	$ch2 = new CurlExecution($url);	//crei l'esecutore dello scraper
	$data = $ch2->curl($url);          //prepari l'esecutore per il curl 
	
	//Estraggo info della prima pagina
	$images = extractImages($images, $ch2);
	$links = extractLink($links, $ch2);	
	$names = extractNames($names, $ch2);
	$prices = extractPrices($prices, $ch2);
	$pDates = extractDates($pDates, $ch2);
	$authors = extractAuthors($authors, $ch2);
	$imprints = extractImprints($imprints, $ch2);
	$collections = extractCollection($collections, $ch2);
	$series = extractSeries($series, $ch2);
	
	//Cerco se ci sono pagine successive ed estraggo
	while(1)
	{	
		//Verifico se esiste una nuova pagina
		$ch1 = new CurlExecution($url);	//crei l'esecutore dello scraper
		$data = $ch1->curl($url);          //prepari l'esecutore per il curl 
		$res1 = $ch1->returnData('//a[contains(string(.), "Articoli più vecchi")]');      //estrai dati usando un XPATH
		
		if ($res1->length == 0)
          break;
	  
	    $pag += 1;
		$url = "http://www.rwedizioni.it/search/".urlencode($search)."/page/".$pag."/";
		$ch2 = new CurlExecution($url);	//crei l'esecutore dello scraper
		$data = $ch2->curl($url);          //prepari l'esecutore per il curl 
		
		//Estraggo info della pagina corrente	
		$images = extractImages($images, $ch2);
		$links = extractLink($links, $ch2);	
		$names = extractNames($names, $ch2);
		$prices = extractPrices($prices, $ch2);
		$pDates = extractDates($pDates, $ch2);
		$authors = extractAuthors($authors, $ch2);
		$imprints = extractImprints($imprints, $ch2);
		$collections = extractCollection($collections, $ch2);
		$series = extractSeries($series, $ch2);
	}
	
	$xml = writeXML($images, $links, $names, $prices, $availables, $pDates, $authors, $imprints, $collections, $series);
	var_dump($xml);
	
	function extractImages($images, $ch2)
	{
			$res = $ch2->returnData('//tbody/tr[contains(td[4], "Disponibile") and contains(td/img/@src, "jpg")]//img/@src');
			foreach ($res as $curr)
			{
			 $string = $curr->nodeValue;
			 if ($string == "" || $string == " " || $string == NULL)
				$images[] = "";
			 else $images[] = trim($curr->nodeValue);
			}
			
			return $images;
	}
	
	function extractLink($links, $ch2)
	{
			$res = $ch2->returnData('//tbody/tr[contains(td[4], "Disponibile") and contains(td/img/@src, "jpg")]/td[2]//a/@href');
			foreach ($res as $curr)
			{
			 $string = $curr->nodeValue;
			 if ($string == "" || $string == " " || $string == NULL)
				$links[] = "";
			 else $links[] = trim($curr->nodeValue);
			}
			
			return $links;
	}

	function extractNames($names, $ch2)
	{
			$res = $ch2->returnData('//tbody/tr[contains(td[4], "Disponibile") and contains(td/img/@src, "jpg")]/td[2]');
			foreach ($res as $curr)
			{
			 $string = $curr->nodeValue;
			 if ($string == "" || $string == " " || $string == NULL)
				$names[] = "";
			 else $names[] = trim($curr->nodeValue);
			}
			
			return $names;
	}
	
	function extractPrices($prices, $ch2)
	{
			$res = $ch2->returnData('//tbody/tr[contains(td[4], "Disponibile") and contains(td/img/@src, "jpg")]/td[3]');
			foreach ($res as $curr)
			{
			 $string = $curr->nodeValue;
			 if ($string == "" || $string == " " || $string == NULL)
				$prices[] = "";
			 else $prices[] = trim($curr->nodeValue);
			}
			 
			return $prices;
	}
	
	function extractDates($pDates, $ch2)
	{
			$res = $ch2->returnData('//tbody/tr[contains(td[4], "Disponibile") and contains(td/img/@src, "jpg")]/td[5]');
			foreach ($res as $curr)
			{
			 $string = $curr->nodeValue;
			 if ($string == "" || $string == " " || $string == NULL)
				$pDates[] = "";
			 else $pDates[] = transformDate(trim($curr->nodeValue));
			}
			 
			return $pDates;
	}
	
	function extractAuthors($authors, $ch2)
	{
			$res = $ch2->returnData('//tbody/tr[contains(td[4], "Disponibile") and contains(td/img/@src, "jpg")]/td[6]');
			foreach ($res as $curr)
			{
			 $string = $curr->nodeValue;
			 if ($string == "" || $string == " " || $string == NULL)
				$aauthors[] = "";
			 else $authors[] = trim($curr->nodeValue);
			}
			
			return $authors;
	}
	
	function extractImprints($imprints, $ch2)
	{
			$res = $ch2->returnData('//tbody/tr[contains(td[4], "Disponibile") and contains(td/img/@src, "jpg")]/td[7]');
			foreach ($res as $curr)
			{
			 $string = $curr->nodeValue;
			 if ($string == "" || $string == " " || $string == NULL)
				$imprints[] = "";
			 else $imprints[] = trim($curr->nodeValue);
			}
			
			return $imprints;
	}
	
	function extractCollection($collections, $ch2)
	{
			$res = $ch2->returnData('//tbody/tr[contains(td[4], "Disponibile") and contains(td/img/@src, "jpg")]/td[8]');
			foreach ($res as $curr)
			{
			 $string = $curr->nodeValue;
			 if ($string == "" || $string == " " || $string == NULL)
				$collections[] = "";
			 else $collections[] = trim($curr->nodeValue);
			}
			
			return $collections;
	}
	
	function extractSeries($series, $ch2)
	{
			$res = $ch2->returnData('//tbody/tr[contains(td[4], "Disponibile") and contains(td/img/@src, "jpg")]/td[9]');
			foreach ($res as $curr)
			{
			 $string = $curr->nodeValue;
			 if ($string == "" || $string == " " || $string == NULL)
				$series[] = "";
			 else $series[] = trim($curr->nodeValue);
			}
			
			return $series;
	}
	
	function writeXML($images, $links, $names, $prices, $availables, $pDates, $authors, $imprints, $collections, $series)
	{
			//Dichiaro l'XML di ritorno
			$xml = '<?xml version="1.0"><list_products>';
			
			$len = count($links);
			
			for ($n = 0; $n < $len; $n++)
			{
				$xml = $xml.'<product><name>'.$names[$n].'</name><series>'.$series[$n].'</series>';
			
				if ($collections[$n] <> "")
					$xml = $xml.'<collection>'.$collections[$n].'</collections>';
		
				if ($imprints[$n] <> "")
					$xml = $xml.'<imprint>'.$imprints[$n].'</imprint>';
		
				if ($authors[$n] <> "")
					$xml = $xml.'<authors>'.$authors[$n].'</authors>';
			
				$xml = $xml.'<price>'.$prices[$n].'</price>';
				
				if ($pDates[$n] <> "")
					$xml = $xml.'<publication_date>'.$pDates[$n].'</publication_date><image>'.$images[$n].'</image><link>'.$links[$n].'</link></product>';
			}
			
			$xml = $xml.'</list_products>';	
			return $xml;
	}
	
	//funzione ausiliaria per la correzione della data
	function transformDate($string)
	{
			if ($string == "" || $string == " " || $string == NULL)
				return "";
			else {
				$current_date = explode(" ", $string);
				switch($current_date[1])
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
