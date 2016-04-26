<?php
    // returns the relative path from current folder to Web Site Root directory
    function getRootPath() {
        $current_path = pathinfo($_SERVER['SCRIPT_NAME'], PATHINFO_DIRNAME);
        $current_host = pathinfo($_SERVER['REMOTE_ADDR'], PATHINFO_BASENAME);
        $the_depth = substr_count( $current_path , '/');
		$pathtoroot = "";
		
		// echo "depth: ".$the_depth."<br/>";
		// echo "current: ".$current_path."<br/>";
		// echo "host: ".$current_host."<br/>";
		// echo "strpos: ".strpos($current_path,"projects")."<br/>";

        // Set path to root for includes to access from anywhere
        if(strpos($current_path,"projects")>0) {
			$pathtoroot = str_repeat('../', $the_depth-2); // handles wamp
			// echo "wamp: ".$pathtoroot;
		}
        elseif($current_host == '127.0.0.1') {
			$pathtoroot = str_repeat('../' , $the_depth-1); // handles phpstorm and others
			// echo "localhost: ".$pathtoroot;
		}
        else $pathtoroot = str_repeat ('../' , $the_depth); // online
        return $pathtoroot;
    }

    function getGeshiPath() {
        return "includes/geshi/geshi";
    }
	
	function buildModalContentFromDirectory($directory) {
		$index = 1;
		foreach (array_filter(glob(getRootPath().$directory), 'is_file') as $file) {
			buildModalContentFromFile($file, $index++);
		}
	}
	
	function buildModalContentFromFile($file, $index) {
		echo "<section class=\"semantic-content\" id=\"".basename($file, ".php")."\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"modal_".$index."\" aria-hidden=\"true\">";
		echo "<div class=\"modal-inner\">";
		echo "<header id=\"modal-".$index."\"><h2>".str_replace('_',' ', basename($file, ".php"))."</h2></header>";
		echo "<div class=\"modal-content\">";
		include $file;
		echo "</div></div>";
		echo "<a href=\"#!\" class=\"modal-close\" title=\"Close\" data-close=\"Close\" data-dismiss=\"modal\">×</a>";
		echo "</section>";
	}
	
	function buildUnorderedListFromDirectory($directory) {
		$index = 1;
		foreach (array_filter(glob(getRootPath().$directory), 'is_file') as $file) {
			echo "<li><a href=\"#".basename($file, ".php")."\">".str_replace('_',' ', basename($file, ".php"))."</a></li>";
			$index++;
		}
	}
?>