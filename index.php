    <!DOCTYPE>
    <html lang="en">
    <head>
      
      <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
      
      <title>Manga Cards</title>
      
      <link href='https://fonts.googleapis.com/css?family=Lato:400,300,400italic,700,900' rel='stylesheet' type='text/css'>
  	  <!--<link href="assets/css/theme/style.css" rel="stylesheet" type="text/css" media="all" />-->
      <link href="assets/css/animate.css" rel="stylesheet" type="text/css" media="all" />

      <!--SELECT 2 Instructions -->
      <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />


      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
      <meta name="description" content="Techie Bootstrap 3 skin">
      <meta name="keywords" content="bootstrap 3, skin, flat">
      <meta name="author" content="bootstraptaste">
  	
      <!-- Bootstrap css -->
      <link href="assets/css/bootstrap.min.css" rel="stylesheet">
      <link href="assets/css/bootstrap.techie.css" rel="stylesheet">

      <style type="text/css">
        .select2-container .select2-selection--single{
          height:40px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered
        {
          line-height: 38px;
        }
      </style>
	  <style type="text/css">
		.vertical-center {
      text-align: center;
	  min-height: 100%;  /* Fallback for browsers do NOT support vh unit */
	  min-height: 100vh; /* These two lines are counted as one :-)       */

	  display: flex;
	  align-items: center;
	}
	</style>
  	
    <!-- =======================================================
        Theme Name: Techie
        Theme URL: https://bootstrapmade.com/techie-free-skin-bootstrap-3/
        Author: BootstrapMade
        Author URL: https://bootstrapmade.com
    ======================================================= -->

      <!-- Docs Custom styles -->
      <style>
    body,html{overflow:hidden}body{padding:0px 20px 0}footer{border-top:1px solid #ddd;padding:30px;margin-top:50px}.row>[class*=col-]{margin-bottom:40px}.navbar-container{position:relative;min-height:100px}.navbar.navbar-fixed-bottom,.navbar.navbar-fixed-top{position:absolute;top:50px;z-index:0}.navbar.navbar-fixed-bottom .container,.navbar.navbar-fixed-top .container{max-width:90%}.btn-group{margin-bottom:10px}.form-inline input[type=password],.form-inline input[type=text],.form-inline select{width:180px}.input-group{margin-bottom:10px}.pagination{margin-top:0}.navbar-inverse{margin:110px 0}
      </style>
      
    </head>

  <body>
    <div class="overlay">
      <div class="loading vertical-center">
        <i style="margin:auto" class="fa fa-cog fa-spin fa-3x fa-refresh"></i>
      </div>
      </div>
    </div>
    <div id="bg" class="bg_Manga"></div>
    	<!-- main --> 
  		<div class="items-group">
  						<div class="jumbotron">
  							<div class="agile-row">
  								<div> 
  									<h1 style="text-align:center; font-weight:bold">Manga<br>Cards</h1>
  									<p style="font-weight:bold; text-align:center">Cerca informazioni sui tuoi manga e comics preferiti e confronta i prezzi!</p>
  								</div>
  							</div> 
  							<form id="main" action="info.php" method="post">
  								<div class="row">
                    <div align="center">
                      <div class="input-group">
                        <div class="input-group-btn">
                          <button type="button" id="typeButton" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Manga <span class="caret"></span></button>
<!--NICO-->                   <ul class="dropdown-menu">
                              <li><a href="javascript:changeType('Manga');">Manga</a></li>
                              <li><a href="javascript:changeType('Comic');">Comic</a></li>
                            </ul>
                        </div> <!-- /btn-group -->   
                        <input id="work_selected" name="work_selected" type="hidden" value=""/>                       
                        <select class="form-control" name="select">
                        </select>
                            <!--<input id="title" name="title" type="text" class="form-control" placeholder="Inserisci il titolo del manga">-->
                        <span class="hidden fa fa-times form-control-feedback"></span>
                      </div>
                    </div>
                  </div>
    							<div class="row">
    									<div style="text-align: center">
    										<a class="btn btn-primary btn-lg btn-search">Cerca</a>
    									</div>
                  </div>
  							</form>
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
      <!-- Main Scripts-->
      <script src="assets/js/jquery.js"></script>
      <script src="assets/js/bootstrap.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
      <!-- Bootstrap 3 has typeahead optionally -->
      <script src="assets/js/typeahead.min.js"></script>
  	   <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
      <script type="text/javascript">
        
        function showOverlay() {
          $(".overlay").fadeIn(400);
        }     
        
        function hideOverlay() {
          $(".overlay").fadeOut(400);
        }

        $(document).ready(function(){
          hideOverlay();
        });
 
 
        function MangaSelect(){
		
        $('select').select2(
        {
          language: {
            noResults: function(){
              return "Nessun risultato trovato";
            },
            searching: function () {
              return 'Ricerca in corso...';
            },
            inputTooShort: function (args) {
              var remainingChars = args.minimum - args.input.length;

              var message = 'Inserire altri ' + remainingChars + ' per avviare la ricerca';

              return message;
            },
            errorLoading: function () {
              return 'Ricerca in corso...';
            },

          },
          minimumInputLength: 3,
          ajax: {
            dataType: "json",
            delay: 250,
            url: "listofvalues.php",
            results: function (data) {
              return {
                results: data
              };
            },
          }
        });
		
		   }
		   
		   MangaSelect();
		   
		   function FumettoSelect(){
			   $('select').select2(
        {
          language: {
            noResults: function(){
              return "Nessun risultato trovato";
            },
            searching: function () {
              return 'Ricerca in corso...';
            },
            inputTooShort: function (args) {
              var remainingChars = args.minimum - args.input.length;

              var message = 'Inserire altri ' + remainingChars + ' per avviare la ricerca';

              return message;
            },
            errorLoading: function () {
              return 'Ricerca in corso...';
            },

          },
          minimumInputLength: 3,
          ajax: {
            dataType: "json",
            delay: 250,
            url: "comicsvalues.php",
            results: function (data) {
              return {
                results: data
              };
            },
          }
        });
			   
		   }

      	var type_work = "Manga";
        function changeType(type)
        {
        	type_work=type;
          $("#typeButton").html(type + " <span class=\"caret\">");
          if(type == "Comic")
          {
            //$('#title').attr("placeholder", "Inserisci il titolo della serie");
            $('#bg').removeClass("bg_Manga").addClass("bg_Comics");
			FumettoSelect();
          }
          else
          {
            //$('#title').attr("placeholder", "Inserisci il titolo del manga");
            $('#bg').removeClass("bg_Comics").addClass("bg_Manga");
			MangaSelect();
          }

        }
        $(".btn-search").click(function(){
      		if($("select option:selected").text() != "")
      			$("form#main").submit();
      		else
      		{
      			showError();
      		}

      	});

       $("form#main").submit(function(e){

          showOverlay();    
      		if($("select option:selected").text() != ""){
            text_selected = $("select").select2().find(":selected").html();
        
            $('#work_selected').attr('value', text_selected);

      			return true;
          }
      		else
      		{
      			showError();
      			return false;
      		}
  		});
        
        
        

        function showError()
        {
        	$(".form-group.has-feedback").addClass("has-error animated shake");
      	  $(".fa.fa-times").removeClass("hidden");
      	  //$('#title').attr("placeholder", "Il titolo dell'opera è obbligatorio");
      	  //$("select").addClass("animated shake");
      	  setTimeout(clear, 3000);
        }

      	function clear()
      	{
      	  $(".form-group.has-feedback").removeClass("has-error animated shake");
      		//$("select").removeClass("animated shake");
      		$(".fa.fa-times").addClass("hidden");
      		//if(type_work == "Manga")
      		//	$('#title').attr("placeholder", "Inserisci il titolo del manga");
      		//else
      		//	$('#title').attr("placeholder", "Inserisci il titolo della serie");
      	}

      </script>
    </body>
  </html>