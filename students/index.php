<?php
    // Set headers to allow cross-origin requests
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Content-Type');
    header('Content-Type: application/json');

    $conn = mysqli_connect("localhost","root","","info_stud_camilla");

    if(!$conn){
        die("Connection Error");
    }

    $query = "select * from students";
    $result = mysqli_query($conn,$query);
    // if(mysqli_num_rows($result) > 0){
    //     while($show = mysqli_fetch_assoc($result)){
    //         echo $show['name'];
    //     }
    // }

    $method = $_SERVER['REQUEST_METHOD'];
    if(mysqli_num_rows($result) > 0){
        while($show = mysqli_fetch_assoc($result)){
            $data[] = $show;
        }
    }else{
        echo "No Record Found!";
    }
    // $data = [
    //     [            
    //         "name" => "Juan Dela Cruz",
    //         "course" => "BEED"
    //     ],
    //     [            
    //         "name" => "Pepito Manaloto",
    //         "course" => "AB PolSci"
    //     ],
    //     [            
    //         "name" => "Renmark Salalila",
    //         "course" => "BSIT"
    //     ]
    // ];


    if($method == "GET") {        
        if(isset($_GET['id'])) {
            if(isset($data[$_GET['id']]))
                echo json_encode($data[$_GET['id']]);
            else
                echo json_encode('No Record Found!');
        }
        else
        if(isset($data)){
            echo json_encode($data);
        }
    }

    if($method == "POST") {
        $temp = urldecode(file_get_contents('php://input'));
        parse_str($temp, $value);

        // $query = "INSERT INTO students (name,course) VALUES ('miss','dash')";
        // $add = mysqli_query($conn,$query);
        // array_push($data, ["name" => $value['name'], "course" => $value['course']]);
        $name = $value['name'];
        $course = $value['course'];
        $query = "INSERT INTO students(name,course) VALUES ('$name','$course')";
        $add = mysqli_query($conn,$query);
        $response = [
            "message" => "Post Success",
            "data" => $data
        ];
        echo json_encode($response);
    }

    if($method == "PUT") {
        $temp = urldecode(file_get_contents('php://input'));
        parse_str($temp, $value);
        
        // array_push($data, ["id" => $value['id'], "name" => $value['name'], "course" => $value['course']]);
        $id = $value['id'];
        $name = $value['name'];
        $course = $value['course'];
        $query = "UPDATE students SET name = '$name', course = '$course' WHERE id = '$id'";
        $update = mysqli_query($conn,$query);

        
        // $data[$_GET['id']]['name'] = $value['name'];
        // $data[$_GET['id']]['course'] = $value['course'];

        $response = [
            "message" => "Put Success",
            "data" => $data
        ];
        echo json_encode($response); 
    }

    if($method == "DELETE") {
        $temp = urldecode(file_get_contents('php://input'));
        parse_str($temp, $value);
        $id = $value['id'];
        $query = "DELETE FROM students WHERE id = '$id'";
        $deletes = mysqli_query($conn,$query);
        $response = [
            "message" => "Delete Success",
            "data" => $data
        ];
        echo json_encode($response);
    }


?>