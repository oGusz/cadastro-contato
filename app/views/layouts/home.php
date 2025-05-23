<?php
require_once 'header.php';
?>

<div class="container my-4">

    <h2 class="mb-4">Cadastrar Contato</h2>

    <form id="formContato" method="POST" action="">
        <input type="hidden" name="id" value="<?= $contatoEditando['id'] ?? '' ?>">

        <div class="form-group">
            <label for="nome">Nome *</label>
            <input
                type="text"
                id="nome"
                name="nome"
                required
                class="form-control"
                value="<?= $contatoEditando['nome'] ?? '' ?>">
        </div>

        <div class="form-group">
            <label for="email">E-mail *</label>
            <input
                type="email"
                id="email"
                name="email"
                required
                class="form-control"
                value="<?= $contatoEditando['email'] ?? '' ?>">
        </div>

        <div class="form-group">
            <label for="telefone">Telefone *</label>
            <input
                type="tel"
                id="telefone"
                name="telefone"
                required
                class="form-control"
                value="<?= $contatoEditando['telefone'] ?? '' ?>">
        </div>

        <div class="form-group">
            <label for="data_nascimento">Data de nascimento</label>
            <input
                type="text"
                id="data_nascimento"
                name="data_nascimento"
                class="form-control"
                value="<?= isset($contatoEditando['data_nascimento']) ? date('d/m/Y', strtotime($contatoEditando['data_nascimento'])) : '' ?>">

        </div>

        <button type="submit" name="salvar" class="btn btn-primary">Salvar</button>
    </form>







</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

<script>
    $(document).ready(function() {

        /* Mascaras Telefone ou celular / Data de Nascimento */
        
        var behavior = function(val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
        };
        var options = {
            onKeyPress: function(val, e, field, options) {
                field.mask(behavior.apply({}, arguments), options);
            }
        };
        $('#telefone').mask(behavior, options);

        $('#data_nascimento').mask('00/00/0000');


        /* POST */

        $('#formContato').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: '',
                method: 'POST',
                data: $(this).serialize() + '&ajax=1',
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status === 'success') {
                        alert('Contato salvo com sucesso!');
                        window.location.href = '<?= $urlBase ?>contatos';

                    } else {
                        alert('Erro ao salvar contato.');
                    }
                },
                error: function() {
                    alert('Erro ao salvar contato.');
                }
            });
        });


    });
</script>