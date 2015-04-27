<?php
	session_start();
    require 'database.php';
	
	
 $sess_id = "loggedin";
						if($_SESSION["id"]!=$sess_id)
							header("Location: login.php");
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: dogsindex.php");
    }
     
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
            $dogsbreedError = 'Please enter dogs breed';
            $valid = false;
        
        }
         
        if (empty($dogsage)) {
            $dogsageError = 'Please enter dogs age';
            $valid = false;
        }
         
        // update data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE dogs  set dogsname = ?, dogsbreed = ?, dogsage =? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($dogsname,$dogsbreed,$dogsage,$id));
            Database::disconnect();
            header("Location: dogsindex.php");
        }
    } else {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM dogs where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $dogsname = $data['dogsname'];
        $dogsbreed = $data['dogsbreed'];
        $dogsage = $data['dogsage'];
		
		
        Database::disconnect();
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
                        <h3>Update a Dog</h3>
                    </div>
             
                    <form class="form-horizontal" action="updatedog.php?id=<?php echo $id?>" method="post">
                      <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                        <label class="control-label">Dogs Name</label>
                        <div class="controls">
                            <input name="dogsname" type="text"  placeholder="dogsname" value="<?php echo !empty($dogsname)?$dogsname:'';?>">
                            <?php if (!empty($nameError)): ?>
                                <span class="help-inline"><?php echo $nameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($breedError)?'error':'';?>">
                        <label class="control-label">Dogs Breed</label>
                        <div class="controls">
                            <input name="dogsbreed" type="text" placeholder="dogsbreed" value="<?php echo !empty($dogsbreed)?$dogsbreed:'';?>">
                            <?php if (!empty($breedError)): ?>
                                <span class="help-inline"><?php echo $breedError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($ageError)?'error':'';?>">
                        <label class="control-label">Dogs Age</label>
                        <div class="controls">
                            <input name="dogsage" type="text"  placeholder="dogsage" value="<?php echo !empty($dogsage)?$dogsage:'';?>">
                            <?php if (!empty($ageError)): ?>
                                <span class="help-inline"><?php echo $ageError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
					   
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Update</button>
                          <a class="btn" href="dogsindex.php">Back</a>
                        </div>
                    </form>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>
