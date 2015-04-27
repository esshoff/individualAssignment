<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
            <div class="row">
                <h3>Dogs!</h3>
            </div>
            <div class="row">
                <p>
                    <a href=<?php session_start();
					$id = $_GET["id"];
					if(!isset($_GET["id"])) $id = $_SESSION["customerid"];
					$_SESSION["customerid"] = $id;
					
					echo '"createdog.php?id='.$id.'"'?>class="btn btn-success">Add Dog</a>
                </p>
                <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Dog's Name</th>
                          <th>Dog's Breed</th>
                          <th>Dog's Age</th>
						 
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
					  
					  	
						$sess_id = "loggedin";
						if($_SESSION["id"]!=$sess_id)
							header("Location: login.php");
						
						
                       include 'database.php';
                       $pdo = Database::connect();
					  
                      if ( !empty($_GET['id'])) {
							$id = $_REQUEST['id'];
						  
						   if ( !empty($_REQUEST['id'])) {
							$id = $_SESSION['customerid'];
						  }
							}
						//if ( null==$id ) {
						//	header("Location: index.php");
						//}
						
                       $sql = 'SELECT * FROM dogs WHERE customersid = ' . $id . ' ORDER BY id DESC';
                       foreach ($pdo->query($sql) as $row) {
                                echo '<tr>';
                                echo '<td>'. $row['dogsname'] . '</td>';
                                echo '<td>'. $row['dogsbreed'] . '</td>';
                                echo '<td>'. $row['dogsage'] . '</td>';
								
                                 echo '<td width=300>';
                                echo '<a class="btn" href="file_download.php?id='.$row['id'].'">View</a>';
                                echo ' ';
								echo '<a class="btn" href="file_upload.php?id='.$row['id'].'">Upload</a>';
                                echo ' ';
                                echo '<a class="btn btn-success" href="updatedog.php?id='.$row['id'].'">Update</a>';
                                echo ' ';
                                echo '<a class="btn btn-danger" href="deletedog.php?id='.$row['id'].'">Delete</a>';
                                echo '</td>';

                                echo '</tr>';
                       }
                       Database::disconnect();
                      ?>
                      </tbody>
                </table>
        </div>
		
    </div> <!-- /container -->
  </body>
</html>