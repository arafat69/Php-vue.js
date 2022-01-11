<?php 


$conn = new mysqli('localhost','root','','Student');

if ($conn->connect_errno) {
    die('Database COnnect Error!');
}

$response = [
    "error"=>false,
];

$action = 'read';

if (isset($_GET['action'])) {
    $action = $_GET['action'];
}

if ($action==='read') {

    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    $users= [];
    while($row = $result->fetch_assoc()){
      array_push($users,$row);
    }

    $response["user"] = $users;


}elseif($action==="create"){
   
    $name= $_POST['name'];
    $roll= $_POST['roll'];
    $reg= $_POST['reg'];
    $department= $_POST['department'];
    $email= $_POST['email'];

    $result = $conn->query("INSERT INTO `users`(`name`, `roll`, `reg`, `department`, `email`) 
                            VALUES ('$name','$roll','$reg','$department','$email')");
    if ($result) {
        $response["message"] = "Data Save Success!";
    }else{
        $response["error"] = true;
        $response["message"] = "Data Save failed!";
    }
}
elseif($action==="update"){
    $id= $_POST['id'];
    $name= $_POST['name'];
    $roll= $_POST['roll'];
    $reg= $_POST['reg'];
    $department= $_POST['department'];
    $email= $_POST['email'];

    $result = $conn->query("UPDATE `users` SET `name`='$name',`roll`='$roll',`reg`='$reg',`department`='$department',`email`='$email' WHERE id=$id");

    if ($result) {
        $response["message"] = "Data Update Success!";
    }else{
        $response["error"] = true;
        $response["message"] = "Data Update failed!";
    }

}elseif($action==="delete"){
    
    $id= $_POST['id'];

    $result = $conn->query("DELETE FROM `users` WHERE id=$id");

    if ($result) {
        $response["message"] = "Data Delete Success!";
    }else{
        $response["error"] = true;
        $response["message"] = "Data Delete failed!";
    }
}else{
    die('Invelid action!');
}

header('Content-Type: application/json');
echo json_encode($response);








?>