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

function cpf_valido($cpf) {
    $cpf = preg_replace('/\D/', '', $cpf);

    if(strlen($cpf) !== 11) {
        return false;
    }

    for($posicao = 9; $posicao <= 10; $posicao++) {
        $soma = 0;

        for ($i = 0; $i < $posicao; $i++) {
            $peso = $posicao + 1 - $i;
            $soma += (int) $cpf[$i] * $peso;
        }

        $resto = $soma % 11;
        $digitoCalculado = $resto < 2 ? 0 : 11 - $resto;

        if ((int) $cpf[$posicao] !== $digitoCalculado) {
            return false;
        }
    }

    return true;
}

function email_valido($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
?>