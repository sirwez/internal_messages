<?php
namespace Data;

use Exception;
use InvalidArgumentException;
use Util\ConstantesGenericasUtil;
const PATH = __DIR__ . '\users.json';

class data
{

    public function verificarUser($user, $senha)
    {
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
                $valid = false;

                foreach ($data as $key => $value)
                {
                    if ((($user == $value->nome)) && (($senha == $value->senha)))
                    {
                        $valid = true;
                    }
                }
                if ($valid)
                {
                    echo "<p>$user :'encontrado'</p>";
                }
                else
                {
                    throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_LOGIN_NAO_EXISTE);
                }
            }
        }
        catch(Exception $e)
        {
            echo "Exceção capturada: " . $e->getMessage();
        }

    }
    public function cadastrarUser($user, $senha)
    {

        try
        {
            // extrai a informação do ficheiro
            $string = file_get_contents(PATH);
            if (!$string)
            {
                throw new Exception(ConstantesGenericasUtil::MSG_ERRO_AO_ABRIR_ARQUIVO);
            }
            else
            {
                // faz o decode o json para uma variavel php que fica em array
                $json = json_decode($string, true);
                $valid = false;

                foreach ($json as $key => $value)
                {
                    if (in_array($user, $value))
                    {
                        $valid = true;
                    }
                }
                if ($valid)
                {
                    echo "deu ruim";
                }
                else
                {
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
        }
        catch(Exception $e)
        {
            echo "Exceção capturada: " . $e->getMessage();
        }

    }

}