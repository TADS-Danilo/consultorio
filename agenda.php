<?php
include("menu.php");

$conexao = abre_conexao();
$mensagem = "";
$tipo_mensagem = "danger";
$paciente_id = "";
$usuario_id = "";
$data_agendamento = "";
$horario = "";
$observacoes = "";

if(isset($_POST['BtOpc']) && $_POST['BtOpc'] == 'Cancelar') {
    $agendamento_id = filter_var($_POST['agendamento_id'] ?? '', FILTER_VALIDATE_INT, array('options' => array('min_range' => 1)));
    if($agendamento_id === false) {
        $mensagem = "Agendamento inválido.";
    } else {
        $agendamento_id = (int)$agendamento_id;
        $sql = "SELECT * FROM agendamento
                WHERE id = '".$agendamento_id."'
                AND situacao = 'Agendado'
                AND data_agendamento >= CURDATE()";
        $rs = mysqli_query($conexao, $sql);
        if(!$rs) {
            error_log("Erro ao consultar agendamento para cancelamento: " . mysqli_error($conexao));
            $mensagem = "Não foi possível consultar o agendamento.";
        } elseif(mysqli_num_rows($rs) == 0) {
            $mensagem = "O agendamento não existe, já foi cancelado ou já passou.";
        } else {
            $sql = "UPDATE agendamento SET situacao = 'Cancelado'
                    WHERE id = '".$agendamento_id."' AND situacao = 'Agendado'";
            $rs = mysqli_query($conexao, $sql);
            if($rs && mysqli_affected_rows($conexao) > 0) {
                $mensagem = "Agendamento cancelado com sucesso.";
                $tipo_mensagem = "success";
            } else {
                error_log("Erro ao cancelar agendamento: " . mysqli_error($conexao));
                $mensagem = "Não foi possível cancelar o agendamento.";
            }
        }
    }
}

if(isset($_POST['BtOpc']) && $_POST['BtOpc'] == 'Agendar') {
    $paciente_id = filter_var($_POST['paciente_id'] ?? '', FILTER_VALIDATE_INT, array('options' => array('min_range' => 1)));
    $usuario_id = filter_var($_POST['usuario_id'] ?? '', FILTER_VALIDATE_INT, array('options' => array('min_range' => 1)));
    $data_agendamento = trim($_POST['data_agendamento'] ?? '');
    $horario = trim($_POST['horario'] ?? '');
    $observacoes = trim($_POST['observacoes'] ?? '');

    if($paciente_id === false || $usuario_id === false) {
        $mensagem = "Selecione um paciente e um dentista.";
    } elseif(!checkdate((int)substr($data_agendamento, 5, 2), (int)substr($data_agendamento, 8, 2), (int)substr($data_agendamento, 0, 4)) ||
             !preg_match('/^\d{4}-\d{2}-\d{2}$/', $data_agendamento) || $data_agendamento < date('Y-m-d')) {
        $mensagem = "Informe uma data válida, a partir de hoje.";
    } elseif(!preg_match('/^(?:[01][0-9]|2[0-3]):[0-5][0-9]$/', $horario)) {
        $mensagem = "Informe um horário válido.";
    } else {
        $paciente_id = (int)$paciente_id;
        $usuario_id = (int)$usuario_id;
        $data_agendamento_sql = mysqli_real_escape_string($conexao, $data_agendamento);
        $horario_sql = mysqli_real_escape_string($conexao, $horario);
        $observacoes_sql = mysqli_real_escape_string($conexao, $observacoes);

        $sql = "SELECT * FROM paciente WHERE id = '".$paciente_id."'";
        $rs = mysqli_query($conexao, $sql);
        if(!$rs) {
            error_log("Erro ao consultar paciente para agendamento: " . mysqli_error($conexao));
            $mensagem = "Não foi possível validar o paciente selecionado.";
        } elseif(mysqli_num_rows($rs) == 0) {
            $mensagem = "O paciente selecionado não foi encontrado.";
        } else {
            $sql = "SELECT * FROM usuario WHERE id = '".$usuario_id."' AND perfil = 'Dentista'";
            $rs = mysqli_query($conexao, $sql);
            if(!$rs) {
                error_log("Erro ao consultar dentista para agendamento: " . mysqli_error($conexao));
                $mensagem = "Não foi possível validar o dentista selecionado.";
            } elseif(mysqli_num_rows($rs) == 0) {
                $mensagem = "O dentista selecionado não foi encontrado.";
            } else {
                $sql = "SELECT * FROM agendamento
                        WHERE data_agendamento = '".$data_agendamento_sql."'
                        AND horario = '".$horario_sql."'
                        AND situacao = 'Agendado'
                        AND (usuario_id = '".$usuario_id."' OR paciente_id = '".$paciente_id."')";
                $rs = mysqli_query($conexao, $sql);
                if(!$rs) {
                    error_log("Erro ao verificar horário do agendamento: " . mysqli_error($conexao));
                    $mensagem = "Não foi possível verificar a disponibilidade do horário.";
                } elseif(mysqli_num_rows($rs) > 0) {
                    $mensagem = "O dentista ou o paciente já possui um agendamento nesse horário.";
                } else {
                    $sql = "INSERT INTO agendamento(paciente_id, usuario_id, data_agendamento, horario, observacoes, situacao)
                            VALUES('".$paciente_id."', '".$usuario_id."', '".$data_agendamento_sql."', '".$horario_sql."', '".$observacoes_sql."', 'Agendado')";
                    $rs = mysqli_query($conexao, $sql);
                    if($rs) {
                        $mensagem = "Agendamento cadastrado com sucesso.";
                        $tipo_mensagem = "success";
                        $paciente_id = "";
                        $usuario_id = "";
                        $data_agendamento = "";
                        $horario = "";
                        $observacoes = "";
                    } else {
                        error_log("Erro ao cadastrar agendamento: " . mysqli_error($conexao));
                        $mensagem = "Não foi possível cadastrar o agendamento.";
                    }
                }
            }
        }
    }
}

$filtro_data = trim($_GET['data'] ?? '');
$filtro_usuario_id = filter_var($_GET['usuario_id'] ?? '', FILTER_VALIDATE_INT, array('options' => array('min_range' => 1)));
if($filtro_data != '' &&
   (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $filtro_data) ||
   !checkdate((int)substr($filtro_data, 5, 2), (int)substr($filtro_data, 8, 2), (int)substr($filtro_data, 0, 4)))) {
    $filtro_data = "";
    $mensagem = "O filtro de data informado é inválido.";
    $tipo_mensagem = "danger";
}
if($filtro_usuario_id === false) {
    $filtro_usuario_id = "";
}

$sql = "SELECT * FROM paciente ORDER BY nome";
$rs_pacientes = mysqli_query($conexao, $sql);
if(!$rs_pacientes) {
    error_log("Erro ao listar pacientes: " . mysqli_error($conexao));
    $mensagem = "Não foi possível carregar a lista de pacientes.";
}

$sql = "SELECT * FROM usuario WHERE perfil = 'Dentista' ORDER BY nome";
$rs_dentistas = mysqli_query($conexao, $sql);
if(!$rs_dentistas) {
    error_log("Erro ao listar dentistas: " . mysqli_error($conexao));
    $mensagem = "Não foi possível carregar a lista de dentistas.";
}

$sql = "SELECT a.id, a.data_agendamento, a.horario, a.observacoes, a.situacao,
               p.nome AS paciente_nome, p.cpf, u.nome AS dentista_nome
        FROM agendamento a
        INNER JOIN paciente p ON p.id = a.paciente_id
        INNER JOIN usuario u ON u.id = a.usuario_id";
if($filtro_data != '') {
    $filtro_data_sql = mysqli_real_escape_string($conexao, $filtro_data);
    $sql .= " WHERE a.data_agendamento = '".$filtro_data_sql."'";
} else {
    $sql .= " WHERE a.data_agendamento >= CURDATE()";
}
if($filtro_usuario_id != '') {
    $sql .= " AND a.usuario_id = '".(int)$filtro_usuario_id."'";
}
$sql .= " ORDER BY a.data_agendamento, a.horario";
$rs_agendamentos = mysqli_query($conexao, $sql);
if(!$rs_agendamentos) {
    error_log("Erro ao listar agendamentos: " . mysqli_error($conexao));
    $mensagem = "Não foi possível carregar os agendamentos. Verifique se a tabela agendamento foi criada.";
}

echo("  <div class='consultorio-page'>
            <div class='container consultorio-container'>
                <br/>
                <center>
                    <h4>Agenda</h4>
                </center>
                <br/>");

if($mensagem != '') {
    echo("<div class='alert alert-".$tipo_mensagem."'>".$mensagem."</div>");
}

echo("          <form name='form' method='post'>
                    <center>
                        <h5>Agendar consulta</h5>
                    </center>
                    <br/>
                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-1 col-form-label'><font color='red'>*</font>Paciente</label>
                        <div class='col-sm-3'>
                            <select class='form-control' name='paciente_id' required>
                                <option value=''>Selecione um paciente</option>");

if($rs_pacientes) {
    while($paciente = mysqli_fetch_array($rs_pacientes)) {
        echo("                      <option value='".$paciente['id']."' ".((string)$paciente_id === (string)$paciente['id'] ? 'selected' : '').">
                                    ".htmlspecialchars($paciente['nome']." - ".$paciente['cpf'], ENT_QUOTES, 'UTF-8')."
                                </option>");
    }
}

echo("                      </select>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-1 col-form-label'><font color='red'>*</font>Dentista</label>
                        <div class='col-sm-3'>
                            <select class='form-control' name='usuario_id' required>
                                <option value=''>Selecione um dentista</option>");

if($rs_dentistas) {
    mysqli_data_seek($rs_dentistas, 0);
    while($dentista = mysqli_fetch_array($rs_dentistas)) {
        echo("                      <option value='".$dentista['id']."' ".((string)$usuario_id === (string)$dentista['id'] ? 'selected' : '').">
                                    ".htmlspecialchars($dentista['nome'], ENT_QUOTES, 'UTF-8')."
                                </option>");
    }
}

echo("                      </select>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-1 col-form-label'><font color='red'>*</font>Data</label>
                        <div class='col-sm-3'>
                            <input type='date' class='form-control' name='data_agendamento' min='".date('Y-m-d')."' value='".htmlspecialchars($data_agendamento, ENT_QUOTES, 'UTF-8')."' required/>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-1 col-form-label'><font color='red'>*</font>Horário</label>
                        <div class='col-sm-3'>
                            <input type='time' class='form-control' name='horario' value='".htmlspecialchars($horario, ENT_QUOTES, 'UTF-8')."' required/>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-1 col-form-label'>Observações</label>
                        <div class='col-sm-3'>
                            <textarea class='form-control' name='observacoes' rows='3'>".htmlspecialchars($observacoes, ENT_QUOTES, 'UTF-8')."</textarea>
                        </div>
                    </div>
                    <br/>
                    <center>
                        <input type='submit' class='btn btn-primary' value='Agendar' name='BtOpc' />
                        <input type='reset' class='btn btn-light' value='Limpar' />
                    </center>
                </form>
                <br/>
                <hr/>
                <br/>
                <center>
                    <h5>Agendamentos</h5>
                </center>
                <br/>
                <form name='formFiltro' method='get'>
                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-1 col-form-label'>Data</label>
                        <div class='col-sm-2'>
                            <input type='date' class='form-control' name='data' value='".htmlspecialchars($filtro_data, ENT_QUOTES, 'UTF-8')."'/>
                        </div>
                        <label class='col-sm-1 col-form-label'>Dentista</label>
                        <div class='col-sm-2'>
                            <select class='form-control' name='usuario_id'>
                                <option value=''>Todos</option>");

if($rs_dentistas) {
    mysqli_data_seek($rs_dentistas, 0);
    while($dentista = mysqli_fetch_array($rs_dentistas)) {
        echo("                      <option value='".$dentista['id']."' ".((string)$filtro_usuario_id === (string)$dentista['id'] ? 'selected' : '').">
                                    ".htmlspecialchars($dentista['nome'], ENT_QUOTES, 'UTF-8')."
                                </option>");
    }
}

echo("                      </select>
                        </div>
                        <div class='col-sm-2'>
                            <input type='submit' class='btn btn-primary' value='Filtrar'/>
                            <a class='btn btn-light' href='agenda.php'>Limpar</a>
                        </div>
                    </div>
                </form>
                <div class='form-group row'>
                    <div class='col-sm-12'>
                        <table class='table table-sm table-hover'>
                            <tr class='table-primary'>
                                <th>Data</th>
                                <th>Horário</th>
                                <th>Paciente</th>
                                <th>CPF</th>
                                <th>Dentista</th>
                                <th>Observações</th>
                                <th>Situação</th>
                                <th></th>
                            </tr>");

if($rs_agendamentos && mysqli_num_rows($rs_agendamentos) == 0) {
    echo("                  <tr>
                                <td colspan='8' class='alert alert-danger' style='text-align:center'>Nenhum agendamento encontrado</td>
                            </tr>");
}

if($rs_agendamentos) {
    while($agendamento = mysqli_fetch_array($rs_agendamentos)) {
        echo("                  <tr>
                                <td>".date('d/m/Y', strtotime($agendamento['data_agendamento']))."</td>
                                <td>".htmlspecialchars(substr($agendamento['horario'], 0, 5), ENT_QUOTES, 'UTF-8')."</td>
                                <td>".htmlspecialchars($agendamento['paciente_nome'], ENT_QUOTES, 'UTF-8')."</td>
                                <td>".htmlspecialchars($agendamento['cpf'], ENT_QUOTES, 'UTF-8')."</td>
                                <td>".htmlspecialchars($agendamento['dentista_nome'], ENT_QUOTES, 'UTF-8')."</td>
                                <td>".htmlspecialchars($agendamento['observacoes'], ENT_QUOTES, 'UTF-8')."</td>
                                <td>".htmlspecialchars($agendamento['situacao'], ENT_QUOTES, 'UTF-8')."</td>
                                <td>");
        if($agendamento['situacao'] == 'Agendado' && $agendamento['data_agendamento'] >= date('Y-m-d')) {
            echo("                  <form method='post' onsubmit='return confirm(\"Deseja realmente cancelar este agendamento?\")'>
                                        <input type='hidden' name='agendamento_id' value='".$agendamento['id']."' />
                                        <input type='submit' class='btn btn-danger btn-sm' value='Cancelar' name='BtOpc' />
                                    </form>");
        }
        echo("                  </td>
                            </tr>");
    }
}

echo("                  </table>
                    </div>
                </div>
            </div>
        </div>
    </body>");
?>
