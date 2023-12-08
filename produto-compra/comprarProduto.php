<?php

session_start();

//include_once('../connection/connection.php');

if(isset($_POST['adicionarCarrinho'])){

    if(isset($_SESSION['compar'])){

        $session_array_id = array_column($_SESSION['comprar'], "idproduto");

        if(!in_array($_GET['idproduto'], $session_array_id)){
            $session_array = array(
                'idproduto' => $_GET['idproduto'],
                "nome" => $_POST['nome'],
                "valor" => $_POST['valor'],
                "quantidade" => $_POST['quantidade']
            );

            $_SESSION['comprar'][] = $session_array;
        }

    }else{
        $session_array = array(
            'idproduto' => $_GET['idproduto'],
            "nome" => $_POST['nome'],
            "valor" => $_POST['valor'],
            "quantidade" => $_POST['quantidade']
        );

        $_SESSION['comprar'][] = $session_array;
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <!-- Scripts Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">

<h1>Compra de Produtos</h1>

<div class="col-md-12">
    <div class="row">

   

<?php

$query = "SELECT * FROM produto";

$conexao = $this->conn->conexaoDB();

$result = $conexao->prepare($query);


while($row = mysqli_fetch_array($result)){?>
    <div class="col-md-4">

        <form action="listarProduto.php?idproduto=<?=$row['idproduto']?>" method="GET">
            <img src="img/<?=$row['image']?>" style='height:150px' alt="">
            <h5 class="text-center"><?=$row['nome']?></h5>
            <h5 class="text-center"><?=$row['marca']?></h5>
            <h5 class="text-center"><?=$row['modelo']?></h5>
            <h5 class="text-center">$<?=number_format($row['valor'],2)?></h5>

            <input type="hidden" name="nome" value="<?=$row['nome']?>">
            <input type="hidden" name="marca" value="<?=$row['marca']?>">
            <input type="hidden" name="modelo" value="<?=$row['modelo']?>">
            <input type="hidden" name="valor" value="<?=$row['valor']?>">
            <input type="number" name="quantidade" value="1" class="form-control">



            <input type="submit" name="adicionarCarrinho" class="btn btn-warning btn-block" value="Comprar">

        </form>
    </div>

<?php }


?>

</div>
    </div>

    <div class="col-md-6">
        <h2>Itens Selecionados</h2>

        <?php

        $output = "";

        $output .= "
        <table class='table table-bordered table-striped'></table>
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>Preço</th>
            <th>Quantidade</th>
            <th>Preço Total</th>
            <th>Ações</th>
        </tr>

        ";

        if(!empty($_SESSION('comprar'))){

            foreach($_SESSION['comprar'] as $key -> $value){

                $output .= "
                <tr>
                <td>".$value['idproduto']."</td>
                <td>".$value['nome']."</td>
                <td>".$value['valor']."</td>
                <td>".$value['quantidade']."</td>
                <td>$".number_format($value['valor'] * $value['quantidade'])."</td>
                <td>
                <a href='listarProdutos.php?action=remove&idproduto=".$value['idproduto']."'>
                <button class='btn btn-danger btn-block'>Remove</button>
                </a>
                </td>



                </tr>
                
                ";
            }
        }

        echo $output;
        
        ?>

    </div>

</div>
    
</body>
</html>