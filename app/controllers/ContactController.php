<?php

require_once 'app/models/ContactModel.php';

class ContatoController
{
    /* Listar todos contatos */
    public function listarTodos($renderView = true)
    {
        $contatos = Contact::listarTodos();
      
        return $contatos;
    }

    /* Adicionar contato */
    public function adicionar()
    {
        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        $telefone = $_POST['telefone'] ?? '';
        $dataNascimento = $_POST['data_nascimento'] ?? '';

        $resultado = Contact::adicionar($nome, $email, $telefone, $dataNascimento);

        if (
            !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        ) {
            echo json_encode(['status' => $resultado ? 'success' : 'error']);
            exit;
        }

        // Senão, redirecione
        header("Location: /contatos");
        exit;
    }


    /* Editar contato */
    public function editar($id)
    {
        $nome = $_POST['nome'] ?? '';
        $email = $_POST['email'] ?? '';
        $telefone = $_POST['telefone'] ?? '';
        $dataNascimento = $_POST['data_nascimento'] ?? '';
        $dataCadastro = $_POST['data_cadastro'] ?? '';

        $sucesso = Contact::atualizar($id, $nome, $email, $telefone, $dataNascimento, $dataCadastro);

        // Se for via AJAX, devolve JSON e não redireciona
        if (
            !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        ) {
            echo json_encode(['status' => $sucesso ? 'success' : 'error']);
            exit;
        }

        // Senão, redireciona normalmente
        header("Location: /contatos");
        exit;
    }

    /* Excluir */
    public function excluir($id)
    {
        Contact::excluir($id);
    }
}
