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
                <h3>People Sharing Their Dogs!! </h3>
            </div>
            <div class="row">
                <p>
                    <a href="createperson.php" class="btn btn-success">Create</a>
                </p>
                <table class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Email Address</th>
                          <th>Mobile Number</th>
						 
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
					  
					  	session_start();
						$sess_id = "loggedin";
						if($_SESSION["id"]!=$sess_id)
							header("Location: login.php");
                       include 'database.php';
                       $pdo = Database::connect();
                       $sql = 'SELECT * FROM customers ORDER BY id DESC';
                       foreach ($pdo->query($sql) as $row) {
                                echo '<tr>';
                                echo '<td>'. $row['name'] . '</td>';
                                echo '<td>'. $row['email'] . '</td>';
                                echo '<td>'. $row['mobile'] . '</td>';
								
                                 echo '<td width=250>';
                                echo '<a class="btn" href="dogsindex.php?id='.$row['id'].'">Select</a>';
                                echo ' ';
                                echo '<a class="btn btn-success" href="updateperson.php?id='.$row['id'].'">Update</a>';
                                echo ' ';
                                echo '<a class="btn btn-danger" href="deleteperson.php?id='.$row['id'].'">Delete</a>';
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