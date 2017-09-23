<?php
include 'FunctionsJpop.php';
function creaPagina($url,$search){

$numUltimapagina=RitornaButtonPagine($url);
$ReturnXml=new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><prodotti></prodotti>');
if($numUltimapagina !=0){

for($i=1;$i<=$numUltimapagina;$i++){
	$newUrl=$url;
	$newUrl=$newUrl."=&p=".$i;
	$immagini=array();
	$immagini=RitornaImmagini($newUrl);
	$prezzi=array();
	$prezzi=ritornaPrezzi($newUrl);
	$PaginaDettaglio=array();
	$PaginaDettaglio=ritornaLinkPagina($newUrl);
for($l=0;$l<count($immagini); $l++){
	if(stripos($PaginaDettaglio['Titoli'][$l],$search)!==false and stristr($PaginaDettaglio['Disponibilita'][$l],"non è più Disponibile")==false){
    $user=$ReturnXml->addChild('prodotto');
	$user->addChild('nome', trim($PaginaDettaglio['Titoli'][$l]));
	$user->addChild('prezzo', trim($prezzi[$l]));
	$user->addChild('autore', trim($PaginaDettaglio['Autori'][$l]));
	$user->addChild('disponibilita', trim($PaginaDettaglio['Disponibilita'][$l]));
	$user->addChild('immagine', trim($immagini[$l]));
	$user->addChild('link_acquisto', trim($PaginaDettaglio['Links'][$l]));
	$user->addChild('dettagli', trim($PaginaDettaglio['Riassunto'][$l]));
	
	
	
	/*
	<img src=" echo $immagini[$l];">
	<a href="<?php echo $PaginaDettaglio['Links'][$l];?>" title="<?php echo $PaginaDettaglio['Titoli'][$l];?>" target="_blank"> echo $PaginaDettaglio['Titoli'][$l];</a>
	<p>Prezzo:  echo $prezzi[$l];</p>
	<p>Disponbilità:  echo $PaginaDettaglio['Disponibilita'][$l];</p>
	<p>Autore:  echo $PaginaDettaglio['Autori'][$l];</p>
	<p> echo $PaginaDettaglio['Riassunto'][$l];</p>
	  
	</div>
*/
	}

}
}
}else{
	
	$immagini=array();
	$immagini=RitornaImmagini($url);
	$prezzi=array();
	$prezzi=ritornaPrezzi($url);
	$PaginaDettaglio=array();
	$PaginaDettaglio=ritornaLinkPagina($url);
for($l=0;$l<count($immagini); $l++){
   if(stripos($PaginaDettaglio['Titoli'][$l],$search)!==false and stristr($PaginaDettaglio['Disponibilita'][$l],"non è più Disponibile")==false){
	   $user=$ReturnXml->addChild('prodotto');
	$user->addChild('nome', trim($PaginaDettaglio['Titoli'][$l]));
	$user->addChild('prezzo', trim($prezzi[$l]));
	$user->addChild('autore', trim($PaginaDettaglio['Autori'][$l]));
	$user->addChild('disponibilita', trim($PaginaDettaglio['Disponibilita'][$l]));
	$user->addChild('immagine', trim($immagini[$l]));
	$user->addChild('link_acquisto', trim($PaginaDettaglio['Links'][$l]));
	$user->addChild('dettagli', trim($PaginaDettaglio['Riassunto'][$l]));
	   
	   /*
    <div  align="center">
	<img src="echo $immagini[$l];">
	<a href=" echo $PaginaDettaglio['Links'][$l];" title=" echo $PaginaDettaglio['Titoli'][$l];" target="_blank"> echo $PaginaDettaglio['Titoli'][$l];</a>
	<p>Prezzo: echo $prezzi[$l];</p>
	<p>Disponbilità: echo $PaginaDettaglio['Disponibilita'][$l];</p>
	<p>Autore:  echo $PaginaDettaglio['Autori'][$l];</p>
	<p> echo $PaginaDettaglio['Riassunto'][$l];</p>
	  
	</div>
	  */
 }
}
}
 return $ReturnXml->asXML();   
	 
}


$search="tokyo ghoul";
$xml =creaPagina("http://www.j-pop.it/cerca?controller=search&orderby=position&orderway=desc&search_query=".urlencode($search)."&submit_search=",$search);
echo $xml;

?>

