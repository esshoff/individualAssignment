<?php
session_start();

$dogsid = $_GET["id"];
if(!isset($_GET["id"])) $dogsid = $_SESSION["dogsid"];
$_SESSION["dogsid"] = $dogsid;
$dogsid = $_SESSION["dogsid"];

//$_SESSION["dogsid"] = $_GET["id"];
//$dogsid = $_SESSION["dogsid"];
/**
 * Purpose: This file will;
 *          upload a file, saving it to the mysql db
 *x
 * Author:  Kevin Stachowski
 * Date:    11/20/2014
 * Update:  11/20/2014
 * Notes:   image is saved in a blob data type
 * 
 */

//set file upload permissions
ini_set('file-uploads',true);
//turn on errors
error_reporting(e_all);

/** These vars will be part of the global collection.
*  These will need to be changed to your respective DB and table.
*/
define("hostname","localhost");
define("username","CIS355esshoff");
define("password","esshoff");
define("dbname","CIS355esshoff");
define("tableName","gpc_upload");

//check if the form should show or an upload attempted


if(isset($_POST['upload']) && $_FILES['userfile']['size']>0)
{
	
	uploadFile($dogsid);
}
else
{
	
	printForm();
}

 /**
 * Purpose: This will download a file to the mysql database.
 * Pre:     a file to upload has been selected with the form.
 * Post:    file has been downloaded
 */
function uploadFile($dogsid)
{
	//get filename attributes
	$fileName = $_FILES['userfile']['name'];
	$tmpName  = $_FILES['userfile']['tmp_name'];
	$fileSize = $_FILES['userfile']['size'];
	$fileType = $_FILES['userfile']['type'];
	//$id = $_GET['id'];
	//make sure that internal quotes are escaped.
	$fileType=(get_magic_quotes_gpc()==0 ? mysql_real_escape_string(
	
	//this will remove any slashes
	$_FILES['userfile']['type']) : mysql_real_escape_string(
					stripslashes ($_FILES['userfile'])));
	//open the file in read only mode
	$fp = fopen($tmpName, 'r');
	//read the contents of the file
	$content = fread($fp, filesize($tmpName));
	//add slashes
	$content = addslashes($content);
	//show the file attributes to the user
	echo "filename: ".$fileName."<br>";
	echo "filesize: ".$fileSize."<br>";
	echo "filetype: ".$fileType."<br>";
	//close the file
	fclose($fp);
	// if there were any escape chars needed add slashes
		
	if(!get_magic_quotes_gpc())
	{
		$fileName = addslashes($fileName);
	}
		
	//connect to mysql
	$con = mysql_connect(hostname, username, password) or die(mysql_error());
	
	//select the db
	$db = mysql_select_db(dbname, $con);

	if($db){
		
		//the query to execute on the DB
		$query = "INSERT INTO ".tableName." (name, size, type, content, dogsid) ".
			"VALUES ('$fileName', '$fileSize', '$fileType', '$content', '$dogsid')";
		//execute or die
		mysql_query($query) or die('Error, query failed'); 
		//close the connection
		mysql_close();
		echo "<br>File $fileName uploaded<br>";
	}
	else 
	{ 
		echo "file upload failed: ".mysql_error(); 
	}
}

 /**
 * Purpose: This will display the form to the user.
 * Pre:     none
 * Post:    file has been uploaded to the mysql db
 */
function printForm()
{
	
	echo "<html>
<body>
<form method='post' enctype='multipart/form-data'>
<table width='350' border='0' cellpadding='1'
cellspacing='1' class='box'>
<tr>
<td>Please select a file. Please ensure file is under 1MB.</td></tr>
<tr>
<td>
<input type='hidden' name='MAX_FILE_SIZE'
value='16000000'>
<input name='userfile' type='file' id='userfile'> 
</td>
<td width='80'><input name='upload'
type='submit' class='box' id='upload' value=' Upload '></td>
</tr>
</table>
</form>
<br>
<a href='file_download.php'>Download</a><br>
</body>
</html>
<!-- from: http://codereview.stackexchange.com/questions/27796/php-upload-to-database
-->";
}
?>