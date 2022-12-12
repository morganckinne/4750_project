<?php

function getAllPosts() {
    global $db;
    $query = "  SELECT e.postId, e.postTitle, e.username, e.postContent, e.timePosted, e.rating, Course.name AS courseName, 
                Professor.firstName AS profFirstName, Professor.lastName AS profLastName FROM 
                    (SELECT Post.postID, Post.postTitle, Post.username, Post.postContent, Post.timePosted, Post.rating, associated_prof.profID, associated_course.courseID
                    FROM Post LEFT JOIN associated_prof ON Post.postID=associated_prof.postID LEFT JOIN associated_course ON Post.postID=associated_course.postID) 
                AS e LEFT JOIN Course ON e.courseID = Course.courseID 
                LEFT JOIN Professor ON e.profID = Professor.profID
                ORDER BY e.timePosted DESC";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}

function getPostsByCourse($courseId) {
    global $db;
    $query = "  SELECT e.postId, e.postTitle, e.username, e.postContent, e.timePosted, e.rating, Course.name AS courseName, 
                Professor.firstName AS profFirstName, Professor.lastName AS profLastName FROM 
                    (SELECT Post.postID, Post.postTitle, Post.username, Post.postContent, Post.timePosted, Post.rating, associated_prof.profID, associated_course.courseID
                    FROM Post LEFT JOIN associated_prof ON Post.postID=associated_prof.postID LEFT JOIN associated_course ON Post.postID=associated_course.postID) 
                AS e LEFT JOIN Course ON e.courseID = Course.courseID 
                LEFT JOIN Professor ON e.profID = Professor.profID
                WHERE Course.courseID = $courseId
                ORDER BY e.timePosted DESC";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}

function getPostsByUserId($username) {
    global $db;
    $query = "  SELECT e.postId, e.postTitle, e.username, e.postContent, e.timePosted, e.rating, Course.name AS courseName, 
                Professor.firstName AS profFirstName, Professor.lastName AS profLastName FROM 
                    (SELECT Post.postID, Post.postTitle, Post.username, Post.postContent, Post.timePosted, Post.rating, associated_prof.profID, associated_course.courseID
                    FROM Post LEFT JOIN associated_prof ON Post.postID=associated_prof.postID LEFT JOIN associated_course ON Post.postID=associated_course.postID 
                    WHERE Post.username = '$username')
                AS e LEFT JOIN Course ON e.courseID = Course.courseID 
                LEFT JOIN Professor ON e.profID = Professor.profID
                ORDER BY e.timePosted DESC";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}

function deletePost($id)
{
    global $db;
    
    // Need to delete associated_course and associated_prof values first (foreign keys)  
    $query1 = "DELETE FROM associated_course WHERE postID=$id";
    $statement = $db->prepare($query1);
    $statement->execute();
    $statement->closeCursor();
    $query2 = "DELETE FROM associated_prof WHERE postID=$id";
    $statement = $db->prepare($query2);
    $statement->execute();
    $statement->closeCursor(); 
    
    // Delete from Post table
    $query3 = "DELETE FROM Post WHERE postID=$id";
    $statement = $db->prepare($query3);
    $statement->execute();
    $statement->closeCursor(); 
}

function getPostByID($id) {
    global $db;
    $query = "  SELECT e.postId, e.postTitle, e.username, e.postContent, e.timePosted, e.rating, Course.name AS courseName, 
                Professor.firstName AS profFirstName, Professor.lastName AS profLastName FROM 
                    (SELECT Post.postID, Post.postTitle, Post.username, Post.postContent, Post.timePosted, Post.rating, associated_prof.profID, associated_course.courseID
                    FROM Post LEFT JOIN associated_prof ON Post.postID=associated_prof.postID LEFT JOIN associated_course ON Post.postID=associated_course.postID 
                    WHERE Post.postID = $id)
                AS e LEFT JOIN Course ON e.courseID = Course.courseID 
                LEFT JOIN Professor ON e.profID = Professor.profID
                ORDER BY e.timePosted DESC";

    try {
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch(); 
        $statement->closeCursor();
    } catch (PDOException $e) {
        if ($statement->rowCount() == 0)
            echo $id . " is not found <br/>";
        else
            var_dump($result);
    }
    return $result;
}

function updatePost($id, $title, $content, $professor, $course, $rating)
{
    // Update Post
    global $db;
    $query = "UPDATE Post SET postTitle=:title, postContent=:content, rating=$rating WHERE postID=$id";
    $statement = $db->prepare($query);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':content', $content);
    $statement->execute();
    $statement->closeCursor();

    // Update associated_prof
    // Check if current record exists
    $count_prof_query = "SELECT * FROM associated_prof WHERE postID=$id";
    $statement2 = $db->prepare($count_prof_query);
    $statement2->execute();
    $result = $statement2->fetchAll();
    $statement2->closeCursor();
    if($statement2->rowCount() == 1) {
        // Current record does exist
        if($professor != -1) {
            // Delete current record and add a new one
            $query3 = "DELETE FROM associated_prof WHERE postID=$id";
            $statement3 = $db->prepare($query3);
            $statement3->execute();
            $statement3->closeCursor();
            $query32 = "INSERT INTO associated_prof VALUES ($id, $professor)";
            $statement32 = $db->prepare($query32);
            $statement32->execute();
            $statement32->closeCursor();
        } else {
            // Delete current record
            $query3 = "DELETE FROM associated_prof WHERE postID=$id";
            $statement3 = $db->prepare($query3);
            $statement3->execute();
            $statement3->closeCursor();
        }
    } else {
        // Current record does not exist
        if ($professor != -1) {
            $query4 = "INSERT INTO associated_prof VALUES ($id, $professor)";
            $statement4 = $db->prepare($query4);
            $statement4->execute();
            $statement4->closeCursor();
        }
    }

    // Update associated_course
    // Check if current record exists
    $count_course_query = "SELECT * FROM associated_course WHERE postID=$id";
    $statement5 = $db->prepare($count_course_query);
    $statement5->execute();
    $result = $statement5->fetchAll();
    $statement5->closeCursor();
    if($statement5->rowCount() == 1) {
        // Current record does exist
        if($course != -1) {
            // Delete current record and add a new one
            $query6 = "DELETE FROM associated_course WHERE postID=$id";
            $statement6 = $db->prepare($query6);
            $statement6->execute();
            $statement6->closeCursor();
            $query62 = "INSERT INTO associated_course VALUES ($id, $course)";
            $statement62 = $db->prepare($query62);
            $statement62->execute();
            $statement62->closeCursor();
        } else {
            // Delete current record
            $query6 = "DELETE FROM associated_course WHERE postID=$id";
            $statement6 = $db->prepare($query6);
            $statement6->execute();
            $statement6->closeCursor();
        }
    } else {
        // Current record does not exist
        if ($course != -1) {
            $query7 = "INSERT INTO associated_course VALUES ($id, $course)";
            $statement7 = $db->prepare($query7);
            $statement7->execute();
            $statement7->closeCursor();
        }
    }    
}

function getAllCourses() {
    global $db;
    $query = "SELECT * FROM Course";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}

function getAllProfs() {
    global $db;
    $query = "SELECT * FROM Professor";
    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}
?>