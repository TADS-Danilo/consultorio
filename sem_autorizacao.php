<?php
include("menu_externo.php");

echo("  <div class='consultorio-page'>
            <div class='container consultorio-container'>
                <br/>

                <div class='alert alert-danger'>
				    Você precisa realizar o login no sistema para acessar a página desejada.<br/><br/>
				    <form action='index.php'>
					    <input type='submit' name='BtOpc' value='Ir para o login' class='btn btn-primary' />
				    </form>
			    </div>
            </div>
        </div>
    </body>");
?>