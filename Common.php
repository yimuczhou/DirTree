<?php 


function returnJson( $error = false, $message = '', $data = '') 
{
	echo  json_encode(compact('error', 'message', 'data'));
	exit();
}

?>