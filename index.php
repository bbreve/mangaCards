  <!DOCTYPE>
  <html lang="en">
  <head>
    
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
    
    <title>MangaCards</title>
    
    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,400italic,700,900' rel='stylesheet' type='text/css'>
	<link href="assets/css/theme/style.css" rel="stylesheet" type="text/css" media="all" />

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
  <div id="bg" class="bg_Manga"></div>
  	<!-- main --> 
	<div class="main-agileinfo slider ">
		<div class="items-group">
			<div class="item agileits-w3layouts">
				<div class="block text main-agileits"> 
					<div class="login-form loginw3-agile"> 
						<div class="login-agileits-top jumbotron">
							<div class="agile-row">
								<div>
									<h1 style="font-weight:bold">Manga<br><br>Cards</h1>
									<p style="font-weight:bold; text-align:center">Cerca informazioni sui tuoi manga e comics preferiti e confronta i prezzi!</p>
								</div>
							</div> 
							<div class="agile-row">
							  <div> 
								<div class="input-group">
								  <div class="input-group-btn">
									<button type="button" id="typeButton" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Manga <span class="caret"></span></button>
									<ul class="dropdown-menu">
									  <li><a href="javascript:changeType('Manga');">Manga</a></li>
									  <li><a href="javascript:changeType('Fumetto');">Fumetto</a></li>
									</ul>
								  </div><!-- /btn-group -->
								  <input id="title" type="text" class="form-control" placeholder="Inserisci il titolo del manga">
								</div><!-- /input-group -->
							  </div>
							  <div class="agile-row">
								<div style="text-align: center;">
									<a class="btn btn-primary btn-lg" href="#">Cerca</a>
								</div>
							  </div>
							</div>
							
							<div class="agile-row">
							<footer class="text-center">
								<div class="credits">
									<p>Progetto realizzato per il corso di Integrazione Dati sul Web</p>
								</div>
							</footer>
							</div>
						</div>
					</div>
				</div>
			</div>	
		</div>
	</div>		
    <!-- Main Scripts-->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
   
    <!-- Bootstrap 3 has typeahead optionally -->
    <script src="assets/js/typeahead.min.js"></script>
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <script type="text/javascript">
      function changeType(type)
      {
        $("#typeButton").html(type + " <span class=\"caret\">");
        if(type == "Fumetto")
        {
          $('#title').attr("placeholder", "Inserisci il titolo della serie");
          $('#bg').removeClass("bg_Manga").addClass("bg_Comics");
        }
        else
        {
          $('#title').attr("placeholder", "Inserisci il titolo del manga");
          $('#bg').removeClass("bg_Comics").addClass("bg_Manga");
        }

      }
    </script>

  </body>
</html>