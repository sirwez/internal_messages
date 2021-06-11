<?php
namespace Repository;
use Exception;
use InvalidArgumentException;
use Util\ConstantesGenericasUtil;
const PATH = __DIR__ . '\messages.json';

class messagesRepository
{

    private static function verificaMessage()
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
                $tamArray = count($json);
                $retorno = [$json, $tamArray];
                return $retorno;
            }
        }
        catch(Exception $e)
        {
            echo "Exceção capturada: " . $e->getMessage();
        }
    }

    public function send_Message($id, $remetente, $destinatario, $assunto, $corpo, $resposta)
    {
        $responde = self::verificaMessage();
        $responde[0][$responde[1]]["id"] = $id;
        $responde[0][$responde[1]]["remetente"] = $remetente;
        $responde[0][$responde[1]]["destinatario"] = $destinatario;
        $responde[0][$responde[1]]["assunto"] = $assunto;
        $responde[0][$responde[1]]["corpo"] = $corpo;
        $responde[0][$responde[1]]["resposta"] = $resposta;
        // abre o ficheiro em modo de escrita
        $fp = fopen(PATH, 'w');
        // escreve no ficheiro em json
        fwrite($fp, json_encode($responde[0], JSON_PRETTY_PRINT));
        // fecha o ficheiro
        fclose($fp);

        $tam = self::verificaMessage();
        if ($tam[1] > $responde[1])
        {
            $response = array(
                'status' => 1,
                'status_message' => 'Mensagem enviada com sucesso.'
            );
        }
        else
        {
            $response = array(
                'status' => 0,
                'status_message' => 'Falha ao enviar mensagem.'
            );
        }
        header('Content-Type: application/json');
        json_encode($response);

    }

    public function listarMessage($id)
    {
        $allMessages = [];
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
                $json = json_decode($string);
                $cont = 0;
                foreach ($json as $key => $value)
                {
                    if ($id == $value->id)
                    {
                        $allMessages[$cont]['remetente'] = $value->remetente;
                        $allMessages[$cont]['destinatario'] = $value->destinatario;
                        $allMessages[$cont]["assunto"] = $value->assunto;
                        $allMessages[$cont]["corpo"] = $value->corpo;

                        $cont++;
                    }
                }
                if (empty($allMessages))
                {
                    throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERR0_NENHUMA_MSG_ENCONTRADA);
                }
                else
                {
                    return $allMessages;
                }
                // return $retorno;
                
            }
        }
        catch(Exception $e)
        {
            echo "Exceção capturada: " . $e->getMessage();
        }

    }

    public function deleteMessage($id, $destinatario, $assunto, $corpo)
    {
        $allMessages = [];
        try
        {
            $string = file_get_contents(PATH);
            if (!$string)
            {
                throw new Exception(ConstantesGenericasUtil::MSG_ERRO_AO_ABRIR_ARQUIVO);
            }
            else
            {
                $json = json_decode($string);
                $tamAntes = self::verificaMessage();
                $cont = 0;
                foreach ($json as $key => $value)
                {
                    if (($id == $value->id) && $destinatario == $value->destinatario && $assunto == $value->assunto && $corpo == $value->corpo)
                    {
                        unset($allMessages[$cont]);
                        # code...
                        
                    }
                    else
                    {
                        $allMessages[$cont]['id'] = $value->id;
                        $allMessages[$cont]['remetente'] = $value->remetente;
                        $allMessages[$cont]['destinatario'] = $value->destinatario;
                        $allMessages[$cont]["assunto"] = $value->assunto;
                        $allMessages[$cont]["corpo"] = $value->corpo;
                        $allMessages[$cont]["resposta"] = $value->resposta;
                        $cont++;
                    }

                }
                $fp = fopen(PATH, 'w');
                // escreve no ficheiro em json
                fwrite($fp, json_encode($allMessages, JSON_PRETTY_PRINT));
                // fecha o ficheiro
                fclose($fp);
                $tamDepois = self::verificaMessage();
                if (!($tamAntes>$tamDepois))
                {
                     throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERR0_DELETE_MSG);
                }
                else
                {
                    return ConstantesGenericasUtil::MSG_DELETADO_SUCESSO;
                }

            }
        }
        catch(Exception $e)
        {
            echo "Exceção capturada: " . $e->getMessage();
        }
    }

    public function deleteAllMessageById($id)
    {
        $allMessages = [];
        try
        {
            $string = file_get_contents(PATH);
            if (!$string)
            {
                throw new Exception(ConstantesGenericasUtil::MSG_ERRO_AO_ABRIR_ARQUIVO);
            }
            else
            {
                $json = json_decode($string);
                $tamAntes = self::verificaMessage();
                $cont = 0;
                foreach ($json as $key => $value)
                {
                    if (($id == $value->id))
                    {
                        unset($allMessages[$cont]);  
                    }
                    else
                    {
                        $allMessages[$cont]['id'] = $value->id;
                        $allMessages[$cont]['remetente'] = $value->remetente;
                        $allMessages[$cont]['destinatario'] = $value->destinatario;
                        $allMessages[$cont]["assunto"] = $value->assunto;
                        $allMessages[$cont]["corpo"] = $value->corpo;
                        $allMessages[$cont]["resposta"] = $value->resposta;
                        $cont++;
                    }

                }
                $fp = fopen(PATH, 'w');
                // escreve no ficheiro em json
                fwrite($fp, json_encode($allMessages, JSON_PRETTY_PRINT));
                // fecha o ficheiro
                fclose($fp);
                $tamDepois = self::verificaMessage();
                if (!($tamAntes>$tamDepois))
                {
                     throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERR0_DELETE_MSG);
                }
                else
                {
                    return ConstantesGenericasUtil::MSG_DELETADO_SUCESSO;
                }

            }
        }
        catch(Exception $e)
        {
            echo "Exceção capturada: " . $e->getMessage();
        }
    }
}

