<?php
	header("Content-type: application/xml");
    $title = $_POST['title'];
	$title=transform($title);
	$title=str_replace(array("\"","\'"),"",$title);
	preg_match('!(((\w+ )|(\w+)|( \w+))(\'?)(:?))*!ui',$title, $title_cleaned);
	$title=trim($title_cleaned[0]);
	
	$conn = new mysqli("localhost", "root", "", "db_mangacards");//database connection
			if ($conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
						}
						
					
    $conn->set_charset("utf8");
	$querySQL="SELECT * FROM `panini` WHERE Serie='$title'";
	$resultQuery=mysqli_query($conn,$querySQL);
	if($resultQuery->num_rows !=0){
		   $xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><offers></offers>');
		   while ($row=$resultQuery->fetch_object()){
			   $value = $xml->addChild('offer');
			   $value->addChild('title',$row->NomeOfferta);
			   $value->addChild('product_type',$row->TipoProdotto);
			   $value->addChild('productNumber',$row->NumeroVolume);
			   if($row->Autori!="")
			   $value->addChild('authors',$row->Autori);
		       if($row->Descrizione!="")
		       $value->addChild('description',$row->Descrizione);
		       if($row->Edizione!="")
			   $value->addChild('edition',$row->Edizione);
		       if($row->InfoEdizione!="")
		       $value->addChild('info_volume',$row->InfoEdizione);
		       $value->addChild('price',$row->PrezzoScontato);
		       $value->addChild('old_price',$row->Prezzo);	
			   $value->addChild('release_date',$row->DataUscita);
			   $value->addChild('cover',$row->Immagine);
			   $value->addChild('url_to_product',$row->LinkAcquisto);
			   
		   
		   }
		   echo $xml->asXML();
			$conn->close();
	}else{
	  $conn->close();
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
	$authors = array();
	$descriptions = array();
	
	//Parametri di ricerca
	 $title = $_POST['title'];
	$search = transform($title);
	$type = $_POST['type'];
	$origin_name = $_POST['origin'];
	
	//Dichiaro l'XML di ritorno
	$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><list_products></list_products>');		
	
	libxml_use_internal_errors(true);
	
	$url = "http://comics.panini.it/store/pub_ita_it/catalogsearch/result/index/?p=1&q=".urlencode($search)."";		
	$dom = new DomDocument();
	$dom->loadHTMLFile($url);
	$xpath = new DOMXPath($dom);         
	$res1 = $xpath->query('//div[@class="text-center"]');      
	
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
			$dom = new DomDocument();
			$dom->loadHTMLFile($url);
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
			extractInPage();
		}
		writeXML();
	}
	
	//Caso dei nomi di manga stilizzati particolarmente
	if ($xml->count() == 0)
	{
		$arr_name = explode("-", $search);
		if (count($arr_name) > 1)
		{
			for ($i = count($arr_name)-1; $i >= 0; $i--)
			{
				$search = trim($arr_name[$i]);
				$url = "http://comics.panini.it/store/pub_ita_it/catalogsearch/result/index/?p=1&q=".urlencode($search)."";		
				$dom = new DomDocument();
				$dom->loadHTMLFile($url);
				$xpath = new DOMXPath($dom);         
				$res1 = $xpath->query('//div[@class="text-center"]');      
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
						$dom = new DomDocument();
						$dom->loadHTMLFile($url);
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
						extractInPage();
					}
	
					writeXML();
				
					if ($xml->count() != 0)
						break;
				}
			}
		}	
	}
	
	echo $xml->asXML();
	
	}
	
	function writeXML()
	{
		global $images, $links, $titles, $volume_numbers, $volume_infos, $editions, $pDates, $prices, $currPrices, $authors, $descriptions, $xml;
		for ($n = 0; $n < count($titles); $n++)
		{
			$prodotto = $xml->addChild("product");
				
			$prodotto->addChild("title", $titles[$n]);
			$prodotto->addChild("productNumber", $volume_numbers[$n]);
			
			if ($authors[$n] <> "")
				$prodotto->addChild("authors", $authors[$n]);
			
			if ($editions[$n] <> "Edizione Originale")
				$prodotto->addChild("edition", $editions[$n]);
			if ($volume_infos[$n] <> "")
				$prodotto->addChild("info_volume", $volume_infos[$n]);
			
			$prodotto->addChild("old_price", $prices[$n]);
			$prodotto->addChild("curr_price", $currPrices[$n]);
			$prodotto->addChild("release_date", $pDates[$n]);
			
			if ($descriptions[$n] <> "")
				$prodotto->addChild("description", $descriptions[$n]);
			
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
		
		  $conn = new mysqli("localhost", "root", "", "db_mangacards");//database connection
				if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
						}
						
		  $conn->set_charset("utf8");
		
		$xml=new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><offers></offers>');
		foreach($arr as $product){
			$titoloProdotto="";
			$tipoProdotto="";
			$autoriProdotto="";
			$serieProdotto="";
			$descrizioneProdotto="";
			$edizioneProdotto="";
			$infoEdizioneProdotto="";
			$prezzoVecchioProdotto="";
			$prezzoScontatoProdotto="";
			$dataUscitaProdotto="";
			$immagineProdotto="";
			$linkAcquistoProdotto="";
			$numeroVolumeProdotto="";
			
			$value = $xml->addChild('offer');
			$value->addChild('title',(string)$product->title);
			$titoloProdotto=(string)$product->title;
			$value->addChild('product_type',(string)$product->product_type);
			$tipoProdotto=(string)$product->product_type;
			$value->addChild('productNumber',(string)$product->productNumber);
			$numeroVolumeProdotto=(string)$product->productNumber;
			
			if (((string) $product->authors) != NULL){
				$value->addChild('authors',(string)$product->authors);
				$autoriProdotto=(string)$product->authors;
			}
			if (((string) $product->description) != NULL){
				$value->addChild('description',(string)$product->description);
				$descrizioneProdotto=(string)$product->description;
			}
			
			if (((string) $product->edition) != NULL){
				$value->addChild('edition',(string)$product->edition);
				$edizioneProdotto=(string)$product->edition;
			}
			if (((string) $product->info_volume) != NULL){
				$value->addChild('info_volume',(string)$product->info_volume);
				$infoEdizioneProdotto=(string)$product->info_volume;
			}
			
			$value->addChild('price',(string)$product->curr_price);
			$prezzoScontatoProdotto=(string)$product->curr_price;
			
			$value->addChild('old_price',(string)$product->old_price);
			$prezzoVecchioProdotto=(string)$product->old_price;
			
			$value->addChild('release_date',(string)$product->release_date);
			$dataUscitaProdotto=(string)$product->release_date;
			
			$value->addChild('cover',(string)$product->cover);
			$immagineProdotto=(string)$product->cover;
			
			$value->addChild('url_to_product',(string)$product->url_to_product);
			$linkAcquistoProdotto=(string)$product->url_to_product;
			$serieProdotto=$_POST['title'];
			
			$titoloProdotto=str_replace(array("\"","\'"),"",$titoloProdotto);
			$descrizioneProdotto=str_replace(array("\"","\'"),"",$descrizioneProdotto);
			$serieProdotto=str_replace(array("\"","\'"),"",$serieProdotto);
			
			
			$toinsert = 'INSERT INTO panini
							(NomeOfferta, Serie, TipoProdotto, Autori, Descrizione, Edizione, InfoEdizione, Prezzo, PrezzoScontato, DataUscita, Immagine, LinkAcquisto, NumeroVolume)
							VALUES
							("'.$titoloProdotto.'", "'.$serieProdotto.'", "'.$tipoProdotto.'", "'.$autoriProdotto.'", "'.$descrizioneProdotto.'", "'.$edizioneProdotto.'", "'.$infoEdizioneProdotto.'", "'.$prezzoVecchioProdotto.'", "'.$prezzoScontatoProdotto.'", "'.$dataUscitaProdotto.'", "'.$immagineProdotto.'", "'.$linkAcquistoProdotto.'", "'.$numeroVolumeProdotto.'")';
							
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
			global $images, $search, $xpath;
			
			$res = $xpath->query('//div[contains(@class,"list-group-item row item") and div/div/div/div/div/button/@title = "Aggiungi al carrello"]');
			foreach ($res as $curr)
			{
				
				$string = $xpath->query('.//h3/a/text()', $curr)->item(0)->nodeValue;
				$string = trim($string);
				if (checkProduct($string) == FALSE)
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
				if (checkProduct($string) == FALSE)
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
	
	function extractInPage()
	{
			global $links, $authors, $descriptions, $search, $xpath;
			
			$res = $xpath->query('//div[contains(@class,"list-group-item row item") and div/div/div/div/div/button/@title = "Aggiungi al carrello"]');
			
			foreach ($res as $curr)
			{
				$string = $xpath->query('.//h3/a/text()', $curr)->item(0)->nodeValue;
				$string = trim($string);
				if (checkProduct($string) == FALSE)
					continue;
				
				$queryResult = $xpath->query('.//h3/a/@href', $curr);
				if ($queryResult->length != 0)
				{
					$anchor = trim($queryResult->item(0)->nodeValue);
				
					$dom1 = new DomDocument;
					$dom1->loadHTMLFile($anchor);
					$innerXPath = new DOMXPath($dom1);
					
					$creators = $innerXPath->query('//div[@id="authors"]//div[@class="attribute content"]/text()');
					if ($creators->length != 0)
					{
						$author = trim($creators->item(0)->nodeValue);
						$authors[] = $author;		
					}
					else
						$authors[] = "";
					
					$des = $innerXPath->query('//div[@id="description"]/text()');
					if ($des->length != 0)
					{
						$descr = trim($des->item(0)->nodeValue);
						$descriptions[] = $descr;		
					}
					else
						$descriptions[] = "";
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
				if (checkProduct($string) == FALSE)
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
				if (checkProduct($string) == FALSE)
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
				if (checkProduct($string) == FALSE)
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
				if (checkProduct($string) == FALSE)
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
				if (checkProduct($string) == FALSE)
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
				if (checkProduct($string) == FALSE)
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
				if (checkProduct($string) == FALSE)
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
	
	function transform($string)
	{
		if (stripos($string, "×") !== FALSE)
			$string = str_replace("×", "x", $string);

		return $string;
	}
	
	function checkProduct($string)
	{
		global $title, $type, $origin_name, $search;

		if (stripos($string, $title) !== FALSE || stripos($title, $string) !== FALSE)
			return TRUE;
		
		if (stripos($string, $search) !== FALSE || stripos($search, $string) !== FALSE)
			return TRUE;
		
		if (stripos($string, $origin_name) !== FALSE || stripos($origin_name, $string) !== FALSE)
			return TRUE;
		
		return FALSE;
	}
?>	