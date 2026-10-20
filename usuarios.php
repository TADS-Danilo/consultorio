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
    $sql = "SELECT * FROM usuario WHERE login = '".$login."'";
    $rs = mysqli_query($conexao, $sql);
    if(mysqli_num_rows($rs) > 0) {
        echo("<div class='alert alert-danger'>O login \"".$login."\" já está cadastrado no sistema</div>");
    } else {
        $sql = "INSERT INTO usuario(nome, perfil, email, login, senha) VALUES('".$nome."', '".$perfil."', '".$email."', '".$login."', '".$senha."')";
        $rs = mysqli_query($conexao, $sql);
        echo("<div class='alert alert-success'>Usuário cadastrado com sucesso com o login \"".$login."\" e senha \"123456\" que deve alterar no primeiro acesso.</div>");
    }
}

echo("  <div class='consultorio-page'>
            <div class='container consultorio-container'>
                <form name='form' method='post'>
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
    echo("                      <tr>
                                    <td colspan='5' class='alert alert-danger' style='text-align:center'>Nenhum usuário cadastrado</td>
                                </tr>");
}

while($usuario_array = mysqli_fetch_array($rs)) {
    echo("                      <tr>
                                    <td>".$usuario_array['nome']."</td>
                                    <td>".$usuario_array['perfil']."</td>
                                    <td>".$usuario_array['email']."</td>
                                    <td>".$usuario_array['login']."</td>
                                    <td>
                                        <input type='submit' class='btn btn-primary' value='Atualizar' name='usuario".$usuario_array['id']."'
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
                        <h5>Cadastrar usuário</h5>
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
                        <label class='col-sm-0-5 col-form-label'>Perfil</label>
                        <div class='col-sm-3-5'>
                            <select size='1' class='form-control' name='perfil' required >
                                <option></option>
                                <option value='Assistente' ".($usuario['perfil'] == 'Assistente' ? 'selected' : '').">Assistente</option>
                                <option value='Dentista' ".($usuario['perfil'] == 'Dentista' ? 'selected' : '').">Dentista</option>
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
                        <label class='col-sm-0-5 col-form-label'>Login</label>
                        <div class='col-sm-3-5'>
                            <input type='text' class='form-control' name='login' />
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