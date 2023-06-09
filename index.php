<?php
// Replace with your Firebase project's API key and database URL
$apiKey = "AIzaSyDnOjfqFNLlsNNu-Ot5MUvDpoSnlCc0gPc";
$databaseUrl = "https://order-form-2e781-default-rtdb.firebaseio.com";
$firebaseEndpoint = $databaseUrl . "/orders.json?auth=" . $apiKey;

// Data to be sent to Firebase
$data = array(
    "name" => $_POST["name"],
    "email" => $_POST["email"],
    "phone" => $_POST["phone"],
    "address" => $_POST["address"],
    "transport" => $_POST["transport"],
    "payment" => $_POST["payment"],
    "delivery" => $_POST["delivery"]
);

// Convert data to JSON format
$dataJson = json_encode($data);

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $firebaseEndpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);

// Send HTTP request to Firebase
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
} else {
    echo 'Order placed successfully';
    
    // Send email to owner
    $to = "deliteapparels@gmail.com";
    $subject = "New Order Placed";
    $message = "A new order has been placed:\n\nName: " . $data["name"] . "\nEmail: " . $data["email"] . "\nPhone: " . $data["phone"] . "\nAddress: " . $data["address"] . "\nTransport: " . $data["transport"] . "\nPayment: " . $data["payment"] . "\nDelivery Address: " . $data["delivery"];
    $headers = "From: orderbot@notifier.com\r\n";
    $headers .= "Reply-To: ".$_POST["email"]."\r\n";
    $headers .= "Content-Type: text/plain; charset=utf-8\r\n";
    mail($to, $subject, $message, $headers);
}

// Close cURL session
curl_close($ch);
?>
