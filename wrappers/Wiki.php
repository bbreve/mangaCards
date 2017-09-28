<?php

	header("Content-type: application/xml");
	
	$datesIT = array();
	$numvol = array();
	$numChapters = array();
	$nameChapters = array();
	$volChapters = array();
	$stories = array();
	$titles = array();
	
	libxml_use_internal_errors(true);
	/* Createa a new DomDocument object */
	$dom = new DomDocument;
	/* Load the HTML */
	$url = "https://it.wikipedia.org/wiki/Capitoli_di_Bleach";
	$dom->loadHTMLFile($url);
	/* Create a new XPath object */
	$xpath = new DomXPath($dom);
	
	$series = "One Piece";
	
	$num_manga = 1;
	
	if (stripos($url, "Capitoli") !== FALSE)
		$format_page = 1;
	else $format_page = 2;
	
	$number = 73;
	$numberJ = 74;
	
	extractTitles();
	extractDatesIt();
	extractNumvol();
	
	/*var_dump($titles);
	echo "<br />";
	var_dump(count($titles));
	echo "<br />";
	var_dump($datesIT);
	echo "<br />";
	var_dump(count($datesIT));
	echo "<br />";
	var_dump($numvol);
	echo "<br />";
	var_dump(count($numvol));
	echo "<br />";*/
	$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><list_volumes></list_volumes>');
	//$xml->addChild("io", count($numvol));
	//$xml->addChild("io", count($datesIT));
	//$xml->addChild("io", count($titles));
	if (count($titles) == $number && count($datesIT) == $number && count($numvol) == $number)
	{
		
		extractVolChapters();
		extractStories();
		//$xml->addChild("Ciao");
		writeVolumesXML();
	}
	
	extractNameChapters();
	extractNumChapters();
	//var_dump($nameChapters);
	//var_dump($numChapters);
	$xml2 = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><list_chapters></list_chapters>');
	//$xml2->addChild("io", count($numChapters));
	//$xml2->addChild("io", count($nameChapters));
	if (count($nameChapters) == count($numChapters))
		writeChaptersXML();
	
	echo $xml->asXML();
	//echo $xml2->asXML();
	
	function writeVolumesXML()
	{
		global $datesIT, $titles, $numvol, $stories, $volChapters, $xml;
		
		for ($i = 0; $i < count($titles); $i++)
		{
			$prodotto = $xml->addChild("volume");
			
			$prodotto->addChild("title", $titles[$i]);
			$prodotto->addChild("number", $numvol[$i]);
			$prodotto->addChild("date", $datesIT[$i]);
			
			if (count($stories) == count($titles))
				$prodotto->addChild("story", $stories[$i]);
			
			if (count($volChapters) == count($titles))
			{
				$list = $prodotto->addChild("chapters_list");
				foreach ($volChapters[$i] as $node)
					$list->addChild("chapter", trim($node->nodeValue));
			}			
		}
	}
	
	function writeChaptersXML()
	{
		global $nameChapters, $numChapters, $xml2;
		
		for ($n = 0; $n < count($nameChapters); $n++)
		{
			if ($nameChapters[$n] <> "")
			{
				$capitolo = $xml2->addChild("chapter");
					
				$capitolo->addChild("title", $nameChapters[$n]);
			
				if (is_numeric($numChapters[$n]) == FALSE)
					$capitolo->addChild("speciale");
				else 
					$capitolo->addChild("number", $numChapters[$n]);
			}
		}
	}
	
	function extractDatesIt()
	{
		global $number, $datesIT, $xpath, $format_page, $num_manga, $series;
		
		if ($format_page == 2)
			$query = $xpath->query("//span[@id = 'Capitoli' or @id = 'Manga']/following::table[@class='wikitable'][1]//tr[td[1] > 0 and td[1] <= ".$number."]/td[last()]/text()");	
		else 
		{
			if ($num_manga == 1)
			{	
				if ($series == "One Piece" || $series == "Naruto")
					$query = $xpath->query("//table[@class='wikitable']//tr[td[1] > 0 and td[1] <= ".$number."]/td[last()]/text()");
				else
					$query = $xpath->query("//table[@class='wikitable'][1]//tr[td[1] > 0 and td[1] <= ".$number."]/td[last()]/text()");
			}
			else 
				$query = $xpath->query("//table[@class='wikitable'][2]//tr[td[1] > 0 and td[1] <= ".$number."]/td[last()]/text()");
		}
		
		foreach ($query as $node)
		{
			if ($node == "" || $node == " " || $node == NULL)
				continue;
			
			$arrays = explode(" ", $node->nodeValue);
			if (count($arrays) != 3)
				$datesIT[] = trim($node->nodeValue);
			else 
			{
				if (count($datesIT) > 0)
				{
					$user_date = DateTime::createFromFormat('d/m/Y', $datesIT[count($datesIT)-1]);
					$current = DateTime::createFromFormat('d/m/Y', transformDate(trim($node->nodeValue)));
					if (stripos($datesIT[count($datesIT)-1], $node->nodeValue) !== false || $current <= $user_date)
					continue;
				}
				
				$datesIT[] = transformDate(trim($node->nodeValue));
			}
		}
	}
	
	function extractVolChapters()
	{
		global $volChapters, $number, $xpath, $format_page;
		
		if ($format_page == 2)
			$query = $xpath->query("//span[@id = 'Capitoli' or @id = 'Manga']/following::table[@class='wikitable'][1]//tr[td[1] > 0 and td[1] <= ".$number." and td[2]/@rowspan > 0]/td[2]");
		else 
			$query = $xpath->query("//table[@class='wikitable']//tr[td[1] > 0 and td[1] <= ".$number." and td[2]/@rowspan > 0]/td[2]");

		if ($query->length == 0)
		{
			if ($format_page == 2)
				$query = $xpath->query("//span[@id = 'Capitoli' or @id = 'Manga']/following::table[@class='wikitable'][1]//tr[td[1] > 0 and td[1] <= ".$number."]/following::tr[1]//ul");
			else
				$query = $xpath->query("//table[@class='wikitable']//tr[td[1] > 0 and td[1] <= ".$number."]/following::tr[1]//ul");

			if ($query->length == $number)
			{
				foreach ($query as $node)
				{
					
					if ($node == "" || $node == " " || $node == NULL)
						continue;
					
					$single_volume = $xpath->query(".//li", $node);
					$volChapters[] = $single_volume;
								
				}
			}				
		}
	}
	
	function extractTitles()
	{
		global $titles, $number, $numberJ, $xpath, $format_page, $series, $num_manga;
		
		$counter = 1;
		
		if ($format_page == 2)
			$query = $xpath->query("//span[@id = 'Capitoli' or @id = 'Manga']/following::table[@class='wikitable'][1]//tr[td[1] > 0 and td[1] <= ".$number."]//b");	
		else 
		{
			if ($num_manga == 1)
			{
				if ($series == "One Piece" || $series == "Naruto")
					$query = $xpath->query("//table[@class='wikitable']//tr[td[1] > 0 and td[1] <= ".$number."]//b");
				else 
					$query = $xpath->query("//table[@class='wikitable'][1]//tr[td[1] > 0 and td[1] <= ".$number."]//b");
			}
			else 
				$query = $xpath->query("//table[@class='wikitable'][2]//tr[td[1] > 0 and td[1] <= ".$number."]//b");
		}	
		
		foreach ($query as $node)
		{
			if ($node == "" || $node == " " || $node == NULL)
				continue;
		
			if (stripos($node->nodeValue, "/") !== false)
			{
				$arrays = explode("/", $node->nodeValue);
				if (is_numeric($arrays[count($arrays)-1]) == TRUE)
					$titles[] = trim($node->nodeValue);
				else 
				{
					for ($i = 0; $i < count($arrays); $i++)
					{
						if ($arrays[$i] == "" || $arrays[$i] == " " || $arrays[$i] == NULL)
							continue;
					
						if (count($titles) > 0)
						{
							if (stripos($titles[count($titles)-1], $arrays[$i]) !== false || $titles[count($titles)-1] == $arrays[$i])
								continue;
						}	
					
						$titles[] = trim($arrays[$i]);
					}
				}
			}
			else 
			{	
				if ($format_page == 2)
					$query1 = $xpath->query("//span[@id = 'Capitoli' or @id = 'Manga']/following::table[@class='wikitable'][1]//tr[td[1] > 0 and td[1] <= ".$number." and td[2]/@rowspan > 0]/td[2]");
				else 
				{	
					if ($num_manga == 1)
						$query1 = $xpath->query("//table[@class='wikitable'][1]//tr[td[1] > 0 and td[1] <= ".$number." and td[2]/@rowspan > 0]/td[2]");
					else 
						$query1 = $xpath->query("//table[@class='wikitable'][2]//tr[td[1] > 0 and td[1] <= ".$number." and td[2]/@rowspan > 0]/td[2]");
				}
				
				if ($query1->length != 0 && $query->length == $numberJ)
				{
					$count = count(explode(" ", $series));
				
					$array = explode(" ", $node->nodeValue);
					$countT = count($array);

					$titles[] = trim($series." ".$counter++);
					$titles[] = trim($series." ".$counter++);
				}
				else
					$titles[] = trim($node->nodeValue);
			}
		}
		
		
		//Elimino eventuali citazioni
		for ($i = 0; $i < count($titles); $i++)
		{
			$arrays = explode("[1]", $titles[$i]);   //da modificare con l'espressione regolare corretta
			if (count($arrays) == 2)
				$titles[$i] = $arrays[0]." ".$arrays[1];
			else if (count($arrays) == 1)
				$titles[$i] = $arrays[0];
		}
	}
	
	function extractNumvol()
	{
		global $numvol, $number, $xpath, $format_page, $num_manga, $series;
		
		if ($format_page == 2)
			$query = $xpath->query("//span[@id = 'Capitoli' or @id = 'Manga']/following::table[@class='wikitable'][1]//tr[td[1] > 0 and td[1] <= ".$number." and td[2]/@rowspan > 0]/td[2]");	
		else
		{
			if ($num_manga == 1)
				$query = $xpath->query("//table[@class='wikitable'][1]//tr[td[1] > 0 and td[1] <= ".$number." and td[2]/@rowspan > 0]/td[2]");
			else 
				$query = $xpath->query("//table[@class='wikitable'][2]//tr[td[1] > 0 and td[1] <= ".$number." and td[2]/@rowspan > 0]/td[2]");
		}
		
		if ($query->length != 0)
		{
			foreach ($query as $node)
			{
				$arrays = explode("-", $node->nodeValue);
				for ($i = 0; $i < count($arrays); $i++)
				{
					if (count($numvol) > 0)
					{
						if (stripos($numvol[count($numvol)-1], $arrays[$i]) !== false)
							continue;
					}	
					$numvol[] = trim($arrays[$i]);
				}	
			}
		}
		else
		{
			if ($format_page == 2)
				$query = $xpath->query("//span[@id = 'Capitoli' or @id = 'Manga']/following::table[@class='wikitable'][1]//tr[td[1] > 0 and td[1] <= ".$number."]/td[1]");	
			else
			{
				if ($num_manga == 1)
				{	
					if ($series == "One Piece" || $series == "Naruto")
						$query = $xpath->query("//table[@class='wikitable']//tr[td[1] > 0 and td[1] <= ".$number."]/td[1]");
					else
						$query = $xpath->query("//table[@class='wikitable'][1]//tr[td[1] > 0 and td[1] <= ".$number."]/td[1]");
				}
				else 
					$query = $xpath->query("//table[@class='wikitable'][2]//tr[td[1] > 0 and td[1] <= ".$number."]/td[1]");
			}
			
			foreach ($query as $node)
				$numvol[] = trim($node->nodeValue);
		}
	}
	
	function extractNameChapters()
	{
		global $nameChapters, $numberJ, $xpath, $format_page, $series, $num_manga;
		
		if ($format_page == 2)
			$query = $xpath->query("//span[@id = 'Capitoli' or @id = 'Manga']/following::table[@class='wikitable'][1]//tr[td[1] > 0 and td[1] <= ".$numberJ."]/following::tr[1]//li");
		else	
		{
			if ($num_manga == 1)
			{
				if ($series == "One Piece" || $series == "Naruto")
					$query = $xpath->query("//table[@class='wikitable']//tr[td[1] > 0 and td[1] <= ".$numberJ."]/following::tr[1]//li");
				else 
					$query = $xpath->query("//table[@class='wikitable'][1]//tr[td[1] > 0 and td[1] <= ".$numberJ."]/following::tr[1]//li");
			}
			else
				$query = $xpath->query("//table[@class='wikitable'][2]//tr[td[1] > 0 and td[1] <= ".$numberJ."]/following::tr[1]//li");
		}
		
		if ($query->length != 0)
		{
			foreach ($query as $node)
			{
				$arrays = explode("(", $node->nodeValue);
				$arrays1 = explode(". ", $arrays[0]);
				if (count($arrays1) >= 2)
				{
					$string = "";
					for ($i = 1; $i < count($arrays1); $i++)
						$string = $string.trim($arrays1[$i])." ";

					$nameChapters[] = trim($string);
				}
				else $nameChapters[] = trim($arrays1[0]);
			}
		}
		
		$query = $xpath->query("//span[contains(string(.), 'Capitoli non ancora') and contains(@class, 'headline')]/following::ul[1]//li");
		if ($query->length != 0)
		{
			foreach ($query as $node)
			{
				$arrays = explode("(", $node->nodeValue);
				$arrays1 = explode(". ", $arrays[0]);
				if (count($arrays1) >= 2)
				{
					$string = "";
					for ($i = 1; $i < count($arrays1); $i++)
						$string = $string.trim($arrays1[$i])." ";

					$nameChapters[] = trim($string);
				}
				else $nameChapters[] = trim($arrays1[0]);
			}
		}	
	}
	
	function extractNumChapters()
	{
		global $numChapters, $numberJ, $xpath, $format_page, $series, $num_manga;
		
		$count = 1;
		if ($format_page == 2)
			$query = $xpath->query("//span[@id = 'Capitoli' or @id = 'Manga']/following::table[@class='wikitable'][1]//tr[td[1] > 0 and td[1] <= ".$numberJ."]/following::tr[1]//li");
		else	
		{
			if ($num_manga == 1)
			{
				if ($series == "One Piece"  || $series == "Naruto")
					$query = $xpath->query("//table[@class='wikitable']//tr[td[1] > 0 and td[1] <= ".$numberJ."]/following::tr[1]//li");
				else 
					$query = $xpath->query("//table[@class='wikitable'][1]//tr[td[1] > 0 and td[1] <= ".$numberJ."]/following::tr[1]//li");
			}
			else
				$query = $xpath->query("//table[@class='wikitable'][2]//tr[td[1] > 0 and td[1] <= ".$numberJ."]/following::tr[1]//li");
		}
		
		if ($query->length != 0)
		{
			foreach ($query as $node)
			{
				$arrays = explode("(", $node->nodeValue);
				if (stripos($arrays[0], ".") !== FALSE)
					$arrays1 = explode(". ", $arrays[0]);
				else if (stripos($arrays[0], ":") !== FALSE)
					$arrays1 = explode(": ", $arrays[0]);
				
				if (stripos($arrays1[0], "Special") !== FALSE || stripos($arrays1[0], "Gaiden") !== FALSE || stripos($arrays1[0], "Extra") !== FALSE || stripos($arrays1[0], "Bonus") !== FALSE)
					$numChapters[] = "special";
				else
				{
					if (is_numeric($arrays1[0]) == FALSE)
					{
						$arraysF = explode(" ", $arrays1[0]);
						if (is_numeric($arraysF[count($arraysF)-1]) == FALSE)
							$numChapters[] = "special";
						else 
							$numChapters[] = $count++;
					}
					else 
					{
						$numChapters[] = $count++;
					}
				}
			}
		}
		
		$query = $xpath->query("//span[contains(string(.), 'Capitoli non ancora') and contains(@class, 'headline')]/following::ul[1]//li");
		if ($query->length != 0)
		{
			foreach ($query as $node)
			{
				$arrays = explode("(", $node->nodeValue);
				$arrays1 = explode(". ", $arrays[0]);
				
				if (stripos($arrays1[0], "Special") !== FALSE || stripos($arrays1[0], "Gaiden") !== FALSE || stripos($arrays1[0], "Extra") !== FALSE || stripos($arrays1[0], "Bonus") !== FALSE)
					$numChapters[] = "special";
				else
				{
					if (is_numeric($arrays1[0]) == FALSE)
					{
						$arraysF = explode(" ", trim($arrays1[0]));
						$word = $arraysF[count($arraysF)-1];
						if (is_numeric($word[strlen($word)-1]) == FALSE)
						{
							$word1 = substr($word, 0, strlen($word)-1);
							if (is_numeric($word1) != FALSE)
								$numChapters[] = $count++;
							else
								$numChapters[] = "special";
						}
						else
							$numChapters[] = $count++;
					}
					else 
					{
						$numChapters[] = $count++;
					}
				}
			}
		}
	}

	function extractStories()
	{
		global $stories, $number, $xpath, $format_page;
		
		if ($format_page == 2)
			$query = $xpath->query("//span[@id = 'Capitoli' or @id = 'Manga']/following::table[@class='wikitable'][1]//tr[td[1] > 0 and td[1] <= ".$number." and td[2]/@rowspan > 0]/td[2]");	
		else 
			$query = $xpath->query("//table[@class='wikitable']//tr[td[1] > 0 and td[1] <= ".$number." and td[2]/@rowspan > 0]/td[2]");
		
		//Se il volume giapponese corrisponde a quello italiano, ne estraggo la trama
		if ($query->length == 0)
		{
			if ($format_page == 2)
				$query = $xpath->query("//span[@id = 'Capitoli' or @id = 'Manga']/following::table[@class='wikitable'][1]//tr[td[1] > 0 and td[1] <= ".$number."]/following::tr[2 and contains(string(.), 'Trama')]/td[1]");
			else
				$query = $xpath->query("//table[@class='wikitable']//tr[td[1] > 0 and td[1] <= ".$number."]/following::tr[2 and contains(string(.), 'Trama')]/td[1]");
		
			if ($query->length != 0 && $query->length == $number)
			{
				foreach ($query as $node)
				{
					$arrays = explode("Trama", $node->nodeValue);
					$stories[] = trim($arrays[1]);
				}
			}
		}
	}
	
	//funzione ausiliaria per la correzione della data
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
					case "1º": $current_date[0] = "01"; break;
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