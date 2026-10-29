<?php
session_start();
if(!isset($_SESSION['login'])) {
    header("Location: sem_autorizacao.php");
    exit();
}

include_once("funcoes.php");

header('Content-Type: text/html; charset=utf-8');

echo('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">');
echo('<link href="css/style.css" rel="stylesheet">');
echo('<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>');

echo("  <!DOCTYPE html>
        <html>
            <head>
                <title>Consultório Odontológico</title>
            </head>");

echo("<body>");

echo("  <div class='consultorio-page'>
            <nav class='navbar navbar-consultorio-azul bg-consultorio-azul navbar-expand-lg'>
                <div style='width: 100%'>
                    <div class='container'>
                        <center>
                            <h3 class='bg-consultorio-azul'>Consultório Odontológico</h3>
                        </center>
                    </div>
                </div>
            </nav>");

echo("      <nav class='navbar sticky-top navbar-expand-lg navbar-consultorio-azul bg-consultorio-azul'>
                <div style='width: 100%'>
                    <div class='container'>
                        <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
                            <span class='navbar-toggler-icon'></span>
                        </button>

                        <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                            <ul class='navbar-nav mr-auto'>
                                <li class='nav-item'>
                                    <a class='nav-link' href='inicio.php' >Início</a>
                                </li>
                                <li class='nav-item'>
                                    <a class='nav-link' href='perfis.php' >Perfis</a>
                                </li>
                                <li class='nav-item'>
                                    <a class='nav-link' href='usuarios.php' >Usuários do sistema</a>
                                </li>
                                <li class='nav-item dropdown'>
                                    <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                        Pacientes
                                    </a>
                                    <div class='dropdown-menu bg-consultorio-azul' aria-labelledby='navbarDropdown'>
                                       <a class='dropdown-item' href='pacientes.php' >Pacientes</a>
                                       <a class='dropdown-item' href='relatorio_paciente_aniversariante.php' >Relatório de aniversariantes</a>
                                    </div>
                                </li>
                                <li class='nav-item'>
                                    <a class='nav-link' href='agenda.php' >Agenda</a>
                                </li>
                            </ul>
                            <div class='ms-auto d-flex gap-3'>
                                <a class='nav-link logout-consultorio-azul' href='alterar_senha.php'>Alterar senha</a>
                                <a class='nav-link logout-consultorio-azul' href='encerrar.php'>Encerrar sessão</a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            <br/>");
?>