<?php 
/**
 * 
 */

class Content 
{

	public static function GetContent($dir)
	{
		return file_get_contents($dir);
	}
}


?>