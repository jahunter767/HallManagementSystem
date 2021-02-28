<?php
class Login {
    private $username;
    private $password;

    public function __construct($database){
        $this->database = $database->dataBank();
    }

    public function signIN($username, $password){
        $statement = $this->database->prepare('SELECT * FROM login WHERE username = :username AND password = :password');
        $statement->bindParam(':username', $username, PDO::PARAM_STR, strlen($username));
        $statement->bindParam(':password', $password, PDO::PARAM_STR, strlen($password));
        $statement->execute();
        $usernames = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        $state = FALSE;

        if(empty($username)){
            echo json_encode(
                array(
                    'sess' => session_id(),//should be removed
                    'loggedIn'=> -1,//user not found
                    'message' => "User Not Found"
                )
            ); 
            return FALSE;
        }
        
        foreach($usernames as $username){
            if(isset($username['username'])){
                $this->username = $username['username'];
                echo json_encode(
                    array(
                        'sess' => session_id(),//should be removed
                        'loggedIn'=> 1,//logged in succesfully
                        'message' => file_get_contents('../frontend/confirmation.php')
          
                    )
                ); 
                // echo "<script>alert('Logged in successfully!');</script>";
                $state = TRUE;
                break;
            }
        }

        if(!$state){
            echo json_encode(
                array(
                    'sess' => session_id(),//should be removed
                    'loggedIn'=> 0,//user found but password or user name incorrect
                    'message' => "User name or Password incorrect."
      
                )
            );
            return FALSE;
        } else {
            return TRUE;
        }

        #return $state;
    } #Complete function, returns TRUE if the username and password matches from the database or FALSE if they do not

    public function signInA($username, $password){
        $statement = $this->database->prepare('SELECT username FROM loginA WHERE username = :username AND password = :password');
        $statement->bindParam(':username', $username, PDO::PARAM_STR, strlen($username));
        $statement->bindParam(':password', $password, PDO::PARAM_STR, strlen($password));
        $statement->execute();
        $usernames = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        $state = FALSE;

        if(empty($username)){
            echo json_encode(
                array(
                    'sess' => session_id(),//should be removed
                    'loggedIn'=> -1,//user not found
                    'message' => "User Not Found"
                )
            ); 
            return FALSE;
        }
        
        foreach($usernames as $username){
            if(isset($username['username'])){
                $this->username = $username['username'];
                echo json_encode(
                    array(
                        'sess' => session_id(),//should be removed
                        'loggedIn'=> 1,//logged in succesfully
                        'message' => file_get_contents('../frontend/admin.php')
          
                    )
                ); 
                $state = TRUE;
                break;
            }
        }

        if(!$state){
            echo json_encode(
                array(
                    'sess' => session_id(),//should be removed
                    'loggedIn'=> 0,//user found but password or user name incorrect
                    'message' => "User name or Password incorrect."
      
                )
            );
            return FALSE;
        } else {
            return TRUE;
        }

        #return $state;
    } #Complete function, returns TRUE if the username and password matches from the database or FALSE if they do not

    public function addLogin($username, $password){ #Use admin or resident controller to retrieve the admin or resident object then return the ID number of the object. A resident or admin has to be in the system before registering with a password
        $statement = $this->database->prepare('INSERT INTO login (username, password) VALUES (:username, :password)');
        $statement->bindParam(':username', $username, PDO::PARAM_STR, strlen($username));
        $statement->bindParam(':password', $password, PDO::PARAM_STR, strlen($password));
        $statement->execute();
        echo "<script>alert('Username and password saved!');</script>";
    }
}
?>