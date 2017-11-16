<?php

//	header("Content-type: application/xml");
$series = $title;
$conn = new mysqli("localhost", "root", "", "db_mangacards");//database connection
				if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
						}
						
	$conn->set_charset("utf8");
$querySQL="SELECT * FROM `volumi_manga` WHERE NomeManga='$series' ORDER BY Numero";
$resultQuery=mysqli_query($conn,$querySQL);
//echo $resultQuery->num_rows;
if($resultQuery->num_rows !=0){
	$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><list_volumes></list_volumes>');
	 while ($row=$resultQuery->fetch_object())
    {
		$prodotto = $xml->addChild("volume");
		$prodotto->addChild("title", $row->NomeVolume);
		$prodotto->addChild("number", $row->Numero);
		$prodotto->addChild("dateIT", $row->DataITA);
		$prodotto->addChild("dateJPN", $row->DataJPN);
		$prodotto->addChild("story", $row->Trama);
		$prodotto->addChild("chapters_list", $row->ListaCapitoli);	
      
    }
	
	foreach($xml->volume as $volume){
	$arr[]=$volume;
}

	usort($arr,function($a,$b){
		return $a->number - $b->number;
	});	
	$xmlOrdered=new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><list_volumes></list_volumes>');	
	foreach($arr as $volume){
		$prodotto = $xmlOrdered->addChild("volume");
		$prodotto->addChild("title", (string)$volume->title);
		$prodotto->addChild("number", (string)$volume->number);
		$prodotto->addChild("dateIT", (string)$volume->dateIT);
		$prodotto->addChild("dateJPN", (string)$volume->dataJPN);
		$prodotto->addChild("story", (string)$volume->story);
		$prodotto->addChild("chapters_list", (string)$volume->chapters_list);
	}
	
	echo $xmlOrdered->asXML();
	$conn->close();
}else{
	$conn->close();
	$datesIT = array();
	$datesJPN = array();
	$numvol = array();
	$num_vol_jp = array();
	$volChapters = array();
	$stories_and_chapters = array();
	$titles = array();

	$double_numeration = 0;

	libxml_use_internal_errors(true);
	/* Createa a new DomDocument object */
	$dom = new DomDocument;
	/* Load the HTML */
	if ($chapters_link != "https://it.wikipedia.org")
	{
		$url = $chapters_link;
		$format_page = 1;
	}
	else 
	{
		$url = $work_link;
		$format_page = 2;
	}

	$dom->loadHTMLFile($url);
	/* Create a new XPath object */
	$xpath = new DomXPath($dom);
	
	$series = $title;

	$number = $num_it;
	$numberJ = $num_jp;
	

	extractNumvol();
	extractStoriesAndChapters(); 
	extractTitles();
	extractDatesJPN();
	extractDatesIt();

	$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><list_volumes></list_volumes>');
	writeVolumesXML();
	
	//Caso di estrazione per tabelle formattatate differentemente da quelle regolari
	//Vedi es. Tokyo Ghoul
	if ($xml->count() == 0)
	{
		$datesJPN = array();
		$datesIT = array();
		$numvol = array();
		$stories_and_chapters = array();
		$titles = array();
		
		$dom = new DomDocument;
		$dom->loadHTMLFile($url);
		$xpath = new DomXPath($dom);
		$volumes = $xpath->query('//table[@class="wikitable"]//tr[contains(@id, "vol")]');
		$pointer = -1;
		foreach($volumes as $vol)
		{
			//Verifico la numerazione ed aggiunto il numero del volume
			$num = $xpath->query('.//td[1]', $vol);
			if ($num->item(0)->nodeValue < $pointer)
				continue;
			else
			{
				$pointer = $num->item(0)->nodeValue;
				$numvol[] = $num->item(0)->nodeValue;
			}
			
			//Aggiungo nomi fittizi per i volumi
			$titles[] = "Volume ".$pointer;
			
			//Estraggo le date ITA
			$it = $xpath->query('.//td[contains(@style, "text-align:center;white-space:nowrap")][3]', $vol);
			if ($it->length != 0)
			{
				$day = str_replace("&ordm;", " ", htmlentities($it->item(0)->nodeValue));
				preg_match_all("#(\d+ +)?\w+ \d+#", $day, $match);

				$temp = [];
				foreach($match[0] as $date_in_volume)
				{
					$temp[] = transformDate(trim($date_in_volume));
				}
				
				$datesIT[] = $temp;
			}
			
			//Estraggo le date JPN
			$jpn = $xpath->query('.//td[contains(@style, "text-align:center;white-space:nowrap")][1]', $vol);
			if ($jpn->length != 0)
			{
				preg_match_all("#(\d+\?? )?\w+ \d+#", $jpn->item(0)->nodeValue, $match);

				$temp = [];
				foreach($match[0] as $date_in_volume)
				{
					$temp[] = transformDate(trim($date_in_volume));
				}
				
				$datesJPN[] = $temp;
			}
			
			//Estraggo capitoli e trame
			$chapters = $xpath->query('./following-sibling::tr[1][not(contains(@id, "vol"))]//td/div/ul/li', $vol);
			$chapters_string = "";

			foreach($chapters as $chapter)
				$chapters_string .= '<li>'.$chapter->textContent.'</li>';

			$res_story = $xpath->query('./following-sibling::tr[2][not(contains(@id, "vol"))]/td/div/p', $vol);
			
			if ($res_story->length == 0)
				$story = "";
			else
				$story = trim($res_story->item(0)->nodeValue);
			$stories_and_chapters[$pointer] = array(
				'chapters' => $chapters_string,
				'story' => $story
			);
		}

		writeVolumesXML();
	}

	echo $xml->asXML();
}

	function writeVolumesXML()
	{
		global $datesIT, $datesJPN, $titles, $num_vol_jp, $numvol, $stories, $volChapters, $xml, $double_numeration, $stories_and_chapters, $series;
		
		$conn = new mysqli("localhost", "root", "", "db_mangacards");//database connection
				if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
						}
						
		$conn->set_charset("utf8");

		for ($i = 0; $i < count($titles); $i++)
		{
			
			$nomeManga="";
			$numeroVolume="";
			$nomeVolume="";
			$dataJPN="";
			$dataITA="";
			$tramaVolume="";
			$listaCapitoli="";
			
			$prodotto = $xml->addChild("volume");
			
			$prodotto->addChild("title", htmlspecialchars($titles[$i]));
			$nomeVolume=htmlspecialchars($titles[$i]);
			if(is_null($numvol[$i])){
				$prodotto->addChild("number", 'IN USCITA');
				$numeroVolume="IN USCITA";
			}
			else{
				$prodotto->addChild("number", $numvol[$i]);
				$numeroVolume=$numvol[$i];
			}
			if(count($datesIT[$i]) > 1)
			{
				$dates_publication = "";
				foreach($datesIT[$i] as $date)
				{
					$dates_publication .= $date."-";
				}
				$prodotto->addChild("dateIT", $dates_publication);	
				$dataITA=$dates_publication;
			}	
			else
			{
				$prodotto->addChild("dateIT", $datesIT[$i][0]);
				$dataITA=$datesIT[$i][0];
			}
			
			if(count($datesJPN[$i]) > 1)
			{
				$dates_publication = "";
				foreach($datesJPN[$i] as $date)
				{
					$dates_publication .= $date."-";
				}
				$prodotto->addChild("dateJPN", $dates_publication);	
				$dataJPN=$dates_publication;
			}	
			else
			{
				$prodotto->addChild("dateJPN", $datesJPN[$i][0]);
				$dataJPN=$datesJPN[$i][0];
			}
			

			if(!$double_numeration)
			{	
				if ($stories_and_chapters[$numvol[$i]]['story'] <> ""){
					$prodotto->addChild("story", $stories_and_chapters[$numvol[$i]]['story']);
					$tramaVolume=$stories_and_chapters[$numvol[$i]]['story'];
				}
				
				if (htmlspecialchars($stories_and_chapters[$numvol[$i]]['chapters']) <> ""){
					$prodotto->addChild("chapters_list", htmlspecialchars($stories_and_chapters[$numvol[$i]]['chapters']));	
                    $listaCapitoli=	htmlspecialchars($stories_and_chapters[$numvol[$i]]['chapters']);	
				}					
			}
			else
			{	
				if ($stories_and_chapters[$num_vol_jp[$i]]['story'] <> ""){
					$prodotto->addChild("story", $stories_and_chapters[$num_vol_jp[$i]]['story']);
					$tramaVolume=$stories_and_chapters[$num_vol_jp[$i]]['story'];
					
				}
				if (htmlspecialchars($stories_and_chapters[$num_vol_jp[$i]]['chapters']) <> ""){
					$prodotto->addChild("chapters_list", htmlspecialchars($stories_and_chapters[$num_vol_jp[$i]]['chapters']));	
                    $listaCapitoli=htmlspecialchars($stories_and_chapters[$num_vol_jp[$i]]['chapters']);
				}					
			}
			
			$nomeManga=$series;
			$nomeManga=str_replace(array("\"","\'"),"",$nomeManga);
			$nomeVolume=str_replace(array("\"","\'"),"",$nomeVolume);
			$tramaVolume=str_replace(array("\"","\'"),"",$tramaVolume);
			$listaCapitoli=str_replace(array("\"","\'"),"",$listaCapitoli);
			
			
			$toinsert = 'INSERT INTO volumi_manga
							(Numero, NomeManga, NomeVolume, DataJPN, DataITA, Trama, ListaCapitoli)
							VALUES
							("'.$numeroVolume.'", "'.$nomeManga.'", "'.$nomeVolume.'", "'.$dataJPN.'", "'.$dataITA.'", "'.$tramaVolume.'", "'.$listaCapitoli.'")';
							
							
							if ($conn->query($toinsert) === TRUE) {
									//echo "New record created successfully";
									} else {
										//echo "Error: " . $sql . "<br>" . $conn->error;
												}
			
		}
		$conn->close();
	}
	
	function extractDatesJPN()
	{
		global $datesJPN, $xpath, $format_page;
		
		if ($format_page == 2)
		{
			$dates_jp_query = $xpath->query('//span[@id = "Capitoli" or @id = "Manga"]/following::table[@class="wikitable"][1]//tr[contains(@id, "vol")]/td[contains(@style, "white-space:nowrap")][1]');
		}
		else 
		{	
			$dates_jp_query = $xpath->query('//table[@class="wikitable"]//tr[contains(@id, "vol")]/td[contains(@style, "white-space:nowrap")][1]');
		}
		
		foreach($dates_jp_query as $date_jp)
		{	
			if ($date_jp == "" || $date_jp == " " || $date_jp == NULL)
				continue;


			preg_match_all("#(\d+\?? )?\w+ \d+#", $date_jp->nodeValue, $match);

			$temp = [];
			foreach($match[0] as $date_in_volume)
			{
				$temp[] = transformDate(trim($date_in_volume));
				
			}
			$datesJPN[] = $temp;
		}
	}

	function extractDatesIt()
	{
		global $datesIT, $xpath, $format_page;
		
		if ($format_page == 2)
		{
			$dates_it_query = $xpath->query('//span[@id = "Capitoli" or @id = "Manga"]/following::table[@class="wikitable"][1]//tr[contains(@id, "vol")]/td[contains(@style, "white-space:nowrap")][2]');
		}
		else 
		{	
			$dates_it_query = $xpath->query('//table[@class="wikitable"]//tr[contains(@id, "vol")]/td[contains(@style, "white-space:nowrap")][2]');
		}
		
		foreach($dates_it_query as $date_it)
		{	
			if ($date_it == "" || $date_it == " " || $date_it == NULL)
				continue;

			$day = str_replace("&ordm;", " ", htmlentities($date_it->nodeValue));
			preg_match_all("#(\d+ +)?\w+ \d+#", $day, $match);

			$temp = [];
			foreach($match[0] as $date_in_volume)
			{
				$temp[] = transformDate(trim($date_in_volume));
				
			}
			$datesIT[] = $temp;
		}
	}

	function extractTitles()
	{
		global $titles, $number, $numberJ, $xpath, $format_page, $series, $double_numeration;
		
		if ($format_page == 2)
		{
			$titles_query = $xpath->query('//span[@id = "Capitoli" or @id = "Manga"]/following::table[@class="wikitable"][1]//tr[contains(@id, "vol")]/td[(./i/b or ./b/i)][not(following-sibling::td[./text()="-" or ./text()="—"])]');
		}
		else 
		{
			$titles_query = $xpath->query('//table[@class="wikitable" and not(preceding-sibling::h2/span[(contains(@id, "speciali"))])]//tr[contains(@id, "vol")]/td[(./i/b or ./b/i)][not(following-sibling::td[./text()="-" or ./text()="—"])]');
		}	
		foreach($titles_query as $title_query)
		{	
				$titles[] = $title_query->nodeValue;
		}
	}

	function extractNumVol()
	{
		global $titles, $numvol, $num_vol_jp, $number, $numberJ, $xpath, $format_page, $series, $double_numeration, $numTabelle;
		$numTabelle=$xpath->query('//table[@class="wikitable" and not(preceding-sibling::h2/span[(contains(@id, "speciali"))])]');

		
		for($i=1;$i<=$numTabelle->length;$i++)
		{
			$doppiaNumerazione=$xpath->query('//table[@class="wikitable" and not(preceding-sibling::h2/span[(contains(@id, "speciali"))])]['.$i.']//th[contains(text(),"N")and contains(a,"It")]');
			
			if ($format_page != 2)
			{
				$nums_query = $xpath->query('//table[@class="wikitable" and not(preceding-sibling::h2/span[(contains(@id, "speciali"))])]['.$i.']//tr[contains(@id, "vol")]/td[contains(@style, "text-align:center") and not(contains(@style, "white-space:nowrap")) and not(following-sibling::td[contains(@style, "white-space:nowrap") and (./text()="-")])]');
			}
			else
			{
				$nums_query = $xpath->query('//span[@id = "Capitoli" or @id = "Manga"]/following::table[@class="wikitable"][1]//tr[contains(@id, "vol")]/td[contains(@style, "text-align:center") and not(contains(@style, "white-space:nowrap")) and not(following-sibling::td[contains(@style, "white-space:nowrap") and (./text()="-" or ./text()="—")])]');
			}
			
			//Se è presente un solo tipo di numerazione
			if($doppiaNumerazione->length==0)
			{

				foreach($nums_query as $num_query)
				{		
					if(stristr($num_query->nodeValue,'('))
					{
						$valore=explode("(",$num_query->nodeValue);
						$num=explode(")",$valore[1]);
						$numvol[] = $num[0];
					}
					else
						$numvol[] = $num_query->nodeValue;
					}
			}
			//Se invece sono presenti due tipi di numerazione: quella italiaprepre e giapponese
			else 
			{
				$double_numeration = true;
				$italian = false;
				foreach ($nums_query as $num_query) {
					if(!$italian)
					{
						$num_vol_jp[] = $num_query->nodeValue;
						$italian = true;
					}
					else if($italian)
					{
						$numvol[] = $num_query->nodeValue;
						$italian = false;
					}
				}
			}
		
		}
	}

	function extractStoriesAndChapters()
	{
		global $stories_and_chapters, $xpath, $numvol, $format_page;

		if ($format_page == 1)
		{
			$query = '//table[@class="wikitable" and not(preceding-sibling::h2/span[(contains(@id, "speciali"))])]//tr[contains(@id, "vol")]';
		}
		else
		{
			$query = '//span[@id = "Capitoli" or @id = "Manga"]/following::table[@class="wikitable"][1]//tr[contains(@id, "vol")]';
		}		
		$volumes_tr = $xpath->query($query);

		foreach($volumes_tr as $volume_tr)
		{
			$id = $xpath->query('./td[1]/text()', $volume_tr);
			$chapters = $xpath->query('./following-sibling::tr[1][not(contains(@id, "vol"))]//td/div/ul/li', $volume_tr);
			$chapters_string = "";

			if ($chapters->length != 0)
			{
				foreach($chapters as $chapter)
					$chapters_string .= '<li>'.$chapter->textContent.'</li>';
			}
			
			$res_story = $xpath->query('./following-sibling::tr[2][not(contains(@id, "vol"))]/td/div/p', $volume_tr);
			if ($res_story->length == 0)
				$story == "";
			else
				$story = $res_story->item(0)->textContent;
			
			$stories_and_chapters[$id->item(0)->textContent] = array(
				'chapters' => $chapters_string,
				'story' => $story
			);
		}
	}

	//funzione ausiliaria per la correzione della data
	function transformDate($string)
	{
		if ($string == "" || $string == " " || $string == NULL)
			return "";
		else {
			$current_date = explode(" ", $string);
				
			if (count($current_date) < 3)
				return $string;
			else if (count($current_date) == 4)
			{
				$current_date[1] = $current_date[2];
				$current_date[2] = $current_date[3];
			}
					
			switch($current_date[0])
			{
				case "1" : $current_date[0] = "01"; break;
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