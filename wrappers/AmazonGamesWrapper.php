	<?php
	//header("Content-type: application/xml");
			
	error_reporting(0);
	class AmazonWrapper{
		
		public function AmazonWrapper($query, $type_search, $precision)
		{
			global $query_product, $pages, $offers_array, $search;
			
			$query_product = trim($query);
			$pages = $precision;
			$search = $type_search;

			$offers_array = array();
			
		}
		
		
		private function print_result($title, $url_to_product, $price, $image, $author)
		{
			echo "<div>
				<img src=$image />
				<h1>$title</h1>
				<h3>di $author</h3>
				<a href=\"$url_to_product\">$price</a>";
			echo "</div></br>--------------------------------------------</br>";			
		}
		
		private function save_product($number, $title, $url_to_product, $price, $image)
		{
			global $offers_array_products;
			
			$offers_array_products[$number[0][0]] = array($title, $url_to_product, $price, $image);
		}
		
		public function execute()
		{
			global $query_product, $pages, $offers_array, $xml;
			
			
			$offers_array_products = array();
			
			for($i = 1; $i<=$pages; $i++)
			{
				$xmlPageDom = new DomDocument();
				$url = "https://www.amazon.it/s/ref=nb_sb_ss_i_1_5?url=search-alias%3Dvideogames&page=".$i."&field-keywords=".urlencode(htmlspecialchars($query_product))."";
				$xmlPageDom->loadHTMLFile($url);
				$xmlPageXPath = new DomXPath($xmlPageDom);
				
				//Si verifica se esista almeno un risultato
				if ($i == 1)
				{
					$result = $xmlPageXPath->query('//h1[contains(text(), "Non abbiamo trovato nessun risultato")]');
					if ($result->length != 0)
					{
						return $this->createXML();
					}
				}
				
				$products_rows = $xmlPageXPath->query('//div[@id="centerMinus"]//ul/li[contains(@class,"s-result-item")]');
				
				foreach($products_rows as $product_row)
				{
					$disp = $xmlPageXPath -> query('.//span[text="Non disponibile"]', $product_row);
					$plat = $xmlPageXPath -> query('.//a[contains(@class, "a-link-normal")]/h3[not(contains(text(), "sconosciuta")) and not(contains(text(), "sistema"))]', $product_row);
					$title = $xmlPageXPath -> query('.//h2', $product_row)->item(0)->textContent;
					//print_r($product_row->textContent);
					$authors = $xmlPageXPath -> query('.//div[@class="a-row a-spacing-none" and starts-with(string(), "di")]', $product_row);
					$author_string = substr($authors->item(0)->textContent, 3);
					
					$checking = checkProduct($title, $author_string);
					if ($disp->length != 0 || $plat->length == 0 || !$checking)
						continue;
					
					if ($plat->length == 1)
					{
						$plat = $plat->item(0)->textContent;
						$url_to_product = $xmlPageXPath -> query('.//a[contains(@class, "s-access-detail-page")]/@href', $product_row)->item(0)->textContent;
					
						$price = $xmlPageXPath -> query('.//span[contains(@class, "price") and contains(@class, "text-bold")]', $product_row)->item(0)->textContent;
						$price = substr($price, 4)."€";
						$image = $xmlPageXPath -> query('.//img/@src', $product_row)->item(0)->textContent;
						
						$day = $xmlPageXPath->query('.//span[@class="a-size-small a-color-secondary"]', $product_row);
						$rDate = transformDate(trim($day->item(0)->textContent));
					
						preg_match_all('!\d+!', $title, $number);
						//$this->save_product($number[0][0], $title, $url_to_product, $price, $image);

					
						if(stristr($title, urldecode($query_product)) && $price != "€" )
						{
							//Si fa ciò per fare in modo che i prodotti che non hanno un numero nel titolo, vangano posti alla fine della lista di prodotti ordinata.
							if(count($number[0]) == 0)
							{
								$this->appendArray($title, $url_to_product, $price, $image, $author_string, $plat, $rDate, 30000);
							}
							else
							{
								$this->appendArray($title, $url_to_product, $price, $image, $author_string, $plat,  $rDate, $number[0][0]);
							}
						}
					}
					else
					{
						$plat = $xmlPageXPath -> query('.//a[contains(@class, "a-link-normal") and h3/@data-attribute]/@href', $product_row);
						foreach($plat as $pl)
						{
							$doc = new DomDocument;
							$doc->loadHTMLFile($pl->nodeValue);
							$xpath = new DomXPath($doc);
							$image = $xpath->query('//div[@id="imgTagWrapperId"]/img/@src')->item(0)->textContent;
			
							$title = $xpath->query('//span[@id="productTitle"]')->item(0)->textContent;

							$untrimmed = $xpath->query('//div[@class="a-section a-spacing-none"]')->item(0)->textContent;
							$producer = substr(trim($untrimmed), 3);
							
							$platform = $xpath->query('//div[@class="content"]//li[contains(b, "Piattaforma")]/text()')->item(0)->textContent;
			
							$untrimmedDate = $xpath->query('//li[contains(b/text(), "Data di uscita")]/text()');
							$rDate = transformDate(trim($untrimmedDate->item(0)->textContent));
							
							$price = $xpath->query('//span[@id="priceblock_ourprice"]')->item(0)->textContent;
							$price = substr($price, 4)."€";
			
							preg_match_all('!\d+!', $title, $number);
							if(stristr($title, urldecode($query_product)) && $price != "€" )
							{
								//Si fa ciò per fare in modo che i prodotti che non hanno un numero nel titolo, vangano posti alla fine della lista di prodotti ordinata.
								if(count($number[0]) == 0)
								{
									$this->appendArray($title, $pl->nodeValue, $price, $image, $producer, $platform, $rDate, 30000);
								}
								else
								{
									$this->appendArray($title, $pl->nodeValue	, $price, $image, $producer, $platform, $rDate, $number[0][0]);
								}
							}		
						}
					}
				}
			}

			return $this->createXML();
		}

		function appendArray($title, $url_to_product, $price, $image, $author, $plat, $day, $number)
		{
			global $offers_array;
			$offers_array[] = array(
				'title' => $title,
				'price' => $price,
				'productNumber' => $number,
				'cover' => $image,
				'author' => $author,
				'plat' => $plat,
				'day' => $day,
				'url_to_product' => $url_to_product
			); 

		}

		function createXML()
		{
			global $offers_array, $search;
			
			usort($offers_array, function($a, $b){
				return strcmp($a['title'], $b['title']);
			});
			
			 $conn = new mysqli("localhost", "root", "", "db_mangacards");//database connection
				if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
						}
				$conn->set_charset("utf8");
			
				
			$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><offers></offers>');

			foreach($offers_array as $offer)
			{
				if (!checkInMap($offer))
					continue;
				
				$offer_element = $xml->addChild("offer");
				$offer_element->addChild("title", htmlspecialchars($offer['title']));
				$offer_element->addChild("price", $offer['price']);
				$offer_element->addChild("author", $offer['author']);
				$offer_element->addChild("cover", $offer['cover']);
				$offer_element->addChild("plat", $offer['plat']);
				$offer_element->addChild('release_date', $offer['day']);
				$offer_element->addChild("url_to_product", htmlspecialchars($offer['url_to_product']));
				
				$titoloProdotto=str_replace(array("\"","\'"),"",htmlspecialchars($offer['title']));
				$serieProdotto= str_replace(array("\"","\'"),"",$_POST['title']);
		
				
				$toinsert = 'INSERT INTO amazon
							(NomeOfferta, TipoProdotto, Serie, DataUscita, Prezzo, Autore, Piattaforma, Immagine, LinkAcquisto)
							VALUES
							("'.$titoloProdotto.'", "'.$search.'", "'.$serieProdotto.'" , "'.$offer['day'].'", "'.$offer['price'].'", "'.$offer['author'].'", "'.$offer['plat'].'", "'. $offer['cover'].'", "'.htmlspecialchars($offer['url_to_product']).'")';
							
							if ($conn->query($toinsert) === TRUE) {
									//echo "New record created successfully";
									} else {
										//echo "Error: " . $sql . "<br>" . $conn->error;
												}
			}
             $conn->close();
			return $xml;
		}
		
	}

	$original = $title;
	$title = $_POST['title'];
	$type_search = $_POST['type'];
	$origin_name = $_POST['origin'];
	$authors = $_POST['authors'];

/*
	$title = "Dragon Ball";
	$type_search = "manga";
	$origin_name = "";
	$authors = "";
*/

	//Trasforma caratteri speciali in particolari manga/comic
	$title = transform($title);
	
	//Si eliminano info superflue dal nome
	preg_match('!(((\w+ )|(\w+)|( \w+))(\'?)(:?))*!ui',$title, $title_cleaned);
	$cleanTitle = $title_cleaned[0];

	
	//Si mantiene in memoria il nome originale
	$temp = $cleanTitle;
	
	//Si eliminano, se esiste, il "due punti" dalla ricerca
	$title = str_replace(":", "", $cleanTitle);	
	$amazon = new AmazonWrapper($title, $type_search, 3);
	$xml = $amazon->execute();

	//Se non è stato trovato nulla
	if ($xml->count() == 0 && $type_search = "comic")
	{
		$title = $temp;
		//Si verifica se esiste un "due punti" nel nome
		if ($stripos($title, ":") !== FALSE)
		{
			//Si individua la seconda parte del nome, ossia quella dopo il due punti
			//Viene effettuato ciò poichè per i fumetti le informazioni essenziali per questi comic risiedono nella seconda parte del nome
			$arr = explode(":", $title);
			$title = trim($arr[0]);
			$amazon = new AmazonWrapper($title, $type_search, 3);
			$xml = $amazon->execute();
		}
	}
	
	
	echo $xml->asXML();
	
	function transform($string)
	{
		if (stripos($string, "×") !== FALSE)
			$string = str_replace("×", "x", $string);

		return $string;
	}
	
	function checkProduct($name, $author)
	{
		global $title, $origin_name, $type_search, $authors;
		
		$modifiedName = str_replace(".", "", $name);
		
		if (stripos($name, $title) !== FALSE || stripos($title, $name) !== FALSE || stripos($modifiedName, $title) !== FALSE || stripos($title, $modifiedName) !== FALSE)
			return TRUE;
		
		if (stripos($name, $origin_name) !== FALSE || stripos($origin_name, $name) !== FALSE  || stripos($modifiedName, $origin_name) !== FALSE || stripos($origin_name, $modifiedName) !== FALSE)
			return TRUE;
		
		return FALSE;
	}	
	
	//Funzione ausiliaria per la correzione della data
	function transformDate($string)
	{
			if ($string == "" || $string == " " || $string == NULL)
				return "";
			else {
				$current_date = explode(" ", $string);
				if (count($current_date) != 3)
					return $string;
					
				switch($current_date[0])
				{
					case "1" : $current_date[0] = "01"; break;
					case "1?": $current_date[0] = "01"; break;
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
					case "gennaio" : case "gen." : return $current_date[0]."/01/".$current_date[2]; break;
					case "febbraio" : case "feb." : return $current_date[0]."/02/".$current_date[2]; break;
					case "marzo" : case "mar." : return $current_date[0]."/03/".$current_date[2]; break;
					case "aprile" : case "apr." : return $current_date[0]."/04/".$current_date[2]; break;
					case "maggio" : case "mag." : return $current_date[0]."/05/".$current_date[2]; break;
					case "giugno" : case "giu." : return $current_date[0]."/06/".$current_date[2]; break;
					case "luglio" : case "lug." : return $current_date[0]."/07/".$current_date[2]; break;
					case "agosto" : case "ago." : return $current_date[0]."/08/".$current_date[2]; break;
					case "settembre" : case "set." : return $current_date[0]."/09/".$current_date[2]; break;
					case "ottobre" : case "ott." : return $current_date[0]."/10/".$current_date[2]; break;
					case "novembre" : case "nov." : return $current_date[0]."/11/".$current_date[2]; break;
					case "dicembre" : case "dic." : return $current_date[0]."/12/".$current_date[2]; break;
				}
			}
	}

	function checkInMap($offer)
	{
		global $map_prods;
		
		if (!array_key_exists(trim($offer['title'].trim($offer['plat'])), $map_prods))
		{
			$map_prods[trim($offer['title']).trim($offer['plat'])] = "";
			return TRUE;
		}
		else
			return FALSE;
	}	
?>