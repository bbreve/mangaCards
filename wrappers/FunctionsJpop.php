<?php

function RitornaImmagini($url){
		$linkImmagini=array();
		$prezzo=array();
		libxml_use_internal_errors(true);
/* Createa a new DomDocument object */
$dom = new DomDocument;
/* Load the HTML */
$dom->loadHTMLFile($url);
/* Create a new XPath object */
$xpath = new DomXPath($dom);
/* Query all <td> nodes containing specified class name */
$immagini = $xpath->query("//div[@class='image']/a/img/@src");

/* Set HTTP response header to plain text for debugging output */
//header("Content-type: text/plain");
/* Traverse the DOMNodeList object to output each DomNode's nodeValue */

 foreach ($immagini as $node){
   $linkImmagini[]=strval($node->nodeValue);
   //echo $node->nodeValue;
 }
	
	return $linkImmagini;
		
	}
	
	function RitornaButtonPagine($url){
		libxml_use_internal_errors(true);
/* Createa a new DomDocument object */
$dom = new DomDocument;
/* Load the HTML */
$dom->loadHTMLFile($url);
/* Create a new XPath object */
$xpath = new DomXPath($dom);
/* Query all <td> nodes containing specified class name */

$pagine=$xpath->query("//div[@class='toolbar-bottom']//div[@class='pagination']/ul[@class='pagination']/li[last()-1]/a");


/* Set HTTP response header to plain text for debugging output */
header("Content-type: text/plain");
/* Traverse the DOMNodeList object to output each DomNode's nodeValue */
   if($pagine[0]!=NULL){
     return intval($pagine[0]->nodeValue);
	}else{
		
		return 0;
	}
		
	}
	
	function ritornaPrezzi($url){
		
		$prezzi=array();
		libxml_use_internal_errors(true);
/* Createa a new DomDocument object */
$dom = new DomDocument;
/* Load the HTML */
$dom->loadHTMLFile($url);
/* Create a new XPath object */
$xpath = new DomXPath($dom);
/* Query all <td> nodes containing specified class name */
$valori = $xpath->query("//div[@class='price-box']//span[@class='price']");

/* Set HTTP response header to plain text for debugging output */
//header("Content-type: text/plain");
/* Traverse the DOMNodeList object to output each DomNode's nodeValue */

 foreach ($valori as $node){
   $prezzi[]=strval($node->nodeValue);
   //echo $node->nodeValue;
 }
	
	return $prezzi;
		
		
	}
	
		function ritornaLinkPagina($url){
		
		$titoli=array();
		$links=array();
		$toReturn=array();
		$disponibilità=array();
		$riassunto=array();
		$autori = array();
		libxml_use_internal_errors(true);
/* Createa a new DomDocument object */
$dom = new DomDocument;
/* Load the HTML */
$dom->loadHTMLFile($url);
/* Create a new XPath object */
$xpath = new DomXPath($dom);
/* Query all <td> nodes containing specified class name */
$titolo = $xpath->query("//div[@class='box-product-item']//div[@class='name']/a/@title");
$link = $xpath->query("//div[@class='box-product-item']//div[@class='name']/a/@href");

/* Set HTTP response header to plain text for debugging output */
//header("Content-type: text/plain");
/* Traverse the DOMNodeList object to output each DomNode's nodeValue */

 foreach ($titolo as $node){
   $titoli[] = $node->nodeValue;
  // echo $node->nodeValue."\n";
 }
 foreach ($link as $node){
	 $dom = new DomDocument;
	 $dom->loadHTMLFile($node->nodeValue);
	 $xpath = new DomXPath($dom);
	 $inBreve = $xpath->query("//div[@class='short-description']/div[@class='std']//text()");//rissunto della storia del prodotto
	 $disp = $xpath->query("//div[@class='addtocont']/p[@id='availability_statut']/span[@id='availability_value']/strong");//disponibilità del prodotto
	 $autore = $xpath->query("//ul[@id='idTab2']/li[1]/text()");
	 $disponibilità[]=$disp[0]->nodeValue;
	 $riassunto[]=$inBreve[0]->nodeValue; 
     $links[]=$node->nodeValue;
	 $autori[]= $autore[0]->nodeValue;
   //echo $node->nodeValue."\n";
 }
 
 $toReturn["Titoli"]= $titoli;
 $toReturn["Links"]=$links;
 $toReturn["Disponibilita"]=$disponibilità;
 $toReturn["Riassunto"]=$riassunto;
 $toReturn["Autori"]=$autori;
 
	
	return $toReturn;
		
		
	}

?>