<?php
include 'FunctionsJpop.php';
header("Content-type: text/xml");
function creaPagina($url,$search,$serie){

$numUltimapagina=RitornaButtonPagine($url);
$ReturnXml=new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><list_products></list_products>');
header("Content-type: text/xml");

	$conn = new mysqli("localhost", "root", "", "db_mangacards");//database connection
				if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
						}
						
	$conn->set_charset("utf8");

if($numUltimapagina !=0){

for($i=1;$i<=$numUltimapagina;$i++){
	$newUrl=$url;
	$newUrl=$newUrl."=&p=".$i;
	
	$PaginaDettaglio=array();
	$PaginaDettaglio=ritornaLinkPagina($newUrl,$search);
for($l=0;$l<count($PaginaDettaglio['Titoli']); $l++){
	$numeroTitolo=get_numerics($PaginaDettaglio['Titoli'][$l]);
	if(stripos($PaginaDettaglio['Titoli'][$l],$search)!==false and stristr($PaginaDettaglio['Disponibilita'][$l],"non è più Disponibile")==false ){
		$user=$ReturnXml->addChild('product');
		$numeroTitle;
		if( count($numeroTitolo)!=0){
			$numeroTitle=$numeroTitolo[0];
		}else{
			$numeroTitle=30000;
		}
    $user->addChild('name', trim($PaginaDettaglio['Titoli'][$l]));
	$user->addChild('productNumber',intval($numeroTitle) );
	$user->addChild('price', trim($PaginaDettaglio['Prezzi'][$l]));
	$user->addChild('author', trim($PaginaDettaglio['Autori'][$l]));
	$user->addChild('image', trim($PaginaDettaglio['Immagini'][$l]));
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
		$value->addChild('details',(string)$product->details);
		
		$nomeManga=htmlspecialchars((string)$product->name);
		$PrezzoManga=htmlspecialchars((string)$product->price);
		$autoreManga=htmlspecialchars((string)$product->author);
		$immagineManga=htmlspecialchars((string)$product->image);
		$linkProdotto=htmlspecialchars((string)$product->linkproduct);
		$dettaglioManga=htmlspecialchars((string)$product->details);
		
		$nomeManga=str_replace(array("\"","\'"),"",$nomeManga);
		$dettaglioManga=str_replace(array("\"","\'"),"",$dettaglioManga);
		
		$toinsert = 'INSERT INTO jpop
							(NomeOfferta, Serie, Prezzo, Autore, Dettagli, Immagine, LinkAcquisto)
							VALUES
							("'.$nomeManga.'", "'.$serie.'", "'.$PrezzoManga.'", "'.$autoreManga.'", "'.$dettaglioManga.'", "'.$immagineManga.'", "'.$linkProdotto.'")';
							
							
							if ($conn->query($toinsert) === TRUE) {
									//echo "New record created successfully";
									} else {
										//echo "Error: " . $sql . "<br>" . $conn->error;
												}
		
	}
}else{
	
	
	$PaginaDettaglio=array();
	$PaginaDettaglio=ritornaLinkPagina($url);
for($l=0;$l<count($PaginaDettaglio['Titoli']); $l++){
	$numeroTitolo=get_numerics($PaginaDettaglio['Titoli'][$l]);
   if(stripos($PaginaDettaglio['Titoli'][$l],$search)!==false and stristr($PaginaDettaglio['Disponibilita'][$l],"non è più Disponibile")==false){
	   $numeroTitle;
		if( count($numeroTitolo)!=0){
			$numeroTitle=$numeroTitolo[0];
		}else{
			$numeroTitle=30000;
		}
	   $user=$ReturnXml->addChild('product');
	$user->addChild('name', trim($PaginaDettaglio['Titoli'][$l]));
	$user->addChild('productNumber',intval($numeroTitle));
	$user->addChild('price', trim($PaginaDettaglio['Prezzi'][$l]));
	$user->addChild('author', trim($PaginaDettaglio['Autori'][$l]));
	$user->addChild('image', trim($PaginaDettaglio['Immagini'][$l]));
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
		$value->addChild('details',(string)$product->details);
		
		$nomeManga=htmlspecialchars((string)$product->name);
		$PrezzoManga=htmlspecialchars((string)$product->price);
		$autoreManga=htmlspecialchars((string)$product->author);
		$immagineManga=htmlspecialchars((string)$product->image);
		$linkProdotto=htmlspecialchars((string)$product->linkproduct);
		$dettaglioManga=htmlspecialchars((string)$product->details);
		
		$nomeManga=str_replace(array("\"","\'"),"",$nomeManga);
		$dettaglioManga=str_replace(array("\"","\'"),"",$dettaglioManga);
		
		$toinsert = 'INSERT INTO jpop
							(NomeOfferta, Serie, Prezzo, Autore, Dettagli, Immagine, LinkAcquisto)
							VALUES
							("'.$nomeManga.'", "'.$serie.'", "'.$PrezzoManga.'", "'.$autoreManga.'", "'.$dettaglioManga.'", "'.$immagineManga.'", "'.$linkProdotto.'")';
							
							if ($conn->query($toinsert) === TRUE) {
									//echo "New record created successfully";
									} else {
										//echo "Error: " . $sql . "<br>" . $conn->error;
												}
		
		
	}
}
 $conn->close();
 return $RXml->asXML();   
	 
}

function get_numerics ($str) {
    preg_match_all('/\d+/', $str, $matches);
    return $matches[0];
}


$titles = $_POST['title'];

$title=explode("-", $titles);
//$URL="http://www.j-pop.it/cerca?controller=search&orderby=position&orderway=desc&search_query=".urlencode($title[0])."&submit_search=";

$conn = new mysqli("localhost", "root", "", "db_mangacards");//database connection
				if ($conn->connect_error) {
						die("Connection failed: " . $conn->connect_error);
						}
						
$conn->set_charset("utf8");
$querySQL="SELECT * FROM `jpop` WHERE Serie='$titles' ORDER BY NomeOfferta";
$resultQuery=mysqli_query($conn,$querySQL);
if($resultQuery->num_rows !=0){
	$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><offers></offers>');
	 while ($row=$resultQuery->fetch_object())
    {
		$prodotto = $xml->addChild("offer");
		$prodotto->addChild("title", $row->NomeOfferta);
		$prodotto->addChild("price", $row->Prezzo);	
		$prodotto->addChild("author", $row->Autore);
		$prodotto->addChild("cover", $row->Immagine);
		$prodotto->addChild("url_to_product", $row->LinkAcquisto);
		$prodotto->addChild("details", $row->Dettagli);	
      
    }
	
	echo $xml->asXML();
	$conn->close();
}else{
$conn->close();
$xml =creaPagina("http://www.j-pop.it/cerca?controller=search&orderby=position&orderway=desc&search_query=".urlencode($title[0])."&submit_search=",$title[0],$titles);
echo $xml;
}
?>

