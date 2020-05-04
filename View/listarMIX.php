<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Selecao Br24</title>
    <link rel="stylesheet" href="styles.css">
</head>


<body>
        <div class="wrapper">
            <h1> Selecao Br24</h1><br>
            <div class="div-table">
                <table class="customers" id="customers">
                    <tr>
                        <th>Nome</th>
                        <th>Ultimo nome</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>Email</th>
                    </tr>
                        <?php include '../Controller/tableContact.php';?>
                </table>
                <br>
                <table class="customers" id="customers">
                    <tr>
                        <th>Empresa</th>
                        <th>CNPJ</th>
                        <th>Ganhos</th>
                    </tr>
                        <?php include '../Controller/tableCompany.php';?>
                </table>
            </div>
            <br>
            <div class="div-central">
                <a href="main.html"><input  class="btn" type="button" value= "Clique aqui para voltar para pagina inicial."/> </a>
            </div>
        </div>	
</body>
</html>