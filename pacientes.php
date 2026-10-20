<?php
include("menu.php");

$conexao = abre_conexao();

if(isset($_POST['BtOpc']) && $_POST['BtOpc'] == 'Cadastrar') {
    $nome = $_POST['nome'].trim();
    $perfil = $_POST['perfil'];
    $login = $_POST['login'].trim();
    $email = $_POST['email'].trim();
    $senha = md5('123456');

    //verifica se já existe o login
    $sql = "SELECT * FROM paciente WHERE login = '".$login."'";
    $rs = mysqli_query($conexao, $sql);
    if(mysqli_num_rows($rs) > 0) {
        echo("<div class='alert alert-danger'>O login \"".$login."\" já está cadastrado no sistema</div>");
    } else {
        $sql = "INSERT INTO paciente(nome, perfil, email, login, senha) VALUES('".$nome."', '".$perfil."', '".$email."', '".$login."', '".$senha."')";
        $rs = mysqli_query($conexao, $sql);
        echo("<div class='alert alert-success'>Usuário cadastrado com sucesso com o login \"".$login."\" e senha \"123456\" que deve alterar no primeiro acesso.</div>");
    }
}

echo("  <div class='consultorio-page'>
            <div class='container consultorio-container'>
                <form name='form' method='post'>
                    <br/>

                    <center>
                        <h4>Pacientes</h4>
                    </center>
                    <br/>
                
                    <div class='form-group row'>
                        <div class='col-sm-12'>
                            <table class='table table-sm table-hover'>
                                <tr class='table-primary'>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>Data de nascimento</th>
                                    <th>Sexo</th>
                                    <th>Email</th>
                                    <th>Telefone</th>
                                    <th>Celular</th>
                                    <th></th>
                                </tr>");

$sql = "SELECT * FROM paciente ORDER BY nome";
$rs = mysqli_query($conexao, $sql);
if(mysqli_num_rows($rs) == 0) {
    echo("                      <tr>
                                    <td colspan='8' class='alert alert-danger' style='text-align:center'>Nenhum paciente cadastrado</td>
                                </tr>");
}

while($paciente_array = mysqli_fetch_array($rs)) {
    echo("                      <tr>
                                    <td>".$paciente_array['nome']."</td>
                                    <td>".$paciente_array['cpf']."</td>
                                    <td>".$paciente_array['data_nascimento']."</td>
                                    <td>".$paciente_array['sexo']."</td>
                                    <td>".$paciente_array['email']."</td>
                                    <td>".$paciente_array['telefone']."</td>
                                    <td>".$paciente_array['celular']."</td>
                                    <td>
                                        <input type='submit' class='btn btn-primary' value='Atualizar' name='paciente".$paciente_array['id']."'
                                        ".($disabled_alterar_ou_excluir?'disabled':'')." formnovalidate />
                                    </td>
                                </tr>");
}

echo("                      </table>
                        </div>
                    </div>
                    <br/>
                    <hr/>
                    <br/>");

echo("              <center>
                        <h5>Cadastrar paciente</h5>
                    </center>
                    <br/>

                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-0-5 col-form-label'>Nome</label>
                        <div class='col-sm-3-5'>
                            <input type='text' class='form-control' name='nome' />
                        </div>
                    </div>
                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-0-5 col-form-label'>CPF</label>
                        <div class='col-sm-3-5'>
                            <input type='text' class='form-control' name='cpf' />
                        </div>
                    </div>
                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-0-5 col-form-label'>Data de nascimento</label>
                        <div class='col-sm-3-5'>
                            <input type='text' class='form-control' name='data_nascimento' />
                            <small>dd/mm/aaaa</small>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-0-5 col-form-label'>Sexo</label>
                        <div class='col-sm-3-5'>
                            <select size='1' class='form-control' name='sexo' required >
                                <option></option>
                                <option value='Feminino' ".($paciente['sexo'] == 'Feminino' ? 'selected' : '').">Feminino</option>
                                <option value='Masculino' ".($paciente['perfil'] == 'Masculino' ? 'selected' : '').">Masculino</option>
                            </select>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-0-5 col-form-label'>Email</label>
                        <div class='col-sm-3-5'>
                            <input type='text' class='form-control' name='email' />
                        </div>
                    </div>
                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-0-5 col-form-label'>Telefone</label>
                        <div class='col-sm-3-5'>
                            <input type='text' class='form-control' name='telefone' />
                        </div>
                    </div>
                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-0-5 col-form-label'>Celular</label>
                        <div class='col-sm-3-5'>
                            <input type='text' class='form-control' name='celular' />
                        </div>
                    </div>
                    <br/>
                    <center>
                        <input type='submit' class='btn btn-primary' value='Cadastrar' name='BtOpc' />
                        <input type='submit' class='btn btn-light' value='Cancelar' name='BtOpc' formnovalidate />
                    </center>
                </form>
            </div>
        </div>
    </body>");
?>