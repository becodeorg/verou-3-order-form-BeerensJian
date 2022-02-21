<?php


// This file is your starting point (= since it's the index)
// It will contain most of the logic, to prevent making a messy mix in the html

// This line makes PHP behave in a more strict way
declare(strict_types=1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// We are going to use session variables so we need to enable sessions
session_start();

// Use this function when you need to need an overview of these variables
function pre_r( $array ) {
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

function whatIsHappening() {
    echo '<h2>$_GET</h2>';
    pre_r($_GET);
    echo '<h2>$_POST</h2>';
    pre_r($_POST);
    echo '<h2>$_COOKIE</h2>';
    pre_r($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    pre_r($_SESSION);
}
whatIsHappening();

// TODO: provide some products (you may overwrite the example)
$products = [
    ['name' => 'Baby Shield', 'price' => 19.99],
    ["name" => 'RedBull 6 pack (sugar free)', 'price' => 6]
];
// print_r($products) ;
// var_dump($products[1]["name"]) ;
$totalValue = 0;
function whatProducts() {
    global $products;
    $productsSelected = "";
    foreach($_POST["products"] as $x => $val) {
        if ($val === "1") {
            $productsSelected .= "- " . $products[$x]['name'] . "<br>" ;
        }
    }
    return $productsSelected;
}

$orderFailed = false;

function validate()
{
    global $orderFailed;
    $orderFailed = true;
    $errorResponse = [];
    // This function will send a list of invalid fields back
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    if (empty($_POST["email"])) {
        $errorResponse[] = "Please fill in an email";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorResponse[] = "Your email isnt in the correct format";
    }
    if (empty($_POST["street"])) {
        $errorResponse[] = "Please fill in a street";
    }
    if (empty($_POST["streetnumber"])) {
        $errorResponse[] = "Please fill in a street number";
    } else if (!is_numeric($_POST["streetnumber"])) {
        $errorResponse[] = "Please fill in a correct street number";
    }
    if (empty($_POST["city"])) {
        $errorResponse[] = "Please fill in a city";
    }
    if (empty($_POST["zipcode"])) {
        $errorResponse[] = "Please fill in a zipcode";
    } else if (!is_numeric($_POST["zipcode"])) {
        $errorResponse[] = "Please fill in a correct zipcode";
    }
    if (!array_key_exists('products', $_POST)) {
        $errorResponse[] = "Select a product before ordering";
    }
    
    return $errorResponse;
}

function handleForm()
{
    // TODO: form related tasks (step 1)

    // Validation (step 2)
    $invalidFields = validate();
    if (!empty($invalidFields)) {
        // TODO: handle errors
        $_SESSION = $_POST;
        $errorMessage = "";
        foreach($invalidFields as $error) {
            $errorMessage .= ($error . "<br>");
        }
        echo '<div class="alert alert-danger" role="alert">' . $errorMessage . '</div>' ;
    } else {
        //TODO: handle successful submission
        $GLOBALS['orderFailed'] = false;
        setcookie("email", $_POST['email'], time() + 3600);
        $succesResponse = "You ordered :<br>" . whatProducts() . "It will be delivered too : <br>" . $_POST['street'] . " " . $_POST['streetnumber'] . " in " . $_POST['zipcode'] . " " . $_POST['city'];
        echo '<div class="alert alert-primary" role="alert">' . $succesResponse . '</div>';
    }
}

function receiveSessionInfo($key) {
    global $orderFailed;
    if (!empty($_SESSION)) {
        if (isset($_SESSION[$key]) && ($orderFailed == true)) {
            echo $_SESSION[$key];
        }
    }
}




require 'form-view.php';