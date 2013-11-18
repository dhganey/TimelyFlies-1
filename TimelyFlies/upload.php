<?php
  require_once 'header.php';
  $path = "/opt/bitnami/apache2/htdocs/TimelyFlies/";


  if($loggedin)
  {
  	if (isset($_SESSION['user']))
        {
        	$user = sanitizeString($_SESSION['user']);
                $path .= $user . "/";
		echo "<div id='container'><div id='header' class='header'><h1>File Uploader</h1></div>";
		
		echo "<h4>You can use this tool to upload files such as tickets or boarding passes</h4>";
		
		echo "<div id='menu' class='menubar'>";
			echo "<form action='uploader.php' method='post'";
		    		echo "enctype='multipart/form-data'>";
		    		echo "<label for='file'>Filename:</label>";
		    		echo "<input type='file' name='file' id='file'><br>";
		    		echo "<input type='submit' name='submit' value='Upload'>";
	    		echo "</form>";
		echo "</div>";
		
		echo "<div id='flights' class='main'>";
			echo "<h4>Your Files:</h4>";
			echo "List user's files here<br><br/>";
			if ($handle = opendir("$path"))
			{
	        		while (false !== ($entry = readdir($handle)))
	        		{
		            		if ($entry != "." && $entry != "..")
		            		{
		            			$filepath = $path;
		            			$filepath .= $entry;
		                		echo "<a href='$filepath'>$entry</a>";
		                		echo "<br><br/>";
		            		}
				}
	        		closedir($handle);
	   		}
		echo "</div>";
        }
        else
        {
        	echo "Error with user account";
        }

  }
  else
  {
    	die("You are not logged in. Please <a href='login.php'>click here</a> to log in.");

  }
?>
