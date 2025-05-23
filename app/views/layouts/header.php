<?php

include "app/views/layouts/head.php";

?>
<header class="header-mvc bg-primary-color p-3">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary p-0">
            <!-- Logo -->
            <a class="logo navbar-brand" href="<?= $urlBase ?>">
                <figure>
                    <img src="<?= $urlBase ?>imagens/logo.png" alt="Template Shop" width="74" height="42" />
                </figure>
            </a>

            <!-- Botão Hamburguer -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navMenu"
                aria-controls="navMenu" aria-expanded="false" aria-label="Alternar navegação">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Itens do menu -->
            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item <?= ($_SERVER['REQUEST_URI'] == $urlBase ? 'active' : '') ?>">
                        <a class="nav-link" href="<?= $urlBase ?>">Home</a>
                    </li>
                    <li class="nav-item <?= ($_SERVER['REQUEST_URI'] == $urlBase . 'contatos' ? 'active' : '') ?>">
                        <a class="nav-link" href="<?= $urlBase ?>contatos">Contatos</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>