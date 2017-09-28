    <!DOCTYPE>
    <html lang="en">
    <head>
      
      <meta http-equiv="content-type" content="text/html; charset=UTF-8"> 
      
      <title>Manga Cards</title>
      
      <link href='https://fonts.googleapis.com/css?family=Lato:400,300,400italic,700,900' rel='stylesheet' type='text/css'>
  	  <link href="assets/css/theme/style.css" rel="stylesheet" type="text/css" media="all" />
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

      <style>
        .select2-container .select2-selection--single{
          height:40px;
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
  							<form id="main" action="info.php" method="post">
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
  									   <div class="form-group has-feedback" style="margin-bottom: 0px">		
                              <input id="work_selected" name="work_selected" type="hidden" value=""/>					           		
                              <select class="form-control" name="select">

                              </select>
  							            	 <!--<input id="title" name="title" type="text" class="form-control" placeholder="Inserisci il titolo del manga">-->
  							            	 <span class="hidden fa fa-times form-control-feedback"></span>
  							           </div>  
  									 
  									</div><!-- /input-group -->
  								  </div>
  								  <div class="agile-row">
  									<div style="text-align: center;">
  										<a class="btn btn-primary btn-lg btn-search">Cerca</a>
  									</div>
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
        var array = [{id:0, text:"07-Ghost"},{id:1, text:"1 or W"},{id:2, text:"11 Eyes"},{id:3, text:"100% Fragola"},{id:4, text:"2001 Nights"},{id:5, text:"20th Century Boys"},{id:6, text:"3x3 occhi"},{id:7, text:"4 ragioni per innamorarsi di lui"},{id:8, text:"5 Elementos"},{id:9, text:"666 Satan"},{id:10, text:"91 Days"},{id:11, text:"A Town Where You Live"},{id:12, text:"After School Adventure"},{id:13, text:"Afterschool Nightmare"},{id:14, text:"Agharta (manga)"},{id:15, text:"Air Gear"},{id:16, text:"Akira (manga)"},{id:17, text:"Alderamin on the Sky"},{id:18, text:"Alexander - Cronache di guerra di Alessandro il Grande"},{id:19, text:"Ali d'argento"},{id:20, text:"Alice 19th"},{id:21, text:"Alice Academy"},{id:22, text:"Alita l'angelo della battaglia"},{id:23, text:"Alita Last Order"},{id:24, text:"Alive (manga)"},{id:25, text:"Alpen Rose"},{id:26, text:"Anatolia Story"},{id:27, text:"Andante (manga)"},{id:28, text:"Angel (fumetto)"},{id:29, text:"Angel Dust (manga)"},{id:30, text:"Angel Heart"},{id:31, text:"Angel Sanctuary"},{id:32, text:"Angelic Layer"},{id:33, text:"Ano Hana"},{id:34, text:"Appleseed"},{id:35, text:"Aqua Knight"},{id:36, text:"Arahabaki"},{id:37, text:"Aria (manga)"},{id:38, text:"Armitage III"},{id:39, text:"Arrivare a te"},{id:40, text:"Assassination Classroom"},{id:41, text:"Assembler OX"},{id:42, text:"Astro Boy"},{id:43, text:"Astrorobot contatto Ypsilon"},{id:44, text:"Attacco! A scuola coi giganti"},{id:45, text:"L'attacco dei giganti"},{id:46, text:"Attacker YOU!"},{id:47, text:"Avanti tutta Coco!"},{id:48, text:"Ayako"},{id:49, text:"Ayashi no Ceres"},{id:50, text:"Azumanga daiō"},{id:51, text:"B.O.D.Y."},{id:52, text:"Bad Company (manga)"},{id:53, text:"Baka to test to shōkanjū"},{id:54, text:"Bakuman."},{id:55, text:"Bakuretsu Hunter"},{id:56, text:"Banana Fish"},{id:57, text:"Baoh"},{id:58, text:"Basilisk: I segreti mortali dei ninja"},{id:59, text:"Bastard!!"},{id:60, text:"Batticuore a mezzanotte - Ransie la strega"},{id:61, text:"Batticuore notturno - Ransie la strega"},{id:62, text:"Battle Athletes daiundōkai"},{id:63, text:"Battle Royale (manga)"},{id:64, text:"Battle Royale II - Blitz Royale"},{id:65, text:"Beck (manga)"},{id:66, text:"Beet the Vandel Buster"},{id:67, text:"Bem il mostro umano"},{id:68, text:"Berserk (manga)"},{id:69, text:"Le bizzarre avventure di JoJo"},{id:70, text:"Black Cat"},{id:71, text:"Black Jack"},{id:72, text:"Black Lagoon"},{id:73, text:"Blame!"},{id:74, text:"Blazer Drive"},{id:75, text:"Bleach (manga)"},{id:76, text:"Blood Lad"},{id:77, text:"Blood Blockade Battlefront"},{id:78, text:"Bloody Monday"},{id:79, text:"Blue Dragon Ral Ω Grad"},{id:80, text:"Bokura ga ita"},{id:81, text:"Boogiepop Phantom"},{id:82, text:"Boys Be"},{id:83, text:"Brave Story"},{id:84, text:"Budda (manga)"},{id:85, text:"Burst Angel"},{id:86, text:"C'era una volta in Giappone"},{id:87, text:"Calm Breaker"},{id:88, text:"Candy Candy"},{id:89, text:"Capitan Harlock"},{id:90, text:"Capitan Tsubasa (manga)"},{id:91, text:"Capitan Tsubasa World Youth"},{id:92, text:"Captain Tsubasa Road to 2002"},{id:93, text:"Captain Tsubasa Golden 23"},{id:94, text:"Captain Tsubasa Rising Sun"},{id:95, text:"Card Captor Sakura"},{id:96, text:"Caro fratello"},{id:97, text:"Cat's Eye"},{id:98, text:"I Cavalieri dello zodiaco"},{id:99, text:"I Cavalieri dello zodiaco - Episode G"},{id:100, text:"I Cavalieri dello zodiaco - The Lost Canvas - Il mito di Ade"},{id:101, text:"Chaos Dragon"},{id:102, text:"Chirality"},{id:103, text:"Chobits"},{id:104, text:"Chonchu"},{id:105, text:"Chrono Crusade"},{id:106, text:"Cinderella Boy"},{id:107, text:"City Hunter"},{id:108, text:"Claymore (manga)"},{id:109, text:"La clinica dell'amore"},{id:110, text:"Code Geass: Lelouch of the Rebellion"},{id:111, text:"Code Geass: Suzaku of the Counterattack"},{id:112, text:"Code Geass: Nightmare of Nunnally"},{id:113, text:"Code Geass: Renya of Darkness"},{id:114, text:"Comet Lucifer"},{id:115, text:"Compiler (manga)"},{id:116, text:"Compiler Returns"},{id:117, text:"La corazzata Yamato"},{id:118, text:"Cosmowarrior Zero"},{id:119, text:"Cowa!"},{id:120, text:"Cowboy Bebop"},{id:121, text:"Crayon Shin-chan"},{id:122, text:"Crusher Joe"},{id:123, text:"Crying Freeman"},{id:124, text:"Il cuneo dell'amore"},{id:125, text:"Cuore di menta"},{id:126, text:"Daitarn 3"},{id:127, text:"Danganronpa"},{id:128, text:"Danguard A"},{id:129, text:"Darker than Black"},{id:130, text:"Dash Kappei"},{id:131, text:"Daydream (manga)"},{id:132, text:"Days"},{id:133, text:"D.C.: Da capo"},{id:134, text:"Deadman (manga)"},{id:135, text:"Death Billiards"},{id:136, text:"Death Note"},{id:137, text:"Death Parade"},{id:138, text:"DearS"},{id:139, text:"Demon City Shinjuku, la città dei mostri"},{id:140, text:"Dengeki! Pikachu"},{id:141, text:"Dennō Coil"},{id:142, text:"Densetsu no yūsha no densetsu"},{id:143, text:"Il destino di Kakugo"},{id:144, text:"Detective Conan"},{id:145, text:"Devilman"},{id:146, text:"Devilman - Time Travellers"},{id:147, text:"D.Gray-man"},{id:148, text:"Digimon Adventure V-Tamer 01"},{id:149, text:"Digimon Chronicle"},{id:150, text:"D-Cyber"},{id:151, text:"Digimon Next"},{id:152, text:"Dimension W"},{id:153, text:"Divine Gate"},{id:154, text:"DNA²"},{id:155, text:"D•N•Angel"},{id:156, text:"Domu - Sogni di bambini"},{id:157, text:"Don Dracula"},{id:158, text:"Doraemon"},{id:159, text:"Dorohedoro"},{id:160, text:"Dororo"},{id:161, text:"Double Arts"},{id:162, text:"Dr. Slump & Arale"},{id:163, text:"Dragon Ball"},{id:164, text:"Dragon Head"},{id:165, text:"Durarara!!"},{id:166, text:"Eat-Man"},{id:167, text:"Elemental Gerad"},{id:168, text:"Elemental Gerad Flag of Blue Sky"},{id:169, text:"Elementalors"},{id:170, text:"Elfen Lied"},{id:171, text:"Erased"},{id:172, text:"I cieli di Escaflowne"},{id:173, text:"ES (manga)"},{id:174, text:"Evangelion: Cronache degli angeli caduti"},{id:175, text:"Evangelion - Detective Shinji Ikari"},{id:176, text:"Evangelion Iron Maiden"},{id:177, text:"Excel Saga"},{id:178, text:"Eyeshield 21"},{id:179, text:"F. Compo"},{id:180, text:"Fairy Cube"},{id:181, text:"Fairy Tail"},{id:182, text:"Fancy Lala"},{id:183, text:"Fake (manga)"},{id:184, text:"FAKE second"},{id:185, text:"Fatal Fury"},{id:186, text:"Fate/stay night"},{id:187, text:"La fenice"},{id:188, text:"Il fiore del sonno profondo"},{id:189, text:"The Five Star Stories"},{id:190, text:"FLCL"},{id:191, text:"Fortified School"},{id:192, text:"Food Wars! Shokugeki no Soma"},{id:193, text:"Un frammento di te"},{id:194, text:"Free Collars Kingdom"},{id:195, text:"Free Soul"},{id:196, text:"Fruits Basket"},{id:197, text:"Fullmetal Alchemist"},{id:198, text:"Full Metal Panic!"},{id:199, text:"Fullmoon - Canto d'amore"},{id:200, text:"Fūka (manga)"},{id:201, text:"Fushigi Yûgi"},{id:202, text:"GALS!"},{id:203, text:"Gantz"},{id:204, text:"L'invincibile Dendoh"},{id:205, text:"Gene-X"},{id:206, text:"Generation Basket"},{id:207, text:"The Gentlemen's Alliance Cross - L'accademia dei misteri"},{id:208, text:"Georgie"},{id:209, text:"Get Backers"},{id:210, text:"Ghost in the Shell (manga)"},{id:211, text:"Ghost in the Shell 1.5: Human-Error Processer"},{id:212, text:"Ghost in the Shell 2: ManMachine Interface"},{id:213, text:"Ginga densetsu Weed"},{id:214, text:"Ginga: Nagareboshi Gin"},{id:215, text:"Ginguiser"},{id:216, text:"Gintama"},{id:217, text:"Il giocattolo dei bambini"},{id:218, text:"God Child"},{id:219, text:"God Eater"},{id:220, text:"Gokujō seitokai"},{id:221, text:"Golden Boy (manga)"},{id:222, text:"Goth (manga)"},{id:223, text:"Gon (manga)"},{id:224, text:"Il grande sogno di Maya"},{id:225, text:"Gravitation"},{id:226, text:"Great Teacher Onizuka"},{id:227, text:"GTO - Shonan 14 Days"},{id:228, text:"Guilty Crown"},{id:229, text:"Gundam Wing"},{id:230, text:"Gunslinger Girl"},{id:231, text:"Guru Guru Pon-chan"},{id:232, text:"Guru Guru - Il girotondo della magia"},{id:233, text:"Guyver (manga)"},{id:234, text:"H2 (manga)"},{id:235, text:"Hanayori Dango"},{id:236, text:"Harlem Beat"},{id:237, text:"Harlock Saga - L'anello dei Nibelunghi"},{id:238, text:"Hatsukoi monster"},{id:239, text:"Hell Girl"},{id:240, text:"Hellsing"},{id:241, text:"HEN (manga)"},{id:242, text:"High School Debut"},{id:243, text:"High School DxD"},{id:244, text:"Higurashi no naku koro ni"},{id:245, text:"Hikaru no go"},{id:246, text:"Himiko-Den"},{id:247, text:"Hitorinoshita - The Outcast"},{id:248, text:"Homunculus (manga)"},{id:249, text:"Honey x Honey Drops"},{id:250, text:"Hoshin Engi"},{id:251, text:"Host Club - Amore in affitto"},{id:252, text:"Hot Gimmick"},{id:253, text:"Hungry Heart"},{id:254, text:"Hunter × Hunter"},{id:255, text:"Hurricane Polimar"},{id:256, text:"I cieli di Escaflowne"},{id:257, text:"Ichi the Killer"},{id:258, text:"Idaten Jump"},{id:259, text:"I s"},{id:260, text:"Ikigami"},{id:261, text:"Il club della magia!"},{id:262, text:"Il guerriero alchemico"},{id:263, text:"Imadoki"},{id:264, text:"L'Immortale (manga)"},{id:265, text:"L'incrociatore stellare Nadesico"},{id:266, text:"Indigo Blue"},{id:267, text:"Inferno e paradiso (manga)"},{id:268, text:"Inuyasha"},{id:269, text:"L'invincibile shogun"},{id:270, text:"Japan (manga)"},{id:271, text:"Jeanne, la ladra del vento divino"},{id:272, text:"Jeeg robot d'acciaio"},{id:273, text:"Jigoku shōjo R"},{id:274, text:"Jiraishin"},{id:275, text:"Junk - Cronache dell'ultimo eroe"},{id:276, text:"Kaiba"},{id:277, text:"Kaito Kid"},{id:278, text:"Kagewani"},{id:279, text:"Kajika"},{id:280, text:"Kamikaze (manga)"},{id:281, text:"Kannazuki no miko"},{id:282, text:"Kanon"},{id:283, text:"Karin (manga)"},{id:284, text:"Karin piccola dea"},{id:285, text:"Kashimashi: Girl Meets Girl"},{id:286, text:"Kaze tachinu (manga)"},{id:287, text:"Keiji il magnifico"},{id:288, text:"Kekkaishi"},{id:289, text:"Ken il guerriero"},{id:290, text:"Ken il guerriero: Le origini del mito"},{id:291, text:"Kenshin Samurai vagabondo"},{id:292, text:"Keroro"},{id:293, text:"Kimba, il leone bianco"},{id:294, text:"Kilari"},{id:295, text:"Kingdom Hearts (manga)"},{id:296, text:"Kingdom Hearts: Chain of Memories (manga)"},{id:297, text:"Kingdom Hearts II (manga)"},{id:298, text:"Kirihito"},{id:299, text:"Kiseiju - L'ospite indesiderato"},{id:300, text:"Knights Of The Apocalypse"},{id:301, text:"Kobato."},{id:302, text:"Kōkō tekken-den Tough"},{id:303, text:"K-On!"},{id:304, text:"Kuroko's Basket"},{id:305, text:"Koudelka"},{id:306, text:"Kurochan"},{id:307, text:"Kyashan il ragazzo androide"},{id:308, text:"La città delle bestie incantatrici"},{id:309, text:"La leggenda di Arslan"},{id:310, text:"Lady Oscar - Le storie gotiche"},{id:311, text:"Lamù"},{id:312, text:"The Last Man"},{id:313, text:"Last Exile"},{id:314, text:"Lawful Drugstore"},{id:315, text:"La legge di Ueki"},{id:316, text:"La legge di Ueki Plus"},{id:317, text:"Lei, l'arma finale"},{id:318, text:"Letter Bee"},{id:319, text:"Le bizzarre avventure di JoJo"},{id:320, text:"Le situazioni di Lui & Lei"},{id:321, text:"Life (manga)"},{id:322, text:"LOST + BRAIN"},{id:323, text:"Love Hina"},{id:324, text:"Love Live!"},{id:325, text:"Love Me Knight - Kiss Me Licia"},{id:326, text:"Love My Life (manga)"},{id:327, text:"Lovely Complex"},{id:328, text:"Lucky Star (manga)"},{id:329, text:"Lui, il diavolo!"},{id:330, text:"Lupin III"},{id:331, text:"Lythtis"},{id:332, text:"Magic Knight Rayearth"},{id:333, text:"Magic Knight Rayearth 2"},{id:334, text:"Il magico viaggio dei Pokémon"},{id:335, text:"Mahoromatic"},{id:336, text:"Maid-sama!"},{id:337, text:"Mai-HiME"},{id:338, text:"Maison Ikkoku - Cara dolce Kyoko"},{id:339, text:"Majin Devil"},{id:340, text:"Mao Dante"},{id:341, text:"Maria-sama ga miteru"},{id:342, text:"Marmalade Boy - Piccoli problemi di cuore"},{id:343, text:"Mars (manga)"},{id:344, text:"Mermaid Melody - Principesse sirene"},{id:345, text:"Meru Puri"},{id:346, text:"Mew Mew - À la mode"},{id:347, text:"Mikami Agenzia Acchiappafantasmi"},{id:348, text:"Mi piaci perché mi piaci"},{id:349, text:"Miracle Girls"},{id:350, text:"Mirai Nikki - Future Diary"},{id:351, text:"Mirmo"},{id:352, text:"Mob Psycho 100"},{id:353, text:"Monochrome Factor"},{id:354, text:"Monogatari (light novel)"},{id:355, text:"Monster (manga)"},{id:356, text:"Monster Hunter Orage"},{id:357, text:"Monster School"},{id:358, text:"Murder Princess"},{id:359, text:"Muyung"},{id:360, text:"MW (manga)"},{id:361, text:"My Hero Academia"},{id:362, text:"My Otome"},{id:363, text:"Nachun"},{id:364, text:"Nana (manga)"},{id:365, text:"Narutaru"},{id:366, text:"Naruto"},{id:367, text:"Nausicaä della Valle del vento (manga)"},{id:368, text:"Negima: Magister Negi Magi"},{id:369, text:"Neon Genesis Evangelion"},{id:370, text:"Neon Genesis Evangelion The Shinji Ikari Raising Project"},{id:371, text:"Non sono un angelo"},{id:372, text:"Noragami"},{id:373, text:"Il nostro gioco"},{id:374, text:"Nui!"},{id:375, text:"Oh, mia dea!"},{id:376, text:"Old Boy (manga)"},{id:377, text:"One Piece"},{id:378, text:"One Punch-Man"},{id:379, text:"One Pound Gospel"},{id:380, text:"Onegai My Melody"},{id:381, text:"Onegai Twins"},{id:382, text:"Orange Road"},{id:383, text:"Orphen"},{id:384, text:"Orpheus (manga)"},{id:385, text:"Outbreak Company"},{id:386, text:"Outlaw Star"},{id:387, text:"Pandora Hearts"},{id:388, text:"Panic x Panic"},{id:389, text:"Paradise Kiss"},{id:390, text:"Parfait Tic!"},{id:391, text:"Partner (manga)"},{id:392, text:"Patlabor (manga)"},{id:393, text:"Perfect Girl Evolution"},{id:394, text:"Petit Eva - Bokura tanken dōkōkai"},{id:395, text:"Petit Eva - Evangelion@School"},{id:396, text:"Piece"},{id:397, text:"Pitaten"},{id:398, text:"Planetarian: chiisana hoshi no yume"},{id:399, text:"Planetes"},{id:400, text:"Plastic Memories"},{id:401, text:"Please Teacher!"},{id:402, text:"Pokémon Adventures"},{id:403, text:"Pokémon Manga"},{id:404, text:"Pokémon Zensho"},{id:405, text:"Potemayo"},{id:406, text:"Pretty Guardian Sailor Moon"},{id:407, text:"Pretty Star - Sognando l'Aurora"},{id:408, text:"Priest (manhwa)"},{id:409, text:"Princess Ai"},{id:410, text:"Princess Princess"},{id:411, text:"Princess Princess +"},{id:412, text:"La principessa Zaffiro"},{id:413, text:"Proteggi la mia terra"},{id:414, text:"Psyren"},{id:415, text:"Pyū to fuku! Jaguar"},{id:416, text:"Pretty Cure"},{id:417, text:"Pretty Cure Max Heart"},{id:418, text:"Pretty Cure Splash Star"},{id:419, text:"Yes! Pretty Cure 5"},{id:420, text:"Yes! Pretty Cure 5 GoGo!"},{id:421, text:"Fresh Pretty Cure!"},{id:422, text:"HeartCatch Pretty Cure!"},{id:423, text:"Suite Pretty Cure"},{id:424, text:"Smile Pretty Cure!"},{id:425, text:"Dokidoki! Pretty Cure"},{id:426, text:"HappinessCharge Pretty Cure!"},{id:427, text:"Go! Princess Pretty Cure"},{id:428, text:"Queen Emeraldas"},{id:429, text:"Random Walk (manga)"},{id:430, text:"Ranma ½"},{id:431, text:"Rash!!"},{id:432, text:"Rave - The Groove Adventure"},{id:433, text:"RahXephon - L'ultimo robot"},{id:434, text:"Re:Zero"},{id:435, text:"Real (manga)"},{id:436, text:"The Record of Fallen Vampire"},{id:437, text:"Record of Lodoss War: La guerra di Pharis"},{id:438, text:"Record of Lodoss War: La storia di Deedlit"},{id:439, text:"Record of Lodoss War: La strega grigia"},{id:440, text:"Record of Lodoss War: Le cronache dell'eroico cavaliere"},{id:441, text:"Red Eyes"},{id:442, text:"RG Veda"},{id:443, text:"Rockin' Heaven - Alla conquista del Paradiso"},{id:444, text:"Rocky Joe"},{id:445, text:"Rosario + Vampire"},{id:446, text:"Rosario + Vampire II"},{id:447, text:"Le rose di Versailles - Le avventure di Lady Oscar"},{id:448, text:"Rough (manga)"},{id:449, text:"Rozen Maiden"},{id:450, text:"Saint Tail"},{id:451, text:"Saiyuki"},{id:452, text:"Saiyuki Gaiden"},{id:453, text:"Saiyuki Reload"},{id:454, text:"Saiyuki Reload Blast"},{id:455, text:"Saiyuki Ibun"},{id:456, text:"Samurai Deeper Kyo"},{id:457, text:"Sanctuary (manga)"},{id:458, text:"Sand Land"},{id:459, text:"Saru Lock"},{id:460, text:"Satoshi to Pikachu"},{id:461, text:"School Rumble"},{id:462, text:"School Rumble Z"},{id:463, text:"School Days"},{id:464, text:"La scoperta dell'amore"},{id:465, text:"Un segreto x 2"},{id:466, text:"Sesame Street (manga)"},{id:467, text:"Sfondamento dei cieli Gurren Lagann"},{id:468, text:"Shadow Lady"},{id:469, text:"Shaman King"},{id:470, text:"Shaman King Flowers"},{id:471, text:"Shamo"},{id:472, text:"Shigatsu wa kimi no uso"},{id:473, text:"Shigurui"},{id:474, text:"Shimūn"},{id:475, text:"Shiroi heya no futari"},{id:476, text:"Shinrei tantei Yakumo"},{id:477, text:"Shinrei tantei Yakumo: Akai hitomi wa shitteiru"},{id:478, text:"Shokugeki no Sōma"},{id:479, text:"Shonan Junai Gumi - La banda dell'amore puro di Shonan"},{id:480, text:"Shugo Chara!"},{id:481, text:"Shugo Chara! Encore!"},{id:482, text:"Shutendoji (manga)"},{id:483, text:"Sidooh"},{id:484, text:"Silent Möbius"},{id:485, text:"Le situazioni di Lui & Lei"},{id:486, text:"Skyhigh"},{id:487, text:"Skyhigh: Karma"},{id:488, text:"Skyhigh: Shinshō"},{id:489, text:"Slam Dunk"},{id:490, text:"Slayers (manga)"},{id:491, text:"Slayers - Le nuove avventure"},{id:492, text:"Slayers: Premium"},{id:493, text:"Slow Step"},{id:494, text:"Soul Eater"},{id:495, text:"La spada di Paros"},{id:496, text:"Special A"},{id:497, text:"Steam Detectives"},{id:498, text:"La stirpe delle tenebre"},{id:499, text:"La storia dei tre Adolf"},{id:500, text:"Strawberry Panic!"},{id:501, text:"Strawberry Shake Sweet"},{id:502, text:"Streghe per amore"},{id:503, text:"Sugar Sugar Rune"},{id:504, text:"Suzuka (manga)"},{id:505, text:"Sweetness & Lightning"},{id:506, text:"Sword Art Online"},{id:507, text:"Tales of Zestiria"},{id:508, text:"Tantei Opera Milky Holmes"},{id:509, text:"Tetsuwan Girl"},{id:510, text:"The World God Only Knows"},{id:511, text:"Toradora!"},{id:512, text:"Toriko"},{id:513, text:"Tokyo Babylon"},{id:514, text:"Tokyo ESP"},{id:515, text:"Tokyo Mew Mew - Amiche vincenti"},{id:516, text:"Toto (manga)"},{id:517, text:"Toto!: The Wonderful Adventure"},{id:518, text:"Touch (manga)"},{id:519, text:"Tough (manga)"},{id:520, text:"To Love-Ru"},{id:521, text:"To Love-Ru Darkness"},{id:522, text:"Trigun"},{id:523, text:"Trigun Maximum"},{id:524, text:"Trinity Blood"},{id:525, text:"Tsubasa RESERVoir CHRoNiCLE"},{id:526, text:"Tsubasa World CHRoNiCLE: Nirai Kanai-hen"},{id:527, text:"Tutor Hitman Reborn!"},{id:528, text:"Twin Princess - Principesse gemelle"},{id:529, text:"Twin Star Exorcists"},{id:530, text:"UFO Baby"},{id:531, text:"UFO Baby! 2 - Le nuove avventure di Lou"},{id:532, text:"Ultimi raggi di luna"},{id:533, text:"Umineko When They Cry"},{id:534, text:"L'uomo che cammina"},{id:535, text:"L'Uomo Tigre"},{id:536, text:"Ushio e Tora"},{id:537, text:"Uta kata"},{id:538, text:"Uta no Prince-sama"},{id:539, text:"Utena la fillette révolutionnaire"},{id:540, text:"Utena la fillette révolutionnaire - Apocalisse adolescenziale"},{id:541, text:"Vagabond"},{id:542, text:"Vampire Knight"},{id:543, text:"Vampire Princess Miyu"},{id:544, text:"Variante"},{id:545, text:"Venus Versus Virus"},{id:546, text:"Video Girl"},{id:547, text:"Video Girl Ai"},{id:548, text:"Video Girl Len"},{id:549, text:"Violence Jack"},{id:550, text:"Virgin Crisis"},{id:551, text:"Wedding Peach"},{id:552, text:"Wild Rock"},{id:553, text:"Wish (manga)"},{id:554, text:"Wolf's Rain"},{id:555, text:"Working!!"},{id:556, text:"Worst - La legge del più forte"},{id:557, text:"Wild Boy - Un amore che viene dalla giungla"},{id:558, text:"X (manga)"},{id:559, text:"XxxHOLiC"},{id:560, text:"XxxHOLiC: Rei"},{id:561, text:"Yankee-kun & Megane-chan - Il teppista e la quattrocchi"},{id:562, text:"Yahari ore no seishun love kome wa machigatteiru"},{id:563, text:"Yokohama kaidashi kikō"},{id:564, text:"Yotsuba &!"},{id:565, text:"Yu degli spettri"},{id:566, text:"Yu-Gi-Oh! (manga)"},{id:567, text:"Yu-Gi-Oh! GX"},{id:568, text:"Yu-Gi-Oh! 5D's"},{id:569, text:"Zatch Bell!"},{id:570, text:"Zero no tsukaima"},{id:571, text:"Zero One"},{id:572, text:"Zetman (2003)"},{id:573, text:"Zetsuai 1989"},{id:574, text:"Zettai kareshi - Assolutamente lui"},{id:575, text:"Zodiac Detective"},{id:576, text:"Zombie Powder"},{id:577, text:"ZOMBIE-LOAN"},{id:578, text:".hack//Legend of the Twilight"},{id:579, text:".hack//SIGN"}];


        $('select').select2({data: array});
      	var type_work = "Manga";
        function changeType(type)
        {
        	type_work=type;
          $("#typeButton").html(type + " <span class=\"caret\">");
          if(type == "Fumetto")
          {
            //$('#title').attr("placeholder", "Inserisci il titolo della serie");
            $('#bg').removeClass("bg_Manga").addClass("bg_Comics");
          }
          else
          {
            //$('#title').attr("placeholder", "Inserisci il titolo del manga");
            $('#bg').removeClass("bg_Comics").addClass("bg_Manga");
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
        		$(".form-group.has-feedback").addClass("has-error");
      		$(".fa.fa-times").removeClass("hidden");
      		//$('#title').attr("placeholder", "Il titolo dell'opera è obbligatorio");
      		$("#title").addClass("animated shake");
      		setTimeout(clear, 3000);
        	}

      	function clear()
      	{
      		$(".form-group.has-feedback").removeClass("has-error");
      		$("#title").removeClass("animated shake");
      		$(".fa.fa-times").addClass("hidden");
      		//if(type_work == "Manga")
      		//	$('#title').attr("placeholder", "Inserisci il titolo del manga");
      		//else
      		//	$('#title').attr("placeholder", "Inserisci il titolo della serie");
      	}

      </script>
    </body>
  </html>