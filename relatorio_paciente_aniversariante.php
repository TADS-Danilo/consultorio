<?php
include("menu.php");

$conexao = abre_conexao();
$disabled_alterar_ou_excluir = false;
$titulo = "Cadastrar paciente";

if(isset($_POST['BtOpc']) && $_POST['BtOpc'] == 'Cadastrar') {
    $nome = $_POST['nome'].trim();
    $cpf = $_POST['cpf'].trim();
    $data_nascimento = $_POST['data_nascimento'].trim();
    $sexo = $_POST['sexo'].trim();
    $email = $_POST['email'].trim();
    $telefone = $_POST['telefone'].trim();
    $celular = $_POST['celular'].trim();

    //verifica se já existe o paciente
    $sql = "SELECT * FROM paciente WHERE cpf = '".$cpf."'";
    $rs = mysqli_query($conexao, $sql);
    if(mysqli_num_rows($rs) > 0) {
        echo("<div class='alert alert-danger'>Já existe um paciente cadastrado com este CPF</div>");
    } else {
        $sql = "INSERT INTO paciente(nome, cpf, data_nascimento, sexo, email, telefone, celular)
            VALUES('".$nome."', '".$cpf."', '".$data_nascimento."', '".$sexo."', '".$email."', '".$telefone."', '".$celular."')";
        $rs = mysqli_query($conexao, $sql);
        echo("<div class='alert alert-success'>Paciente \"".$nome."\"  cadastrado com sucesso.</div>");

        $nome = "";
        $cpf = "";
        $data_nascimento = "";
        $sexo = "";
        $email = "";
        $telefone = "";
        $celular = "";
    }
}

echo("  <div class='consultorio-page'>
            <div class='container consultorio-container'>
            
                <br/>

                <center>
                    <h4>Aniversariantes</h4>
                </center>
                <br/>
            
                <form name='form' method='post'>
                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-0-5 col-form-label'><font color='red'>*</font>Mês</label>
                        <div class='col-sm-3'>
                            <select size='1' class='form-control' name='mes' required >
                                <option></option>
                                <option value='1' ".($_POST['mes'] == 1 ? "selected" : "").">Janeiro</option>
                                <option value='2' ".($_POST['mes'] == 2 ? "selected" : "").">Fevereiro</option>
                                <option value='3' ".($_POST['mes'] == 3 ? "selected" : "").">Março</option>
                                <option value='4' ".($_POST['mes'] == 4 ? "selected" : "").">Abril</option>
                                <option value='5' ".($_POST['mes'] == 5 ? "selected" : "").">Maio</option>
                                <option value='6' ".($_POST['mes'] == 6 ? "selected" : "").">Junho</option>
                                <option value='7' ".($_POST['mes'] == 7 ? "selected" : "").">Julho</option>
                                <option value='8' ".($_POST['mes'] == 8 ? "selected" : "").">Agosto</option>
                                <option value='9' ".($_POST['mes'] == 9 ? "selected" : "").">Setembro</option>
                                <option value='10' ".($_POST['mes'] == 10 ? "selected" : "").">Outubro</option>
                                <option value='11' ".($_POST['mes'] == 11 ? "selected" : "").">Novembro</option>
                                <option value='12' ".($_POST['mes'] == 12 ? "selected" : "").">Dezembro</option>
                            </select>
                        </div>
                        <div class='col-sm-3'>
                            <input type='submit' class='btn btn-primary' value='Buscar' name='BtOpc' />
                        </div>
                    </div>
                </form>

                <div class='form-group row'>
                    <div class='col-sm-12'>
                        <table class='table table-sm table-hover'>
                            <tr class='table-primary'>
                                <th>Nome</th>
                                <th>Data de nascimento</th>
                                <th>Sexo</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Celular</th>
                            </tr>");

$sql = "SELECT * FROM paciente WHERE MONTH(data_nascimento) = ".$_POST['mes']." ORDER BY nome";
$rs = mysqli_query($conexao, $sql);
if(mysqli_num_rows($rs) == 0) {
    echo("                  <tr>
                                <td colspan='6' class='alert alert-danger' style='text-align:center'>Nenhum aniversariante neste mês</td>
                            </tr>");
}

while($paciente_array = mysqli_fetch_array($rs)) {
    echo("                  <tr>
                                <td>".$paciente_array['nome']."</td>
                                <td>".$paciente_array['data_nascimento']."</td>
                                <td>".$paciente_array['sexo']."</td>
                                <td>".$paciente_array['email']."</td>
                                <td>".$paciente_array['telefone']."</td>
                                <td>".$paciente_array['celular']."</td>
                            </tr>");
}

echo("                  </table>
                    </div>
                </div>
            </div>
        </div>
    </body>");
?>