<?php

	header("Content-type: application/xml");
	
	$series = $_POST['series'];
	
		
	$querySQL = "SELECT COUNT(DISTINCT VersioneAnime) as NumeroAnime FROM `episodi_anime` WHERE NomeAnime LIKE '%$series%'";
	$queryProva="SELECT * FROM `episodi_anime` WHERE NomeAnime LIKE '%$series%'";
	$conn = new mysqli("localhost", "root", "", "db_mangacards");//database connection
				if ($conn->connect_error) {
						die("Connection failed: ".$conn->connect_error);
						}
						
	$conn->set_charset("utf8");
	
	$resultQuery=mysqli_query($conn,$querySQL);
	$RisultatoProva=mysqli_query($conn,$queryProva);
	if($RisultatoProva->num_rows !=0){
		$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><list_anime_products></list_anime_products>');
		while ($row=$resultQuery->fetch_object()){
		      $numeroAnime=intval($row->NumeroAnime);
	    }
		
		for($i=1;$i<=$numeroAnime;$i++){
			$firstQuery="SELECT * FROM `episodi_anime` WHERE NomeAnime LIKE '%$series%' AND VersioneAnime='$i' ORDER BY Numero";
			$RisultatoQuery=mysqli_query($conn,$firstQuery);
			$l=0;
			while ($row=$RisultatoQuery->fetch_object()){
				if($l==0){
			  $a = $xml->addChild("anime");
			  $a->addChild("title", $row->NomeAnime);
			  $episodes = $a->addChild("episodes");
				}
			  
			  $prodotto = $episodes->addChild("episode");
			  $prodotto->addChild("title", $row->NomeEpisodio);
			  $prodotto->addChild("number", $row->Numero);
			  $prodotto->addChild("dateJPN", $row->DataJPN);
              $prodotto->addChild("dateIT", $row->DataITA);			  
			  $prodotto->addChild("story", $row->Trama);
			  $l=1;
			}
		}
		
			
			
		
		echo $xml->asXML();
		$conn->close();
	}else{
	$conn->close();
	
	$datesIT = array();
	$datesJPN = array();
	$numep = array();
	$stories = array();
	$references = array();
	$titles = array();
	$versionAnime=array();
	
	$anime = array();
	$animeCount = 0;
	
	$movies = array();
	$oavs = array();
	
	$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><list_anime_products></list_anime_products>');
	libxml_use_internal_errors(true);
	
	$series = $_POST['series'];
	
	$url = "https://it.wikipedia.org/wiki/".$series;
	$dom = new DomDocument;
	$dom->loadHTMLFile($url);
	$xpath = new DomXPath($dom);
	
	
	$queryAnime = $xpath->query('//span[contains(@id, "Anime") or contains(@id, "anime")]/following::table[contains(@class, "noprint")]//i//a[contains(@href, "Episodi") and not(contains(@href, "OAV"))]/@href');

	//Controllo su eventuali molteplici pagine di anime
	if ($queryAnime->length > 0)
	{	
		foreach($queryAnime as $animes)
		{
			$animeName = explode("/", $animes->nodeValue);
			$animeName = explode("_", $animeName[2]);
			
			$string = "";
			for ($i = 2; $i < count($animeName); $i++)
				$string .= $animeName[$i]." ";
			$anime[] = trim($string);
			$animeCount += 1;
			
			$url2 = "https://it.wikipedia.org".$animes->nodeValue;
			$dom->loadHTMLFile($url2);
			$xpath = new DomXPath($dom);
			
			$format_page = 1;
			
			$queryResult = $xpath->query('//table[@class="wikitable"]//td[contains(@id, "ns")]/span/a[contains(@title, "Episodi") and contains(@href, "Episodi")]/@href');
			$queryResult2 = $xpath->query('//table[@class="wikitable"]//th/a[contains(@title, "Episodi") and contains(@href, "Episodi")]/@href');
			
			//Si tenta la seconda query per le saghe se la prima fallisce
			if ($queryResult->length == 0)
				$queryResult = $queryResult2;
			
			//Si effettua il controllo sulle saghe
			if ($queryResult->length == 0)
			{
				extractNumEp();
				extractStories(); 
				extractTitles();	
				extractDatesIt();
				extractDatesJPN();	
			}
			//Esistono saghe
			else
			{
				foreach($queryResult as $qR)
				{
					$temp = "";
			
					$newUrl = "https://it.wikipedia.org".$qR->nodeValue;
					if ($newUrl != $temp)
					{
						$temp = $newUrl;
				
						$dom1 = new DomDocument;
						$dom1->loadHTMLFile($newUrl);
						$xpath = new DomXPath($dom1);
			
						extractNumEp();
						extractStories(); 
						extractTitles();
						extractDatesIt();
						extractDatesJPN();
					}
				}
			}
			
			writeEpisodesXML();
		}	
	}
	//Se non ha una propria lista, cerco nella pagina standalone
	else
	{
		
		$format_page = 2;
		
		extractTitles();
		if (count($titles) > 0)
		{
			$anime[] = $series;
			$animeCount += 1;
			
			extractNumEp();
			extractStories();
			extractDatesJPN();
			extractDatesIt();
			/*
			echo "<pre>";
			var_dump(count($references)." ".count($datesIT)." ".count($stories)." ".count($datesJPN)." ".count($numep)." ".count($titles));
			die();
			*/
			writeEpisodesXML();
		}
	}
	
	//Se non ci sono riscontri nell'estrazione per lista di episodi
	//Si cerca nella navbox
	if ($xml->count() == 0)
	{
		$domA = new DomDocument;
		$domA->loadHTMLFile($url);
		$xpathA = new DomXPath($domA);

		//Cerco nella navbox
		$navbox = $xpathA->query('//table[contains(@class, "navbox")]//tr//th//i/a[contains(@href, "wiki")]');
		if ($navbox->length != 0)
		{
			if (stripos($series, $navbox->item(0)->nodeValue) !== FALSE)
			{
				//Verifico se ci sono anime nella navbox
				$animes = $xpathA->query('//table[contains(@class, "navbox")]//tr[contains(th/text(), "Anime")]/td/i');
				if ($animes->length != 0)
				{
					foreach($animes as $a)
					{
						$title = $xpathA->query('./a/@title', $a);
						$anchor = $xpathA->query('./a/text()', $a);
						$href = $xpathA->query('./a/@href', $a);
			
						$query = './following-sibling::small[1 and (contains(a/@title, "'.$anchor->item(0)->nodeValue.'") or contains(a/@title, "'.$title->item(0)->nodeValue.'"))]/a/@href';

						//Verifico se c'è un link alla lista di episodi per l'anime
						$list = $xpathA->query($query, $a);	
						$domS = new DomDocument;
						//Se non esiste il link alla lista, cerco nella pagina standalone
						//tag "small" degli episodi inesistente
						if ($list->length == 0)
						{
							$format_page = 2;
						
							if (stripos($title->item(0)->nodeValue, "Episodi") !== FALSE)
							{
								$animeName = explode("_", $title->item(0)->nodeValue);
			
								$string = "";
								for ($i = 2; $i < count($animeName); $i++)
									$string .= $animeName[$i]." ";
								$anime[] = trim($string);
								$animeCount += 1;	
							}
							else
							{
								$anime[] = $title->item(0)->nodeValue;
								$animeCount += 1;
							}
						
							$domS->loadHTMLFile("https://it.wikipedia.org".$href->item(0)->nodeValue);
							$xpath = new DomXPath($domS);
						
							extractNumEp();
							extractStories();
							extractTitles();
							extractDatesIt();
							extractDatesJPN();
						
							writeEpisodesXML();
						}		
						//Si entra nella lista dell'anime
						else 
						{
							$link = "https://it.wikipedia.org".$list->item(0)->nodeValue;
						
							$domS->loadHTMLFile($link);
							$xpath = new DomXPath($domS);
			
							$format_page = 1;
			
							$queryResult = $xpath->query('//table[@class="wikitable"]//td[contains(@id, "ns")]/span/a[contains(@title, "Episodi") and contains(@href, "Episodi")]/@href');
			
							//Si ripete il case senza saga
							if ($queryResult->length == 0)
							{
								//Si individua il nome dell'anime
								if (stripos($title->item(0)->nodeValue, "Episodi") !== FALSE)
								{
									$animeName = explode("_", $title->item(0)->nodeValue);
			
									$string = "";
									for ($i = 2; $i < count($animeName); $i++)
										$string .= $animeName[$i]." ";
									$anime[] = trim($string);	
									$animeCount += 1;
								}
								else
								{
									$anime[] = $title->item(0)->nodeValue;
									$animeCount += 1;
								}
							
								extractNumEp();
								extractStories(); 
								extractTitles();
								extractDatesIt();
								extractDatesJPN();
							}
							//Si ripete il case delle saghe
							else
							{
								//Si individua il nome dell'anime
								if (stripos($title->item(0)->nodeValue, "Episodi") !== FALSE)
								{
									$animeName = explode("_", $title->item(0)->nodeValue);
				
									$string = "";
									for ($i = 2; $i < count($animeName); $i++)
										$string .= $animeName[$i]." ";
									$anime[] = trim($string);
									$animeCount += 1;								
								}
								else
								{
									$anime[] = $title->item(0)->nodeValue;
									$animeCount += 1;
								}
							
								//Ciclo sulle saghe
								foreach($queryResult as $qR)
								{
									$temp = "";
			
									$newUrl = "https://it.wikipedia.org".$qR->nodeValue;
								
									if ($newUrl != $temp)
									{
										$temp = $newUrl;
				
										$dom1 = new DomDocument;
										$dom1->loadHTMLFile($newUrl);
										$xpath = new DomXPath($dom1);
			
										extractNumEp();
										extractStories(); 
										extractTitles();
										extractDatesIt();
										extractDatesJPN();
									}
								}
							}
						
							writeEpisodesXML();
						}
					}
				}
			}
		}
	}
	
	$dom2 = new DomDocument;
	$dom2->loadHTMLFile($url);
	$xpath = new DomXPath($dom2);
	
	//Cerco nella navbox per eventuali produzioni extra
	$queryNavbox = $xpath->query('//table[contains(@class, "navbox")]//tr//th//a[text() = "'.$series.'"]');
	if ($queryNavbox->length != 0)
	{
		//Si cerca di estrarre film e OAV
		extractMovies();
		extractOAVandONAandSpecialsandMiniEpisodes();
		writeMovOAVSpecialsXML();
	}
	//Si cerca se il titolo della serie, ottenuto, è presente nel titolo della navbox
	else
	{
		$navName = 	$xpath->query('//table[contains(@class, "navbox")]//tr//th//a/text()');
		if ($navName->length != 0)
		{
			if (stripos($series, $navName->item(0)->nodeValue) !== FALSE)
			{
				//Si cerca di estrarre film e OAV
				extractMovies();
				extractOAVandONAandSpecialsandMiniEpisodes();
				writeMovOAVSpecialsXML();
			}
		}
	}
	echo $xml->asXML();
	
	}
	//Si aggiungono eventuali film e OAV all'xml
	function writeMovOAVSpecialsXML()
	{
		global $xml, $movies, $oav_ona_specials_miniepisodes;
		
		if (count($movies) > 0)
		{
			$film = $xml->addChild("movies");
			for ($i = 0; $i < count($movies); $i++)
			{
				$prodotto = $film->addChild("movie");
			
				$prodotto->addChild("title", $movies[$i]["name"]);
				if ($movies[$i]["date"] != "")
					$prodotto->addChild("year", $movies[$i]["date"]);
			}
		}
		
		if (count($oav_ona_specials_miniepisodes) > 0)
		{
			$animes = $xml->addChild("other_productions");
		
			for ($n = 0; $n < count($oav_ona_specials_miniepisodes); $n++)
			{
				$prodotto = $animes->addChild($oav_ona_specials_miniepisodes[$n]["type"]);
			
				$prodotto->addChild("title", $oav_ona_specials_miniepisodes[$n]["name"]);
				
				if ($oav_ona_specials_miniepisodes[$n]["date"] != "")
					$prodotto->addChild("year", $oav_ona_specials_miniepisodes[$n]["date"]);
			}
		}
	}
	
	//Si aggiungono gli episodi di un anime all'xml
	function writeEpisodesXML()
	{
		global $xml, $anime, $animeCount, $datesIT, $titles, $datesJPN, $numep, $references, $stories, $versionAnime;
		
		$count = 0;
		$titoloAnime="";
		$numeroEpisodioAnime="";
		$nomeEpisodio="";
		$dataUscitaJpn="";
		$dataUscitaIta="";
		$tramaAnime="";
		$versioneAnime="";
		
		$conn = new mysqli("localhost", "root", "", "db_mangacards");//database connection
				if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
						}
						
		$conn->set_charset("utf8");
		
		for ($i = 0; $i < count($titles); $i++)
		{
			if ($numep[0] == 0)
				$start = 0;
			else
				$start = 1;
			
			if (intval($numep[$i]) == $start)
			{
				$a = $xml->addChild("anime");
				$a->addChild("title", change($anime[$count++]));
				$titoloAnime=change($anime[($count - 1)]);
				$versionAnime[]=change($anime[($count - 1)]);
				$episodes = $a->addChild("episodes");	
			}
			
			$versioneAnime=count($versionAnime);
			$prodotto = $episodes->addChild("episode");
			
			$prodotto->addChild("title", $titles[$i]);
			$nomeEpisodio=$titles[$i];
			if(is_null($numep[$i])){
				$prodotto->addChild("number", 'IN USCITA');
				$numeroEpisodioAnime="IN USCITA";
			}
			else{
				$prodotto->addChild("number", $numep[$i]);
				$numeroEpisodioAnime=$numep[$i];
			}
			
			if(count($datesJPN) > $i)
			{
				$prodotto->addChild("dateJPN", $datesJPN[$i]);	
				$dataUscitaJpn=$datesJPN[$i];
			}	
			else
			{
				$prodotto->addChild("dateJPN", "N.D.");
				$dataUscitaJpn="N.D.";
			}
			
			if (count($datesIT) > $i)
			{
				$prodotto->addChild("dateIT", $datesIT[$i]);
				$dataUscitaIta=$datesIT[$i];
			}
			else{
				$prodotto->addChild("dateIT", "N.D.");
				$dataUscitaIta="N.D.";
			}

			//Si assume che per la descrizione della trama e le referenze di adattamento ci siano valori con pi? di due parole
			if ($references[$numep[$i].$anime[$count-1]] != "" && count(explode(" ", $references[$numep[$i].$anime[$count-1]])) > 2)
				$prodotto->addChild("reference", htmlspecialchars($references[$numep[$i].$anime[$count-1]]));
			
			if ($stories[$numep[$i].$anime[$count-1]] != "" && count(explode(" ", $stories[$numep[$i].$anime[$count-1]])) > 2){
				$prodotto->addChild("story", htmlspecialchars($stories[$numep[$i].$anime[$count-1]]));
				$tramaAnime=htmlspecialchars($stories[$numep[$i].$anime[$count-1]]);
			}
			
			$titoloAnime=str_replace(array("\"","\'"),"",$titoloAnime);
			$nomeEpisodio=str_replace(array("\"","\'"),"",$nomeEpisodio);
			$tramaAnime=str_replace(array("\"","\'"),"",$tramaAnime);
			
			$toinsert = 'INSERT INTO episodi_anime
							(Numero, NomeAnime, VersioneAnime, NomeEpisodio, DataJPN, DataITA, Trama)
							VALUES
							('.intval($numeroEpisodioAnime).', "'.$titoloAnime.'", "'.$versioneAnime.'" ,"'.$nomeEpisodio.'", "'.$dataUscitaJpn.'", "'.$dataUscitaIta.'", "'.$tramaAnime.'")';
							
							
							if ($conn->query($toinsert) === TRUE) {
									//echo "New record created successfully";
									} else {
										//echo "Error: " . $sql . "<br>" . $conn->error;
												}
			
		}
		
		//Si reinizializzano le variabili per una nuova successiva aggiunta
		$anime = array();
		$animeCount = 0;
		$titles = array();
		$numep = array();
		$datesIT = array();
		$datesJPN = array();
		$stories = array();
		$references = array();
		$conn->close();
	}

	//Funzione di estrazione delle date italiane
	function extractDatesIt()
	{
		global $datesIT, $xpath, $format_page;
		
		if ($format_page == 1)
		{
			$query = '//table[@class="wikitable" and not(preceding-sibling::h2/span[contains(@id, "speciali") or contains(@id, "OAV")  or contains(@id, "Film")]) and not(preceding-sibling::h3/span[contains(@id, "Parallel")])]//tr[contains(@id, "ep")]';
		}
		else
		{
			$query = '//span[@id = "Anime" or @id = "Episodi"]/following::table[@class="wikitable"][1]//tr[contains(@id, "ep")]';
		}		
		$eps = $xpath->query($query);
		
		foreach($eps as $ep)
		{
			$dates_it_query = $xpath->query('./td[contains(@style, "white-space:nowrap")][2]', $ep);

			if ($dates_it_query->length == 0)
			{
				
				$datesIT[] = "N.D.";
				continue;
			}

			if ($dates_it_query->item(0)->nodeValue == "-" || $dates_it_query->item(0)->nodeValue == "Inedito")
			{
				
				$datesIT[] = "N.D.";
			}
			else
			{	
				preg_match_all("#(\d+\?? )?(\w+ )?\d+#", $dates_it_query->item(0)->nodeValue, $match);
				
				$string = "";
				foreach ($match[0] as $word)
					$string .= $word." ";	
					
				$transformedDate = transformDate(trim($string));	

				if ($transformedDate == "")
					$datesIT[] = "N.D.";
				else
					$datesIT[] = $transformedDate;
			}
		}
				
		//Case per l'estrazione in pagine di stagioni successive
		if ($format_page == 2)
		{
			$counter = 1;
			
			while (1)
			{	
				$query_season = $xpath->query('//span[@id = "Anime" or @id = "Episodi"]/following::table[@class="wikitable"]['.$counter.']/following::*[name()="span" or name()="dt"]['.$counter.' and contains(text(), "stagione")][1]');
				
				if ($query_season->length == 0)
					break;
				
				$eps = $xpath->query('./following::table[1]//tr[contains(@id, "ep")]', $query_season->item(0));
				foreach($eps as $ep)
				{			
					$dates_it_query = $xpath->query('./td[contains(@style, "white-space:nowrap")][2]', $ep);
			
					if ($dates_it_query->length == 0)
					{
						$datesIT[] = "N.D.";
						continue;
					}

					if ($dates_it_query->item(0)->nodeValue == "-" || $dates_it_query->item(0)->nodeValue == "Inedito")
					{
						$datesIT[] = "N.D.";
					}
					else
					{	
						preg_match_all("#(\d+\?? )?(\w+ )?\d+#", $dates_it_query->item(0)->nodeValue, $match);
						$string = "";
						foreach ($match[0] as $word)
							$string .= $word." ";	

						$transformedDate = transformDate(trim($string));
						if ($transformedDate == "")
							$datesIT[] = "N.D.";
						else
							$datesIT[] = $transformedDate;
					}
				}

				$counter += 1;
			}
		}
	}
	
	//Funzione di estrazione delle date giapponesi
	function extractDatesJPN()
	{
		global $datesJPN, $xpath, $format_page;
		
		if ($format_page == 2)
		{
			$dates_jpn_query = $xpath->query('//span[@id = "Anime" or @id = "Episodi"]/following::table[@class="wikitable"][1]//tr[contains(@id, "ep")]/td[contains(@style, "white-space:nowrap")][1]/text()');
		}
		else 
		{	
			$dates_jpn_query = $xpath->query('//table[@class="wikitable" and not(preceding-sibling::h2/span[contains(@id, "speciali") or contains(@id, "OAV")  or contains(@id, "Film")]) and not(preceding-sibling::h3/span[contains(@id, "Parallel")])]//tr[contains(@id, "ep")]/td[contains(@style, "white-space:nowrap")][1]/text()');
		}
		
		foreach($dates_jpn_query as $date_jpn)
		{	
			if ($date_jpn == "" || $date_jpn == " " || $date_jpn == NULL)
				continue;

			preg_match_all("#(\d+\?? )?(\w+ )?\d+#", $date_jpn->nodeValue, $match);
			
			$string = "";
			foreach ($match[0] as $word)
				$string .= $word." ";	
				
			$transformedDate = transformDate(trim($string));

			if ($transformedDate == "")
				$datesJPN[] = "N.D.";
			else
				$datesJPN[] = $transformedDate;
		}
		
		//Case per l'estrazione in pagine di stagioni successive
		if ($format_page == 2)
		{
			$counter = 1;
			
			while (1)
			{	
				$query_season = $xpath->query('//span[@id = "Anime" or @id = "Episodi"]/following::table[@class="wikitable"]['.$counter.']/following::*[name()="span" or name()="dt"]['.$counter.' and contains(text(), "stagione")][1]');
				
				if ($query_season->length == 0)
					break;
				
				$dates_jpn_query = $xpath->query('./following::table[1]//tr[contains(@id, "ep")]/td[contains(@style, "white-space:nowrap")][1]', $query_season->item(0));
				foreach($dates_jpn_query as $date_jpn)
				{			
					if ($date_jpn == "" || $date_jpn == " " || $date_jpn == NULL)
						continue;

					preg_match_all("#(\d+\?? )?(\w+ )?\d+#", $date_jpn->nodeValue, $match);
			
					$string = "";
					foreach ($match[0] as $word)
						$string .= $word." ";	
						
					$transformedDate = transformDate(trim($string));

					if ($transformedDate == "")
						$datesJPN[] = "N.D.";
					else
						$datesJPN[] = $transformedDate;
				}

				$counter += 1;
			}
		}
	}

	//Funzione di estrazione dei titoli degli episodi
	function extractTitles()
	{
		global $titles, $xpath, $format_page;
		
		if ($format_page == 2)
		{
			$titles_query = $xpath->query('//span[@id = "Anime" or @id = "Episodi"]/following::table[@class="wikitable"][1]//tr[contains(@id, "ep")]/td[./i/b or ./b/i or contains(span/@lang, "ja")]');
		}
		else 
		{
			$titles_query = $xpath->query('//table[@class="wikitable" and not(preceding-sibling::h2/span[contains(@id, "speciali") or contains(@id, "OAV")  or contains(@id, "Film")]) and not(preceding-sibling::h3/span[contains(@id, "Parallel")])]//tr[contains(@id, "ep")]/td[./i/b or ./b/i or contains(span/@lang, "ja")]');
		}	
		//$i = 1;
		foreach($titles_query as $title_query)
		{	
				$titles[] = $title_query->nodeValue;
		}
		
		//Case per l'estrazione in pagine di stagioni successive
		if ($format_page == 2 && count($titles) > 0)
		{
			$counter = 1;
			
			while (1)
			{
				$query_season = $xpath->query('//span[@id = "Anime" or @id = "Episodi"]/following::table[@class="wikitable"]['.$counter.']/following::*[name()="span" or name()="dt"]['.$counter.' and contains(text(), "stagione")][1]');

				if ($query_season->length == 0)
					break;

				$titles_query = $xpath->query('./following::table[1]//tr[contains(@id, "ep")]/td[./i/b or ./b/i or contains(span/@lang, "ja")]', $query_season->item(0));
				foreach($titles_query as $title_query)
				{		
					$titles[] = $title_query->nodeValue;
				}
				
				$counter += 1;
			}	
		}
	}

	//Funzione di estrazione del numero di ogni episodio
	function extractNumEp()
	{
			global $numep, $xpath, $format_page;
			
			$numTot = $xpath->query('//table[@class="wikitable" and not(preceding-sibling::h2/span[contains(@id, "speciali") or contains(@id, "OAV")  or contains(@id, "Film")]) and not(preceding-sibling::h3/span[contains(@id, "Parallel")])]//th[contains(text(), "N°Tot")]');
			
			if ($format_page != 2)
			{
				if ($numTot->length == 0)
					$nums_query = $xpath->query('//table[@class="wikitable" and not(preceding-sibling::h2/span[contains(@id, "speciali") or contains(@id, "OAV")  or contains(@id, "Film")]) and not(preceding-sibling::h3/span[contains(@id, "Parallel")])]//tr[contains(@id, "ep")]/td[1]');
				else
					$nums_query = $xpath->query('//table[@class="wikitable" and not(preceding-sibling::h2/span[contains(@id, "speciali") or contains(@id, "OAV")  or contains(@id, "Film")]) and not(preceding-sibling::h3/span[contains(@id, "Parallel")])]//tr[contains(@id, "ep")]/td[2]');
			}
			else
			{
				if ($numTot->length == 0)
					$nums_query = $xpath->query('//span[@id = "Anime" or @id = "Episodi"]/following::table[@class="wikitable"][1]//tr[contains(@id, "ep")]/td[1]');
				else
					$nums_query = $xpath->query('//span[@id = "Anime" or @id = "Episodi"]/following::table[@class="wikitable"][1]//tr[contains(@id, "ep")]/td[2]');
			}
			
			foreach($nums_query as $num_query)
			{	
					if(stristr($num_query->nodeValue,'('))
					{
						$value = explode("(", $num_query->nodeValue);
						$numep[] = trim($value[0]);
					}
					else
					{
						$numep[] = $num_query->nodeValue;
					}
			}
			
			//Case per l'estrazione in pagine di stagioni successive
			if ($format_page == 2)
			{
				$counter = 1;

				while(1)
				{
					$query_season = $xpath->query('//span[@id = "Anime" or @id = "Episodi"]/following::table[@class="wikitable"]['.$counter.']/following::*[name()="span" or name()="dt"]['.$counter.' and contains(text(), "stagione")][1]');

					if ($query_season->length == 0)
						break;
				
					if ($numTot->length == 0)
						$nums_query = $xpath->query('./following::table[1]//tr[contains(@id, "ep")]/td[1]', $query_season->item(0));
					else
						$nums_query = $xpath->query('./following::table[1]//tr[contains(@id, "ep")]/td[2]', $query_season->item(0));
					
					if (stripos($num_query->nodeValue,'(') !== FALSE)
					{
						$value = explode("(", $num_query->nodeValue);
						$numep[] = trim($num[0]);
					}
					else
					{
						$numep[] = $num_query->nodeValue;
					}
					
					$counter += 1;
				}				
			}
	}

	//Funzione di estrazione della trama di ogni episodio e dal capitolo/romanzo da cui è prodotto
	function extractStories()
	{
		global $stories, $anime, $animeCount, $references, $xpath, $format_page;
		
		$numTot = $xpath->query('//table[@class="wikitable" and not(preceding-sibling::h2/span[contains(@id, "speciali") or contains(@id, "OAV")  or contains(@id, "Film")]) and not(preceding-sibling::h3/span[contains(@id, "Parallel")])]//th[contains(text(), "N°Tot")]');
		if ($format_page == 1)
		{
			$query = '//table[@class="wikitable" and not(preceding-sibling::h2/span[contains(@id, "speciali") or contains(@id, "OAV")])]//tr[contains(@id, "ep")]';
		}
		else
		{
			$query = '//span[@id = "Anime" or @id = "Episodi"]/following::table[@class="wikitable"][1]//tr[contains(@id, "ep")]';
		}		
		$eps_tr = $xpath->query($query);

		foreach($eps_tr as $ep_tr)
		{
			$id = $xpath->query('./td[1]/text()', $ep_tr);
			$idTot = $xpath->query('./td[2]/text()', $ep_tr);
			
			if(stristr($id->item(0)->nodeValue,'('))
			{
				$value = explode("(", $id->item(0)->nodeValue);
				$idToWrite = trim($value[0]);
			}
			else
			{
				$idToWrite = $id->item(0)->nodeValue;
			}
			if ($numTot->length > 0)
			{
				if(stristr($id->item(0)->nodeValue,'('))
				{
					$value = explode("(", $idTot->item(0)->nodeValue);
					$idToWrite = trim($value[0]);
				}
				else
				{
					$idToWrite = $idTot->item(0)->nodeValue;
				}
			}
			
			$story = $xpath->query('./following-sibling::tr/td[@colspan = 7 and not(contains(@style, "text-align"))]', $ep_tr);
			if ($story->length != 0)
			{
				$stories[$idToWrite.$anime[$animeCount-1]] = $story->item(0)->nodeValue;
				$reference = $xpath->query('./div[contains(@style, "font-size:0.95em")]/p[contains(i/b, "Adattato")]/i/text()', $story->item(0));
				
				$string = "";
				if ($reference->length > 1)
				{
					foreach ($reference as $ref)
						$string .= " ".$ref->nodeValue;
				
					$references[$idToWrite.$anime[$animeCount-1]] = trim($string);
				}
				else
				{
					if ($reference->length == 1)	
						$references[$idToWrite.$anime[$animeCount-1]] = $reference->item(0)->nodeValue;
					else
						$references[$idToWrite.$anime[$animeCount-1]] = "";
				}
			}
			else 
			{		
				$stories[$idToWrite.$anime[$animeCount-1]] = "";
				$references[$idToWrite.$anime[$animeCount-1]] = "";
			}
		}
		
		//Case per l'estrazione in pagine di stagioni successive
		if ($format_page == 2)
		{
			
			$counter = 1;
			
			while (1)
			{
				$query_season = $xpath->query('//span[@id = "Anime" or @id = "Episodi"]/following::table[@class="wikitable"]['.$counter.']/following::*[name()="span" or name()="dt"]['.$counter.' and contains(text(), "stagione")][1]');
				
				if ($query_season->length == 0)
					break;
				
				$eps_tr = $xpath->query('./following::table[1]//tr[contains(@id, "ep")]', $query_season->item(0));
				foreach($eps_tr as $ep_tr)
				{
					$id = $xpath->query('./td[1]/text()', $ep_tr);
					$idTot = $xpath->query('./td[2]/text()', $ep_tr);
			
					$idToWrite = $id->item(0)->nodeValue;
					if ($numTot->length > 0)
					{
						$idToWrite = $idTot->item(0)->nodeValue;
					}
					$story = $xpath->query('./following-sibling::tr/td[@colspan = 7 and not(contains(@style, "text-align"))]', $ep_tr);
					if ($story->length != 0)
					{
						$stories[$idToWrite.$anime[$animeCount-1]] = $story->item(0)->nodeValue;
						$reference = $xpath->query('./div[contains(@style, "font-size:0.95em")]/p[contains(i/b, "Adattato")]/i/text()', $story->item(0));
				
						$string = "";
						if ($reference->length > 1)
						{
							foreach ($reference as $ref)
								$string .= " ".$ref->nodeValue;
				
							$references[$idToWrite.$anime[$animeCount-1]] = trim($string);
						}
						else
						{
							if ($reference->length == 1)	
								$references[$idToWrite.$anime[$animeCount-1]] = $reference->item(0)->nodeValue;
							else
								$references[$idToWrite.$anime[$animeCount-1]] = "";
						}
					}
					else 
					{		
						$stories[$idToWrite.$anime[$animeCount-1]] = "";
						$references[$idToWrite.$anime[$animeCount-1]] = "";
					}
				}
				
				$counter += 1;
			}
		}
	}
	
	//Funzione di estrazione dei film
	function extractMovies()
	{
		global $movies, $xpath, $series;

		$query = '//table[contains(@class, "navbox")][1]//tr[contains(th, "Film")]//td/i';
		
		$films = $xpath->query($query);
		if ($films->length == 0)
			return;
		
		foreach ($films as $res)
		{
			$name = $xpath->query("./a/text()", $res);
			$date = $xpath->query("./following-sibling::text()[1]", $res);	
			
			if ($date->length == 0)
				$movies[] = array("name" => $name->item(0)->nodeValue, "date" => "");
			else
			{
				preg_match_all("#\d+#", $date->item(0)->nodeValue, $match);
				$string = "";
				foreach($match[0] as $word)
					$string .= $word." ";
					
				$movies[] = array("name" => $name->item(0)->nodeValue, "date" => trim($string));
			}
		}
	}
	
	//Funzione di estrazione di OAV
	function extractOAVandONAandSpecialsandMiniEpisodes()
	{
		global $oav_ona_specials_miniepisodes, $xpath, $series;

		$query = '//table[contains(@class, "navbox")]//tr[cth = "OAV" or th = "ONA"]//td/i';
		
		$videos = $xpath->query($query);
		
		if ($videos->length != 0)
		{
			foreach ($videos as $res)
			{
				$name = $xpath->query("./a/text()", $res);
				$date = $xpath->query("./following-sibling::text()[1]", $res);	
			
				if ($date->length == 0)
					$oav_ona_specials_miniepisodes[] = array("name" => $name->item(0)->nodeValue, "date" => "", "type" => "oav");
				else
				{
					preg_match_all("#\d+#", $date->item(0)->nodeValue, $match);
					$string = "";
					foreach($match[0] as $word)
						$string .= $word." ";
					
					$oav_ona_specials_miniepisodes[] = array("name" => $name->item(0)->nodeValue, "date" => trim($string), "type" => "oav");	
				}
			}
		}
		
		$query = '//table[contains(@class, "navbox")]//tr[contains(th, "Special") or contains(th, "special")]//td/i';
		
		$videos = $xpath->query($query);
		
		if ($videos->length != 0)
		{
			foreach ($videos as $res)
			{
				$name = $xpath->query("./a/text()", $res);
				$date = $xpath->query("./following-sibling::text()[1]", $res);	
			
				if ($date->length == 0)
					$oav_ona_specials_miniepisodes[] = array("name" => $name->item(0)->nodeValue, "date" => "", "type" => "special");
				else
				{
					preg_match_all("#\d+#", $date->item(0)->nodeValue, $match);
					$string = "";
					foreach($match[0] as $word)
						$string .= $word." ";
					
					$oav_ona_specials_miniepisodes[] = array("name" => $name->item(0)->nodeValue, "date" => trim($string), "type" => "special");	
				}
			}
		}
		
		$query = '//table[contains(@class, "navbox")]//tr[contains(th, "Corti")]//td/i';
		
		$videos = $xpath->query($query);
		
		if ($videos->length != 0)
		{
			foreach ($videos as $res)
			{
				$name = $xpath->query("./a/text()", $res);
				$date = $xpath->query("./following-sibling::text()[1]", $res);	
			
				if ($date->length == 0)
					$oav_ona_specials_miniepisodes[] = array("name" => $name->item(0)->nodeValue, "date" => "", "type" => "miniepisode");
				else
				{
					preg_match_all("#\d+#", $date->item(0)->nodeValue, $match);
					$string = "";
					foreach($match[0] as $word)
						$string .= $word." ";
					
					$oav_ona_specials_miniepisodes[] = array("name" => $name->item(0)->nodeValue, "date" => trim($string), "type" => "miniepisode");	
				}
			}
		}
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
	
	function change($string)
	{
		if (stripos($string, "%C2%BD") !== FALSE)
			$string = str_replace("%C2%BD", "½", $string);
		
		if (stripos($string, "%C3%97") !== FALSE)
			$string = str_replace("%C3%97", "×", $string);
		
		if (stripos($string, "%CE%A9") !== FALSE)
			$string = str_replace("%CE%A9", "Ω", $string);
		
		if (stripos($string, "%C5%8D") !== FALSE)
			$string = str_replace("%C5%8D", "ō", $string);
		
		if (stripos($string, "%2B") !== FALSE)
			$string = str_replace("%2B", "+", $string);
		
		return $string;
	}
?>