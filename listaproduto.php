<?php
include("conectadb.php");
session_start();
$nomeusuario = $_SESSION['nomeusuario'];

$sql = "SELECT * FROM produtos WHERE pro_ativo = 's'";
$retorno = mysqli_query($link, $sql);
$ativo = "s";

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $ativo = $_POST['ativo'];

    #VALIDA SE PRODUTO EXISTE
    if ($ativo == 's') {
        $sql = "SELECT * FROM produtos WHERE pro_ativo = 's'";
        $retorno = mysqli_query($link, $sql);
    } else {
        $sql = "SELECT * FROM produtos WHERE pro_ativo = 'n'";
        $retorno = mysqli_query($link, $sql);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estiloadm.css">
    <title>LISTA PRODUTOS</title>
</head>
<body>
    <div>
        <ul class= "menu">
            <li><a href="cadastrausuario.php">CADASTRA USUARIO</a></li>
            <li><a href="cadastracliente.php">CADASTRA CLIENTE</a></li>
            <li><a href="cadastraproduto.php">CADASTRA PRODUTO</a></li>
            <li><a href="listausuario.php">LISTA USUARIO</a></li>
            <li><a href="listaproduto.php">LISTA PRODUTO</a></li>
            <li><a href="listacliente.php">LISTA CLIENTE</a></li>
            <li class="menuloja"><a href="logout.php">SAIR</a></li>
            <?php
                #ABERTO O PHP PARA VALIDAR SE A SESSÃO DU USUÁRIO ESTÁ ABERTA
                #SE SESSÃO ABERTA, FECHA O PHP PARA USAR ELEMENTOS HTML
                if ($nomeusuario != null) {
                ?>
                <!-- USO DO ELEMENTO HTML COM PHP INTERNO -->
                <li class="profile">OLÁ
                <?= strtoupper($nomeusuario) ?>
                </li>
                <?php
                #ABERTURA DE OUTRO PHP PARA CASO FALSE
                } else {
                echo "<script>window.alert('CLIENTE NÃO AUTENTICADO');window.location.href='login.php';</script>";
                }
                #FIM DO PHP PARA CONTINUAR MEU HTML
            ?>

        </ul>
    </div>

    <div>
        <form action="listaproduto.php" method="post">
            <input type="radio" name="ativo" class="radio" value="s" required onclick="submit()" <?=$ativo == 's' ? "checked":""?>>ATIVOS

            <input type="radio" name="ativo" class="radio" value="n" required onclick="submit()" <?=$ativo == 'n' ? "checked":""?>>INATIVOS
        </form>
        <div class="container">
            <table border="1">
                <tr>
                    <th>ID PRODUTO</th>
                    <th>NOME</th>
                    <th>DESCRIÇÃO</th>
                    <th>QUANTIDADE DE ESTOQUE</th>
                    <th>CUSTO</th>
                    <th>PREÇO</th>
                    <th>IMAGEM</th>
                    <th>ALTERAR</th>
                    <th>ATIVO?</th>
                </tr>
                <?php
                    while($tbl = mysqli_fetch_array($retorno))
                    {
                        ?>
                    <tr>
                        <td><?=$tbl[0]?></td> <!-- COLETA ID PRODUTO COLUNA 0 -->
                        <td><?=$tbl[1]?></td> <!-- COLETA NOME PRODUTO COLUNA 1 -->
                        <td><?=$tbl[2]?></td> <!-- COLETA DESCRIÇÃO PRODUTO COLUNA 2 -->
                        <td><?=$tbl[3]?></td> <!-- COLETA QUANTIDADE PRODUTO COLUNA 3 -->
                        <td>R$<?=number_format($tbl[4],2,',','.')?></td> <!-- CONVERTE PONTO EM VÍRGULA -->
                        <td>R$<?=number_format($tbl[5],2,',','.')?></td> <!-- CONVERTE PONTO EM VÍRGULA -->
                        <!--VEM DO BANCO A IMAGEM EM BASE64 O QUE FAZER? -->
                        <!-- DECRIPTAR O BASE64 TRAZENDO A IMAGEM -->
                        <td><img src="data:image/jpeg;base64,<?=$tbl[7]?>" width="100" height="100"></td> <!-- BOTÃO ALTERAR PRODUTO -->
                        <td>
                            <a href="alteraproduto.php?id=<?=$tbl[0]?>">
                            <input type="button" value="ALTERAR">
                        </td> 
                        <td><?=$check= ($tbl[6] == 's')? "SIM":"NÃO"?></td> 
                    </tr>
                    <?php
                    }
                    ?>
            </table>
        </div>
    </div>
</body>