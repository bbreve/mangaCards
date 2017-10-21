<?php
  $title = $_POST['work_selected'];
  
  
  ob_start();
  require __DIR__.'\wrappers\WikipediaWrapper.php';
  $page_info = ob_get_clean(); 
  $work_info = simplexml_load_string($page_info);
  
  $num_jp = $work_info->work->volumes_jp;
  $num_it = $work_info->work->volumes_it;
  $chapters_link = $work_info->work->chapters_link;
  $work_link = $work_info->work->work_link;
  
  ob_start();  
  require __DIR__.'\wrappers\Wiki.php';
  $chapters_info = ob_get_clean(); 
  $chapters_xml = simplexml_load_string($chapters_info);

  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Manga Cards - Dettaglio</title>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,400italic,700,900' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Ubuntu+Mono:700' rel='stylesheet' type='text/css'>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Techie Bootstrap 3 skin">
    <meta name="keywords" content="bootstrap 3, skin, flat">
    <meta name="author" content="bootstraptaste">
    <!-- Bootstrap css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap.techie.css" rel="stylesheet">
    <link href="assets/css/animate.css" rel="stylesheet">
    <!-- =======================================================
      Theme Name: Techie
      Theme URL: https://bootstrapmade.com/techie-free-skin-bootstrap-3/
      Author: BootstrapMade
      Author URL: https://bootstrapmade.com
      ======================================================= -->
    <!-- Docs Custom styles -->
    <style>
      body,html{overflow-x:hidden}body{padding:60px 20px 0}footer{border-top:1px solid #ddd;padding:30px;margin-top:50px}.row>[class*=col-]{margin-bottom:40px}.navbar-container{position:relative;min-height:100px}.navbar.navbar-fixed-bottom,.navbar.navbar-fixed-top{position:absolute;top:50px;z-index:0}.navbar.navbar-fixed-bottom .container,.navbar.navbar-fixed-top .container{max-width:90%}.btn-group{margin-bottom:10px}.form-inline input[type=password],.form-inline input[type=text],.form-inline select{width:180px}.input-group{margin-bottom:10px}.pagination{margin-top:0}.navbar-inverse{margin:110px 0}
      .panel-default > .panel-heading {
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-sm-4 ">
          <a href="#" class="thumbnail">
          <img src=<?php echo ($work_info->work->link_image != "https:") ? ($work_info->work->link_image) : '""'?>  alt="Immagine non disponibile">
          </a>
        </div>
        <div class="col-lg-5 col-sm-5">
          <div class="agile-row">
            <h1><?php echo $work_info->work->name?></h1>
          </div>
          <div class="agile-row">
            <h5>Creato da: <?php  $authors_list = "";
              foreach($work_info->work->authors->author as $author) 
              {
                $authors_list .= $author.", ";
              }
              $authors_list = rtrim($authors_list, ", ");
              echo $authors_list;
              ?></h5>
          </div>
          <div class="agile-row">
            <h5>Editore: <?php  $editors_list = "";
              foreach($work_info->work->editors->editor as $editor) 
              {
                $editors_list .= $editor.", ";
              } 
              $editors_list = rtrim($editors_list, ", ");
              echo $editors_list;
              ?></h5>
          </div>
          <div class="agile-row">
            <h5>Volumi giapponesi: <?php echo $num_jp; ?></h5>
          </div>
          <div class="agile-row">
            <h5>Volumi italiani: <?php echo $num_it; ?></h5>
          </div>
        </div>
      </div>
      <div class="tabbable">
        <ul class="nav nav-tabs tab-products">
          <?php if(!empty($chapters_xml)){?>
                  <li class="active"><a href="#tab11" data-toggle="tab">Volumi</a></li>
          <?php } ?> 
          <li <?php if(empty($chapters_xml)) echo'class="active"'; ?> ><a href="#tab12" data-toggle="tab">Offerte</a></li>
        </ul>
        <div class="tab-content">
          <?php if(!empty($chapters_xml)){ ?>
          <div class="tab-pane active" id="tab11">
            <div class="row">
              <div class="col-sm-12">
                <h3>Elenco volumi</h3>
                <div class="panel-group" id="accordion-panel">
                  <?php
                    foreach($chapters_xml->volume as $volume) 
                    {
                      $content = insertPanelContent($volume);
                      echo '
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-panel" href="#volume'.str_replace(' ', '', $volume->number).'">['.$volume->number."] ".$volume->title.'
                            </a>
                          </h4>
                        </div>
                        <div id="volume'.str_replace(' ', '', $volume->number).'" class="panel-collapse collapse">
                          <div class="panel-body">';
                      echo $content;
                      echo'
                          </div>
                        </div>
                      </div>';
                    } 
                    ?>
                </div>
              </div>
            </div>
          </div>
          <?php } ?>
          <div <?php if(!empty($chapters_xml)) echo 'class="tab-pane"'; else echo 'class="tab-pane active"'; ?> id="tab12">
            <div class="row">
                <div class="col-sm-12 container offers">
				<div class="row">
					<h3>Negozi</h3>
					<div class="overlay loading text-center">
					  <h4 class="loading">Caricamento delle offerte in corso...</h4>
					  <i class="fa fa-cog fa-spin fa-3x fa-refresh"></i>
					</div>                    
				</div>
				<div class="row container-shops">
					
				</div>
				<div class="panel-group container-products-shops" id="products-shops">
					<hr>
				</div>
            </div>
          </div>
          
        </div>
		<div class="tab-pane" id="tab13" >
		  <div class "row">
		    <div class="tab-anime" >
					</div>
				</div>
			</div>
		
      </div>
    </div>
    <footer class="text-center">
      <p>&copy; Manga Cards</p>
    </footer>
    <!-- Main Scripts-->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Bootstrap 3 has typeahead optionally -->
    <script src="assets/js/typeahead.min.js"></script>
    <script>
      $(document).ready(function(){
		  var Editors = "<?php echo $editors_list; ?>";
        $.ajax({
          type: "POST",
          data: {
            'title': <?php echo '"'.$title.'"'; ?>,
          },
          url: "wrappers/AmazonWrapper.php",
          async: true

        })
        .done(function (data){  
          hideOverlay();
          parseAmazonXML(data);
        });
		
		if(Editors.search(/J-Pop/i)!==-1 || Editors.search(/JPop/i)!==-1){
				$.ajax({
				type: "POST",
				data: {
					'title': <?php echo '"'.$title.'"'; ?>
				},
				url: "wrappers/JpopMangaWrapper.php",
				async: true

				})
				.done(function (data){  
				hideOverlay();
				parseJPopXML(data);
				});
			}
			
		if(Editors.search(/Panini/i)!==-1){
				$.ajax({
				type: "POST",
				data: {
					'title': <?php echo '"'.$title.'"'; ?>
				},
				url: "wrappers/PaniniWrapper.php",
				async: true

				})
				.done(function (data){  
				hideOverlay();
				parsePaniniXML(data);
				});
			}

        $.ajax({
          type: "POST",
          data: {
            'series': <?php echo '"'.$title.'"'; ?>
          },
          url: "wrappers/WikiAnime.php",
          async: true

        })
        .done(function (data){  
          
          parseAnimeXML(data);
        });
      });

 
        function showOverlay() {
          $(".overlay").fadeIn(400);
        }     
        
        function hideOverlay() {
          $(".overlay").fadeOut(400);
        }




      function parseAmazonXML(data)
      {
		   
		   $('.container-shops').append('<a class="accordion-toggle" data-toggle="collapse" data-parent="#products-shops" href="#tab14" ><img class="animated bounceInUp" height=80" width="200"  src="assets/img/amazonLogo2.jpg" /></a>');
		   $('.container-products-shops').append('<div class="panel panel-default" style="border:hidden"><div id="tab14" class="panel-collapse collapse"><div class="tab-content amazon"></div></div></div>');
        $(data).find('offer').each(function(){
          title = $(this).find('title').text();
          url = $(this).find('url_to_product').text();
          image = $(this).find('cover').text();

          price = $(this).find('price').text();
          
          author = $(this).find('author').text();
		 
		    
		   
          $('.amazon').append(
            '<div class="row">'
            +'  <div class="col-sm-3"><a href="#" class="mini-thumbnail"><img src="'+image+'"/></a></div>'
            +'  <div class="col-sm-6">'
            +'    <div class="agile-row">'
            +'      <h4>'+title+'</h4>'
            +'    </div>'
            +'    <div class="agile-row">'
            +'      <p>di '+author+'</p>'
            +'    </div>'
            +'    <div class="agile-row">'
            +'      <h2>'+price+'</h2>'
            +'    </div>'
            +'  </div>'
            +'  <div class="col-sm-2">'
            +'    <div class="agile-row">'
            +'      <img src="https://images-na.ssl-images-amazon.com/images/G/01/SellerCentral/legal/amazon-logo_transparent.png" style="width: 100%"/>'
            +'    </div>'
            +'    <div class="agile-row">'
            +'      <a href="'+url+'" class="mini-thumbnail" target="_blank"><img style="width:100%" src="http://www.cavouresoterica.it/wp-content/uploads/2016/04/acquista-ora.png" /></a>'
            +'    </div>'
            +'  </div>'
            +'</div>'
            +'<hr>');

        });

      }
	  
	  function parseJPopXML(data)
      {
		  $('.container-shops').append('<a class="accordion-toggle" data-toggle="collapse" data-parent="#products-shops" href="#tab15" ><img class="animated bounceInUp" height=170" width="200"  src="assets/img/JPopLogo.png" /></a>');
		   $('.container-products-shops').append('<div class="panel panel-default" style="border:hidden"><div id="tab15" class="panel-collapse collapse"><div class="tab-content JPop"></div></div></div>');
        $(data).find('offer').each(function(){
          title = $(this).find('title').text();
          url = $(this).find('url_to_product').text();
          image = $(this).find('cover').text();

          price = $(this).find('price').text();
		  details=$(this).find('details').text();
          
          author = $(this).find('author').text();
          $('.JPop').append(
            '<div class="row">'
            +'  <div class="col-sm-3"><a href="#" class="mini-thumbnail"><img src="'+image+'"/></a></div>'
            +'  <div class="col-sm-6">'
            +'    <div class="agile-row">'
            +'      <h4>'+title+'</h4>'
            +'    </div>'
            +'    <div class="agile-row">'
            +'      <p>di '+author+'</p>'
            +'    </div>'
            +'    <div class="agile-row">'
            +'      <h3>'+price+'</h3>'
            +'    </div>'
			+'		<div class="agile-row">'
            +'     		 <h4>'+'In breve:'+'</h4>'
			+'                  <p>'+details+'</p>  '
            +'    </div>'
            +'  </div>'
            +'  <div class="col-sm-2">'
            +'    <div class="agile-row">'
            +'      <img src="http://www.j-pop.it//img/logo-4.jpg?1470504371" style="width: 100%"/>'
            +'    </div>'
            +'    <div class="agile-row">'
            +'      <a href="'+url+'" class="mini-thumbnail" target="_blank"><img style="width:100%" src="http://www.cavouresoterica.it/wp-content/uploads/2016/04/acquista-ora.png"/></a>'
            +'    </div>'
            +'  </div>'
            +'</div>'
            +'<hr>');

        });
	  }
	  
	  function parsePaniniXML(data)
      {
		  $('.container-shops').append('<a class="accordion-toggle" data-toggle="collapse" data-parent="#products-shops" href="#tab16" ><img class="animated bounceInUp" height=70" width="200"  src="assets/img/paninicomics.gif" /></a>');
		   $('.container-products-shops').append('<div class="panel panel-default" style="border:hidden"><div id="tab16" class="panel-collapse collapse"><div class="tab-content Panini"></div></div></div>');
        $(data).find('offer').each(function(){
          title = $(this).find('title').text();
          url = $(this).find('url_to_product').text();
          image = $(this).find('cover').text();

          price = $(this).find('price').text();
		  old = $(this).find('old_price').text();
		  rDate =$(this).find('release_date').text();
		  
		  edition = $(this).find('edition').text();
		  info_volume =$(this).find('info_volume').text();
		  
		  author = $(this).find('authors').text();
		  if (author == "" || author == null)
			  author = "Provvisorio";
		  
		  description = $(this).find('description').text();

		  
          s = '<div class="row">'
            +'  <div class="col-sm-3"><a href="#" class="mini-thumbnail"><img src="'+image+'"/></a></div>'
            +'  <div class="col-sm-6">'
            +'    <div class="agile-row">'
            +'      <h4>'+title+'</h4>'
            +'    </div>'
            +'    <div class="agile-row">'
            +'      <p>di '+author+'</p>'
            +'    </div>';
		 
		  if (info_volume != "" || info_volume != null)
		  {
				s	+= '<div class="agile-row"><p>'+info_volume+'</p></div>';
		  }
		  if (edition != "Edizione Originale")
		  {
				s	+= '<div class="agile-row"><p>'+edition+'</p></div>';
		  }
		  
		  s += '		<div class="agile-row">'
			+'			<h5><del>'+old+'</del><h5>'	
            +'     		 <h2>'+price+'</h2>'
			+'                  <h4>'+rDate+'</h4>  '
            +'    </div>'
			+'		<div class="agile-row">'
            +'     		 <h4>'+'Descrizione:'+'</h4>'
			+'                  <p>'+description+'</p>  '
            +'    </div>'
            +'  </div>'
            +'  <div class="col-sm-2">'
            +'    <div class="agile-row">'
            +'      <img src="assets/img/Panini.gif" style="width: 100%"/>'
            +'    </div>'
            +'    <div class="agile-row">'
            +'      <a href="'+url+'" class="mini-thumbnail" target="_blank"><img style="width:100%" src="http://www.cavouresoterica.it/wp-content/uploads/2016/04/acquista-ora.png"/></a>'
            +'    </div>'
            +'  </div>'
            +'</div>'
            +'<hr>';
			
			$('.Panini').append(s);	
		  //author = $(this).find('author').text();
          /*
		  $('.Panini').append(
            '<div class="row">'
            +'  <div class="col-sm-3"><a href="#" class="mini-thumbnail"><img src="'+image+'"/></a></div>'
            +'  <div class="col-sm-6">'
            +'    <div class="agile-row">'
            +'      <h4>'+title+'</h4>'
            +'    </div>'
            +'    <div class="agile-row">'
            +'      <p>di '+author+'</p>'
            +'    </div>'
			+'		<div class="agile-row">'
			+'			<h5><del>'+old+'</del><h5>'	
            +'     		 <h2>'+price+'</h2>'
			+'                  <h4>'+rDate+'</h4>  '
            +'    </div>'
            +'  </div>'
            +'  <div class="col-sm-2">'
            +'    <div class="agile-row">'
            +'      <img src="assets/img/paninicomics.gif" style="width: 100%"/>'
            +'    </div>'
            +'    <div class="agile-row">'
            +'      <a href="'+url+'" class="mini-thumbnail" target="_blank"><img style="width:100%" src="http://www.cavouresoterica.it/wp-content/uploads/2016/04/acquista-ora.png"/></a>'
            +'    </div>'
            +'  </div>'
            +'</div>'
            +'<hr>');*/

        });
	  }
	  

      function parseAnimeXML(data)
      {
        //Se esiste almeno un anime
        if($(data).find('anime').length > 0)
        {
          //Creo la tab con la dicitura "Anime" che comparirà a caricamento ultimato
          $('.tab-products').append('<li class="animated bounceInUp"><a href="#tab13" data-toggle="tab">Anime</a></li>');
          
          //Se l'anime comprende più versioni mostro affianco una lista delle versioni, cliccando sulla lista cambia il contenuto dell'elenco episodi
          if($(data).find('anime').length > 1)
          {
            $('.tab-anime').append('<h3 style="padding-left:15px">Elenco episodi</h3><div class="tab-pane" ><div class="row"><div class="col-sm-12 anime"></div></div></div>');


            //Questa è la creazione del pannello che mostrerà l'elenco degli episodi
            $('.anime').append('<div class="tabbable tabs-right"><div class="col-sm-9"><div class="tab-content contentAnime" style="border-color:#089183"></div></div></div>');
            
            //Questa è la creazione dell'elenco delle versioni dell'anime mostrato sulla destra
            $('.tabbable.tabs-right').append('<div class="col-sm-3"><h3 style="margin-top:0px;">Versioni televisive</h3><ul class="nav nav-anime anime-list"></ul></div>');

          
            //Questa variabile tiene traccia delle versioni diverse dall'anime viene incrementato quando si passa da una versione dell'anime ad un'altra            
            series=1;
            //Scorro tutti gli anime
            $(data).find('anime').each(function(){            
              //Ottengo il titolo della versione dell'anime per mostrarla sulla destra
              title = $(this).find('title').eq(0).text();
              
              //Se sto considerando la prima serie devo gestire un caso a parte, in quanto la prima serie dev'essere quella selezionata di default
              //In questa fase viene legato il click del pannello di destra con l'effettivo elenco degli episodi di quell'anime
              if(series == 1)
              {
                //Inizializzo il blocco dell'anime che mostrerà la lista degli episodi
                $('.contentAnime').append('<div class="tab-pane active" id="tab2'+series+'"><div class="panel-group anime-content'+series+'" id="accordion-panel'+series+'"></div></div>');
                //Aggiungo alla lista delle versioni dell'anime la versione corrente
                $('.anime-list').append('<li class="active"><a href="#tab2'+series+'" data-toggle="tab">'+title+'</a></li>');
              }
              else
              {
                //Inizializzo il blocco dell'anime che mostrerà la lista degli episodi
                $('.contentAnime').append('<div class="tab-pane" id="tab2'+series+'"><div class="panel-group anime-content'+series+'" id="accordion-panel'+series+'"></div></div>');
                //Aggiungo alla lista delle versioni dell'anime la versione corrente
                $('.anime-list').append('<li><a href="#tab2'+series+'" data-toggle="tab">'+title+'</a></li>');
              }

              //Scorro tutti gli episodi dell'anime
              $(this).find('episodes').each(function(){
                $(this).find('episode').each(function(){
                  number = $(this).find('number').text();
                  title = $(this).find('title').text();

                  //Aggiugo al blocco dell'anime l'episodio con il relativo pannello verde
                  $('.anime-content'+series).append('<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-panel'+series+'" href="#episode'+series+''+number+'">['+number+"] "+title+'</a></h4></div>'
                          + '<div id="episode'+series+''+number+'" class="panel-collapse collapse">'
                          + '<div class="panel-body anime-content-body'+series+''+number+'"></div></div></div>');
                  //Aggiungo al pannello dell'episodio le informazioni riguardanti quell'episodio
                  $('.anime-content-body'+series+''+number).append(insertPanelContentAnime($(this)));
                });
              });

              //Passo alla versione televisiva successiva
              series++;
            });
          }
          //Se invece esiste una sola vesione dell'anime visualizzo l'elenco episodi come se mostro l'elenco dei volumi
          else
          {
            $('.tab-anime').append('<h3>Elenco episodi</h3><div class="tab-pane" ><div class="row"><div class="col-sm-12 anime"></div></div></div>');
            //Inizializzo il blocco dell'anime che mostrerà la lista degli episodi
            $('.anime').append('<div class="panel-group anime-content" id="accordion-panelAnime"></div>');  

            $(data).find('anime').each(function(){   

              //Scorro tutti gli episodi
              $(this).find('episodes').each(function(){
                $(this).find('episode').each(function(){

                    number = $(this).find('number').text();
                    title = $(this).find('title').text();

                   //Aggiugo al blocco dell'anime l'episodio con il relativo pannello verde
                  $('.anime-content').append('<div class="panel panel-default">'
                    +'<div class="panel-heading">'
                    +'  <h4 class="panel-title">'
                    +'    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-panelAnime" href="#episode'+number+'">['+number+"] "+title+'</a>'
                    +'  </h4>'
                    +'</div>'
                    +'<div id="episode'+number+'" class="panel-collapse collapse">'
                    + '<div class="panel-body anime-content-body'+number+'"></div></div></div>');
                    
                    //Aggiungo al pannello dell'episodio le informazioni riguardanti quell'episodio
                    $('.anime-content-body'+number).append(insertPanelContentAnime($(this)));
                });
              });
            });

          }
        } 
      }

      //Funzione che formatta le informazioni riguardanti l'episodio
      function insertPanelContentAnime(episode)
      {

        toReturn = '<h5><b>Data d\'uscita in Giappone: </b>'+episode.find('dateJPN').text()+'</h5>';
        toReturn += '<h5><b>Data d\'uscita in Italia: </b>'+episode.find('dateIT').text()+'</h5>';
        toReturn += '<div style="margin-top:35px;"><h5><b>Trama:</b></h5><p>'+episode.find('story').text()+'</p></div>';
        return toReturn;
         
      }
    </script>
    <?php
      function insertPanelContent($volume)
      {
        $toReturn = "";
      
        $plot = $volume->story;
        $date_published = $volume->date;
        $chapters_list = $volume->chapters_list;
        
        if($date_published != "")
        {
          $toReturn .= "<h5><b>Data/e pubblicazione:</b></h5> <ul>";
          $dates_published = explode("-", $date_published);
          foreach ($dates_published as $single_date) {
            if($single_date != "")
              $toReturn .= "<li>".$single_date."</li>"; 
          }
          $toReturn .= "</ul>";
        }
      
        if($plot != "")
        {
          $toReturn .= "<h5><b>Trama:</b></h5><p>".$plot."</p>";
        }
      
      
        if(count($chapters_list) > 0)
        {
          $toReturn .= "<h5><b>Capitoli:</b></h5>";
          $toReturn .= "<ul>".$chapters_list."</ul>";
        }
      
        return $toReturn;
      
                   
      }
      ?>
  </body>
</html>