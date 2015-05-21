<?php

//Check $_POST
if($_SERVER['REQUEST_METHOD'] == "POST"){
    //Get & Sanitize $_POST Values
    $name = strip_tags(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $text = trim($_POST['message']);
    $recipient = $_POST['recipient'];
    $subject = $_POST['subject'];
    
    //Simple Validation
    if(empty($name) || empty($text) || empty($email)){
        //Set a 400(bad request) response code and exit.
        http_response_code(400);
        echo "Please check your form fields";
        exit;
    }
    
    //Build Message
    $message = "Name: $name\n";
    $message .= "Email: $email\n\n";
    $message .= "Message: $text\n";
    
    //Build Headers
    $headers = "From: $name <$email>";
    
    //Send Email
    if(mail($recipient, $subject, $message, $headers)){
        //Set 200 Response(Success)
        http_response_code(200);
        echo "Thank You: Your message has been sent";
    }else{
        //Set 500 Response (internal server error)
        http_response_code(500);
        echo "Error: There was a problem sending your message";
    }
    
}else{
    //Set 403 Response (forbidden)
    http_response_code(403);
    echo "There was a problem with your submission, please try again.";
}


?>