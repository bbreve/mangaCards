<?php

	
	function RitornaButtonPagine($url){
		libxml_use_internal_errors(true);
			/* Createa a new DomDocument object */
			$dom = new DomDocument;
			/* Load the HTML */
			$dom->loadHTMLFile($url);
			/* Create a new XPath object */
			$xpath = new DomXPath($dom);

			$pagine=$xpath->query("//div[@class='toolbar-bottom']//div[@class='pagination']/ul[@class='pagination']/li[last()-1]/a");

/* Set HTTP response header to plain text for debugging output */
			header("Content-type: text/plain");

		   if($pagine[0]!=NULL){
				return intval($pagine[0]->nodeValue);
			}else{
				return 0;
				}
		
	}
	
		function ritornaLinkPagina($url,$title){
			   $linkImmagini=array();
				$prezzi=array();
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
				
				$immagini = $xpath->query("//div[@class='image']/a[contains(translate(@title, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'),translate('".$title."', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'))]/img/@src");
				$titolo = $xpath->query("//div[@class='box-product-item']//div[@class='name']/a[contains(translate(@title, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'),translate('".$title."', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'))]/@title");
				$link = $xpath->query("//div[@class='box-product-item']//div[@class='name']/a[contains(translate(@title, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'),translate('".$title."', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'))]/@href");

			
			
				foreach ($immagini as $node){
					$linkImmagini[]=strval($node->nodeValue);
				  //echo $node->nodeValue;
								}

				foreach ($titolo as $node){
					$titoli[] = $node->nodeValue;
			  // echo $node->nodeValue."\n";
								}
			 //estraggo tutti i dati all'interno della pagina di dettaglio dell'acquisto
				foreach ($link as $node){
					 $dom = new DomDocument;
					 $dom->loadHTMLFile($node->nodeValue);
					 $xpath = new DomXPath($dom);
					 $prezzo= $xpath->query("//div[@class='price-box']//span[@id='our_price_display']");
					 $inBreve = $xpath->query("//div[@class='short-description']/div[@class='std']//text()");//rissunto della storia del prodotto
					 $disp = $xpath->query("//div[@class='addtocont']/p[@id='availability_statut']/span[@id='availability_value']/strong");//disponibilità del prodotto
					 $autore = $xpath->query("//ul[@id='idTab2']/li[1]/text()");
					 $disponibilità[]=$disp[0]->nodeValue;
					 $riassunto[]=$inBreve[0]->nodeValue; 
					 $links[]=$node->nodeValue;
					 $autori[]= $autore[0]->nodeValue;
					 $prezzi[]=strval($prezzo[0]->nodeValue);
			   //echo $node->nodeValue."\n";
					}
			 
					 $toReturn["Titoli"]= $titoli;
					 $toReturn["Links"]=$links;
					 $toReturn["Disponibilita"]=$disponibilità;
					 $toReturn["Riassunto"]=$riassunto;
					 $toReturn["Autori"]=$autori;
					 $toReturn["Prezzi"]=$prezzi;
					 $toReturn["Immagini"]=$linkImmagini;
			 
				
						return $toReturn;
		
	}

?>