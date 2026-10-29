<?php
include("menu.php");

$conexao = abre_conexao();

$nome = "";
$id = 0;
$disabled_alterar = false;
$titulo = "Cadastrar perfil";

if(isset($_POST['BtOpc']) && $_POST['BtOpc'] == 'Cadastrar') {
    $nome = trim($_POST['nome']);

    //verifica se já existe o login
    $sql = "SELECT * FROM perfil WHERE nome = '".$nome."'";
    $rs = mysqli_query($conexao, $sql);
    if(mysqli_num_rows($rs) > 0) {
        echo("<div class='alert alert-danger'>O perfil \"".$nome."\" já está cadastrado no sistema</div>");
    } else {
        $sql = "INSERT INTO perfil(nome) VALUES('".$nome."')";
        $rs = mysqli_query($conexao, $sql);
        echo("<div class='alert alert-success'>Perfil cadastrado com sucesso.</div>");
    }
}

if(isset($_POST['BtOpc']) && $_POST['BtOpc'] == 'Atualizar') {
    $nome = trim($_POST['nome']);

    //verifica se já existe o login
    $sql = "UPDATE perfil SET nome = '".$nome."' WHERE id = '".$_POST['id']."'";
    $rs = mysqli_query($conexao, $sql);
    echo("<div class='alert alert-success'>Perfil atualizado com sucesso.</div>");
    $nome = "";
    $id = 0;
}

if(isset($_POST['BtOpc-A']) && $_POST['BtOpc-A'] == 'Atualizar') {
    $sql = "SELECT * FROM perfil WHERE id = '".$_POST['id']."'";
    $rs = mysqli_query($conexao, $sql);
    $linha = mysqli_fetch_array($rs);
    $nome = $linha['nome'];
    $id = $linha['id'];
    $disabled_alterar = true;
    $titulo = "Atualizar perfil";
}

echo("  <div class='consultorio-page'>
            <div class='container consultorio-container'>
                <br/>

                <center>
                    <h4>Perfis</h4>
                </center>
                <br/>
                
                <div class='form-group row'>
                    <div class='col-sm-12'>
                        <table class='table table-sm table-hover'>
                            <tr class='table-primary'>
                                <th>Nome</th>
                                <th></th>
                            </tr>");

$sql = "SELECT * FROM perfil ORDER BY nome";
$rs = mysqli_query($conexao, $sql);
if(mysqli_num_rows($rs) == 0) {
    echo("                  <tr>
                                <td colspan='2' class='alert alert-danger' style='text-align:center'>Nenhum usuário cadastrado</td>
                            </tr>");
}

while($perfil_array = mysqli_fetch_array($rs)) {
    echo("                  <tr>
                                <td>".$perfil_array['nome']."</td>
                                <td>
                                    <form name='form' method='post'>
                                        <input type='hidden' name='id' value='".$perfil_array['id']."' />
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