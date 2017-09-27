<?php

libxml_use_internal_errors(true);

/* Createa a new DomDocument object */

$dom = new DomDocument;

/* Load the HTML */

$dom->loadHTMLFile("https://it.wikipedia.org/wiki/".$title);

/* Create a new XPath object */



$xpath = new DomXPath($dom);

/* Query all <td> nodes containing specified class name */

$numeroManga=$xpath->query("//table[@class='sinottico'][1]/descendant::tr[@class='sinottico_divisione' and th[.='Manga']]");



$ReturnXml=new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><list_products></list_products>');

 if($numeroManga->length!=0 ){

	$ReturnXml = create_XML($ReturnXml, $xpath);

	

}

else{

            $dom->loadHTMLFile("https://it.wikipedia.org/wiki/".$title."_(manga)");

            /* Create a new XPath object */

            //header("Content-type: text/xml");

            $xpath = new DomXPath($dom);

            /* Query all <td> nodes containing specified class name */

            $numeroManga=$xpath->query("//table[@class='sinottico'][1]/descendant::tr[@class='sinottico_divisione' and th[.='Manga']]");



            if($numeroManga -> length != 0)

            {

                $ReturnXml = create_XML($ReturnXml, $xpath);

            }

            else

            {

        	   if($xpath->query("//table[@class='sinottico'][1]//tr[contains(th,'Nome') and th[contains(span,'orig')]]/td")->length==0){

        	 $nomeProdotto=$xpath->query("//table[@class='sinottico'][1]//tr[@class='sinottico_testata']/th");

        	   }else{

        		   $nomeProdotto=$xpath->query("//table[@class='sinottico'][1]//tr[contains(th,'Nome') and th[contains(span,'orig')]]/td");

        	   }

        	 $editore=$xpath->query("//table[@class='sinottico'][1]//tr[th[.='Editore']]/td//text()");

        	 // $editoreIt=$xpath->query("//table[@class='sinottico'][1]//tr[contains(th,'Editore') and th[contains(span,'it')]]/td//text()");
			 $immagine=$xpath->query("//table[@class='sinottico'][1]/descendant::div[@class='floatnone']/a[@class='image']/img/@src");

        	  $user=$ReturnXml->addChild('comic');
			  $editors=$user->addChild('editors');

        	   $user->addChild('name', trim($nomeProdotto[0]->nodeValue));

        	   foreach ($editore as $node){ 

        	   $editors->addChild('editor', trim($node->nodeValue));

        	   }
			   $user->addChild('link_immagine',"https:".trim($immagine[0]->nodeValue));

        	   /* foreach ($editoreIt as $node){ 

        	    $user->addChild('editore_it', trim($node->nodeValue));

        	   }*/

            }

        	 

 }

 //header("Content-type: text/xml");

 echo $ReturnXml->asXML();





function create_XML($ReturnXml, $xpath)

{

     // vedo se ci sono all'interno delle caselle manga quelli che hanno il titolo sotto, e si trovano nella prima posizione

    //$prova=$xpath->query("//table[@class='sinottico'][1]/descendant::tr[@class='sinottico_divisione' and th[.='Manga']][1]/following-sibling::tr[1]/th/i");



    $numeroTankobon=$xpath->query("//table[@class='sinottico'][1]//tr[th/a[contains(text(),'Tankōbon')]]");



    for($i=1;$i<=$numeroTankobon->length;$i++){

        $ControlloAutore=$xpath->query("//table[@class='sinottico'][1]//tr[th/a[contains(text(),'Tankōbon')]][".$i."]/preceding-sibling::tr[@class='sinottico_divisione' and th[.='Manga']][1]/following::tr[1]/td//text()");
	//Questo controllo serve per vedere se sotto la scrittura manga della tabella ho gli autori o il nome del manga, se ho il titolo, allora gli autori sono al di sotto del titolo.
	if($ControlloAutore->length==0){
		$nomeProdotto=$xpath->query("//table[@class='sinottico'][1]//tr[th/a[contains(text(),'Tankōbon')]][".$i."]/preceding-sibling::tr[th/i][1]");
		$autore=$xpath->query("//table[@class='sinottico'][1]//tr[th/a[contains(text(),'Tankōbon')]][".$i."]/preceding-sibling::tr[@class='sinottico_divisione' and th[.='Manga']][1]/following::tr[2]/td/a");
		//Questo controllo serve per vedere se ci i tag a sono assenti dalla sezione autori e quindi bisogna prendere il testo contentuto nel tag td.
		if($autore->length==0)
		$autore=$xpath->query("//table[@class='sinottico'][1]//tr[th/a[contains(text(),'Tankōbon')]][".$i."]/preceding-sibling::tr[@class='sinottico_divisione' and th[.='Manga']][1]/following::tr[2]/td//text()");
	
	}else{
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
        

        $user=$ReturnXml->addChild('manga');
		$editors=$user->addChild('editors');
	    $authors=$user->addChild('authors');

     foreach ($nomeProdotto as $node){

       //echo "<p>Manga: ".trim($node->nodeValue)."</p>";

       $user->addChild('name', trim($node->nodeValue));

     }



     foreach ($autore as $node){

       //echo "<p>Autore: ".trim($node->nodeValue)."</p>";

       $authors->addChild('author', trim($node->nodeValue));

     }

     

     foreach ($editoriIt as $node){  

        if( (stristr($node->nodeValue,', ')==false) and (stristr($node->nodeValue,' - ')==false))

         //echo "<p>Editore: ".trim($node->nodeValue)."</p>";

         $editors->addChild('editor', trim($node->nodeValue));

       

     }

     

      // echo "<p>Volumi it. : ".trim($numVolumiItalia[0]->nodeValue)."</p>";

      $user->addChild('volumes_jp', trim($numVolumiJp[0]->nodeValue));

        if($numVolumiIt->length!=0){

           $user->addChild('volumes_it', trim($numVolumiIt[0]->nodeValue));

        }else{

          $user->addChild('volumes_it', trim($numVolumiJp[0]->nodeValue));

        }
         
		 $user->addChild('link_immagine',"https:".trim($immagine[0]->nodeValue));
		 
    }

    return $ReturnXml;

}

?>
