<?php
require_once "config/database.php";

class Contact
{
    /**
     * Lista todos os contatos
     */
    public static function listarTodos()
    {
        $pdo = Database::conectar();
        $stmt = $pdo->query("SELECT * FROM contacts");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca contato por ID
     */
    public static function buscarPorId($id)
    {
        $pdo = Database::conectar();
        $stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Adiciona novo contato
     */
    public static function adicionar($nome, $email, $telefone, $data_nascimento)
    {
        try {
            $pdo = Database::conectar();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO contacts (nome, email, telefone, data_nascimento) 
                VALUES (:nome, :email, :telefone, :data_nascimento)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':data_nascimento', $data_nascimento);
            

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Logue o erro ou exiba para debug
            echo "Erro ao adicionar contato: " . $e->getMessage();
            return false;
        }
    }



    /**
     * Atualiza um contato
     */
    public static function atualizar($id, $nome, $email, $telefone, $data_nascimento, $data_cadastro)
    {
        $pdo = Database::conectar();
        $sql = "UPDATE contacts 
            SET nome = :nome, email = :email, telefone = :telefone, data_nascimento = :data_nascimento, data_cadastro = :data_cadastro
            WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':data_nascimento', $data_nascimento);
        $stmt->bindParam(':data_cadastro', $data_cadastro);

        return $stmt->execute();
    }


    /**
     * Exclui um contato
     */
    public static function excluir($id)
    {
        try {
            $pdo = Database::conectar();
            $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            // Opcional: logar o erro ou exibir mensagem amigável
            error_log("Erro ao excluir contato: " . $e->getMessage());
            return false;
        }
    }
}
