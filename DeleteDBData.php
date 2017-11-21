<?php
$conn = new mysqli("localhost", "root", "", "db_mangacards");//database connection

	if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
			}
$queryCancellazioneAmazon="DELETE FROM `amazon` WHERE Creation_Time < (now() - interval 2 DAY)";	
$queryCancellazioneGamestop="DELETE FROM `gamestop` WHERE Creation_Time < (now() - interval 2 DAY)";	
$queryCancellazionePanini="DELETE FROM `panini` WHERE Creation_Time < (now() - interval 2 DAY)";	
$queryCancellazioneJpop="DELETE FROM `jpop` WHERE Creation_Time < (now() - interval 2 DAY)";
$queryCancellazioneRW="DELETE FROM `rwedizioni` WHERE Creation_Time < (now() - interval 2 DAY)";
$queryCancellazioneEpisodiAnime="DELETE FROM `episodi_anime` WHERE Creation_Time < (now() - interval 7 DAY)";
$queryCancellazioneManga="DELETE FROM `manga` WHERE Creation_Time < (now() - interval 7 DAY)";
$queryCancellazioneComics="DELETE FROM `comics` WHERE Creation_Time < (now() - interval 7 DAY)";
$queryCancellazioneVolumiManga="DELETE FROM `volumi_manga` WHERE Creation_Time < (now() - interval 7 DAY)";

if(mysqli_query($conn,$queryCancellazioneAmazon)==FALSE) 
	echo "Query di cancellazione Fallita";
if(mysqli_query($conn,$queryCancellazioneGamestop)==FALSE)
	echo "Query di cancellazione Fallita";
if(mysqli_query($conn,$queryCancellazionePanini)==FALSE)
	echo "Query di cancellazione Fallita";
if(mysqli_query($conn,$queryCancellazioneJpop)==FALSE)
	echo "Query di cancellazione Fallita";
if(mysqli_query($conn,$queryCancellazioneRW)==FALSE)
	echo "Query di cancellazione Fallita";
if(mysqli_query($conn,$queryCancellazioneEpisodiAnime)==FALSE)
	echo "Query di cancellazione Fallita";
if(mysqli_query($conn,$queryCancellazioneManga)==FALSE)
	echo "Query di cancellazione Fallita";
if(mysqli_query($conn,$queryCancellazioneComics)==FALSE)
	echo "Query di cancellazione Fallita";
if(mysqli_query($conn,$queryCancellazioneVolumiManga)==FALSE)
	echo "Query di cancellazione Fallita";

$conn->close();

?>