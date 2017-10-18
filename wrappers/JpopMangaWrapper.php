<?php
include 'FunctionsJpop.php';
//header("Content-type: text/xml");
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
	$numeroTitolo=get_numerics($PaginaDettaglio['Titoli'][$l]);
	if(stripos($PaginaDettaglio['Titoli'][$l],$search)!==false and stristr($PaginaDettaglio['Disponibilita'][$l],"non è più Disponibile")==false and count($numeroTitolo)!=0){
		$user=$ReturnXml->addChild('product');
		
    $user->addChild('name', trim($PaginaDettaglio['Titoli'][$l]));
	$user->addChild('productNumber',intval($numeroTitolo[0]) );
	$user->addChild('price', trim($prezzi[$l]));
	$user->addChild('author', trim($PaginaDettaglio['Autori'][$l]));
	$user->addChild('image', trim($immagini[$l]));
	$user->addChild('linkproduct', trim($PaginaDettaglio['Links'][$l]));
	$user->addChild('details', trim($PaginaDettaglio['Riassunto'][$l]));
	
	}

}


	

}
$arr=array();
foreach($ReturnXml->product as $product){
	$arr[]=$product;
}

	usort($arr,function($a,$b){
		return $a->productNumber - $b->productNumber;
	});
	
	$RXml=new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><offers></offers>');
	foreach($arr as $product){
		$value=$RXml->addChild('offer');
		$value->addChild('title',(string)$product->name);
		$value->addChild('price',(string)$product->price);
		$value->addChild('author',(string)$product->author);
		$value->addChild('cover',(string)$product->image);
		$value->addChild('url_to_product',(string)$product->linkproduct);
		
	}

}else{
	
	$immagini=array();
	$immagini=RitornaImmagini($url);
	$prezzi=array();
	$prezzi=ritornaPrezzi($url);
	$PaginaDettaglio=array();
	$PaginaDettaglio=ritornaLinkPagina($url);
for($l=0;$l<count($immagini); $l++){
	$numeroTitolo=get_numerics($PaginaDettaglio['Titoli'][$l]);
   if(stripos($PaginaDettaglio['Titoli'][$l],$search)!==false and stristr($PaginaDettaglio['Disponibilita'][$l],"non è più Disponibile")==false and count($numeroTitolo)!=0){
	   $user=$ReturnXml->addChild('product');
	$user->addChild('name', trim($PaginaDettaglio['Titoli'][$l]));
	$user->addChild('productNumber',intval($numeroTitolo[0]));
	$user->addChild('price', trim($prezzi[$l]));
	$user->addChild('author', trim($PaginaDettaglio['Autori'][$l]));
	$user->addChild('image', trim($immagini[$l]));
	$user->addChild('linkproduct', trim($PaginaDettaglio['Links'][$l]));
	$user->addChild('details', trim($PaginaDettaglio['Riassunto'][$l]));
	   
 }
}
$arr=array();
foreach($ReturnXml->product as $product){
	$arr[]=$product;
}

	usort($arr,function($a,$b){
		return $a->productNumber - $b->productNumber;
	});
	
	$RXml=new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><offers></offers>');
	foreach($arr as $product){
		$value=$RXml->addChild('offer');
		$value->addChild('title',(string)$product->name);
		$value->addChild('price',(string)$product->price);
		$value->addChild('author',(string)$product->author);
		$value->addChild('cover',(string)$product->image);
		$value->addChild('url_to_product',(string)$product->linkproduct);
		
	}
}
 return $RXml->asXML();   
	 
}

function get_numerics ($str) {
    preg_match_all('/\d+/', $str, $matches);
    return $matches[0];
}


$title = $_POST['title'];
$xml =creaPagina("http://www.j-pop.it/cerca?controller=search&orderby=position&orderway=desc&search_query=".urlencode($title)."&submit_search=",$title);
echo $xml;

?>

