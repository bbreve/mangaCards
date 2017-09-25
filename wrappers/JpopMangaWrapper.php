<?php
include 'FunctionsJpop.php';
header("Content-type: text/xml");
function creaPagina($url,$search){

$numUltimapagina=RitornaButtonPagine($url);
$ReturnXml=new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><list_products></list_products>');
header("Content-type: text/xml");
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
		$user=$ReturnXml->addChild('product');
    $user->addChild('name', trim($PaginaDettaglio['Titoli'][$l]));
	$user->addChild('product_type', "Manga");
	$user->addChild('price', trim($prezzi[$l]));
	$user->addChild('author', trim($PaginaDettaglio['Autori'][$l]));
	$user->addChild('image', trim($immagini[$l]));
	$user->addChild('link', trim($PaginaDettaglio['Links'][$l]));
	$user->addChild('details', trim($PaginaDettaglio['Riassunto'][$l]));
	
	
	
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
	   $user=$ReturnXml->addChild('product');
	$user->addChild('name', trim($PaginaDettaglio['Titoli'][$l]));
	$user->addChild('product_type', "Manga");
	$user->addChild('price', trim($prezzi[$l]));
	$user->addChild('author', trim($PaginaDettaglio['Autori'][$l]));
	$user->addChild('image', trim($immagini[$l]));
	$user->addChild('link', trim($PaginaDettaglio['Links'][$l]));
	$user->addChild('details', trim($PaginaDettaglio['Riassunto'][$l]));
	   
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

