<?php
libxml_use_internal_errors(true);
/* Createa a new DomDocument object */
$dom = new DomDocument;
/* Load the HTML */
$dom->loadHTMLFile("https://it.wikipedia.org/wiki/Tokyo_Ghoul");
/* Create a new XPath object */
header("Content-type: text/xml");
$xpath = new DomXPath($dom);
/* Query all <td> nodes containing specified class name */
$numeroManga=$xpath->query("//table[@class='sinottico'][1]/descendant::tr[@class='sinottico_divisione' and th[.='Manga']]");
$prova=0;// vedo se ci sono all'interno delle caselle manga quelli che hanno il titolo sotto, e si trovano nella prima posizione
$ReturnXml=new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><list_products></list_products>');


 
 if($numeroManga->length!=0 ){
foreach($xpath->query("//table[@class='sinottico'][1]/descendant::tr[@class='sinottico_divisione' and th[.='Manga']][1]/following-sibling::tr[1]/th/i") as $num){
	$prova=$prova+1;
}

for($i=1;$i<=$numeroManga->length;$i++){
	if($i==1){
		if($prova!=0){
			$NomeProdotto=$xpath->query("//table[@class='sinottico'][1]/descendant::tr[@class='sinottico_divisione' and th[.='Manga']][1]/following-sibling::tr[1]/th/i");
			$autore = $xpath->query("//table[@class='sinottico'][1]/descendant::tr[@class='sinottico_divisione' and th[.='Manga']]/following-sibling::tr[2]/td/descendant::text()");
		}else{
             $NomeProdotto= $xpath->query("//table[@class='sinottico'][1]/descendant::tr[@class='sinottico_testata']/th/i");
			 $autore = $xpath->query("//table[@class='sinottico'][1]/descendant::tr[@class='sinottico_divisione' and th[.='Manga']]/following-sibling::tr[1]/td/descendant::text()");
	}

$editoreItaliano = $xpath->query("//table[@class='sinottico'][1]/descendant::tr[@class='sinottico_divisione' and th[.='Manga']][1]/following-sibling::tr[th/a[contains(text(),'Tankōbon')]][".$i."]/following-sibling::tr[1]/td/descendant::text()");
$numVolumiItalia= $xpath->query("//table[@class='sinottico'][1]/descendant::tr[@class='sinottico_divisione' and th[.='Manga']][1]/following-sibling::tr[th[contains(text(),'Volumi')] and descendant::span[@title='italiani' and .='it.']][".$i."]/td/text()");
	
	}else{
		$NomeProdotto= $xpath->query("//table[@class='sinottico'][1]/descendant::tr[@class='sinottico_divisione' and th[.='Manga']][".$i."]/following-sibling::tr[1]/th/i");
		$autore = $xpath->query("//table[@class='sinottico'][1]/descendant::tr[@class='sinottico_divisione' and th[.='Manga']]/following-sibling::tr[1]/td/descendant::text()");
        $editoreItaliano = $xpath->query("//table[@class='sinottico'][1]/descendant::tr[@class='sinottico_divisione' and th[.='Manga'] and following-sibling::tr[1]][".($i-1)."]/following-sibling::tr[th/a[contains(text(),'Tankōbon')]][1]/following-sibling::tr[1]/td/descendant::text()");
        $numVolumiItalia= $xpath->query("//table[@class='sinottico'][1]/descendant::tr[@class='sinottico_divisione' and th[.='Manga'] and following-sibling::tr[1]][".($i-1)."]/following-sibling::tr[th[contains(text(),'Volumi')] and descendant::span[@title='italiani' and .='it.']][1]/td/text()");
	}


if($editoreItaliano[0]->nodeValue!=NULL ){
/* Set HTTP response header to plain text for debugging output */
//header("Content-type: text/plain");
/* Traverse the DOMNodeList object to output each DomNode's nodeValue */
$user=$ReturnXml->addChild('manga');
foreach ($NomeProdotto as $node){
   //echo "<p>Manga: ".trim($node->nodeValue)."</p>";
   $user->addChild('name', trim($node->nodeValue));
 }

 foreach ($autore as $node){
   //echo "<p>Autore: ".trim($node->nodeValue)."</p>";
   $user->addChild('author', trim($node->nodeValue));
 }
 
 foreach ($editoreItaliano as $node){  
  if( (stristr($node->nodeValue,', ')==false) and (stristr($node->nodeValue,' - ')==false))
   //echo "<p>Editore: ".trim($node->nodeValue)."</p>";
    $user->addChild('editor', trim($node->nodeValue));
   
 }
 
  // echo "<p>Volumi it. : ".trim($numVolumiItalia[0]->nodeValue)."</p>";
 $user->addChild('volumes_it', trim($numVolumiItalia[0]->nodeValue));
 
}
$editoreItaliano[0]->nodeValue=NULL;
 //$numVolumiItalia[0]->nodeValue=NULL;
}
 }else{
	   if($xpath->query("//table[@class='sinottico'][1]//tr[contains(th,'Nome') and th[contains(span,'orig')]]/td")->length==0){
	 $nomeProdotto=$xpath->query("//table[@class='sinottico'][1]//tr[@class='sinottico_testata']/th");
	   }else{
		   $nomeProdotto=$xpath->query("//table[@class='sinottico'][1]//tr[contains(th,'Nome') and th[contains(span,'orig')]]/td");
	   }
	 $editore=$xpath->query("//table[@class='sinottico'][1]//tr[th[.='Editore']]/td//text()");
	 // $editoreIt=$xpath->query("//table[@class='sinottico'][1]//tr[contains(th,'Editore') and th[contains(span,'it')]]/td//text()");
	  $user=$ReturnXml->addChild('comic');
	   $user->addChild('name', trim($nomeProdotto[0]->nodeValue));
	   foreach ($editore as $node){ 
	    $user->addChild('editor', trim($node->nodeValue));
	   }
	   /* foreach ($editoreIt as $node){ 
	    $user->addChild('editore_it', trim($node->nodeValue));
	   }*/
	 
 }

echo $ReturnXml->asXML();

?>