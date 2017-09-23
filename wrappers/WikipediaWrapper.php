<?php
libxml_use_internal_errors(true);
/* Createa a new DomDocument object */
$dom = new DomDocument;
/* Load the HTML */
$dom->loadHTMLFile("https://it.wikipedia.org/wiki/Tokyo_Ghoul");
/* Create a new XPath object */
$xpath = new DomXPath($dom);
/* Query all <td> nodes containing specified class name */
$numeroManga=$xpath->query("//table[@class='sinottico'][1]/descendant::tr[@class='sinottico_divisione' and th[.='Manga']]");
$numeroElementi=0;
$prova=0;// vedo se ci sono all'interno delle caselle manga quelli che hanno il titolo sotto, e si trovano nella prima posizione
$ReturnXml=new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><prodotti></prodotti>');
foreach ($numeroManga as $node){
   //$linkImmagini[]=strval($node->nodeValue);
   $numeroElementi=$numeroElementi+1;
 }
foreach($xpath->query("//table[@class='sinottico'][1]/descendant::tr[@class='sinottico_divisione' and th[.='Manga']][1]/following-sibling::tr[1]/th/i") as $num){
	$prova=$prova+1;
}

for($i=1;$i<=$numeroElementi;$i++){
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
   $user->addChild('nome', trim($node->nodeValue));
 }

 foreach ($autore as $node){
   //echo "<p>Autore: ".trim($node->nodeValue)."</p>";
   $user->addChild('autore', trim($node->nodeValue));
 }
 
 foreach ($editoreItaliano as $node){  
  if( (stristr($node->nodeValue,', ')==false) and (stristr($node->nodeValue,' - ')==false))
   //echo "<p>Editore: ".trim($node->nodeValue)."</p>";
    $user->addChild('editore', trim($node->nodeValue));
   
 }
 
  // echo "<p>Volumi it. : ".trim($numVolumiItalia[0]->nodeValue)."</p>";
 $user->addChild('volumi_it', trim($numVolumiItalia[0]->nodeValue));
 
}
$editoreItaliano[0]->nodeValue=NULL;
 //$numVolumiItalia[0]->nodeValue=NULL;
}

echo $ReturnXml->asXML();

?>