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

            print json_encode($result);

            if ($result["status"]) {
                http_response_code(200);
                exit;
            }

            http_response_code(404);
            exit;
        }

        $result = $controller->findBy($idOuPagina);

        print json_encode($result);

        if ($result["status"]) {
            http_response_code(200);
            exit;
        }

        http_response_code(404);
        exit;
    
    break;
    case "POST":
        $data = json_decode($corpoSolicitacao, true);
        $result = $controller->insert($data);

        print json_encode($result);

        if ($result["status"]) {
            http_response_code(201);
            exit;
        }

        http_response_code(400);
    break;
    case "PUT":

    break;
    case "DELETE":

    break;
    default:
        http_response_code(405);
        print json_encode("Método da solicitação inválido!");
        exit;
    break;
}