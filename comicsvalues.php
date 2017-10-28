<?php
//include 'comicsFileGenerator.php';
	$term = $_GET['q'];
	//$term = "sandman";
	libxml_use_internal_errors(true);
	$json=[];
	
	$list = array();
	$file = fopen("list_comics.txt", "r");
	if ($file)
	{
		while (($line = fgets($file)) !== FALSE)
		{
			if (stripos($line, $term) !== FALSE)
			{
				$list[] = str_replace("\r\n", "", $line);
			}			
		}
		
		fclose($file);
	}
	
	$json = array('results' => []);

	$i = 0;
	foreach($list as $list_link)
	{
		$json["results"][] = ['id'=>$i, 'text'=>$list_link];
		$i++;
	}
		
	echo json_encode($json);
?>