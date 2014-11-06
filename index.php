<?php
    require 'settings.php';
    require 'Services/Twilio.php';

    $client = new Services_Twilio($accountsid,$authtoken);

if ($_SERVER['REQUEST_METHOD']==='POST') {
	if( isset($_REQUEST['img']) ){
		$filen = 'images/'.uniqid().'.jpg';
		$data = $_REQUEST['img'];
		$image = explode('base64,',$data);
		file_put_contents($filen, base64_decode($image[1]));
		echo $filen;
		if( isset($_REQUEST['PhoneNumber']) ){
			try {
				$client->account->messages->sendMessage($fromnumber, $_REQUEST["PhoneNumber"], "Here's your drawing", $siteurl.'/'.$filen );
			} catch (Exception $e) {
				echo 'Error: ' . $e->getMessage();
			}
		}
	}else{
		echo "bad";
	}
}else{
	include("sketch.php");
}
?>