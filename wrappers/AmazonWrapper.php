<?php
class AmazonWrapper{
	
	
	public function AmazonWrapper($query, $precision)
	{
		global $query_product, $pages;
		
		$query_product = $query;
		$pages = $precision;
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
		global $array_products;
		
		$array_products[$number[0][0]] = array($title, $url_to_product, $price, $image);
	}
	
	public function execute()
	{
		global $query_product, $pages, $array_products;
		
		
		$array_products = array();
		
		for($i = 1; $i<=$pages; $i++)
		{
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL, "https://www.amazon.it/s/ref=nb_sb_ss_i_1_5?url=search-alias%3Dstripbooks&page=$i&field-keywords=$query_product");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: text/html',
				
			));
			$content = curl_exec($ch);
			
			$xmlPageDom = new DomDocument();
			@$xmlPageDom->loadHTML($content);
			$xmlPageXPath = new DOMXPath($xmlPageDom);

			$products_rows = $xmlPageXPath->query('//ul/li[contains(@class,"s-result-item")]');
			
			
			foreach($products_rows as $product_row)
			{
				//print_r($product_row->textContent);
				$title = $xmlPageXPath -> query('.//h2', $product_row)->item(0)->textContent;
				
				$url_to_product = $xmlPageXPath -> query('.//a[contains(@class, "s-access-detail-page")]/@href', $product_row)->item(0)->textContent;
				
				$price = $xmlPageXPath -> query('.//span[contains(@class, "s-price")]', $product_row)->item(0)->textContent;
				$price = substr($price, 4)."€";
				$image = $xmlPageXPath -> query('.//img/@src', $product_row)->item(0)->textContent;
				
				$author = $xmlPageXPath -> query('.//div/span[contains(text(), "di")]/following-sibling::span/a/text()')->item(0)->textContent;
				
				preg_match_all('!\d+!', $title, $number);
				//$this->save_product($number[0][0], $title, $url_to_product, $price, $image);
				
				
				if(stristr($title, urldecode($query_product)) && $price != "€")
					$this->print_result($title, $url_to_product, $price, $image, $author);
				
				
			}
		}
		
			
	}
	
}
?>