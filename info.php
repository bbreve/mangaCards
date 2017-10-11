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
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="Techie Bootstrap 3 skin">
    <meta name="keywords" content="bootstrap 3, skin, flat">
    <meta name="author" content="bootstraptaste">
    <!-- Bootstrap css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap.techie.css" rel="stylesheet">
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
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab11" data-toggle="tab">Volumi</a></li>
          <li><a href="#tab12" data-toggle="tab">Offerte</a></li>
        </ul>
        <div class="tab-content">
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
          <div class="tab-pane" id="tab12">
            <div class="row">
                <div class="col-sm-12 container offers">

                </div>
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
        $.ajax({
          type: "POST",
          data: {
            'title': <?php echo '"'.$title.'"'; ?>
          },
          url: "wrappers/AmazonWrapper.php",
          async: true

        })
        .done(function (data){
          parseXML(data);
        });
      });



      function parseXML(data)
      {
        $(data).find('offer').each(function(){
          title = $(this).find('title').text();
          url = $(this).find('url_to_product').text();
          image = $(this).find('cover').text();

          price = $(this).find('price').text();
          
          author = $(this).find('author').text();
          $('.container.offers').append(
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
            +'      <a href="'+url+'" class="mini-thumbnail"><img style="width:100%" src="http://www.cavouresoterica.it/wp-content/uploads/2016/04/acquista-ora.png"/></a>'
            +'    </div>'
            +'  </div>'
            +'</div>'
            +'<hr>');

        });

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
          $toReturn .= "<h5 ><b>Capitoli:</b></h5>";
          $toReturn .= "<ul>".$chapters_list."</ul>";
        }
      
        return $toReturn;
      
                   
      }
      ?>
  </body>
</html>