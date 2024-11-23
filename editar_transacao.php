<?php

require_once('connect.php');

if (isset($_GET['id'])) {
    $transaction_id = intval($_GET['id']);
    $sql = "SELECT * FROM transactions WHERE id = $transaction_id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $transaction = mysqli_fetch_assoc($result);
    } else {
        echo "<div class='alert alert-danger'>Transação não encontrada.</div>";
        exit();
    }
} else {
    echo "<div class='alert alert-danger'>ID da transação não especificado.</div>";
    exit();
}


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Transação</title>
</head>
<body>
<main>
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Editar Transação <i class="bi bi-pencil-square"></i></h4>
                        </div>
                        <div class="card-body">
                            <?php
                            // if ($transaction) :
                            ?>
                            <form action="acoes.php" method="post">
                                <input type="hidden" name="month_id" value="<?=$transaction['month_id']?>">
                                <input type="hidden" name="tarefa_id" value="<?=$transaction['id']?>">
                                <div class="mb-4">
                                    <label for="txtNome">Nome / Descrição</label>
                                    <input type="text" name="txtNome" id="txtNome" value="<?=$transaction['name']?>" class="form-control">
                                </div>
                                
                                <div class="mb-4">
                                    <label for="txtCategoria">Categoria</label>
                                    <input type="text" name="txtCategoria" id="txtCategoria" value="<?=$transaction['category']?>" class="form-control">
                                </div>
                                <div class="row">
                                <div class="col">
                                        <label for="txtTipo">Tipo</label>
                                        <input type="text" name="txtTipo" id="txtTipo" value="<?=$transaction['type']?>" class="form-control" id="txtTipo">
                                    </div>
                                    <div class="col">
                                        <label for="txtData">Data</label>
                                        <input type="date" name="txtData" id="txtData" value="<?=$transaction['date']?>" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label for="txtValor">Valor</label>
                                        <input type="number" name="txtValor" id="txtValuor" value="<?=$transaction['value']?>" class="form-control" id="txtValor">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <button type="submit" name="edit_transaction" class="btn btn-outline-primary float-end mt-3 ">Salvar</i></button>
                                </div>
                                </form>
                                <?php
                                // else:
                                ?>
                                <!-- <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    Tarefa não encontrado
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div> -->

                                <?php
                                // endif;
                                ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>

