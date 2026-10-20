<?php
include("menu.php");

if(isset($_POST['BtOpc']) && $_POST['BtOpc'] == 'Alterar') {
    $conexao = abre_conexao();

    $login = $_SESSION['login'];
    $senha = md5($_POST['senha_atual']);
    $nova_senha = md5($_POST['nova_senha']);
    $confirmar_nova_senha = md5($_POST['confirmar_nova_senha']);

    if($nova_senha == $confirmar_nova_senha) {
        $sql = "SELECT * FROM usuario WHERE login = '".$login."' AND senha = '".$senha."'";
        $rs = mysqli_query($conexao, $sql);      
        if(mysqli_num_rows($rs) > 0) {
            $linha = mysqli_fetch_array($rs);
            $sql = "UPDATE usuario SET senha = '".$nova_senha."' WHERE login = '".$login."' AND id = '".$linha['id']."'";
            $rs = mysqli_query($conexao, $sql);
            echo("<div class='alert alert-success'>Senha alterada com sucesso</div>");
        }
    } else {
        echo("<div class='alert alert-danger'>\"Nova senha\" e \"Confirmar nova senha\" não são iguais</div>");
    }

    
}

echo("  <div class='consultorio-page'>
            <div class='container consultorio-container'>
                <br/>

                <center>
                    <h4>Alterar senha</h4>
                </center>
                <br/>
                
                <form name='form' method='post'>
                    <div class='form-group row'>
                        <div class='col-sm-3-5'></div>
                        <label class='col-sm-1-5 col-form-label'>Senha atual</label>
                        <div class='col-sm-3-5'>
                            <input type='password' class='form-control' name='senha_atual' />
                        </div>
                    </div>
                    <div class='form-group row'>
                        <div class='col-sm-3-5'></div>
                        <label class='col-sm-1-5 col-form-label'>Nova senha</label>
                        <div class='col-sm-3-5'>
                            <input type='password' class='form-control' name='nova_senha' />
                        </div>
                    </div>
                    <div class='form-group row'>
                        <div class='col-sm-3-5'></div>
                        <label class='col-sm-1-5 col-form-label'>Confirmar nova senha</label>
                        <div class='col-sm-3-5'>
                            <input type='password' class='form-control' name='confirmar_nova_senha' />
                        </div>
                    </div>
                    <br/>
                    <center>
                        <input type='submit' class='btn btn-primary' value='Alterar' name='BtOpc' />
                        <input type='submit' class='btn btn-light' value='Cancelar' name='BtOpc' formnovalidate />
                    </center>
                </form>
            </div>
        </div>
    </body>");
        
?>