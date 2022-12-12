<?php
function createPost($title, $content, $professor, $course, $rating)
{
    //include("session.php");

    global $db; 

    $query1 = "SELECT MAX(postID) FROM Post";  
    $statement1 = $db->prepare($query1);
    $statement1->execute();
    $postID = $statement1->fetch()[0] + 1; 
    $statement1->closeCursor();


    $username = $_SESSION["login_ID"];
    $query2 = "INSERT INTO `Post` ( `postID`, `username`, `postTitle`, `postContent`, `rating`) VALUES (:postID, :username, :title, :content, :rating)";  

    $result2 = TRUE;

    try 
    {
        $statement2 = $db->prepare($query2);

        $statement2->bindValue(':username', $username);
        $statement2->bindValue(':title', $title);
        $statement2->bindValue(':content', $content);
        $statement2->bindValue(':rating', $rating);
        $statement2->bindValue(':postID', $postID);


        $statement2->execute();
        $result2 = $statement2->fetch();

        $statement2->closeCursor();
    } 
    catch (PDOException $e)
    {
         var_dump($result2);
    }


    $result3 = NULL;
    if($professor != "-1")
    {
        $query3 = "INSERT INTO associated_prof VALUES (:postID, :professor)";  
        try 
        {
            $statement3 = $db->prepare($query3);
            $statement3->bindValue(':postID', $postID);
            $statement3->bindValue(':professor', intval($professor) );

            $statement3->execute();

            $result3 = $statement3->fetch(); 

            $statement3->closeCursor();
        } 
        catch (PDOException $e)
        {
            var_dump($result3);
        }
    }

    $result4 = NULL;
    if($course != "-1")
    {
        $query4 = "INSERT INTO associated_course VALUES (:postID, :course)";  
        try 
        {
            $statement4 = $db->prepare($query4);
            $statement4->bindValue(':postID', $postID);
            $statement4->bindValue(':course', intval($course) );

            $statement4->execute();

            $result4 = $statement4->fetch(); 

            $statement4->closeCursor();
        } 
        catch (PDOException $e)
        {
            var_dump($result4);
        }
    }



}
?>
