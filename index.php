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

    foreach($_POST["products"] as $x => $val) {
        if ($val === "1") {
            echo "- " . $products[$x]['name'] . "<br>" ;
        }
    }
}

function validate()
{
    // This function will send a list of invalid fields back
    return [];
}

function handleForm()
{
    // TODO: form related tasks (step 1)
     echo "You ordered :<br>";
     echo  whatProducts();
     echo "It will be delivered too : <br>";
     echo $_POST['street'] . " " . $_POST['streetnumber'] . " in " . $_POST['zipcode'] . " " . $_POST['city'];


    // Validation (step 2)
    $invalidFields = validate();
    if (!empty($invalidFields)) {
        // TODO: handle errors
        echo "error";
    } else {
        // TODO: handle successful submission

    }
}

// TODO: replace this if by an actual check

if (!empty($_POST['products'])) {
    handleForm();
}


// $age = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");

// foreach($age as $x => $val) {
//     echo "$x = $val<br>";
// }


require 'form-view.php';