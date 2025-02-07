<?php

// Verifica se o POST existe antes de inserir um novo contato
if(isset($_POST["acao"])){
    if ($_POST["acao"]=="inserir"){
        inserirContato();
    }
    if ($_POST["acao"]=="atualizar"){
        atualizarContato();
    }
    if($_POST["acao"]=="excluir"){
        excluirContato();
    }
}


function abrirBanco() {
    $conexao = new mysqli("localhost", "root", "", "agenda");
    if ($conexao->connect_error) {
        echo "deu ruim";
        die("Connection failed: " . $conexao->connect_error);
    }
    return $conexao;
}

function inserirContato() {
    $banco = abrirBanco();
    $sql = "INSERT INTO contato(nome, email, objetivo) 
    VALUES ('{$_POST["nome"]}','{$_POST["email"]}','{$_POST["objetivo"]}')";
    $banco->query($sql);
    $banco->close();
    voltarIndex();
}

function atualizarContato() {
    $banco = abrirBanco();
    $sql = "UPDATE contato SET nome='{$_POST["nome"]}',email='{$_POST["email"]}',objetivo='{$_POST["objetivo"]}' WHERE id='{$_POST["id"]}'";
    $banco->query($sql);
    $banco->close();
    voltarIndex();
}

function excluirContato() {
    $banco = abrirBanco();
    $sql = "DELETE FROM contato WHERE id='{$_POST["id"]}'";
    $banco->query($sql);
    $banco->close();
    voltarIndex();
}

function selectAllContato() {
    $banco = abrirBanco();
    $sql = "SELECT * FROM contato ORDER BY nome";
    $resultado = $banco->query($sql);
    $banco->close();
    
    while($row = mysqli_fetch_array($resultado)) {
        $dados[] = $row;
    }
    return $dados;
}

function selectIdContato($id) {
    $banco = abrirBanco();
    $sql = "SELECT * FROM contato WHERE id=".$id;
    $resultado = $banco->query($sql);
    $banco->close();

    $contato = mysqli_fetch_assoc($resultado);
    return $contato;
}

function voltarIndex(){
    header("Location:index.php");
}

?>