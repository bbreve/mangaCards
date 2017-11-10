<?php

libxml_use_internal_errors(true);
error_reporting(E_ERROR | E_PARSE);
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

    $ReturnXml = create_XML($ReturnXml, $xpath, $title);

    

}

else{
	     $autori=array();
              
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
			   
			   if($nomeOriginale->length!=0){
				   $user->addChild('original_name', trim($nomeOriginale[0]->nodeValue));
			   }

               foreach ($editore as $node){ 

               $editors->addChild('editor', trim(str_replace(array("-",","), "",$node->nodeValue)));

               }
			   
			   
				 foreach($autori_Comics as $aut){
					 $authors->addChild('author', trim(str_replace(array("-",","), "",$aut->nodeValue)));
				 }
			 
				 foreach($testi_Comics as $aut){
					 $authors->addChild('testi', trim(str_replace(array("-",","), "",$aut->nodeValue)));
				 }
			 
				 foreach($disegni_Comics as $aut){
					 $authors->addChild('disegni', trim(str_replace(array("-",","), "",$aut->nodeValue)));
				 }
			 
			   
               $user->addChild('link_image',"https:".trim($immagine[0]->nodeValue));
			   $user->addChild('Type_element',"Comic");

               /* foreach ($editoreIt as $node){ 

                $user->addChild('editore_it', trim($node->nodeValue));

               }*/
            

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
        

        $user=$ReturnXml->addChild('work');
        $editors=$user->addChild('editors');
        $authors=$user->addChild('authors');

     foreach ($nomeProdotto as $node){
       $user->addChild('name', trim($node->nodeValue));
     }



     foreach ($autore as $node){
       $authors->addChild('author', trim($node->nodeValue));
     }

     

     foreach ($editoriIt as $node){  
         $editors->addChild('editor', trim(str_replace(array("-",","), "",$node->nodeValue)));
     }

	  
     if(stristr(trim($numVolumiJp[0]->nodeValue),'unico')==true)
		 $numVolumiJp[0]->nodeValue='1';
		 
      $user->addChild('volumes_jp', trim($numVolumiJp[0]->nodeValue));

        if($numVolumiIt->length!=0){
           
           $nnome=explode(" ",trim($numVolumiIt[0]->nodeValue));
		   if(stristr($nnome[0],'unico')==true)
			   $nnome[0]='1';
		   
           $user->addChild('volumes_it', $nnome[0]);

        }else{

          $user->addChild('volumes_it', trim($numVolumiJp[0]->nodeValue));

        }
         
         $user->addChild('link_image',"https:".trim($immagine[0]->nodeValue));
         $user->addChild('chapters_link', "https://it.wikipedia.org".$chapters_link[0]->nodeValue);
		 $user->addChild('Type_element',"Manga");

		 $user->addChild('work_link', "https://it.wikipedia.org/wiki/".$title);
        
    }

    return $ReturnXml;

}

?>