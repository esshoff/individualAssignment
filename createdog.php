<?php
	session_start();
     
    require 'database.php';
	
 $sess_id = "loggedin";
						if($_SESSION["id"]!=$sess_id)
							header("Location: login.php");
						
    if ( !empty($_POST)) {
        // keep track validation errors
        $nameError = null;
        $breedError = null;
        $ageError = null;
        
		 
        // keep track post values
        $dogsname = $_POST['dogsname'];
        $dogsbreed = $_POST['dogsbreed'];
        $dogsage = $_POST['dogsage'];
        
		 
        // validate input
        $valid = true;
        if (empty($dogsname)) {
            $nameError = 'Please enter Name';
            $valid = false;
        }
         
        if (empty($dogsbreed)) {
            $breedError = 'Please enter the dogs breed';
            $valid = false;
        } 
         
        if (empty($dogsage)) {
            $ageError = 'Please enter dogs age';
            $valid = false;
        }
         
        // insert data
        if ($valid) {
            $pdo = Database::connect();
			
						
			
					
					
			
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO dogs (customersid,dogsname,dogsbreed,dogsage) values(?, ?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($_SESSION["customerid"],$dogsname,$dogsbreed,$dogsage));
            Database::disconnect();
            header("Location: dogsindex.php");
        }else { echo 'not valid';}
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Add a Dog</h3>
						
                    </div>
             
                    <form class="form-horizontal" action="createdog.php" method="post">
                      <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                        <label class="control-label">Dog's Name</label>
                        <div class="controls">
                            <input name="dogsname" type="text"  placeholder="Dog's Name" value="<?php echo !empty($dogsname)?$dogsname:'';?>">
                            <?php if (!empty($nameError)): ?>
                                <span class="help-inline"><?php echo $nameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($breedError)?'error':'';?>">
                        <label class="control-label">Dog's Breed</label>
                        <div class="controls">
                            <input name="dogsbreed" type="text" placeholder="Dog's Breed" value="<?php echo !empty($dogsbreed)?$dogsbreed:'';?>">
                            <?php if (!empty($breedError)): ?>
                                <span class="help-inline"><?php echo $breedError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($ageError)?'error':'';?>">
                        <label class="control-label">Dog's Age</label>
                        <div class="controls">
                            <input name="dogsage" type="text"  placeholder="Dog's Age" value="<?php echo !empty($dogsage)?$dogsage:'';?>">
                            <?php if (!empty($ageError)): ?>
                                <span class="help-inline"><?php echo $ageError;?></span>
                            <?php endif;?>
							
                        </div>
                      </div>
					  
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn" href="dogsindex.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>