<?php
require("connect-db.php"); 
require("post-db.php");
include("session.php");


$list_of_profs = getAllProfs();
$list_of_courses = getAllCourses();

$currentID = $_GET['id'];
$post_to_update = getPostByID($currentID);

?>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['btnAction']) && $_POST['btnAction'] =='Update Post') 
  {
    updatePost($currentID, $_POST['title'], $_POST['content'], $_POST['prof'], $_POST['course'], $_POST['rating']);
    header("Location: /databases/profile.php");
    exit();
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
  <title>Edit Post</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />

</head>

<body>

<text> <?php echo $_SESSION["login_ID"]?> <text>

<div class="container">
  <?php $_SESSION["login_ID"]?>
  <h1>Edit Post</h1>  

<form name="editPostForm" action="editPostForm.php?id=<?= $currentID ?>" method="post">   
  <div class="row mb-3 mx-3">
    <div class="col-8">

      Title:
      <input type="text" class="form-control" name="title" 
        value="<?php if ($post_to_update!=null) echo $post_to_update['postTitle'] ?>"
      />            
      Content: <br>
      <textarea name="content" rows="6" cols="89" wrap="soft"><?php if ($post_to_update!=null) echo $post_to_update['postContent'] ?></textarea>
    </div> 
    <div class="col-4">
      Professor:
        <select class="form-select" name="prof">
          <option value="-1">No Professor Selected...</option>
          <?php foreach($list_of_profs as $prof): ?>
            <option value="<?= $prof['profID']; ?>"> <?= $prof['firstName']; ?> <?= $prof['lastName']; ?> </option>
          <?php endforeach; ?>
        </select>
        <br>
      Courses:
        <select class="form-select" name="course">
          <option value="-1">No Course Selected...</option>
          <?php foreach($list_of_courses as $course): ?>
            <option value="<?= $course['courseID']; ?>"> <?= $course['name']; ?> </option>
          <?php endforeach; ?>
        </select>
        <br>
      Rating:
        <select class="form-select" name="rating" aria-label="One">
          <option value=1>One</option>
          <option value=2>Two</option>
          <option value=3>Three</option>
          <option value=4>Four</option>
          <option value=5>Five</option>
        </select>
        <br>
    </div>

  </div>
  <div class="row mb-3 mx-3">
    <a class="btn btn-danger" href="/databases/profile.php">Cancel</a> 
    <input type="submit" value="Update Post" name="btnAction" class="btn btn-primary" 
          title="Update Post" />     
  </div>


</form>   

</div>    
<br>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>