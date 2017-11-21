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
  
  $type_search = $work_info->work->type_element;
  
  $origin_name = $work_info->work->original_name;
  
  $en_name = $work_info->work->en_name;
  
  $pag_name = str_replace(array("\n","\r")," ",$work_info->work->name);
  
  
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Techie Bootstrap 3 skin">
    
    <meta name="keywords" content="bootstrap 3, skin, flat">
    <meta name="author" content="bootstraptaste">
    <!-- Bootstrap css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap.techie.css" rel="stylesheet">
    <link href="assets/css/animate.css" rel="stylesheet">


    <style>
      body,html{overflow-x:hidden}body{padding:60px 20px 0}footer{border-top:1px solid #ddd;padding:30px;margin-top:50px}.row>[class*=col-]{margin-bottom:40px}.navbar-container{position:relative;min-height:100px}.navbar.navbar-fixed-bottom,.navbar.navbar-fixed-top{position:absolute;top:50px;z-index:0}.navbar.navbar-fixed-bottom .container,.navbar.navbar-fixed-top .container{max-width:90%}.btn-group{margin-bottom:10px}.form-inline input[type=password],.form-inline input[type=text],.form-inline select{width:180px}.input-group{margin-bottom:10px}.pagination{margin-top:0}.navbar-inverse{margin:110px 0}
      .panel-default > .panel-heading {
      }
}

    </style>
  </head>
  <body>    
    <div class="container main">
      <div class="progress animated pulse">
        <div class="progress-bar" style="width: 1%"><span>Caricamento</span></div>
      </div>
      <div class="row">
        <div class="col-lg-4 col-sm-4 ">
          <a href="#" class="thumbnail">
          <img src=<?php echo ($work_info->work->link_image != "https:") ? ($work_info->work->link_image) : '""'?>  alt="Immagine non disponibile">
          </a>
        </div>
        <div class="col-lg-5 col-sm-5">
          <div class="agile-row">
            <h1><?php echo $pag_name?></h1>
          </div>
		  <?php  
		      if(count($origin_name)!=0){
				  echo'<div class="agile-row">';
					echo'<h4>Nome originale: ';  
							  echo $origin_name;
					  echo'</h4>';
				  echo'</div>'; }

			  if(count($en_name) != 0)
			  {
				if (stripos($en_name, $pag_name) === FALSE && stripos($en_name, "(") === FALSE)
				{
					echo'<div class="agile-row">';
						echo'<h4>Nome inglese: ';  
							  echo $en_name;
						echo'</h4>';
					echo'</div>';
				}
			  }
		  
				if(count($work_info->work->authors->author)!=0){
				  echo'<div class="agile-row">';
					echo'<h5>Autore/i: ';  $authors_list = "";
							  $prev = "";
							  foreach($work_info->work->authors->author as $author) 
							  { 
								if ($author != "" && $author != "-" && $author != "," && $author != "." && trim($author) != $prev)
									$authors_list .= $author.", ";
								$prev = $author;
							  }
							  
							  $authors_list = rtrim($authors_list, ", ");
							  $authors_list = str_replace(array("\n","\r")," ",$authors_list);
							  echo $authors_list;
					  echo'</h5>';
				  echo'</div>'; }
		  
				  if(count($work_info->work->authors->testi)!=0){
				  echo'<div class="agile-row">';
					echo'<h5>Testi: ';  $testi_list = "";
						  $prev = "";
						  foreach($work_info->work->authors->testi as $author) 
						  {
							  if ($author != "" && $author != "-" && $author != "," && $author != "." && $prev != trim($author))
								$testi_list .= $author.", ";
							  $prev = $author;	
						  }
						  
						  $testi_list = rtrim($testi_list, ", ");
						  echo $testi_list;
						  echo'</h5>';
				  echo'</div>'; }
				  
				  if(count($work_info->work->authors->disegni)!=0){
				  echo'<div class="agile-row">';
					echo'<h5>Disegni: ';  $disegni_list = "";
						  $prev = "";	
						  foreach($work_info->work->authors->disegni as $author) 
						  {
							  if($author != "" && $author != "-" && $author != "," && $author != "." && $prev != trim($author))
								$disegni_list .= $author.", ";
							  $prev = $author;	
						  }
						  $disegni_list = rtrim($disegni_list, ", ");
						  echo $disegni_list;
						  echo'</h5>';
					echo'</div>'; }
					?>
		  
          <div class="agile-row">
            <h5>Editore: <?php  $editors_list = "";
              $prev = "";
			  foreach($work_info->work->editors->editor as $editor) 
              {
				if($editor != "" && $editor != "-" && $editor != "," && $editor != "." && $prev != trim($editor))
					$editors_list .= $editor.", ";
				$prev = $editor;
              } 
			  
              $editors_list = rtrim($editors_list, ", ");
              echo $editors_list;
              ?></h5>
          </div>
		  <?php if(count($num_jp)!=0){
         echo '<div class="agile-row">';  
            echo'<h5>Volumi giapponesi:';echo $num_jp;'</h5>';
		  echo' </div>';}?>
		 
           <?php if(count($num_it)!=0){
         echo '<div class="agile-row">';  
            echo'<h5>Volumi italiani:';echo $num_it;'</h5>';
		  echo' </div>';}?>
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
					  $idN = $volume->number;
					  if (stripos($idN, "(") !== FALSE)
					  {
						$arr = explode("(", $idN);
						$idN = trim($arr[0]);	
					  }
                      echo '
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-panel" href="#volume'.str_replace(' ', '', $idN).'">['.$idN."] ".$volume->title.'
                            </a>
                          </h4>
                        </div>
                        <div id="volume'.str_replace(' ', '', $idN).'" class="panel-collapse collapse">
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
        <div class="container row">
          <h2>Negozi</h2>
                <div class="overlay loading text-center">
                  <h4 class="loading">Caricamento delle offerte in corso...</h4>
                  <i class="fa fa-cog fa-spin fa-3x fa-refresh"></i>
                </div>                    
        </div>
        <div class="row container container-shops">
          
        </div>
        <div class="panel-group container-products-shops" id="products-shops">
        </div>
            </div>
          </div>
          
        </div>
        <div class="tab-pane" id="tab13" >
          <div class="row">
            <div class="col-sm-12">
              <div class="tab-anime" >
              </div>
            </div>
           </div>
        </div>
        <div class="tab-pane" id="tab50" >
          <div class="row">
            <div class="col-sm-12 container offers">
              <div class="container row">
                <h2>Negozi</h2>
              </div>
              <div class="row container container-games">
                
              </div>
              <div class="panel-group container-products-games" id="products-games">
              </div>
            </div>
        </div>
      </div>
    </div>
    <footer class="text-center">
      <p>&copy; Manga Cards</p>
    <div id="scroll-to-top" style="display: none;"><a><img  height="50" width="50"  src="assets/img/IconTop.png" /></a></div>
    </footer>
  
    <!-- Main Scripts-->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Bootstrap 3 has typeahead optionally -->
    <script src="assets/js/typeahead.min.js"></script>
    <script>
      function amazonAjax(title, search, origin, aut)
      {
        return $.ajax(
        {
          type: "POST",
          data:
          {
            'title': title,
			'type' : search,
			'origin' : origin,
			'authors' : aut
          },
          url: "wrappers/AmazonWrapper.php",
          async: true

        })
        .done(function(data)
        {
          hideOverlay();
          parseAmazonXML(data);
        });
      }
	  
	  function amazonGamesAjax(title, search, origin, aut)
      {
        return $.ajax(
        {
          type: "POST",
          data:
          {
            'title': title,
			'type' : search,
			'origin' : origin,
			'authors' : aut
          },
          url: "wrappers/AmazonGamesWrapper.php",
          async: true

        })
        .done(function(data)
        {
          hideOverlay();
          parseAmazonGamesXML(data);
        });
      }

      function jpopAjax()
      {
        return $.ajax(
          {
            type: "POST",
            data:
            {
              'title': <?php echo '"'.$title.'"'; ?>
            },
            url: "wrappers/JpopMangaWrapper.php",
            async: true

          })
          .done(function(data)
          {
            hideOverlay();
            parseJPopXML(data);
          });
      }

      function rwAjax()
      {
        return $.ajax(
          {
            type: "POST",
            data:
            {
              'title': <?php echo '"'.$pag_name.'"'; ?>
            },
            url: "wrappers/RWEdizioniWrapper.php",
            async: true

          })
          .done(function(data)
          {
            hideOverlay();
            parseRWXML(data);
          });
      }

	  function executeProgress()
      {
        maxPercentage = $('.container.main').width();
        currentPercentage = $('.progress-bar').width();
        amount = Math.random() * 2;
        newPercentage = currentPercentage + ((maxPercentage * amount) / 100);
        $('.progress-bar').css('width', newPercentage);
        setTimeout(executeProgress, 3000)
      }
	  
      function paniniAjax(title, type, origin)
      {
		  setTimeout(executeProgress, 3000);
        return $.ajax(
          {
            type: "POST",
            data:
            {
              'title': title,
			  'type' : type,
			  'origin' : origin
            },
            url: "wrappers/PaniniWrapper.php",
            async: true

          })
          .done(function(data)
          {
            hideOverlay();
            parsePaniniXML(data);
          });
      }

      function gamestopAjax(title, search, origin, en)
      {
        return $.ajax(
        {
          type: "POST",
          data:
          {
            'title': title,
			'type' : search,
			'origin' : origin,
			'english' : en
          },
          url: "wrappers/GamestopWrapper.php",
          async: true

        })
        .done(function(data)
        {
          parseGamestopXML(data);
        });
      }

      function animeAjax()
      {
        return $.ajax(
        {
          type: "POST",
          data:
          {
            'series': <?php echo '"'.$title.'"'; ?>
          },
          url: "wrappers/WikiAnime.php",
          async: true

        })
        .done(function(data)
        {

          parseAnimeXML(data);
        });
      }

     $(document).ready(function()
     {
      var Editors = "<?php echo $editors_list; ?>";
	  
	//Ottengo le variabili di ricerca
      
	  var search = <?php echo '"'.$type_search.'"'; ?>;
	  var pag_name = <?php echo '"'.$pag_name.'"'; ?>;
	  var original_name = <?php echo '"'.$origin_name.'"'; ?>;
	  var selectTitle = <?php echo '"'.$title.'"'; ?>;  
	  var en = <?php echo '"'.$en_name.'"'; ?>;  
	  var text_list = <?php echo '"'.$testi_list.'"'; ?>; 
	  var aut_list = <?php echo '"'.$authors_list.'"'; ?>;  
	  
	//Chiamata AJAX per Amazon (Manga/Comic)
	
	if (search == "manga")
	{
		original_name = "";
		amazonReq = amazonAjax(pag_name, search, original_name, aut_list);
	}
	else
	{
		if (aut_list == "")
			amazonReq = amazonAjax(pag_name, search, original_name, text_list);
		else
			amazonReq = amazonAjax(pag_name, search, original_name, aut_list);
    }
	
	//Chiamata AJAX per J-POP

      if (Editors.search(/J-Pop/i) !== -1 || Editors.search(/JPop/i) !== -1)
      {
        jpopReq = jpopAjax();
      }
      else
      {
        jpopReq = amazonReq;
      }
	  
	//Chiamata AJAX per RW Edizoni

      if (Editors.search(/DC Comics/i) !== -1)
      {
        rwReq = rwAjax();  
      }
      else
        rwReq = amazonReq;

	//Chiamata AJAX per Panini (Comic)
	
      if (Editors.search(/Marvel/i) !== -1)
      {
        paniniReq = paniniAjax(pag_name, search, original_name);
      }
      else 
        paniniReq = amazonReq;

	//Chiamata AJAX per Panini (Manga)
	
      if (Editors.search(/Panini/i) !== -1 || Editors.search(/Planet Manga/i) !== -1)
      {
        paniniReq = paniniAjax(pag_name, search, "");
      }
      else
         paniniReq = amazonReq;

	//Chiamata AJAX per Gamestop

	if (search == "manga")
		original_name = "";
	
	gamestopReq = gamestopAjax(pag_name, search, original_name, en);
	
	//Chiamata AJAX per Amazon (videogiochi)
	
	amazonGamesReq = amazonGamesAjax(pag_name, search, original_name, en);

	  
	// Chiamata AJAX per gli anime
      animeReq = animeAjax();
      
      $.when(amazonReq, paniniReq, rwReq, animeReq, jpopReq, gamestopReq, amazonGamesReq).done(function(a1, a2, a3, a4){
        $('.progress-bar').css('width', '100%');
        $('.progress.animated').fadeOut();
        $('.animated.bounceInUp').removeClass('animated bounceInUp');

      }); 

      });
     function showOverlay()
     {
      $(".overlay").fadeIn(400);
     }

     function hideOverlay()
     {
      $(".overlay").fadeOut(400);
     }

     $('#scroll-to-top').click(function()
     {
      $("html, body").animate(
      {
        scrollTop: 0
      }, 500);

      return false;
     });


     $(document).scroll(function()
     {
      var y = $(this).scrollTop();
      if (y > 1200)
      {
        $('#scroll-to-top').fadeIn();
      }
      else
      {
        $('#scroll-to-top').fadeOut();
      }
     });

     function parseAmazonXML(data)
     {
      maxPercentage = $('.container.main').width();
      currentPercentage = $('.progress-bar').width();
      newPercentage = currentPercentage + ((maxPercentage * 5) / 100);
      $('.progress-bar').css('width', newPercentage);

	  if ($(data).find('offer').length != 0)
	 {	
      $('.container-shops').append('<a class="accordion-toggle" data-toggle="collapse" data-parent="#products-shops" href="#tab14" ><img class="animated bounceInUp" height=70" width="160"  src="assets/img/amazonLogo2.jpg" /></a>');
      $('.container-products-shops').append('<div class="panel panel-default" style="border:hidden"><div id="tab14" class="panel-collapse collapse"><div class="tab-content amazon top-container-offers"></div></div></div>');
      $(data).find('offer').each(function()
      {
        title = $(this).find('title').text();
        url = $(this).find('url_to_product').text();
        image = $(this).find('cover').text();

        price = $(this).find('price').text();
		
		release = $(this).find('release_date').text();

        author = $(this).find('author').text();
     
        s =  '<div class="row">' +
          '  <div class="col-sm-3"><a href="#" class="mini-thumbnail"><img src="' + image + '"/></a></div>' +
          '  <div class="col-sm-6">' +
          '    <div class="agile-row">' +
          '      <h4>' + title + '</h4>' +
          '    </div>';
		  
		  if (author != "" && author != null)
		  {
			s += '    <div class="agile-row">' +
			'      <p>di ' + author + '</p>' +
			'    </div>';
		  }
          
		  s += '    <div class="agile-row">' +
          '      <h2>' + price + '</h2>' +
          '    </div>' +
		  '	<div class="agile-row">' +
          '      <h3>' + release + '</h3>' +
          '    </div>' +
          '  </div>' +
          '  <div class="col-sm-2">' +
          '    <div class="agile-row">' +
          '      <img src="https://images-na.ssl-images-amazon.com/images/G/01/SellerCentral/legal/amazon-logo_transparent.png" style="width: 100%"/>' +
          '    </div>' +
          '    <div class="agile-row">' +
          '      <a href="' + url + '" class="mini-thumbnail" target="_blank"><img style="width:100%" src="http://www.cavouresoterica.it/wp-content/uploads/2016/04/acquista-ora.png" /></a>' +
          '    </div>' +
          '  </div>' +
          '</div>' +
          '<hr>';
		  
		  $('.amazon').append(s);
      });
	  }	
     }

     function parseAmazonGamesXML(data)
     {
      maxPercentage = $('.container.main').width();
      currentPercentage = $('.progress-bar').width();
      newPercentage = currentPercentage + ((maxPercentage * 5) / 100);
      $('.progress-bar').css('width', newPercentage);

	 if ($(data).find('offer').length > 0)
    {	
      $('.container-games').append('<a class="accordion-toggle" data-toggle="collapse" data-parent="#products-games" href="#tab52" ><img class="animated bounceInUp" height=70" width="160"  src="assets/img/amazonLogo2.jpg" /></a>');
      $('.container-products-games').append('<div class="panel panel-default" style="border:hidden"><div id="tab52" class="panel-collapse collapse"><div class="tab-content amazon-games top-container-offers"></div></div></div>');
      $(data).find('offer').each(function()
      {
        title = $(this).find('title').text();
        url = $(this).find('url_to_product').text();
        image = $(this).find('cover').text();

		plat = $(this).find('plat').text();
        price = $(this).find('price').text();
		
		release = $(this).find('release_date').text();

        author = $(this).find('author').text();

        s =  '<div class="row">' +
          '  <div class="col-sm-3"><a href="#" class="mini-thumbnail"><img style="max-width:200px" src="' + image + '"/></a></div>' +
          '  <div class="col-sm-6">' +
          '    <div class="agile-row">' +
          '      <h4>' + title + '</h4>' +
          '    </div>';
		  
          
		  s += '    <div class="agile-row">' +
          '      <h3>' + plat + '</h3>' +
          '    </div>' +
		  '    <div class="agile-row">' +
          '      <h2>' + price + '</h2>' +
          '    </div>' +
		  '	<div class="agile-row">' +
          '      <h3>' + release + '</h3>' +
          '    </div>' +
          '  </div>' +
          '  <div class="col-sm-2">' +
          '    <div class="agile-row">' +
          '      <img src="https://images-na.ssl-images-amazon.com/images/G/01/SellerCentral/legal/amazon-logo_transparent.png" style="width: 100%"/>' +
          '    </div>' +
          '    <div class="agile-row">' +
          '      <a href="' + url + '" class="mini-thumbnail" target="_blank"><img style="width:100%" src="http://www.cavouresoterica.it/wp-content/uploads/2016/04/acquista-ora.png" /></a>' +
          '    </div>' +
          '  </div>' +
          '</div>' +
          '<hr>';
		  
		  $('.amazon-games').append(s);
      });
	  }	
     }

     function parseJPopXML(data)
     {

      maxPercentage = $('.container.main').width();
      currentPercentage = $('.progress-bar').width();
      newPercentage = currentPercentage + ((maxPercentage * 20) / 100);
      $('.progress-bar').css('width', newPercentage);

	 if ($(data).find('offer').length != 0)
	  {  
      $('.container-shops').append('<a class="accordion-toggle" data-toggle="collapse" data-parent="#products-shops" href="#tab15" ><img class="animated bounceInUp" height=70" width="150"  src="assets/img/JPopLogo.png" /></a>');
      $('.container-products-shops').append('<div class="panel panel-default" style="border:hidden"><div id="tab15" class="panel-collapse collapse"><div class="tab-content JPop top-container-offers"></div></div></div>');
      $(data).find('offer').each(function()
      {
        title = $(this).find('title').text();
        url = $(this).find('url_to_product').text();
        image = $(this).find('cover').text();

        price = $(this).find('price').text();
        details = $(this).find('details').text();

        author = $(this).find('author').text();
        $('.JPop').append(
          '<div class="row">' +
          '  <div class="col-sm-3"><a href="#" class="mini-thumbnail"><img src="' + image + '"/></a></div>' +
          '  <div class="col-sm-6">' +
          '    <div class="agile-row">' +
          '      <h4>' + title + '</h4>' +
          '    </div>' +
          '    <div class="agile-row">' +
          '      <p>di ' + author + '</p>' +
          '    </div>' +
          '    <div class="agile-row">' +
          '      <h3>' + price + '</h3>' +
          '    </div>' +
          '    <div class="agile-row">' +
          '         <h4>' + 'In breve:' + '</h4>' +
          '                  <p>' + details + '</p>  ' +
          '    </div>' +
          '  </div>' +
          '  <div class="col-sm-2">' +
          '    <div class="agile-row">' +
          '      <img src="http://www.j-pop.it//img/logo-4.jpg?1470504371" style="width: 100%"/>' +
          '    </div>' +
          '    <div class="agile-row">' +
          '      <a href="' + url + '" class="mini-thumbnail" target="_blank"><img style="width:100%" src="http://www.cavouresoterica.it/wp-content/uploads/2016/04/acquista-ora.png"/></a>' +
          '    </div>' +
          '  </div>' +
          '</div>' +
          '<hr>');

      });
	  }
     }

     function parseRWXML(data)
     {

      maxPercentage = $('.container.test').width();
      currentPercentage = $('.progress-bar').width();
      newPercentage = currentPercentage + ((maxPercentage * 20) / 100);
      $('.progress-bar').css('width', newPercentage);

	if ($(data).find('offer').length != 0)
	{
      $('.container-shops').append('<a class="accordion-toggle" data-toggle="collapse" data-parent="#products-shops" href="#tab17" ><img class="animated bounceInUp" height=70" width="200"  src="assets/img/RW-EDIZIONI-LOGO.jpg" /></a>');
      $('.container-products-shops').append('<div class="panel panel-default" style="border:hidden"><div id="tab17" class="panel-collapse collapse"><div class="tab-content RW top-container-offers"></div></div></div>');
      //document.write($(data).find('offer').length);
      $(data).find('offer').each(function()
      {
        title = $(this).find('title').text();
        url = $(this).find('url_to_product').text();
        image = $(this).find('cover').text();

        price = $(this).find('price').text();
        rDate = $(this).find('release_date').text();

        contained = $(this).find('containedChapters').text();

        volume_authors = $(this).find('authors').text();

        description = $(this).find('description').text();

        editorial = $(this).find('ed_series').text();
        collection = $(this).find('collection').text();
        imprint = $(this).find('imprint').text();
        // document.write($(this).find('description').text());
        s = '<div class="row">' +
          '  <div class="col-sm-3"><a href="#" class="mini-thumbnail"><img style="width:100%" src="' + image + '"/></a></div>' +
          '  <div class="col-sm-6">' +
          '    <div class="agile-row">' +
          '      <h4>' + title + '</h4>' +
          '    </div>' +
          '    <div class="agile-row">' +
          '      <p>' + volume_authors + '</p>' +
          '    </div>';

        if (contained != "" && contained != null)
        {
          s += '<div class="agile-row"><p>' + contained + '</p></div>';
        }
        if (imprint != "" && imprint != null)
        {
          s += '<div class="agile-row"><p>Linea: ' + imprint + '</p></div>';
        }
        if (collection != "" && collection != null)
        {
          s += '<div class="agile-row"><p>Collana :' + collection + '</p></div>';
        }
        if (editorial != "" && editorial != null)
        {
          s += '<div class="agile-row"><p>Serie: ' + editorial + '</p></div>';
        }


        s += '    <div class="agile-row">' +
          '      <h2>' + price + '<h2>' +
          '   </div>';

        if (rDate != "" && rDate != null)
        {
          s += '<div class="agile-row">' +
            '     <h4>' + rDate + '</h4>  ' +
            '    </div>'
        }

        s += '    <div class="agile-row">' +
          '         <h4>' + 'Descrizione:' + '</h4>' +
          '                  <p>' + description + '</p>  ' +
          '    </div>' +
          '  </div>' +
          '  <div class="col-sm-2">' +
          '    <div class="agile-row">' +
          '      <img src="assets/img/lion-comics-logo-rw-620x350_Fotor_Fotor.jpg" style="width: 100%"/>' +
          '    </div>' +
          '    <div class="agile-row">' +
          '      <a href="' + url + '" class="mini-thumbnail" target="_blank"><img style="width:100%" src="http://www.cavouresoterica.it/wp-content/uploads/2016/04/acquista-ora.png"/></a>' +
          '    </div>' +
          '  </div>' +
          '</div>' +
          '<hr>';

        $('.RW').append(s);
      });
	}
   }

     function parsePaniniXML(data)
     {

      maxPercentage = $('.container.test').width();
      currentPercentage = $('.progress-bar').width();
      newPercentage = currentPercentage + ((maxPercentage * 20) / 100);
      $('.progress-bar').css('width', newPercentage);

	if ($(data).find('offer').length != 0)
	{
      $('.container-shops').append('<a class="accordion-toggle" data-toggle="collapse" data-parent="#products-shops" href="#tab16" ><img class="animated bounceInUp" height=70" width="200"  src="assets/img/Panini.gif" /></a>');
      $('.container-products-shops').append('<div class="panel panel-default" style="border:hidden"><div id="tab16" class="panel-collapse collapse"><div class="tab-content Panini top-container-offers"></div></div></div>');
      $(data).find('offer').each(function()
      {
        title = $(this).find('title').text();
        url = $(this).find('url_to_product').text();
        image = $(this).find('cover').text();

        price = $(this).find('price').text();
        old = $(this).find('old_price').text();
        rDate = $(this).find('release_date').text();

        edition = $(this).find('edition').text();
        info_volume = $(this).find('info_volume').text();

        author = $(this).find('authors').text();
        if (author == "" || author == null)
          author = "Provvisorio";

        description = $(this).find('description').text();


        s = '<div class="row">' +
          '  <div class="col-sm-3"><a href="#" class="mini-thumbnail"><img src="' + image + '"/></a></div>' +
          '  <div class="col-sm-6">' +
          '    <div class="agile-row">' +
          '      <h4>' + title + '</h4>' +
          '    </div>' +
          '    <div class="agile-row">' +
          '      <p>di ' + author + '</p>' +
          '    </div>';

        if (info_volume != "" && info_volume != null)
        {
          s += '<div class="agile-row"><p>' + info_volume + '</p></div>';
        }
        if (edition != "Edizione Originale")
        {
          s += '<div class="agile-row"><p>' + edition + '</p></div>';
        }

        s += '    <div class="agile-row">' +
          '      <h5><del>' + old + '</del><h5>' +
          '         <h2>' + price + '</h2>' +
          '                  <h4>' + rDate + '</h4>  ' +
          '    </div>';
		  
		if (description != null && description != "")
	    {
          s += '    <div class="agile-row">' +
          '         <h4>' + 'Descrizione:' + '</h4>' +
          '                  <p>' + description + '</p>  ' +
          '    </div>';
		}
        
		s +=		'  </div>' +
          '  <div class="col-sm-2">' +
          '    <div class="agile-row">' +
          '      <img src="assets/img/paninicomics.gif" style="width: 100%"/>' +
          '    </div>' +
          '    <div class="agile-row">' +
          '      <a href="' + url + '" class="mini-thumbnail" target="_blank"><img style="width:100%" src="http://www.cavouresoterica.it/wp-content/uploads/2016/04/acquista-ora.png"/></a>' +
          '    </div>' +
          '  </div>' +
          '</div>' +
          '<hr>';

        $('.Panini').append(s);
      });
	}
   }

     function parseGamestopXML(data)
     {

      maxPercentage = $('.container.main').width();
      currentPercentage = $('.progress-bar').width();
      newPercentage = currentPercentage + ((maxPercentage * 20) / 100);
      $('.progress-bar').css('width', newPercentage);
      //Se esiste almeno un'offerta
      if ($(data).find('offer').length > 0)
      {
        //Creo la tab con la dicitura "Videogiochi" che comparirà a caricamento ultimato
        $('.tab-products').append('<li class="animated bounceInUp"><a href="#tab50" data-toggle="tab">Videogiochi</a></li>');

        $('.container-games').append('<a class="accordion-toggle" data-toggle="collapse" data-parent="#products-games" href="#tab51" ><img class="animated bounceInUp" height="50" width="180"  src="https://www.gamestop.com/gs/logos/files/GameStopLogo_BlackRed.png" /></a>');
        $('.container-products-games').append('<div class="panel panel-default" style="border:hidden"><div id="tab51" class="panel-collapse collapse"><div class="tab-content Gamestop top-container-offers"></div></div></div>');

        $(data).find('offer').each(function()
        {
          title = $(this).find('title').text();
          url = $(this).find('url_to_product').text();
          image = $(this).find('cover').text();

          producer = $(this).find('producer').text();
          platform = $(this).find('platform').text();

          price = $(this).find('price').text();
          used = $(this).find('used_price').text();
          rDate = $(this).find('release_date').text();

          pegi = $(this).find('pegi').text();

          s = '<div class="row">' +
            '  <div class="col-sm-3"><a href="#" class="mini-thumbnail"><img style="max-width:200px" src="' + image + '"/></a></div>' +
            '  <div class="col-sm-6">' +
            '    <div class="agile-row">' +
            '      <h4>' + title + '</h4>' +
            '    </div>' +
            '    <div class="agile-row">' +
            '      <h5>' + platform + '</h5>' +
            '    </div>' +
            '    <div class="agile-row">' +
            '      <p>Pubblicato da: ' + producer + '</p>' +
            '    </div>';

          if (price != "" && price != null)
          {
            s += '<div class="agile-row"><h2><span style="font-size: 20px">NUOVO</span> ' + price + '</h2></div>';
          }
          if (used != "" && used != null)
          {
            s += '<div class="agile-row"><h2><span style="font-size: 20px">USATO</span> ' + used + '</h2></div>';
          }

          s += '    <div class="agile-row">' +
            '      <h4>' + rDate + '</h4>  ' +
            '    </div>' +
            '  <div class="agile-row">' +
            '      <h5>PEGI: ' + pegi + '</h5>  ' +
            '    </div>' +
            '  </div>' +
            '  <div class="col-sm-2">' +
            '    <div class="agile-row">' +
            '      <img src="assets/img/gamestopIcon.gif" style="width: 100%"/>' +
            '    </div>' +
            '    <div class="agile-row">' +
            '      <a href="' + url + '" class="mini-thumbnail" target="_blank"><img style="width:100%" src="http://www.cavouresoterica.it/wp-content/uploads/2016/04/acquista-ora.png"/></a>' +
            '    </div>' +
            '  </div>' +
            '</div>' +
            '<hr>';

          $('.Gamestop').append(s);
        });
      }
     }

     function parseAnimeXML(data)
     {

      maxPercentage = $('.container.main').width();
      currentPercentage = $('.progress-bar').width();
      newPercentage = currentPercentage + ((maxPercentage * 10) / 100);
      $('.progress-bar').css('width', newPercentage);
      //Se esiste almeno un anime
      if ($(data).find('anime').length > 0)
      {
        //Creo la tab con la dicitura "Anime" che comparirà a caricamento ultimato
        $('.tab-products').append('<li class="animated bounceInUp"><a href="#tab13" data-toggle="tab">Anime</a></li>');

        //Se l'anime comprende più versioni mostro affianco una lista delle versioni, cliccando sulla lista cambia il contenuto dell'elenco episodi
        if ($(data).find('anime').length > 1)
        {
          $('.tab-anime').append('<h3 style="padding-left:15px">Elenco episodi</h3><div class="tab-pane" ><div class="row"><div class="col-sm-12 anime"></div></div></div>');


          //Questa è la creazione del pannello che mostrerà l'elenco degli episodi
          $('.anime').append('<div class="tabbable tabs-right"><div class="col-sm-9"><div class="tab-content contentAnime" style="border-color:#089183"></div></div></div>');

          //Questa è la creazione dell'elenco delle versioni dell'anime mostrato sulla destra
          $('.tabbable.tabs-right').append('<div class="col-sm-3"><h3 style="margin-top:0px;">Versioni televisive</h3><ul class="nav nav-anime anime-list"></ul></div>');


          //Questa variabile tiene traccia delle versioni diverse dall'anime viene incrementato quando si passa da una versione dell'anime ad un'altra            
          series = 1;
          //Scorro tutti gli anime
          $(data).find('anime').each(function()
          {
            //Ottengo il titolo della versione dell'anime per mostrarla sulla destra
            title = $(this).find('title').eq(0).text();

            //Se sto considerando la prima serie devo gestire un caso a parte, in quanto la prima serie dev'essere quella selezionata di default
            //In questa fase viene legato il click del pannello di destra con l'effettivo elenco degli episodi di quell'anime
            if (series == 1)
            {
              //Inizializzo il blocco dell'anime che mostrerà la lista degli episodi
              $('.contentAnime').append('<div class="tab-pane active" id="tab2' + series + '"><div class="panel-group anime-content' + series + '" id="accordion-panel' + series + '"></div></div>');
              //Aggiungo alla lista delle versioni dell'anime la versione corrente
              $('.anime-list').append('<li class="active"><a href="#tab2' + series + '" data-toggle="tab">' + title + '</a></li>');
            }
            else
            {
              //Inizializzo il blocco dell'anime che mostrerà la lista degli episodi
              $('.contentAnime').append('<div class="tab-pane" id="tab2' + series + '"><div class="panel-group anime-content' + series + '" id="accordion-panel' + series + '"></div></div>');
              //Aggiungo alla lista delle versioni dell'anime la versione corrente
              $('.anime-list').append('<li><a href="#tab2' + series + '" data-toggle="tab">' + title + '</a></li>');
            }

            //Scorro tutti gli episodi dell'anime
            $(this).find('episodes').each(function()
            {
              $(this).find('episode').each(function()
              {
                number = $(this).find('number').text();
                title = $(this).find('title').text();

                //Aggiugo al blocco dell'anime l'episodio con il relativo pannello verde
                $('.anime-content' + series).append('<div class="panel panel-default"><div class="panel-heading"><h4 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-panel' + series + '" href="#episode' + series + '' + number + '">[' + number + "] " + title + '</a></h4></div>' +
                  '<div id="episode' + series + '' + number + '" class="panel-collapse collapse">' +
                  '<div class="panel-body anime-content-body' + series + '' + number + '"></div></div></div>');
                //Aggiungo al pannello dell'episodio le informazioni riguardanti quell'episodio
                $('.anime-content-body' + series + '' + number).append(insertPanelContentAnime($(this)));
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

          $(data).find('anime').each(function()
          {

            //Scorro tutti gli episodi
            $(this).find('episodes').each(function()
            {
              $(this).find('episode').each(function()
              {

                number = $(this).find('number').text();
                title = $(this).find('title').text();

                //Aggiugo al blocco dell'anime l'episodio con il relativo pannello verde
                $('.anime-content').append('<div class="panel panel-default">' +
                  '<div class="panel-heading">' +
                  '  <h4 class="panel-title">' +
                  '    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-panelAnime" href="#episode' + number + '">[' + number + "] " + title + '</a>' +
                  '  </h4>' +
                  '</div>' +
                  '<div id="episode' + number + '" class="panel-collapse collapse">' +
                  '<div class="panel-body anime-content-body' + number + '"></div></div></div>');

                //Aggiungo al pannello dell'episodio le informazioni riguardanti quell'episodio
                $('.anime-content-body' + number).append(insertPanelContentAnime($(this)));
              });
            });
          });

        }
      }
     }

     //Funzione che formatta le informazioni riguardanti l'episodio
     function insertPanelContentAnime(episode)
     {

      toReturn = '<h5><b>Data d\'uscita in Giappone: </b>' + episode.find('dateJPN').text() + '</h5>';
      toReturn += '<h5><b>Data d\'uscita in Italia: </b>' + episode.find('dateIT').text() + '</h5>';
	  if (episode.find('story').text() != "")
		toReturn += '<div style="margin-top:35px;"><h5><b>Trama:</b></h5><p>' + episode.find('story').text() + '</p></div>';
      return toReturn;

     }
    </script>
    <?php
      function insertPanelContent($volume)
      {
        $toReturn = "";
      
        $plot = $volume->story;
        $date_published_it = $volume->dateIT;
    $date_published_jpn = $volume->dateJPN;
        $chapters_list = $volume->chapters_list;
        
    if($date_published_jpn != "")
        {
          $toReturn .= "<h5><b>Data pubblicazione JAP:</b></h5> <ul>";
          $dates_published = explode("-", $date_published_jpn);
          foreach ($dates_published as $single_date) {
            if($single_date != "")
              $toReturn .= "<li>".$single_date."</li>"; 
          }
          $toReturn .= "</ul>";
        }
    
        if($date_published_it != "")
        {
          $toReturn .= "<h5><b>Data/e pubblicazione ITA:</b></h5> <ul>";
          $dates_published = explode("-", $date_published_it);
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