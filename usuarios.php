<?php
include("menu.php");

$conexao = abre_conexao();

$nome = "";
$perfil_id = 0;
$email = "";
$login = "";
$id = 0;
$disabled_alterar = false;
$titulo = "Cadastrar usuário";

if(isset($_POST['BtOpc']) && $_POST['BtOpc'] == 'Cadastrar') {
    $nome = trim($_POST['nome']);
    $perfil = $_POST['perfil'];
    $login = trim($_POST['login']);
    $email = trim($_POST['email']);
    $senha = md5('123456');

    //verifica se já existe o login
    $sql = "SELECT * FROM usuario WHERE login = '".$login."'";
    $rs = mysqli_query($conexao, $sql);
    if(mysqli_num_rows($rs) > 0) {
        echo("<div class='alert alert-danger'>O login \"".$login."\" já está cadastrado no sistema</div>");
    } else {
        $sql = "INSERT INTO usuario(nome, perfil_id, email, login, senha) VALUES('".$nome."', '".$perfil."', '".$email."', '".$login."', '".$senha."')";
        $rs = mysqli_query($conexao, $sql);
        echo("<div class='alert alert-success'>Usuário cadastrado com sucesso com o login \"".$login."\" e senha \"123456\" que deve alterar no primeiro acesso.</div>");
    }
}

if(isset($_POST['BtOpc']) && $_POST['BtOpc'] == 'Atualizar') {
    $nome = trim($_POST['nome']);
    $perfil_id = $_POST['perfil_id'];
    $email = trim($_POST['email']);
    $login = trim($_POST['login']);

    //verifica se já existe o login
    $sql = "UPDATE usuario
            SET nome = '".$nome."', perfil_id = '".$perfil_id."', email = '".$email."',
                login = '".$login."'
            WHERE id = '".$_POST['id']."'";

    $rs = mysqli_query($conexao, $sql);
    echo("<div class='alert alert-success'>Perfil atualizado com sucesso.</div>");
    $nome = "";
    $id = 0;
    $perfil_id = 0;
    $email = "";
    $login = "";
}

if(isset($_POST['BtOpc-A']) && $_POST['BtOpc-A'] == 'Atualizar') {
    $sql = "SELECT * FROM usuario WHERE id = '".$_POST['id']."'";
    $rs = mysqli_query($conexao, $sql);
    $linha = mysqli_fetch_array($rs);
    $nome = $linha['nome'];
    $id = $linha['id'];
    $email = $linha['email'];
    $login = $linha['login'];
    $perfil_id = $linha['perfil_id'];
    $disabled_alterar = true;
    $titulo = "Atualizar perfil";
}

$sql = "SELECT * FROM perfil ORDER BY nome";
$rs = mysqli_query($conexao, $sql);
$perfil_array = array();
$i=0;
while($linha = mysqli_fetch_array($rs)) {
    $perfil_array['id'][$i] = $linha['id'];
    $perfil_array['nome'][$i] = $linha['nome'];
    $i++;
}

echo("  <div class='consultorio-page'>
            <div class='container consultorio-container'>
                <br/>

                <center>
                    <h4>Usuários do sistema</h4>
                </center>
                <br/>
            
                <div class='form-group row'>
                    <div class='col-sm-12'>
                        <table class='table table-sm table-hover'>
                            <tr class='table-primary'>
                                <th>Nome</th>
                                <th>Perfil</th>
                                <th>Email</th>
                                <th>Login</th>
                                <th></th>
                            </tr>");

$sql = "SELECT * FROM usuario ORDER BY nome";
$rs = mysqli_query($conexao, $sql);
if(mysqli_num_rows($rs) == 0) {
    echo("                  <tr>
                                <td colspan='5' class='alert alert-danger' style='text-align:center'>Nenhum usuário cadastrado</td>
                            </tr>");
}

while($usuario_array = mysqli_fetch_array($rs)) {

    for($i=0;$i<count($perfil_array['id']);$i++) {
        if($usuario_array['perfil_id'] == $perfil_array['id'][$i]) {
            $usuario_array['perfil_id'] = $perfil_array['nome'][$i];
        }
    }

    echo("                  <tr>
                                <td>".$usuario_array['nome']."</td>
                                <td>".$usuario_array['perfil_id']."</td>
                                <td>".$usuario_array['email']."</td>
                                <td>".$usuario_array['login']."</td>
                                <td>
                                    <form name='form' method='post'>
                                    <input type='hidden' name='id' value='".$usuario_array['id']."' />
                                        <input type='submit' class='btn btn-primary' value='Atualizar' name='BtOpc-A'
                                        ".($disabled_alterar?'disabled':'')." formnovalidate />
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

echo("          <center>
                    <h5>".$titulo."</h5>
                </center>
                <br/>
                <form name='form' method='post'>
                    <input type='hidden' name='id' value='".$id."' />
                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-0-5 col-form-label'><font color='red'>*</font>Nome</label>
                        <div class='col-sm-3-5'>
                            <input type='text' class='form-control' name='nome' value='".$nome."' required />
                        </div>
                    </div>
                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-0-5 col-form-label'><font color='red'>*</font>Perfil</label>
                        <div class='col-sm-3-5'>
                            <select size='1' class='form-control' name='perfil_id' required >
                                <option value='0'></option>");
                                for($i=0;$i<count($perfil_array['id']);$i++) {
                                    echo "<option value='".$perfil_array['id'][$i]."' ".($perfil_id == $perfil_array['id'][$i] ? 'selected' : '').">".$perfil_array['nome'][$i]."</option>";
                                }
echo("                      </select>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-0-5 col-form-label'><font color='red'>*</font>Email</label>
                        <div class='col-sm-3-5'>
                            <input type='text' class='form-control' name='email' value='".$email."' required/>
                        </div>
                    </div>
                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-0-5 col-form-label'><font color='red'>*</font>Login</label>
                        <div class='col-sm-3-5'>
                            <input type='text' class='form-control' name='login' value='".$login."' required/>
                        </div>
                    </div>
                    <br/>
                    <center>
                        <input type='submit' class='btn btn-primary' value='".($disabled_alterar?'Atualizar':'Cadastrar')."' name='BtOpc' />
                        <input type='submit' class='btn btn-light' value='Cancelar' name='BtOpc' formnovalidate />
                    </center>
                </form>
            </div>
        </div>
    </body>");
?>