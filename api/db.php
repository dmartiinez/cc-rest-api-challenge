<?php 

/**
 * Interacts with the Database
 */
class Database 
{
    //variables needed to establish database connection
    private $hostName = 'db';
    private $userName = 'root';
    private $userPWD = 'root_pwd';
    private $dbName = 'my_db';

    /**
     * Connects to the DB and returns connection
     */
    public function connectToDatabase()
    {
        $db_conn = new mysqli($this->hostName, $this->userName, $this->userPWD, $this->dbName);
        if ($db_conn->connect_errno) {
            die("Could not establish database connection: " . $db_conn->connect_error ."\n");
        }
        $this->initDB($db_conn);
        return $db_conn;
    }

    /**
     * Initializes DB with data
     */
    private function initDB($db_conn)
    {
        $sql = "CREATE TABLE IF NOT EXISTS hospitals (
                    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    name TEXT NOT NULL,
                    city TEXT NOT NULL,
                    state TEXT NOT NULL,
                    address TEXT NOT NULL)";
        
        if(!$db_conn->query($sql)){
            die('There was an error creating the hospitals table: ' . $db_conn->error .'\n');
        }

        //add json data to newly created table 
        $hospitals = file_get_contents('hospitalList.json');
        $hospitals = json_decode($hospitals);

        foreach($hospitals as $hospital){
            $insert_sql = "INSERT INTO hospitals (id, name, city, state, address) VALUES ('" . $hospital->id ."', '". $hospital->name . "', '" . $hospital->city . "', '" . $hospital->state . "', '" .$hospital->address . "') 
                            ON DUPLICATE KEY UPDATE name= '".$hospital->name."', city= '".$hospital->city."', state= '".$hospital->state."', address= '".$hospital->address."'";
            if(!$db_conn->query($insert_sql)){
                die("There was an error creating hospital entry: " . $db_conn->error."\n");
            }
        }
    }
}

        
?>