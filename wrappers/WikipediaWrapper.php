<?php

	libxml_use_internal_errors(true);
	error_reporting(E_ERROR | E_PARSE);

	$dom = new DomDocument;
	$url = str_replace("%EF%BB%BF", "", "https://it.wikipedia.org/wiki/".$title);
	$dom->loadHTMLFile($url);
	$xpath = new DomXPath($dom);

	$numeroManga=$xpath->query("//table[@class='sinottico'][1]/descendant::tr[@class='sinottico_divisione' and th[.='Manga']]");
	$ReturnXml=new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><list_products></list_products>');

	if($numeroManga->length!=0 )
	{
		$conn = new mysqli("localhost", "root", "", "db_mangacards");//database connection
				if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
						}
						
	    $conn->set_charset("utf8");
		$querySQL="SELECT * FROM `manga` WHERE Nome='$title' ";
        $resultQuery=mysqli_query($conn,$querySQL);
		if($resultQuery->num_rows !=0){
			 while ($row=$resultQuery->fetch_object()){
					$user=$ReturnXml->addChild('work');
					$editors=$user->addChild('editors');
					$authors=$user->addChild('authors');	
                    $user->addChild('name', $row->Nome);
                    $authors->addChild('author', $row->Autori);	
					$editors->addChild('editor', $row->EditoreITA);
					$user->addChild('volumes_jp', $row->NumVolJPN);
					$user->addChild('volumes_it', $row->NumVolITA);
					$user->addChild('en_name', $row->NomeOriginale);
					$user->addChild('link_image',$row->Immagine);
					$user->addChild('type_element',"manga");   					
				}
				$conn->close();
		}else{
			$conn->close();
		$ReturnXml = create_XML($ReturnXml, $xpath, $title);
		}
		
	}
	else
	{
		
		$conn = new mysqli("localhost", "root", "", "db_mangacards");//database connection
				if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
						}
						
	    $conn->set_charset("utf8");
		$querySQL="SELECT * FROM `comics` WHERE Nome='$title' ";
        $resultQuery=mysqli_query($conn,$querySQL);
		if($resultQuery->num_rows !=0){
			 while ($row=$resultQuery->fetch_object()){
			$user=$ReturnXml->addChild('work');
			$editors=$user->addChild('editors');
			$authors=$user->addChild('authors');
			$user->addChild('name', $row->Nome);
			if($row->NomeOriginale !="")
			$user->addChild('original_name', $row->NomeOriginale);
		
			$editors->addChild('editor', $row->Editore);
          	if($row->Autori !="")		
			$authors->addChild('author', $row->Autori);
		    if($row->Testi !="")
			$authors->addChild('testi', $row->Testi);
		    if($row->Disegni !="")
			$authors->addChild('disegni', $row->Disegni);
			$user->addChild('link_image',$row->Immagine);
			$user->addChild('type_element',"comic");
			 }
		}else{
		
	    //Variabili per db
		$nomeComic="";
		$nomeComicOriginal="";
		$nomeAutori="";
		$nomeTesti="";
		$nomeDisegni="";
		$nomeEditori="";
		$linkImmagine="";
              
		$nomeOriginale=$xpath->query("//table[@class='sinottico'][1]//tr[contains(th,'Nome') and th[contains(span,'orig')]]/td");
			   

        $nomeProdotto=$xpath->query("//table[@class='sinottico'][1]//tr[@class='sinottico_testata']/th/text()");
		if($nomeProdotto->length==0)
            $nomeProdotto=$xpath->query("//table[@class='sinottico'][1]//tr[@class='sinottico_testata']/th");
					   
             

        $editore=$xpath->query("//table[@class='sinottico'][1]//tr[th[.='Editore']]/td//text()");
		$autori_Comics=$xpath->query("//table[@class='sinottico'][1]//tr[th[contains(.,'Autor') and not(contains(.,'it'))]]/td");
		$testi_Comics=$xpath->query("//table[@class='sinottico'][1]//tr[th[contains(.,'Testi') and not(contains(.,'it'))]]/td");
		$disegni_Comics=$xpath->query("//table[@class='sinottico'][1]//tr[th[contains(.,'Disegni') and not(contains(.,'it'))]]/td");
			 
			 

        // $editoreIt=$xpath->query("//table[@class='sinottico'][1]//tr[contains(th,'Editore') and th[contains(span,'it')]]/td//text()");
        $immagine=$xpath->query("//table[@class='sinottico'][1]/descendant::div[@class='floatnone']/a[@class='image']/img/@src");

        $user=$ReturnXml->addChild('work');
        $editors=$user->addChild('editors');
		$authors=$user->addChild('authors');

        $user->addChild('name', trim($nomeProdotto[0]->nodeValue));
		$nomeComic=trim($nomeProdotto[0]->nodeValue);
			   
		if($nomeOriginale->length!=0)
		{
			$user->addChild('original_name', trim($nomeOriginale[0]->nodeValue));
			$nomeComicOriginal=trim($nomeOriginale[0]->nodeValue);
		}

        foreach ($editore as $node)
		{ 
			$editors->addChild('editor', trim(str_replace(array("-",","), "",$node->nodeValue)));
			$nomeEditori.=trim(str_replace(array("-",","), "",$node->nodeValue))." ";
		}
			   
		foreach($autori_Comics as $aut)
		{
			$authors->addChild('author', trim(str_replace(array("-",","), "",$aut->nodeValue)));
			$nomeAutori.=trim(str_replace(array("-",","), "",$aut->nodeValue))." ";
		}
			 
		foreach($testi_Comics as $aut)
		{
			$authors->addChild('testi', trim(str_replace(array("-",","), "",$aut->nodeValue)));
			$nomeTesti.=trim(str_replace(array("-",","), "",$aut->nodeValue))." ";
		}
			 
		foreach($disegni_Comics as $aut)
		{
			$authors->addChild('disegni', trim(str_replace(array("-",","), "",$aut->nodeValue)));
			$nomeDisegni.=trim(str_replace(array("-",","), "",$aut->nodeValue))." ";
		}
				 	   
		$user->addChild('link_image',"https:".trim($immagine[0]->nodeValue));
		$linkImmagine="https:".trim($immagine[0]->nodeValue);
		$user->addChild('type_element',"comic");
		
		$conn = new mysqli("localhost", "root", "", "db_mangacards");//database connection
				if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
						} 
						$conn->set_charset("utf8");
						
			$toinsert = 'INSERT INTO comics
							(Nome, NomeOriginale, Autori, Testi, Disegni, Editore,Immagine)
							VALUES
							("'.$nomeComic.'", "'.$nomeComicOriginal.'", "'.$nomeAutori.'", "'.$nomeTesti.'", "'.$nomeDisegni.'", "'.$nomeEditori.'", "'.$linkImmagine.'")';
							
			if ($conn->query($toinsert) === TRUE) {
				//echo "New record created successfully";
				} else {
					//echo "Error: " . $sql . "<br>" . $conn->error;
							}
							
							$conn->close();
		
		}
		
	}

 //header("Content-type: text/xml");

	echo $ReturnXml->asXML();

function create_XML($ReturnXml, $xpath, $title)
{

     
     // vedo se ci sono all'interno delle caselle manga quelli che hanno il titolo sotto, e si trovano nella prima posizione

    //$prova=$xpath->query("//table[@class='sinottico'][1]/descendant::tr[@class='sinottico_divisione' and th[.='Manga']][1]/following-sibling::tr[1]/th/i");

    $numeroTankobon=$xpath->query("//table[@class='sinottico'][1]//tr[th/a[contains(text(),'Tankōbon')]]");

    $chapters_link = $xpath->query('//b/a[contains(@href, "Capitoli")]/@href');

    for($i=1;$i<=$numeroTankobon->length;$i++){

        $ControlloAutore=$xpath->query("//table[@class='sinottico'][1]//tr[th/a[contains(text(),'Tankōbon')]][".$i."]/preceding-sibling::tr[@class='sinottico_divisione' and th[.='Manga']][1]/following::tr[1]/td//text()");
    //Questo controllo serve per vedere se sotto la scrittura manga della tabella ho gli autori o il nome del manga, se ho il titolo, allora gli autori sono al di sotto del titolo.
    if($ControlloAutore->length==0)
	{
        $nomeProdotto=$xpath->query("//table[@class='sinottico'][1]//tr[th/a[contains(text(),'Tankōbon')]][".$i."]/preceding-sibling::tr[th/i][1]");
        $autore=$xpath->query("//table[@class='sinottico'][1]//tr[th/a[contains(text(),'Tankōbon')]][".$i."]/preceding-sibling::tr[@class='sinottico_divisione' and th[.='Manga']][1]/following::tr[2]/td/a");
        //Questo controllo serve per vedere se ci i tag a sono assenti dalla sezione autori e quindi bisogna prendere il testo contentuto nel tag td.
        if($autore->length==0)
        $autore=$xpath->query("//table[@class='sinottico'][1]//tr[th/a[contains(text(),'Tankōbon')]][".$i."]/preceding-sibling::tr[@class='sinottico_divisione' and th[.='Manga']][1]/following::tr[2]/td//text()");
    
    }
	else
	{
        $nomeProdotto=$xpath->query("//table[@class='sinottico'][1]/descendant::tr[@class='sinottico_testata']/th/i");
        $autore=$xpath->query("//table[@class='sinottico'][1]//tr[th/a[contains(text(),'Tankōbon')]][".$i."]/preceding-sibling::tr[@class='sinottico_divisione' and th[.='Manga']][1]/following::tr[1]/td/a");
        //Questo controllo serve per vedere se ci i tag a sono assenti dalla sezione autori e quindi bisogna prendere il testo contentuto nel tag td.
        if($autore->length==0)
        $autore=$ControlloAutore;    
    }//faccio questa cosa con gli autori perchè nella tabella ci sono casi in cui sotto la scritta manga abbiamo il nome del manga e non l'autore, quindi devo andare sul secondo tr
    
    $numVolumiJp=$xpath->query("//table[@class='sinottico'][1]//tr[th/a[contains(text(),'Tankōbon')]][".$i."]/td/text()");

    $editoriIt=$xpath->query("//table[@class='sinottico'][1]//tr[th/a[contains(text(),'Tankōbon')]][".$i."]/following-sibling::tr[contains(th,'Editore') and th[contains(span,'it')]][1]/td//text()");

    $numVolumiIt=$xpath->query("//table[@class='sinottico'][1]//tr[th/a[contains(text(),'Tankōbon')]][".$i."]/following-sibling::tr[contains(th,'Volumi') and th[contains(span,'it')]][1]/td/text()");

    $immagine=$xpath->query("//table[@class='sinottico'][1]/descendant::div[@class='floatnone']/a[@class='image']/img/@src");
        

    $user=$ReturnXml->addChild('work');
    $editors=$user->addChild('editors');
     $authors=$user->addChild('authors');
	 
	 //variabili per db
	 $nomeManga="";
	 $nomeAutori="";
	 $numeroVolumiIt="";
	 $nomeEditori="";
	 $numeroVolumiJP="";
	 $linkImmagine="";
	 $nomeInglese="";
	 

    foreach ($nomeProdotto as $node)
	{
		$user->addChild('name', trim($node->nodeValue));
		$nomeManga=$title;
    }

	foreach ($autore as $node)
	{
       $authors->addChild('author', trim($node->nodeValue));
	   $nomeAutori.=trim($node->nodeValue)." ";
    }

    foreach ($editoriIt as $node)
	{  
        $editors->addChild('editor', trim(str_replace(array("-",","), "",$node->nodeValue)));
		$nomeEditori.=trim(str_replace(array("-",","), "",$node->nodeValue))." ";
    }

	if(stristr(trim($numVolumiJp[0]->nodeValue),'unico')==true)
		 $numVolumiJp[0]->nodeValue='1';
		 
    $user->addChild('volumes_jp', trim($numVolumiJp[0]->nodeValue));
	$numeroVolumiJP=trim($numVolumiJp[0]->nodeValue);

    if($numVolumiIt->length!=0)
	{
        $nnome=explode(" ",trim($numVolumiIt[0]->nodeValue));
		if(stristr($nnome[0],'unico')==true)
			$nnome[0]='1';
		   
        $user->addChild('volumes_it', $nnome[0]);

        }
		else
		{
			$user->addChild('volumes_it', trim($numVolumiJp[0]->nodeValue));
        }
         
		 $numeroVolumiIt=$nnome[0];
		 
        $user->addChild('link_image',"https:".trim($immagine[0]->nodeValue));
        $user->addChild('chapters_link', "https://it.wikipedia.org".$chapters_link[0]->nodeValue);
		$user->addChild('type_element',"manga");
		$linkImmagine="https:".trim($immagine[0]->nodeValue);

		$user->addChild('work_link', "https://it.wikipedia.org/wiki/".$title);
		//Ottengo il nome inglese della serie
		$res = $xpath->query('//li[contains(@class, "interlanguage")]//a[@lang="en"]/@href');
	if ($res->length != 0)
	{
		$newLink = trim($res->item(0)->nodeValue);
		$inDom = new DomDocument;
		$inDom->loadHTMLFile($newLink);
		$xpath2 = new DomXPath($inDom);
		
		$res = $xpath2->query('//h1[@id="firstHeading"]');
		if (trim($res->item(0)->nodeValue) != ""){
			$user->addChild('en_name', trim($res->item(0)->nodeValue));
			$nomeInglese=trim($res->item(0)->nodeValue);
		}
		else{
			$user->addChild('en_name', $title);
			$nomeInglese=$title;
		}
	}
	else{
		$user->addChild('en_name', $title);
		$nomeInglese=$title;
	}
	$conn = new mysqli("localhost", "root", "", "db_mangacards");//database connection
				if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
						} 
			$conn->set_charset("utf8");
						
	$toinsert = 'INSERT INTO manga
					(Nome, NomeOriginale, Autori, EditoreITA, NumVolJPN, NumVolITA,Immagine)
					VALUES
					("'.$nomeManga.'", "'.$nomeInglese.'", "'.$nomeAutori.'", "'.$nomeEditori.'", "'.$numeroVolumiJP.'", "'.$numeroVolumiIt.'", "'.$linkImmagine.'")';
					
			if ($conn->query($toinsert) === TRUE) {
				//echo "New record created successfully";
				} else {
					//echo "Error: " . $sql . "<br>" . $conn->error;
							}
							
							$conn->close();
		
    }
	
	
	
	
    return $ReturnXml;
}
?>