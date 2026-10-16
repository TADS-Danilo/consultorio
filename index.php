<?php
include("menu_externo.php");

if(isset($_POST['BtOpc']) && $_POST['BtOpc'] == 'Enviar') {
    echo("<script>alert('Função será implementada na próxima versão');</script>");
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