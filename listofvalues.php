<?php
$term = $_GET['q'];
libxml_use_internal_errors(true);
$json=[];
		$dom = new DomDocument;

		/* Load the HTML */

		$dom->loadHTMLFile("https://it.m.wikipedia.org/wiki/Progetto:Anime_e_manga/Lista_di_manga");

		$xpath = new DomXPath($dom);

		/* Query all <td> nodes containing specified class name */

		$titoli=$xpath->query("//div[@id='mw-content-text']//li/i/a[contains(translate(@title,'ABCDEFGHIJKLMNOPQRSTUVWXYZ','abcdefghijklmnopqrstuvwxyz'), translate('".$term."','ABCDEFGHIJKLMNOPQRSTUVWXYZ','abcdefghijklmnopqrstuvwxyz'))]/@title");
		//$links=$xpath->query("//div[@id='mw-content-text']//li/i/a/@href");
		
		$json = array('results' => []);

		$i = 0;
		foreach($titoli as $titolo)
		{
			if (strpos($titolo->nodeValue, 'la pagina non esiste') === false) {
				$json["results"][] = ['id'=>$i, 'text'=>$titolo->nodeValue];
				$i++;
			}
		}
		echo json_encode($json);
?>