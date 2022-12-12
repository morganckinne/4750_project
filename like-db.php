<?php

function userLikePost($username,$postId) {
    global $db;
    //$username = $_SESSION["login_ID"];
    $query1 = "SELECT * FROM `likes` WHERE `username`= :username AND `postID`= :postId";  

    $result1 = 1;

    $doesUserLike = FALSE;

    try 
    {
        $statement1 = $db->prepare($query1);

        $statement1->bindValue(':username', $username);
        $statement1->bindValue(':postId', intval($postId), \PDO::PARAM_INT);


        $statement1->execute();
        if ($statement1->rowCount() != 0)
        {     
            $doesUserLike = TRUE;
        }
        $result1 = $statement1->fetch();

        $statement1->closeCursor();
    } 
    catch (PDOException $e)
    {
        echo $e;
    }

    if($doesUserLike == FALSE)
    {   
        $query2 = "INSERT INTO `likes` VALUES (:username, :postID)";  

        $result2 = 2;

        try 
        {
            $statement2 = $db->prepare($query2);

            $statement2->bindValue(':postID', $postId);
            $statement2->bindValue(':username', $username);


            $statement2->execute();
            $result2 = $statement2->fetch();

            $statement2->closeCursor();
        } 
        catch (PDOException $e)
        {
            var_dump($result2);
        }
    }
    else if($doesUserLike == TRUE)
    {   
        $query3 = "DELETE FROM `likes` WHERE username = :username AND postID = :postID";  

        $result3 = 3;

        try 
        {
            $statement3 = $db->prepare($query3);

            $statement3->bindValue(':postID', $postId);
            $statement3->bindValue(':username', $username);


            $statement3->execute();
            $result3 = $statement3->fetch();

            $statement3->closeCursor();
        } 
        catch (PDOException $e)
        {
            var_dump($result3);
        }
    }

    return;
}


function getAllLikes($username) {
    global $db;
    //$username = $_SESSION["login_ID"];
    $query1 = "SELECT * FROM `likes` WHERE `username`= :username";  

    $result1 = [];
    $postIDs = [];


    try 
    {
        $statement1 = $db->prepare($query1);
        $statement1->bindValue(':username', $username);

        $statement1->execute();
    
        $result1 = $statement1->fetchAll();

        $statement1->closeCursor();
        //return $result1;
    } 
    catch (PDOException $e)
    {
        echo $e;
    }
    foreach($result1 as $like){
        array_push($postIDs,$like[1]);
    }
    
    return $postIDs;
}


?>