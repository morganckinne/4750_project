<?php
require("connect-db.php");
require("post-db.php");
include("session.php");
include("base.php");

$list_of_posts = getPostsByUserId($_SESSION["login_ID"]);
$list_of_courses = getAllCourses();

?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if (!empty($_POST['btnAction']) && $_POST['btnAction'] =='Filter' && $_POST['formFilter'] >= 0) 
  {
    $list_of_posts = getPostsByCourse($_POST['formFilter']);
  }
  else if (!empty($_POST['btnAction']) && $_POST['btnAction'] =='Clear filters') 
  {
    $list_of_posts = getAllPosts();
  }
  else if (!empty($_POST['btnAction']) && $_POST['btnAction'] =='Delete')
  {
    deletePost($_POST['post_to_delete']);
    $list_of_posts = getPostsByUserId($_SESSION["login_ID"]); 
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
  <title>My Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
</head>

<body>
<div class="container">
  <div class="row">
    <div class="col-8">
      <h1>My Posts</h1>  
    </div>

    <hr/>
  </div>
  <div class="row">
    <div class="col-8">
      <?php foreach($list_of_posts as $post): ?>
        <h3><?= $post['postTitle']; ?></h3>
        <h6><?= $post['courseName']==null ? "No affiliated course" : $post['courseName']; ?>, 
          <?= $post['profFirstName']==null ? "No affiliated professor" : $post['profFirstName'];  ?> <?= $post['profLastName']==null ? "" : $post['profLastName']; ?></h6>
        <p><?= $post['postContent']; ?></p>
        <p><em> Posted by <text><u><?= $post['username']; ?></u></text> at <?= $post['timePosted']; ?></em></p>
        <p><strong>Rating: <?= $post['rating']; ?>/5</strong></p>
        <div class="container">
          <div class="row">
            <div class="col-sm-8">
            </div>
            <div class="col-sm-2 text-end">
              <a class="btn btn-primary" href="/databases/editPostForm.php?id=<?= $post['postID'] ?>">Edit</a> 
            </div>
            <div class="col-sm-2">
              <form name="deleteForm" action="profile.php" method="post">
                <input type="submit" value="Delete" name="btnAction" class="btn btn-danger" 
                      title="Click to delete this post" />
                <input type="hidden" name="post_to_delete" 
                      value="<?php echo $post['postID']; ?>"
                />  
              </form>
            </div>
          </div>  
        </div>
        <hr/>
      <?php endforeach; ?>
    </div>
    <div class="col-4">
      <form name="filterForm" action="profile.php" method="post">
        <select class="form-select" name="formFilter">
          <option value="-1">Filter by course...</option>
          <?php foreach($list_of_courses as $course): ?>
            <option value="<?= $course['courseID']; ?>"> <?= $course['name']; ?> </option>
          <?php endforeach; ?>
        </select>
        <br>
        <input type="submit" value="Filter" name="btnAction" class="btn btn-secondary" title="Filter by course" />
        <input type="submit" value="Clear filters" name="btnAction" class="btn btn-danger" title="Clear courese filter" />
      </form>
    </div>
  </div>
</div>   

</div>    
<br>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<script> document.getElementById("profile").classList.add('active'); </script>

</body>
</html>