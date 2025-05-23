<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'app/controllers/ContactController.php';
require_once 'app/models/ContactModel.php';

$controller = new ContatoController();

//Pegando url
$url = $_GET['url'] ?? '';
//Quebrando em partes
$urlParts = explode('/', trim($url, '/'));
//Pegando primeiro pedaço
$rota = $urlParts[0] ?? '';
//Pegando segundo pedaço
$parametro = $urlParts[1] ?? null;

switch ($rota) {
    case '':
    case 'home':
        if (isset($_POST['ajax'])) {
            $salvou = !empty($_POST['id']) ? $controller->editar($_POST['id']) : $controller->adicionar();
            echo json_encode(['status' => $salvou ? 'success' : 'error']);
            exit;
        }

        if (isset($_POST['salvar'])) {
            !empty($_POST['id']) ? $controller->editar($_POST['id']) : $controller->adicionar();
            header('Location: /contatos');
            exit;
        }


        if (isset($_GET['editar'])) {
            $contatoEditando = Contact::buscarPorId($_GET['editar']);
        } else {
            $contatoEditando = null;
        }

        include 'app/views/layouts/home.php';
        break;

    case 'contatos':

        if ($parametro !== null) {
            include 'app/views/layouts/404.php';
            break;
        }

        if (isset($_GET['deletar'])) {
            $controller->excluir($_GET['deletar']);

            if (
                !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
            ) {
                echo json_encode(['status' => 'success']);
                exit;
            }

            header("Location: /contatos");
            exit;
        }

        if (isset($_POST['ajax'])) {
            $salvou = !empty($_POST['id']) ? $controller->editar($_POST['id']) : $controller->adicionar();
            echo json_encode(['status' => $salvou ? 'success' : 'error']);
            exit;
        }

        $contatos = $controller->listarTodos(false);
        include 'app/views/layouts/contatos.php';


        break;

    default:
        include 'app/views/layouts/404.php';
        break;
}

include 'app/views/layouts/footer.php';