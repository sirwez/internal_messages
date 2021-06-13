<?php
namespace Data;

use Exception;
use Util\ConstantesGenericasUtil;

const PATH = __DIR__ . '\users.json';
class PersonController
{

    private $requestMethod;
    private $userId;
    private $key;

    public function __construct($requestMethod, $userId, $key)
    {
        $this->requestMethod = $requestMethod;
        $this->userId = $userId;
        $this->key = $key;
    }

    public function processRequest()
    {
        switch ($this->requestMethod)
        {
            case 'GET':
                if ($flag = 1) {
                    if ($this
                    ->users
                    ->isExiste($this->userId))
                {
                    $response = $this->getUser($this->userId, $this->key);
                }
                } else {
                    //msgs
                }

            break;
            case 'POST':
                $response = $this->createUserFromRequest();
            break;
            default:
                $response = $this->notFoundResponse();
            break;
        }
        header($response['status_code_header']);
        if ($response['body'])
        {
            echo $response['body'];
        }
    }
//users
    private function getUser($id, $senha)
    {
        $result = self::verificarUser($id, $senha);
        if ($result==false)
        {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }
    public static function authenticate($val){
        return $val;
    }
    private function createUserFromRequest()
    {
        $input = (array)json_decode(file_get_contents('php://input') , true);
        if (!$this->isExiste($input['nome']))
        {
            return $this->unprocessableEntityResponse();
        }
        self::cadastrarUser($input['nome'], $input['senha']);
        $response['status_code_header'] = 'HTTP/1.1 201 Created';
        $response['body'] = null;
        return $response;
    }

    public static function verificarUser($user, $senha)
    {
        $id = false;
        try
        {
            $json = file_get_contents(PATH);

            if ($json==false)
            {
                throw new Exception(ConstantesGenericasUtil::MSG_ERRO_AO_ABRIR_ARQUIVO);
            }
            else
            {
                $data = json_decode($json);
                $valid = false;
                foreach ($data as $key => $value)
                {
                    if ((($user == $value->nome)) && (($senha == $value->senha)))
                    {
                        $id = $key;
                        $valid = true;
                    }
                }
                self::authenticate($valid);
                $retorno = $id;
                return $retorno;

            }
        }
        catch(Exception $e)
        {
            exit($e->getMessage());
        }

    }
    public function isExiste($user)
    {
        $valid = false;
        try
        {
            $json = file_get_contents(PATH);

            if (!$json)
            {
                throw new Exception(ConstantesGenericasUtil::MSG_ERRO_AO_ABRIR_ARQUIVO);
            }
            else
            {
                $data = json_decode($json);
                foreach ($data as $key => $value)
                {
                    if (($user == $value->nome))
                    {
                        $valid = true;
                    }
                }

                if ($valid)
                {
                    return $valid;
                }
                else
                {
                    return $valid;
                }
            }
        }
        catch(Exception $e)
        {
           $e->getMessage();
        }

    }

    public static function cadastrarUser($user, $senha)
    {
        try
        {
            $string = file_get_contents(PATH);
            if (!$string)
            {
                throw new Exception(ConstantesGenericasUtil::MSG_ERRO_AO_ABRIR_ARQUIVO);
            }
            else
            {
                $json = json_decode($string, true);
                foreach ($json as $key => $value)
                {
                    if (in_array($user, $value))
                    {
                        $valid = true;
                    }
                }
                $tamArray = count($json);
                $json[$tamArray]["nome"] = $user;
                $json[$tamArray]["senha"] = $senha;
                // abre o ficheiro em modo de escrita
                $fp = fopen(PATH, 'w');
                // escreve no ficheiro em json
                fwrite($fp, json_encode($json, JSON_PRETTY_PRINT));
                // fecha o ficheiro
                fclose($fp);

            }
        }
        catch(Exception $e)
        {
            echo "Exceção capturada: " . $e->getMessage();
        }

    }


    //msgs

    //erros
    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 422 Unprocessable Entity';
        $response['body'] = json_encode(['error' => 'Invalid input']);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}

