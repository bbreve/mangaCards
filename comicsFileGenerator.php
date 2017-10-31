	<?php
	libxml_use_internal_errors(true);
	
	$list = array();
	
	extraction("https://it.wikipedia.org/wiki/Categoria:Fumetti_DC_Comics");
	extraction("https://it.wikipedia.org/wiki/Categoria:Personaggi_DC_Comics");
	extraction("https://it.wikipedia.org/wiki/Categoria:Fumetti_Marvel_Comics");
	extraction("https://it.wikipedia.org/wiki/Categoria:Personaggi_Marvel_Comics");
	
	if (count($list) != 0)
	{
		foreach($list as $list_link)
		{
			file_put_contents("list_comics.txt", $list_link.PHP_EOL, FILE_APPEND | LOCK_EX);
		}
	}
	
	
	function extraction($url)
	{
		global $list;
		
		$dom = new DomDocument;
		$dom->loadHTMLFile($url);
		$xpath = new DomXPath($dom);
		
		//Variabile da usare solo in caso di pagine multiple
		$temp = $xpath;
	
		$titoli = $xpath->query('//h2[contains(text(), "Pagine")]/following::div[@class="mw-category"]//div[@class="mw-category-group"]//a[not(contains(text(), "Pubblicazioni")) and not(contains(text(), "Template"))]');
		foreach($titoli as $curr)
		{
			$title = $xpath->query('./@title', $curr);
			$anchor = $xpath->query('./@href', $curr);
		
			if (!array_key_exists(trim($anchor->item(0)->nodeValue), $list))
			{
				$list[trim($anchor->item(0)->nodeValue)] = trim($title->item(0)->nodeValue);
			}
		}
		
		while(1)
		{
			$newpage = $xpath->query('//div[@id="mw-pages"]//a[position()=1 and contains(text(), "pagina successiva")]/@href');
			if ($newpage->length != 0)
			{
				$newURL = trim($newpage->item(0)->nodeValue);
				$dom1 = new DomDocument;
				$dom1->loadHTMLFile("https://it.wikipedia.org".$newURL);
				$xpath = new DomXPath($dom1);
				
				$titoli = $xpath->query('//h2[contains(text(), "Pagine")]/following::div[@class="mw-category"]//div[@class="mw-category-group"]//a[not(contains(text(), "Pubblicazioni")) and not(contains(text(), "Template"))]');
				foreach($titoli as $curr)
				{
					$title = $xpath->query('./@title', $curr);
					$anchor = $xpath->query('./@href', $curr);
		
					if (!array_key_exists(trim($anchor->item(0)->nodeValue), $list))
					{
						$list[trim($anchor->item(0)->nodeValue)] = trim($title->item(0)->nodeValue);
					}
				}
			}
			else
			{
				$xpath = $temp;
				break;
			}
		}
		
		$sottocategorie = $xpath->query('//h2[contains(text(), "Pagine")]/preceding::div[@id="mw-subcategories" or @class="mw-category"]//a[not(contains(text(), "Pubblicazioni")) and not(contains(text(), "Template"))]');
		
		if ($sottocategorie->length == 0)
			$sottocategorie = $xpath->query('//h2[contains(text(), "Sottocategorie")]/following::div[@class="mw-category" or @class="mw-content-ltr"]//a[not(contains(text(), "Pubblicazioni")) and not(contains(text(), "Template"))]');
		
		foreach($sottocategorie as $curr)
		{
			var_dump($curr->nodeValue."<br />");
			$anchor = $xpath->query('./@href', $curr);
			extraction("https://it.wikipedia.org".trim($anchor->item(0)->nodeValue));
		}
	}
?>