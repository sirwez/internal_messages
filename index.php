<?php
use Data\data;
use Repository\messagesRepository;
use Util\ConstantesGenericasUtil;

include 'bootstrap.php';

$verificar = new data();
$idValid = null;
$idValid = $verificar->verificarUser("weslley", 123);
if ($idValid[0] != null)
{
    echo "\nUsuário: " . $idValid[1]; //debug
    escolha($idValid[1]);
}
else
{
    echo PHP_EOL . ConstantesGenericasUtil::MSG_ERRO_LOGIN_NAO_EXISTE;
}

function escolha($id)
{
    $request_method = $_SERVER["REQUEST_METHOD"];
    switch ('POST')
    {
        case 'GET':

            // if(!empty($_GET[]))
            // // Retrive Products
            // if(!empty($_GET["product_id"])) {
            //     $product_id = intval($_GET["product_id"]);
            //     get_products($product_id);
            // } else {
            //     get_products();
            // }
            
        break;
        case 'POST':
            // Insert Product
            $send = new messagesRepository;
            // $send->send_Message($id[1], "Weslley", "Douglas", "NOVA MSG", "asdasdasd", null);
            $send->deleteAllMessageById($id);
        break;
        case 'PUT':
            // // Update Product
            // $product_id = intval($_GET["product_id"]);
            // update_product($product_id);
            
        break;
        case 'DELETE':
            // // Delete Product
            // $product_id = intval($_GET["product_id"]);
            // delete_product($product_id);
            
        break;
        default:
            // Invalid Request Method
            header("HTTP/1.0 405 Method Not Allowed");
        break;
    }
}

