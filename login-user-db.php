<?php
function LoginUser($username, $password)
{
    global $db; 
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $query = "SELECT * FROM User WHERE username=:username";
    try 
    {
        $statement = $db->prepare($query);
        $statement->bindValue(':username', $username);

        $statement->execute();
        if ($statement->rowCount() == 0)
        {
            $result = array(
                "login" => FALSE
            );
            echo "Username and password have no match in our records.";
        }
        else
        {
            $result = $statement->fetch(); 
            if (password_verify($password, $result['password']) == true) {
                $result = array_merge($result, array("login" => TRUE));
                $_SESSION['login_ID']=$result['username'];
            }
            else {
                $result = array(
                    "login" => FALSE
                );
                echo "Username and password have no match in our records.";
            }
        }
        $statement->closeCursor();
    } 
    catch (PDOException $e)
    {
         var_dump($result);
    }
    return $result;
}
?>
