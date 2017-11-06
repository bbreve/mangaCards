	<?php
	error_reporting(0);

	class AmazonGamesWrapper{
		
		public function AmazonGamesWrapper($query, $precision)
		{
			global $query_product, $pages, $offers_array;
			
			$query_product = trim($query);
			$pages = $precision;

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
				$url = "https://www.amazon.it/s/ref=nb_sb_noss_2?url=search-alias%3Dvideogames&field-keywords=".urlencode(htmlspecialchars($query_product))."";
				$dom = new DomDocument();
				$dom->loadHTMLFile($url);
				$xmlPageXPath = new DomXPath($dom);


				$products_rows = $xmlPageXPath->query('//ul/li[contains(@class,"s-result-item")]');
				
				
				foreach($products_rows as $product_row)
				{
					
					//print_r($product_row->textContent);
					$title = $xmlPageXPath -> query('.//h2', $product_row)->item(0)->textContent;
					
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
								$this->appendArray($title, $url_to_product, $price, $image, $author_string, 30000);
						  }else{
								$this->appendArray($title, $url_to_product, $price, $image, $author_string, $number[0][0]);
								}
					
					
				}
			}
			
			

			return $this->createXML();
			
				
		}

		function appendArray($title, $url_to_product, $price, $image, $author, $number)
		{
			global $offers_array;
			$offers_array[] = array(
				'title' => $title,
				'price' => $price,
				'productNumber' => $number,
				'cover' => $image,
				'author' => $author,
				'url_to_product' => $url_to_product
			); 

		}

		function appendXML($title, $url_to_product, $price, $image, $author)
		{
			global $xml;

			$prodotto = $xml->addChild("offer");
				
			$prodotto->addChild("title", htmlspecialchars($title));
			$prodotto->addChild("price", $price);
			$prodotto->addChild("author", $author);
			$prodotto->addChild("cover", $image);
			$prodotto->addChild("url_to_product", htmlspecialchars($url_to_product));
		}

		function createXML()
		{
			global $offers_array;


			//usort($offers_array,function($a,$b){
			//	return $a['productNumber'] - $b['productNumber'];
			//});

			$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><offers></offers>');

			foreach($offers_array as $offer)
			{
				$offer_element = $xml->addChild("offer");
				$offer_element->addChild("title", htmlspecialchars($offer['title']));
				$offer_element->addChild("price", $offer['price']);
				$offer_element->addChild("author", $offer['author']);
				$offer_element->addChild("cover", $offer['cover']);
				$offer_element->addChild("url_to_product", htmlspecialchars($offer['url_to_product']));
			}

			return $xml;
		}
		
	}

	
	$title = $_POST['title'];


	preg_match('!(((\w+ )|(\w+)|( \w+))(\'?))*!ui',$title, $title_cleaned);
	$title = $title_cleaned[0];

	$amazon = new AmazonGamesWrapper($title, 6);
	$xml = $amazon->execute();

	echo $xml->asXML();

	?>