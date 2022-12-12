<?php
function addUser($username, $password, $firstName, $lastName, $major, $gradYear)
{
    global $db;
    $pwd = htmlspecialchars($password);
    $hash = password_hash($pwd, PASSWORD_DEFAULT);
    $query = "INSERT INTO User VALUES (:username, :password, :firstName, :lastName, :major, :gradYear)";  
    $result = TRUE;
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':password', $hash);
        $statement->bindValue(':firstName', $firstName);
        $statement->bindValue(':lastName', $lastName);
        $statement->bindValue(':major', $major);
        $statement->bindValue(':gradYear', $gradYear);
        $statement->execute();
        $statement->closeCursor();
    }
    catch (PDOException $e) 
    {
        $result = FALSE;
        if (str_contains($e->getMessage(), 'Duplicate entry \'student\' for key \'PRIMARY\''))
        echo "User create failed. Username already taken.<br/>";
        else if (str_contains($e->getMessage(), "CONSTRAINT_1"))
		    echo "User create failed. Grad Year must be between 2023 and 2026 <br/>";
        else 
            echo "User create failed.<br/>";
        //if ($statement->rowCount() == 0)
        //    echo "Failed to add a friend <br/>";
    }
    catch (Exception $e)
    {
        echo $e->getMessage();
    }
    return $result;
}
