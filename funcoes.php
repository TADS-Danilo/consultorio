<?php
# abre conexão com servidor MySQL
function abre_conexao() {
    $conexao = mysqli_connect('localhost','consultorio','123456', 'consultorio');
    if (!$conexao) {
        echo "Error: Unable to connect to MySQL." . PHP_EOL;
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    mysqli_set_charset($conexao, 'utf8mb4');
    return $conexao;
}
?>