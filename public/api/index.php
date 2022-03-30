<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use Alvescbjr\API\helpers\UtilsAPI;
use Alvescbjr\API\controller\AplicarValidacaoDeSolicitacao;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri                = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$params             = explode("/", $uri);
$params             = UtilsAPI::removerIndiceComValorVazio($params);
$rota               = (isset($params[1])) ? $params[1] : "";
$idOuPagina         = (isset($params[2])) ? $params[2] : 0;
$paginacao          = (isset($params[3]) && $params[3] === "list") ? true : false;
$metodoHttp         = $_SERVER["REQUEST_METHOD"];
$corpoSolicitacao   = file_get_contents("php://input");

$headers = apache_request_headers();
$headers = array_change_key_case($headers, CASE_LOWER);

$arrValidacao = (new AplicarValidacaoDeSolicitacao())->validarSolicitacao($rota, $headers, $metodoHttp, $corpoSolicitacao, $idOuPagina);

if ($arrValidacao["status"] === false) {
    print json_encode($arrValidacao);
    exit;
}

$rotas      = require __DIR__ . "/config/rotas.php";
$controller = $rotas[$rota];
/** @var ControleDeSolicitacoesAPI */
$controller = new $controller();

switch ($metodoHttp) {
    case "GET":

        if ($paginacao === false) {
            $result = $controller->findOneBy($idOuPagina);
        }

        if ($paginacao) {
            $result = $controller->findBy($idOuPagina);
        }

        http_response_code($result["codigoHttp"]);
        unset($result["codigoHttp"]);
        print json_encode($result);    
    break;
    case "POST":
        $data = json_decode($corpoSolicitacao, true);
        $result = $controller->insert($data);

        http_response_code($result["codigoHttp"]);
        unset($result["codigoHttp"]);
        print json_encode($result);
    break;
    case "PUT":
        $data = json_decode($corpoSolicitacao, true);
        $result = $controller->update($idOuPagina, $data);

        http_response_code($result["codigoHttp"]);
        unset($result["codigoHttp"]);
        print json_encode($result);
    break;
    case "DELETE":
        if ($paginacao === false) {
            $result = $controller->remove($idOuPagina);

            http_response_code($result["codigoHttp"]);
            unset($result["codigoHttp"]);
            print json_encode($result);
        }
    break;
    default:
        http_response_code(405);
        print json_encode("Método da solicitação inválido!");
        exit;
    break;
}