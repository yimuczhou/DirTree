
<?php

require_once './Tree.php';
require_once './Common.php';
require_once './Content.php';

$defualtRoot = "e:\\e.fangdd.com\Trunk";


$a = isset($_POST['a']) ? trim($_POST['a']) : 'default';
$tree =  new Tree;

if ( 'children' == $a ) {
	$dir = trim($_POST['dir']);
	$folder = $tree->GetFolders($dir)->CreateNode('children');
	returnJson(false, '', $folder);
}

if ( 'content' == $a ) {
	$dir = trim($_POST['dir']);
	$content = Content::GetContent($dir);
	$codeHTML =  '<pre class="brush: php"  style="font-family: consolas;">'.htmlspecialchars($content).'</pre>';
	returnJson(false, '', $codeHTML);
}
// $dd = $tree->GetFolders($defualtRoot)->CreateNode();

?>
<html>
<head>
	<title>目录</title>
	<script type="text/javascript" src="public/js/jquery.js"></script>
	<link rel="stylesheet" type="text/css" href="public/style/main.css">

	<link href="public/syntaxhighlighter/styles/shCore.css" rel="stylesheet" type="text/css" />
	<link href="public/syntaxhighlighter/styles/shThemeDefault.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="public/syntaxhighlighter/scripts/shCore.js"></script>
	<script type="text/javascript" src="public/syntaxhighlighter/scripts/shBrushJScript.js"></script>
	<script type="text/javascript" src="public/syntaxhighlighter/scripts/shBrushPhp.js"></script>
	<script type="text/javascript">
    	// SyntaxHighlighter.all()
    </script>
</head>
<body class="default-skin">

	<!--右边sidebar-->
	<div class="sidebar">
		<?php echo $tree->GetFolders($defualtRoot)->CreateNode()?>
	</div>

	<!--/右边sidebar-->
	<!--主题内容-->
	<div class="content" id="content" >
		<pre class="brush: php">
		</pre>
	</div>
	<!--/主题内容-->
</body>

<script type="text/javascript">
$.fn.coffee = function(obj){
  for(var eName in obj) {
    for(var selector in obj[eName]) {
      $(this).on(eName, selector, obj[eName][selector]);
    }
  }
}

</script>
<script type="text/javascript">

	$(function(){
		//加载完成后，自适应高度左边栏
		sidebarAutoHeight();

		//绑定事件
		$(".sidebar").coffee({
			click:{
				'.folder':function(){
					var $this = $(this);
					var dir = $this.attr('rel');
					var OpenElement = $this.parent('li').find('ul');
					if (OpenElement.length <=0 ) {
						$this.siblings('.tree-wholerow').addClass('tree-clicked');
						$this.siblings('i').removeClass().addClass('tree-open');
						$.post('index.php',{a:'children',dir:dir}, function(ret){
							if ( false === ret.error ) {
								$this.parent('li').append(ret.data);

							}
						},'json');

					} else {
						$this.siblings('.tree-wholerow').removeClass('tree-clicked');
						$this.siblings('i').removeClass().addClass('tree-close');
						OpenElement.remove();
					}
			
				},
				'.file':function(){
					var $this = $(this);
					var dir = $this.attr('rel');
					$("#content").html('');
					$.post('index.php',{a:'content',dir:dir}, function(ret){
						if ( false === ret.error ) {
							$("#content").append(ret.data);
							SyntaxHighlighter.all()
						}
					},'json');
				}
			}
		});

		function sidebarAutoHeight() 
		{
			var winHeight =  window.innerHeight;
			$(".sidebar, .content").css({height:winHeight});
		}
	});
</script>
</html>
