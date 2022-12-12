<?php
require("connect-db.php");      // include("connect-db.php");
require("create-user-db.php");

?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['btnAction']) && $_POST['btnAction'] =='Create User') 
  {  
    $result = addUser($_POST['username'], $_POST['password'], $_POST['firstName'], $_POST['lastName'], $_POST['major'], $_POST['gradYear']);  
    if ($result)
    {
      header('Location: /databases/login.php');
      exit();
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">      
  <title>DB interfacing</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
</head>

<body>


<div class="container">
  <h1>Create user Page</h1>  

<form name="createUserForm"  method="post">   
  <div class="row mb-3 mx-3">
    Username:
    <input type="text" class="form-control" name="username" 
    />            
  </div>  
  <div class="row mb-3 mx-3">
    Password:
    <input type="text" class="form-control" name="password" 
    />            
  </div> 
  <div class="row mb-3 mx-3">
    First Name:
    <input type="text" class="form-control" name="firstName" 
    />            
  </div> 
  <div class="row mb-3 mx-3">
    Last Name:
    <input type="text" class="form-control" name="lastName" 
    />            
  </div> 
  <div class="row mb-3 mx-3">
    Major:
    <input type="text" class="form-control" name="major" 
    />            
  </div> 
  <div class="row mb-3 mx-3">
    Graduation Year:
    <input type="text" class="form-control" name="gradYear" 
    />            
  </div> 

  <div>
    <input type="submit" value="Create User" name="btnAction" class="btn btn-dark" 
           title="Login into to UVA course review app" />            
        
  </div> 

</form>   


</div>    
<br>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>