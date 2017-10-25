<?php
	//$term = $_GET['q'];
	$term = "justice";
	libxml_use_internal_errors(true);
	$json=[];
	
	$list = array();
	$count = 1;

	extraction("https://it.wikipedia.org/wiki/Categoria:Fumetti_DC_Comics");
	extraction("https://it.wikipedia.org/wiki/Categoria:Fumetti_Marvel_Comics");
	
	$json = array('results' => []);

	$i = 0;
	foreach($list as $list_link)
	{
		$json["results"][] = ['id'=>$i, 'text'=>$list_link];
		$i++;
	}
		
	echo json_encode($json);
	
	function extraction($url)
	{
		global $term, $list;
		
		$dom = new DomDocument;
		$dom->loadHTMLFile($url);
		$xpath = new DomXPath($dom);
	
		$titoli = $xpath->query('//h2[contains(text(), "Pagine")]/following::div[@class="mw-category"]//div[@class="mw-category-group"]//a[contains(translate(text(), "abcdefghijklmnopqrstuvwxyz", "ABCDEFGHIJKLMNOPQRSTUVWXYZ"), translate("'.$term.'", "abcdefghijklmnopqrstuvwxyz", "ABCDEFGHIJKLMNOPQRSTUVWXYZ")) and not(contains(text(), "Pubblicazioni")) and not(contains(text(), "Template"))]');
		foreach($titoli as $curr)
		{
			$title = $xpath->query('./@title', $curr);
			$anchor = $xpath->query('./@href', $curr);
		
			if (!array_key_exists(trim($anchor->item(0)->nodeValue), $list))
			{
				$list[trim($anchor->item(0)->nodeValue)] = trim($title->item(0)->nodeValue);
			}
		}
	
		$sottocategorie = $xpath->query('//h2[contains(text(), "Pagine")]/preceding::div[@id="mw-subcategories" or @class="mw-category"]//a[not(contains(text(), "Pubblicazioni")) and not(contains(text(), "Template"))]');
		foreach($sottocategorie as $curr)
		{
			$anchor = $xpath->query('./@href', $curr);
			extraction("https://it.wikipedia.org".trim($anchor->item(0)->nodeValue));
		}
	}
?>