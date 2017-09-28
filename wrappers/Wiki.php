<?php

	//header("Content-type: application/xml");
	
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
	$dom->loadHTMLFile("https://it.wikipedia.org/wiki/Capitoli_di_".$title);
	/* Create a new XPath object */
	$xpath = new DomXPath($dom);

	$titles = extractTitles($titles, $number, $xpath);
	if (count($titles) != $number)
	{
		$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><list_volumes></list_volumes>');
		echo $xml->asXML();
	}
	else 
	{
		$datesIT = extractDatesIt($datesIT, $number, $xpath);
		$volChapters = extractVolChapters($volChapters, $number, $xpath);
		$numvol = extractNumvol($numvol, $number, $xpath);
		$stories = extractStories($stories, $number, $xpath);
		
		//var_dump($stories);
		$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><list_volumes></list_volumes>');
		$xml = writeVolumesXML($datesIT, $titles, $numvol, $stories, $volChapters, $xml);
		echo $xml->asXML();
	}
	
	$nameChapters = extractNameChapters($nameChapters, $number, $xpath);
	$numChapters = extractNumChapters($numChapters, $number, $xpath);

	//var_dump(count($numChapters)." ".count($nameChapters));
	if (count($nameChapters) != count($numChapters))
	{
		$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><list_chapters></list_chapters>');
		//echo $xml->asXML();
	}
	else
	{
		$xml2 = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><list_chapters></list_chapters>');	
		//$xml2 = writeChaptersXML($nameChapters, $numChapters, $xml2);
		//echo $xml2->asXML();
	}
	
	function writeVolumesXML($datesIT, $titles, $numvol, $stories, $volChapters, $xml)
	{
		for ($i = 0; $i < count($titles); $i++)
		{
			$prodotto = $xml->addChild("volume");
			
			$prodotto->addChild("title", $titles[$i]);
			$prodotto->addChild("number", $numvol[$i]);
			$prodotto->addChild("date", $datesIT[$i]);
			
			if (count($stories) == count($titles) && is_numeric($stories[$i]) == FALSE)
				$prodotto->addChild("story", $stories[$i]);
			
			if (count($volChapters) == count($titles))
			{
				$list = $prodotto->addChild("chapters_list");
				foreach ($volChapters[$i] as $node)
					$list->addChild("chapter", trim($node->nodeValue));
			}
		}
		
		return $xml;
	}
	
	function writeChaptersXML($nameChapters, $numChapters, $xml)
	{
		for ($i = 0; $i < count($numChapters); $i++)
		{
			$capitolo = $xml->addChild("chapter");
			
			$capitolo->addChild("title", $nameChapters[$i]);
			
			if (is_numeric($numChapters[$i]) == FALSE)
				$capitolo->addChild("speciale");	
			else $capitolo->addChild("number", $numChapters[$i]);
		}
		
		return $xml;
	}
	
	function extractDatesIt($datesIT, $num, $xpath)
	{
		$query = $xpath->query("//table[@class='wikitable']//tr[td[1] > 0 and td[1] <= ".$num."]/td[last()]/text()");
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
		
		return $datesIT;
	}
	
	function extractVolChapters($volChapters, $num, $xpath)
	{
		$query = $xpath->query("//table[@class='wikitable']//tr[td[1] > 0 and td[1] <= ".$num." and td[2]/@rowspan > 0]/td[2]");
		
		if ($query->length == 0)
		{
			$query = $xpath->query("//table[@class='wikitable']//tr[td[1] > 0 and td[1] <= ".$num."]/following::tr[1]//ul");
			
			if ($query->length == $num)
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
		
		return $volChapters;
	}
	
	function extractTitles($titles, $num, $xpath)
	{
		$query = $xpath->query("//table[@class='wikitable']//tr[td[1] > 0 and td[1] <= ".$num."]//b");
		//echo $query->length."<br />";
		foreach ($query as $node)
		{
			if ($node == "" || $node == " " || $node == NULL)
				continue;
		
			if (stripos($node->nodeValue, "/") !== false)
			{
				$arrays = explode("/", $node->nodeValue);
				//echo $arrays[count($arrays)-1]."<br />";
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
			else $titles[] = trim($node->nodeValue);
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
		
		return $titles;
	}
	
	function extractNumvol($numvol, $num, $xpath)
	{
		$query = $xpath->query("//table[@class='wikitable']//tr[td[1] > 0 and td[1] <= ".$num." and td[2]/@rowspan > 0]/td[2]");
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
			$query = $xpath->query("//table[@class='wikitable']//tr[td[1] > 0 and td[1] <= ".$num."]/td[1]");
			foreach ($query as $node)
				$numvol[] = trim($node->nodeValue);
		}
		return $numvol;
	}
	
	function extractNameChapters($nameChapters, $num, $xpath)
	{
		$query = $xpath->query("//table[@class='wikitable']//tr[td[1] > 0 and td[1] <= ".$num."]/following::tr[1]//li");
		
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

					//echo trim($string)."<br />";
					$nameChapters[] = trim($string);
				}
				else $nameChapters[] = trim($arrays1[0]);
			}
		}
		
		
		return $nameChapters;
	}
	
	function extractNumChapters($numChapters, $num, $xpath)
	{
		$count = 1;
		$query = $xpath->query("//table[@class='wikitable']//tr[td[1] > 0 and td[1] <= ".$num."]/following::tr[1]//li");
		if ($query->length != 0)
		{
			foreach ($query as $node)
			{
				$arrays = explode("(", $node->nodeValue);
				$arrays1 = explode(". ", $arrays[0]);
				if (is_numeric($arrays1[0]) == FALSE && stripos($arrays1[0], "Special") === FALSE && stripos($arrays1[0], "Bonus") === FALSE && stripos($arrays1[0], "Extra") === FALSE)
				{
					//echo strval($count)."<br />";
					$numChapters[] = strval($count);
				}
				else 
				{
					//echo trim($arrays1[0])."<br />";
					$numChapters[] = trim($arrays1[0]);
				}
				$count += 1;
			}
		}
		
		return $numChapters;
	}
	
	function extractStories($stories, $num, $xpath)
	{
		$query = $xpath->query("//table[@class='wikitable']//tr[td[1] > 0 and td[1] <= ".$num." and td[2]/@rowspan > 0]/td[2]");
		
		//Se il volume giapponese corrisponde a quello italiano, ne estraggo la trama
		if ($query->length == 0)
		{
			$query = $xpath->query("//table[@class='wikitable']//tr[td[1] > 0 and td[1] <= ".$num."]/following::tr[2]/td[1]");
		
			if ($query->length != 0 && $query->length == $num)
			{
				foreach ($query as $node)
				{
					$arrays = explode("Trama", $node->nodeValue);
					$stories[] = trim($arrays[1]);
				}
			}
		}
		
		return $stories;
	}
	
	//funzione ausiliaria per la correzione della data
	function transformDate($string)
	{
			if ($string == "" || $string == " " || $string == NULL)
				return "";
			else {
				$current_date = explode(" ", $string);
					
				switch($current_date[0])
				{
					case "1" : $current_date[0] = "01"; break;
					case "1ยบ": $current_date[0] = "01"; break;
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
