<?php
include("menu_externo.php");

if(isset($_POST['BtOpc']) && $_POST['BtOpc'] == 'Enviar') {
    echo("<script>alert('Função será implementada na próxima versão');</script>");
}

echo("  <div class='consultorio-page'>
            <div class='container consultorio-container'>
                <br/>

                <center>
                    <h4>Esqueci minha senha</h4>
                </center>
                <br/>
                
                <form method='post' action='$PHP_SELF'>
                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <label class='col-sm-0-5 col-form-label'>Login</label>
                        <div class='col-sm-3-5'>
                            <input type='text' class='form-control' name='login' value='' />
                        </div>
                    </div>
                    <br/>
                    <center>
                        <input type='submit' class='btn btn-primary' value='Enviar' name='BtOpc' />
                        <input type='submit' class='btn btn-light' value='Cancelar' name='BtOpc' formnovalidate />
                    </center>
                    <br/><br/><br/>
                    <div class='form-group row'>
                        <div class='col-sm-4'></div>
                        <input type='submit' formaction='index.php' class='btn btn-primary col-sm-4' value='Voltar para tela inicial' name='BtOpc' formnovalidate />
                    </div>
                </form>
            </div>
        </div>
    </body>");
        
?>