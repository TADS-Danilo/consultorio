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

    //verifica se o cpf é válido
    if(cpf_valido($cpf)) {
        if(email_valido($email)) {
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
        } else {
            echo("<div class='alert alert-danger'>Email inválido</div>");
        }
    } else {
        echo("<div class='alert alert-danger'>CPF inválido</div>");
    }
}

if(isset($_POST['BtOpc']) && $_POST['BtOpc'] == 'Atualizar') {
    $nome = $_POST['nome'].trim();
    $cpf = $_POST['cpf'].trim();
    $data_nascimento = $_POST['data_nascimento'].trim();
    $sexo = $_POST['sexo'].trim();
    $email = $_POST['email'].trim();
    $telefone = $_POST['telefone'].trim();
    $celular = $_POST['celular'].trim();

    $sql = "UPDATE paciente
            SET nome = '".$nome."', data_nascimento = '".$data_nascimento."', sexo = '".$sexo."',
                    email = '".$email."', telefone = '".$telefone."', celular = '".$celular."'
            WHERE id = '".$_POST['id']."'";
            
    $rs = mysqli_query($conexao, $sql);
    echo("<div class='alert alert-success'>Paciente \"".$nome."\"  atualizado com sucesso.</div>");

    $nome = "";
    $cpf = "";
    $data_nascimento = "";
    $sexo = "";
    $email = "";
    $telefone = "";
    $celular = "";
}

if(isset($_POST['BtOpcTabela']) && $_POST['BtOpcTabela'] == 'Atualizar') {
    //busca o paciente
    $sql = "SELECT * FROM paciente WHERE id = '".$_POST['id']."'";
    $rs = mysqli_query($conexao, $sql);
    $linha = mysqli_fetch_array($rs);
    $nome = $linha['nome'];
    $cpf = $linha['cpf'];
    $data_nascimento = $linha['data_nascimento'];
    $sexo = $linha['sexo'];
    $email = $linha['email'];
    $telefone = $linha['telefone'];
    $celular = $linha['celular'];

    $disabled_alterar_ou_excluir = true;
    $titulo = "Atualizar paciente";
}

echo("  <div class='consultorio-page'>
            <div class='container consultorio-container'>
            
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
    echo("                  <tr>
                                <td colspan='8' class='alert alert-danger' style='text-align:center'>Nenhum paciente cadastrado</td>
                            </tr>");
}

while($paciente_array = mysqli_fetch_array($rs)) {
    echo("                  <tr>
                                <td>".$paciente_array['nome']."</td>
                                <td>".$paciente_array['cpf']."</td>
                                <td>".$paciente_array['data_nascimento']."</td>
                                <td>".$paciente_array['sexo']."</td>
                                <td>".$paciente_array['email']."</td>
                                <td>".$paciente_array['telefone']."</td>
                                <td>".$paciente_array['celular']."</td>
                                <td>
                                    <form name='form' method='post'>
                                        <input type='hidden' name='id' value='".$paciente_array['id']."' />
                                        <input type='submit' class='btn btn-primary' value='Atualizar' name='BtOpcTabela'
                                         ".($disabled_alterar_ou_excluir?'disabled':'')." formnovalidate />
                                    </form>
                                </td>
                            </tr>");
}

echo("                  </table>
                    </div>
                </div>
                <br/>
                <hr/>
                <br/>");

echo("          <form name='form' method='post'>
                    <center>
                        <h5>".$titulo."</h5>
                    </center>
                    <br/>

                    <input type='hidden' name='id' value='".$_POST['id']."' />

                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-1 col-form-label'><font color='red'>*</font>Nome</label>
                        <div class='col-sm-3'>
                            <input type='text' class='form-control' name='nome' value='".$nome."' required/>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-1 col-form-label'><font color='red'>*</font>CPF</label>
                        <div class='col-sm-3'>
                            <input type='text' class='form-control' name='cpf' required maxlength='11' value='".$cpf."' ".($disabled_alterar_ou_excluir?'disabled':'')."/>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-1 col-form-label'><font color='red'>*</font>Data de nascimento</label>
                        <div class='col-sm-3'>
                            <input type='date' class='form-control' name='data_nascimento' required value='".$data_nascimento."' />
                            <small>dd/mm/aaaa</small>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-1 col-form-label'><font color='red'>*</font>Sexo</label>
                        <div class='col-sm-3'>
                            <select size='1' class='form-control' name='sexo' required >
                                <option></option>
                                <option value='Feminino' ".($sexo == 'Feminino' ? 'selected' : '').">Feminino</option>
                                <option value='Masculino' ".($sexo == 'Masculino' ? 'selected' : '').">Masculino</option>
                            </select>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-1 col-form-label'><font color='red'>*</font>Email</label>
                        <div class='col-sm-3'>
                            <input type='text' class='form-control' name='email' required value='".$email."' />
                        </div>
                    </div>
                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-1 col-form-label'>Telefone</label>
                        <div class='col-sm-3'>
                            <input type='text' class='form-control' name='telefone' value='".$telefone."' />
                        </div>
                    </div>
                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-1 col-form-label'><font color='red'>*</font>Celular</label>
                        <div class='col-sm-3'>
                            <input type='text' class='form-control' name='celular' required value='".$celular."'  />
                        </div>
                    </div>
                    <br/>
                    <center>
                        <input type='submit' class='btn btn-primary' value='".($disabled_alterar_ou_excluir?'Atualizar':'Cadastrar')."' name='BtOpc' />
                        <input type='submit' class='btn btn-light' value='Cancelar' name='BtOpc' formnovalidate />
                    </center>
                </form>
            </div>
        </div>
    </body>");
?>