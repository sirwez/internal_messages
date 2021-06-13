<?php
// namespace Service;

// use Repository\messagesRepository;

// class PersonController {

//     private $db;
//     private $requestMethod;
//     private $userId;

//     private $personGateway;

//     public function __construct($requestMethod, $userId, $remetente, $destinatario, $assunto, $corpo)
//     {
//         $this->requestMethod = $requestMethod;
//         $this->userId = $userId;
//         $this->remetente = $remetente;
//         $this->destinatario = $destinatario;
//         $this->assunto = $assunto;
//         $this->corpo = $corpo;

//         $this->messages = new messagesRepository();
//     }

//     public function processRequest()
//     {
//         switch ($this->requestMethod) {
//             case 'GET':
//                 if ($this->userId) {
//                     $response = $this->getUser($this->userId);
//                 } else {
//                     $response = $this->getAllUsers();
//                 };
//                 break;
//             case 'POST':
//                 $response = $this->createUserFromRequest();
//                 break;
//             case 'PUT':
//                 $response = $this->updateUserFromRequest($this->userId);
//                 break;
//             case 'DELETE':
//                 $response = $this->deleteUser($this->userId);
//                 break;
//             default:
//                 $response = $this->notFoundResponse();
//                 break;
//         }
//         header($response['status_code_header']);
//         if ($response['body']) {
//             echo $response['body'];
//         }
//     }
// }