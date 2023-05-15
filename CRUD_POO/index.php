<?php

//incluir o arquivo da classe e o arquivo de conexao
require_once ('classes/crud.php');
require_once ('conexao/conexao.php');

$database = new Database();
$db = $database->getConnection();
$crud = new Crud($db);

//solicitações do usuário
if(isset($_GET['action'])){
    switch($_GET['action']){
        case 'create':
            $crud->create($_POST);
            $rows = $crud->read(); // atualiza a variável $
            break;
        case 'read':
            $rows = $crud->read();
            break;
        case 'update':
            if(isset($_POST['id'])){
                $crud->update($_POST);
            }
            $rows = $crud->read();
            break;
        case 'delete':
            $crud->delete($_GET['id']);
            $rows = $crud->read();
            break;
        default:
            $rows = $crud->read();
            break;
    }
}else{
    $rows = $crud->read();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulário de Banda</title>

    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center ; 
            background-color: #1a1a1a;
            color: #ffffff;
            font-family: "Poppins", Arial, sans-serif;
        }
        form {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            width: 300px;
            height: 450px;
            margin: 0 auto;
            background-color: #2d2d2d;
            padding: 20px;
            border-radius: 0.5rem;
            font-family: "Poppins", Arial, sans-serif;
            margin-bottom: 2rem;
        }
        
        label {
            display: block;
            margin-top: 10px;
        }
        
        input[type="text"],
        input[type="number"]
         {
            width: 100%;
            padding: 5px;
            margin-top: 5px;
            border-radius: 3px;
            border: 1px solid #ffffff;
            background-color: #2d2d2d;
            color: #ffffff;
        }

        input[type="file"]{
            width: 100%;
            padding: 5px;
            margin-top: 5px;
            border-radius: 3px;
            border: none;
            background-color: #4d4d4d;
            color: #ffffff;
            cursor: pointer;
        }
        
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 3px;
            border: none;
            background-color: #4d4d4d;
            color: #ffffff;
            cursor: pointer;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #333;
        }

        th, td {
            text-align: center;
            padding: 8px;
            border: 1px solid #ddd;
            color: white;
            background-color: #2d2d2d;;
        }

        th {
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        a {
            display: inline-block;
            padding: 4px 8px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }

        a:hover {
            background-color: #0069d9;
        }

        a.delete {
            background-color: #dc3545;
        }

        a.delete:hover {
            background-color: #c82333;
        }

        .separar_botoes{
            display:flex;
            justify-content:space-around;
            align-items:center;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;    
            justify-content: center;
            gap: 20px;
        }

        .card {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;  
            width: 300px;
            background-color: #333;
            color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            overflow: hidden;
            box-sizing: border-box;
        }

        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .card-content {
            padding: 20px;
        }

        .card h3 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .card p {
            margin: 10px 0;
        }

        .card-actions {
            width: 100%;
            display: flex;
            justify-content: center;
            padding: 10px;
            background-color: #555;
        }

        .card-actions a {
            margin-left: 10px;
            color: #fff;
            text-decoration: none;
        }

        .delete {
            color: #ff3f3f;
        }
</style>

</head>
<body>

        <?php
            if(isset($_GET['action']) && $_GET['action'] == 'update' && isset($_GET['id'])){
                $id = $_GET['id'];
                $result = $crud->readOne($id);

                if(!$result){
                    echo"Registro não encontrado";
                    exit();
                }
                $nome = $result['nome'];
                $genero = $result['genero'];
                $gravadora = $result['gravadora'];
                $num_discos = $result['num_discos'];
                $qtd_albuns = $result['qtd_albuns'];
        ?>

    <h1> EDITAR INFORMAÇÕES DA BANDA </h1>
    <form method="POST" action="?action=update">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <label for="nome_banda">Nome da Banda:</label>
        <input type="text" id="nome_banda" name="nome" value="<?php echo $nome ?>">

        <label for="genero">Gênero:</label>
        <input type="text" id="genero" name="genero" value="<?php echo $genero ?>">

        <label for="gravadora">Gravadora:</label>
        <input type="text" id="gravadora" name="gravadora" value="<?php echo $gravadora ?>">

        <label for="num_discos">Número de Discos:</label>
        <input type="number" id="num_discos" name="num_discos" value="<?php echo $num_discos ?>">

        <label for="qtd_albuns">Quantidade de Álbuns:</label>
        <input type="number" id="qtd_albuns" name="qtd_albuns" value="<?php echo $qtd_albuns ?>">

        <input type="submit" value="Atualizar" name="enviar" onclick="return confirm('tem certeza que deseja atualizar?')">

        <a href="index.php"> Voltar ao formulario de criação</a>
    </form>

        <?php
            }else{
        ?>
    
    <h1> FORMULÁRIO DA BANDA </h1>
    <form method="POST" action="?action=create">
        <label for="nome_banda">Nome da Bunda:</label>
        <input type="text" id="nome_banda" name="nome">

        <label for="genero">Gênero:</label>
        <input type="text" id="genero" name="genero">

        <label for="gravadora">Gravadora:</label>
        <input type="text" id="gravadora" name="gravadora">

        <label for="num_discos">Número de Discos:</label>
        <input type="number" id="num_discos" name="num_discos">

        <label for="quantidade_albums">Quantidade de Álbuns:</label>
        <input type="number" id="quantidade_albums" name="qtd_albuns">


        <input type="submit" value="Enviar">
    </form>

        <?php
            }
        ?>
        <?php

    if (isset($rows)) {
        echo "<div class='card-container'>";
        foreach($rows as $row){
            echo "<div class='card'>";
            echo "<h3>".$row['nome']."</h3>";
            echo "<p>Genero: ".$row['genero']."</p>";
            echo "<p>Gravadora: ".$row['gravadora']."</p>";
            echo "<p>Número de Discos: ".$row['num_discos']."</p>";
            echo "<p>Quantidade de Álbuns: ".$row['qtd_albuns']."</p>";
            echo "<div class='card-actions'>";
            echo "<a href='?action=update&id=".$row['id']."'>Editar</a>";
            echo "<a href='?action=delete&id=".$row['id']."' onclick='return confirm(\"Tem certeza que deseja deletar esse registro?\")' class='delete'>Excluir</a>";
            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
    }else{
        echo "<h1> asddsa </h1>";
    }
    
    
        ?>

   

</body>
</html>