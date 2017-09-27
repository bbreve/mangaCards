<?php
  $title = $_POST['title'];

  ob_start();
  require '\wrappers\WikipediaWrapper.php';
  $page_info = ob_get_clean(); 
  $load = simplexml_load_string($page_info);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  
  <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
  
  <title>Techie - Bootstrap 3 modern skin</title>
  
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
  </style>
  
</head>

<body>

  <div class="container">
    <div class="row">
       <div class="col-lg-4 col-sm-4 ">
          <a href="#" class="thumbnail">
            <img src="assets/img/image-placeholder.png" alt="">
          </a>
       </div>
      <div class="col-lg-5 col-sm-5">
        <div class="agile-row">
          <h1><?php echo $load->manga->name?></h1>
        </div>
        <div class="agile-row">
          <h5>Creato da: <?php echo $load->manga->author?></h5>
        </div>
        <div class="agile-row">
          <h5>Editore: <?php echo $load->manga->editor?></h5>
        </div>
        <div class="agile-row">
          <h5>Volumi giapponesi: <?php echo $load->manga->volumes_jp?></h5>
        </div>
        <div class="agile-row">
          <h5>Volumi italiani: <?php echo $load->manga->volumes_it?></h5>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 col-lg-12">
        <h3>Volumi</h3>
        <div class="panel-group" id="accordion-panel">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-panel" href="#collapseOnePanel">
                  Collapsible Group Item #1
                </a>
              </h4>
            </div>
            <div id="collapseOnePanel" class="panel-collapse collapse in">
              <div class="panel-body">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. 
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-panel" href="#collapseTwoPanel">
                  Collapsible Group Item #2
                </a>
              </h4>
            </div>
            <div id="collapseTwoPanel" class="panel-collapse collapse">
              <div class="panel-body">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. 
              </div>
            </div>
          </div>
          <div class="panel panel-default">
            <div class="panel-heading">
              <h4 class="panel-title">
                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-panel" href="#collapseThreePanel">
                  Collapsible Group Item #3
                </a>
              </h4>
            </div>
            <div id="collapseThreePanel" class="panel-collapse collapse">
              <div class="panel-body">
                Aliquam facilisis, orci in vulputate posuere, sapien dolor dapibus orci, vitae venenatis dui elit vitae lorem. Sed porta fermentum felis in molestie. Sed porta fermentum felis in molestie. Sed porta fermentum felis in molestie. 
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
    

</body>
</html>

