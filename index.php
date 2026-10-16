<?php
include("menu_externo.php");
include("funcoes.php");

if(isset($_POST['BtOpc']) && $_POST['BtOpc'] == 'Entrar') {
    $conexao = abre_conexao();

    $login = $_POST['login'].trim();
    $senha = md5($_POST['senha']);

    $sql = "SELECT * FROM usuario WHERE login = '".$login."' AND senha = '".$senha."'";
    $rs = mysqli_query($conexao, $sql);
    if(mysqli_num_rows($rs) > 0) {
        $linha = mysqli_fetch_array($rs);
        session_start();
        $_SESSION['login'] = $linha['login'];
        $_SESSION['nome'] = $linha['nome'];
        echo '<script type="text/javascript">window.location.href="inicio.php";</script>';
        exit();
    }
}

echo("  <div class='consultorio-page'>
            <div class='container consultorio-container'>
                <br/>

                <center>
                    <h4>Entrar no sistema</h4>
                </center>
                <br/>
                
                <form name='form' method='post'>
                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-0-5 col-form-label'>Login</label>
                        <div class='col-sm-3-5'>
                            <input type='text' class='form-control' name='login' />
                        </div>
                    </div>
                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-0-5 col-form-label'>Senha</label>
                        <div class='col-sm-3-5'>
                            <input type='password' class='form-control' name='senha' />
                        </div>
                    </div>
                    <br/>
                    <center>
                        <input type='submit' class='btn btn-primary' value='Entrar' name='BtOpc' />
                        <input type='submit' class='btn btn-light' value='Cancelar' name='BtOpc' formnovalidate />
                        <br/><br/>
                        <a href='esqueci_minha_senha.php'>Esqueci minha senha</a>
                    </center>
                </form>
            </div>
        </div>
    </body>");
        
?>