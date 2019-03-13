 <?php
   include 'db.php';

   //connect and initialize DB
   $db = new Database();
   $db_conn = $db->connectToDatabase();

   //determine the type of request received
   $apiRequestType = $_SERVER['REQUEST_METHOD'];

   //act accordingly based on the server request
   switch($apiRequestType)
   {
      case 'GET':
         if(isset($_GET['id']) && $hospital_id = $_GET['id']){
            $resp = get_hospitals($db_conn, $hospital_id);
         }
         else{
            $city = isset($_GET['city']) ? $_GET['city'] : '';
            $resp = get_hospitals($db_conn, null, $city);
         }
         echo json_encode($resp);
         break;
      case 'POST':
         createHospital($db_conn);
         break;
      case 'PUT':
         updateHospital($db_conn);
         break;
      case 'DELETE':
         deleteHospital($db_conn);
         break;
      default:
         print_r("Request Not Supoorted At This Time");
         break;
      break;
   }

   function get_hospitals($db_conn, $id = null, $city = '')
   {
      if($id){
         $sql = "SELECT * FROM hospitals WHERE id ='".$id."'";
      }else if($city){
         $sql = "SELECT * FROM hospitals WHERE city = '".$city."'";
      } else{
         $sql = "SELECT * FROM hospitals";
      }
      if(!($query = $db_conn->query($sql))){
         die("There was an error processing the request: " . $db_conn->error."\n");
      };

      $results = [];
   
      while($row = $query->fetch_assoc()){
         $results[] = $row;
      }

      return $results;
   }

   function createHospital($db_conn){
      $data = json_decode(file_get_contents("php://input"), true);
      if($data){
         if(isset($data['state']) && strlen($data['state']) > 2){
            print_r('Entry was not created: Hospital state has to be specified with a maximum of 2 characters');
            return;
         }
         $sql = <<<SQL
                  INSERT INTO hospitals (name, city, state, address) 
                  VALUES ('{$data["name"]}', '{$data["city"]}', '{$data["state"]}', '{$data["address"]}');
SQL;
   
         if(!($query = $db_conn->query($sql))){
            die("There was an error creating hospital entry: " . $db_conn->error."\n");
         }else{
            print_r("Entry created successfully!");
         }
      }
      return;
   }  

   function updateHospital($db_conn){
      $data = json_decode(file_get_contents("php://input"), true);
      $id = isset($data['id']) ? $data['id'] : null;
      if($data){
         if($id){
            if(isset($data['state']) && strlen($date['state']) > 2){
               print_r('Entry was not created: Hospital state has to be specified with a maximum of 2 characters');
               return;
            }
            $sql = <<<SQL
                     UPDATE hospitals 
                     SET name = '{$data["name"]}', city = '{$data["city"]}', state = '{$data["state"]}', address = '{$data["address"]}'
                     WHERE id = $id;
SQL;
            if(!($query = $db_conn->query($sql))){
               die("There was an error updating hospital entry: " . $db_conn->error."\n");
            }else{
               print_r('Hospital Updated');
            }
         }else{
            print_r('Please provide ID of record to update');
         }
      }
   }

   function deleteHospital($db_conn){
      $data = json_decode(file_get_contents("php://input"), true);
      $id = isset($data['id']) ? $data['id'] : null;
      if($data){
         if($id){
            $sql = <<<SQL
                     DELETE FROM hospitals 
                     WHERE id = $id;
SQL;
            if(!($query = $db_conn->query($sql))){
               die("There was an error deleting hospital entry: " . $db_conn->error."\n");
            }else{
               print_r("Entry {$id} deleted");
            }
         }else{
            print_r('Please provide ID of record to delete');
         }
      }
   }

 ?>
    