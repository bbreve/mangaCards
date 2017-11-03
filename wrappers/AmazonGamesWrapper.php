	<?php

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

				$products_rows = $xmlPageXPath->query('//div[@id="centerMinus"]//ul/li[contains(@class,"s-result-item")]');
				
				foreach($products_rows as $product_row)
				{
					$disp = $xmlPageXPath -> query('.//span[text="Non disponibile"]', $product_row);
					if ($disp->length != 0)
						continue;
					
					//print_r($product_row->textContent);
					$title = $xmlPageXPath -> query('.//h2', $product_row)->item(0)->textContent;
					$authors = $xmlPageXPath -> query('.//div/span[contains(text(), "di")]/following-sibling::span//text()', $product_row);
					
					$author_string = "";
					foreach($authors as $author)
					{
						$author_string .= $author->textContent;
					}
					
					$checking = checkProduct($title, $author_string);
					if (!$checking)
					{
						continue;
					}	
					
					$plat = $xmlPageXPath -> query('.//a[contains(@class, "a-link-normal")]/h3', $product_row)->item(0)->textContent;
					$url_to_product = $xmlPageXPath -> query('.//a[contains(@class, "s-access-detail-page")]/@href', $product_row)->item(0)->textContent;
					
					$price = $xmlPageXPath -> query('.//span[contains(@class, "s-price")]', $product_row)->item(0)->textContent;
					$price = substr($price, 4)."€";
					$image = $xmlPageXPath -> query('.//img/@src', $product_row)->item(0)->textContent;
					
					$authors = $xmlPageXPath -> query('.//div/span[contains(text(), "di")]/following-sibling::span//text()', $product_row);
					
					$author_string = "";
					foreach($authors as $author)
					{
						$author_string .= $author->textContent;
					}

					preg_match_all('!\d+!', $title, $number);
					//$this->save_product($number[0][0], $title, $url_to_product, $price, $image);

					
					if(stristr($title, urldecode($query_product)) && $price != "€" )
						//Si fa ciò per fare in modo che i prodotti che non hanno un numero nel titolo, vangano posti alla fine della lista di prodotti ordinata.
						  if(count($number[0]) == 0){
								$this->appendArray($title, $url_to_product, $price, $image, $author_string, $plat, 30000);
						  }else{
								$this->appendArray($title, $url_to_product, $price, $image, $author_string, $plat, $number[0][0]);
								}
					
					
				}
			}
			
			

			return $this->createXML();
			
				
		}

		function appendArray($title, $url_to_product, $price, $image, $author, $plat, $number)
		{
			global $offers_array;
			$offers_array[] = array(
				'title' => $title,
				'price' => $price,
				'productNumber' => $number,
				'cover' => $image,
				'author' => $author,
				'plat' => $plat,
				'url_to_product' => $url_to_product
			); 

		}

		function createXML()
		{
			global $offers_array, $search;
			
			usort($offers_array, function($a, $b){
				return strcmp($a['title'], $b['title']);
			});
				
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
				$offer_element->addChild("url_to_product", htmlspecialchars($offer['url_to_product']));
			}

			return $xml;
		}
		
	}

	$title = $_POST['title'];
	$type_search = $_POST['type'];
	$origin_name = $_POST['origin'];
	$authors = $_POST['authors'];

	//Trasforma caratteri speciali in particolari manga/comic
	$title = transform($title);
	
	//Si eliminano info superflue dal nome
	preg_match('!(((\w+ )|(\w+)|( \w+))(\'?)(:?))*!ui',$title, $title_cleaned);
	$cleanTitle = $title_cleaned[0];

	
	//Si mantiene in memoria il nome originale
	$temp = $cleanTitle;
	
	//Si eliminano, se esiste, il "due punti" dalla ricerca
	$title = str_replace(":", "", $cleanTitle);	
	$amazon = new AmazonWrapper($title, $type_search, 15);
	$xml = $amazon->execute();

	//Se non è stato trovato nulla
	if ($xml->count() == 0)
	{
		$title = $temp;
		//Si verifica se esiste un "due punti" nel nome
		if ($stripos($title, ":") !== FALSE)
		{
			//Si individua la seconda parte del nome, ossia quella dopo il due punti
			//Viene effettuato ciò poichè per i fumetti le informazioni essenziali per questi comic risiedono nella seconda parte del nome
			$arr = explode(":", $title);
			$title = trim($arr[0]);
			$amazon = new AmazonWrapper($title, $type_search, 15);
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