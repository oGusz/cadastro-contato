<?php
require_once 'header.php';
?>
<div class="container my-4">
    <h2 class="mb-4">Lista de Contatos</h2>

    <form method="GET" action="" class="form-inline mb-3">
        <input
            type="text"
            name="busca"
            placeholder="Buscar por nome ou email"
            value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>"
            class="form-control mr-2 mb-2 mb-sm-0"
            style="min-width: 250px;">

        <select name="ordenar" class="form-control mr-2 mb-2 mb-sm-0">
            <option value="">Ordenar por</option>
            <option value="nome">Nome</option>
            <option value="data_cadastro">Data de Cadastro</option>
        </select>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Telefone</th>
                    <th>Data de nascimento</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($contatos)): ?>
                    <?php foreach ($contatos as $contato): ?>
                        <tr data-id="<?= $contato['id'] ?>" data-cadastro="<?= $contato['data_cadastro'] ?>">
                            <td><?= $contato['id'] ?></td>
                            <td class="nome"><?= htmlspecialchars($contato['nome']) ?></td>
                            <td class="email"><?= htmlspecialchars($contato['email']) ?></td>
                            <td class="telefone"><?= htmlspecialchars($contato['telefone']) ?></td>
                            <td class="data_nascimento"><?= $contato['data_nascimento'] ? date('d/m/Y', strtotime($contato['data_nascimento'])) : '-' ?></td>

                            <td class="d-flex align-items-center justify-content-center ">
                                <button type="button" class="btn btn-sm btn-info btn-edit mr-2">Editar</button>

                                <a
                                    href="<?= $urlBase ?>contatos?deletar=<?= $contato['id'] ?>"
                                    class="btn btn-sm btn-danger">Deletar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Nenhum contato encontrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<script>
    function formatDateToISO(dateBR) {
        if (!dateBR) return '';
        const parts = dateBR.split('/');
        if (parts.length !== 3) return '';
        return `${parts[2]}-${parts[1].padStart(2, '0')}-${parts[0].padStart(2, '0')}`;
    }

    function formatDateToBR(dateISO) {
        if (!dateISO) return '';
        const d = new Date(dateISO);
        if (isNaN(d)) return '';
        return d.toLocaleDateString('pt-BR');
    }

    $(document).ready(function() {

        var urlBase = "<?= $urlBase ?>";



        // Delegação para excluir contato

        $(document).on('click', '.btn-danger', function(e) {
            e.preventDefault();

            if (!confirm('Deseja realmente excluir o contato?')) return;

            var url = $(this).attr('href');

            $.get(url, function(response) {
                try {
                    var json = JSON.parse(response);
                    if (json.status === 'success') {
                        alert('Contato excluído com sucesso!');
                        location.reload();
                    } else {
                        alert('Erro ao excluir contato.');
                    }
                } catch (e) {
                    alert('Erro inesperado ao excluir contato.');
                    console.error('Erro no JSON:', response, e);
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                alert('Erro ao excluir contato.');
                console.error('Erro AJAX:', textStatus, errorThrown);
            });
        });

        // Delegação para editar contato

        $(document).on('click', '.btn-edit', function(e) {
            e.preventDefault();

            if ($('tr.editing').length) {
                alert('Finalize a edição atual primeiro.');
                return;
            }

            var $btn = $(this);
            var $tr = $btn.closest('tr');
            $tr.addClass('editing');

            // Salva valores originais para cancelar depois

            $tr.data('original', {
                nome: $tr.find('.nome').text(),
                email: $tr.find('.email').text(),
                telefone: $tr.find('.telefone').text(),
                data_nascimento: $tr.find('.data_nascimento').text(),
                acoes: $tr.find('td:last').html()
            });

            // Troca as células da coluna por inputs

            var nome = $tr.data('original').nome;
            var email = $tr.data('original').email;
            var telefone = $tr.data('original').telefone;
            var nascimento = $tr.data('original').data_nascimento;

            $tr.find('.nome').html('<input type="text" class="form-control input-nome" value="' + nome + '">');
            $tr.find('.email').html('<input type="email" class="form-control input-email" value="' + email + '">');
            $tr.find('.telefone').html('<input type="text" class="form-control input-telefone" value="' + telefone + '">');
            $tr.find('.data_nascimento').html('<input type="date" class="form-control input-nascimento" value="' + formatDateToISO(nascimento) + '">');

            $tr.find('td:last').html(
                '<button class="btn btn-sm btn-success btn-save mr-2">Salvar</button> ' +
                '<button class="btn btn-sm btn-secondary btn-cancel">Cancelar</button>'
            );
        });

        // Cancelar edição

        $(document).on('click', '.btn-cancel', function() {
            var $tr = $(this).closest('tr');
            var original = $tr.data('original');

            if (!original) return;

            $tr.find('.nome').text(original.nome);
            $tr.find('.email').text(original.email);
            $tr.find('.telefone').text(original.telefone);
            $tr.find('.data_nascimento').text(original.data_nascimento);
            $tr.find('td:last').html(original.acoes);

            $tr.removeClass('editing');
            $tr.removeData('original');
        });

        // Salvar edição

        $(document).on('click', '.btn-save', function() {
            var $tr = $(this).closest('tr');
            var id = $tr.data('id');
            var nome = $tr.find('.input-nome').val().trim();
            var email = $tr.find('.input-email').val().trim();
            var telefone = $tr.find('.input-telefone').val().trim();
            var nascimento = $tr.find('.input-nascimento').val();

            if (!nome || !email) {
                alert('Nome e Email são obrigatórios.');
                return;
            }

            $.ajax({
                url: '<?= $urlBase ?>contatos',
                method: 'POST',
                data: {
                    ajax: true,
                    id: id,
                    nome: nome,
                    email: email,
                    telefone: telefone,
                    data_nascimento: nascimento
                },
                success: function(response) {
                    try {
                        var json = JSON.parse(response);
                        if (json.status === 'success') {
                            alert('Contato atualizado com sucesso!');

                         
                            $tr.find('.nome').text(nome);
                            $tr.find('.email').text(email);
                            $tr.find('.telefone').text(telefone);
                            $tr.find('.data_nascimento').text(formatDateToBR(nascimento));

                           
                            $tr.find('td:last').html(
                                '<button type="button" class="btn btn-sm btn-info btn-edit mr-2">Editar</button> ' +
                                '<a href="' + urlBase + 'contatos?deletar=' + id + '" class="btn btn-sm btn-danger">Deletar</a>'
                            );

                            $tr.removeClass('editing');
                            $tr.removeData('original');
                        } else {
                            alert('Erro ao atualizar contato.');
                        }
                    } catch (e) {
                        alert('Erro inesperado.');
                        console.error('Resposta:', response, e);
                    }
                },
                error: function() {
                    alert('Erro na requisição.');
                }
            });
        });


        // Filtro dinâmico por nome ou e-mail

        $('input[name="busca"]').on('input', function() {
            var valorBusca = $(this).val().toLowerCase().trim();

            $('table tbody tr').each(function() {
                var nome = $(this).find('.nome').text().toLowerCase();
                var email = $(this).find('.email').text().toLowerCase();

                if (nome.includes(valorBusca) || email.includes(valorBusca)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Ordenar por nome ou data de cadastro

        $('select[name="ordenar"]').on('change', function() {
            var criterio = $(this).val();
            var $rows = $('table tbody tr');

            var rowsArray = $rows.get();

            rowsArray.sort(function(a, b) {
                if (criterio === 'nome') {
                    var nomeA = $(a).find('.nome').text().toLowerCase();
                    var nomeB = $(b).find('.nome').text().toLowerCase();
                    return nomeA.localeCompare(nomeB);
                } else if (criterio === 'data_cadastro') {
                    var dataA = new Date($(a).data('cadastro'));
                    var dataB = new Date($(b).data('cadastro'));
                    return dataA - dataB;
                }
            });

            // Reinsere as linhas ordenadas no tbody
            
            $.each(rowsArray, function(index, row) {
                $('table tbody').append(row);
            });
        });

    });
</script>