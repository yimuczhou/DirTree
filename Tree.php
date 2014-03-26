<?php 
/**
 * 目录操作
 */


class Tree 
{
	const IS_FOLDER = 'folder';
	const IS_FILE = 'file';

	public $_folderNode = array();

	public  function GetFolders( $dir )
	{	

		$o = dir($dir);
		while ( $f = $o->read() ) {
			$fp = $dir . DIRECTORY_SEPARATOR . $f;
			if ( $f != "." && $f != ".." && $f !=".svn") {
				if (self::ISFolder($fp)) {
					$type = self::IS_FOLDER;
				} else {
					$type = self::IS_FILE;
				}
				$this->_folderNode[] = array(
				'node_type' => $type,
				'node_dir' => $fp,
				'node_name' => $f
				);
			}
			
		}

		$o->close();
		return $this;
	}


	public function CreateNode( $l = 'current' ) 
	{
		if (empty($this->_folderNode)) {
			return false;
		}

		$ulClass = ( $l == 'children') ? 'tree-children' : '';

		$tree = "<ul class='tree-ul ".$ulClass. "'>";
		foreach ($this->_folderNode as $key => $node) {

			$nodeClass = 'tree-file' ; 
			$openIcon = "<i class='tree-nothing'>&nbsp;</i>";
			if ( self::IS_FOLDER == $node['node_type']) {
				$nodeClass = 'tree-folder' ; 
				$openIcon = "<i class='tree-close'>&nbsp;</i>";
			}	
			$coverDiv = "<div class='tree-wholerow '>&nbsp;</div>";
			$tree .= "<li class='tree-node'>".$coverDiv.$openIcon."<a href='javascript:;' class='".$node['node_type']." tree-name' rel='".$node['node_dir']."' ><i class='".$nodeClass."'>&nbsp;</i>".$node['node_name']."</a></li>";
		}
		$tree .= "</ul>";

		return $tree;
	}


	public static function ISFolder($dir)
	{
		if (is_dir($dir)) {
			return true;
		}
		return false;

	}
}

?>