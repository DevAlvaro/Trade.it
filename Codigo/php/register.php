<?php
session_start();
include("conexao.php");

$cpf = mysqli_real_escape_string($conexao, trim($_POST['cpf']));
$nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
$email = mysqli_real_escape_string($conexao, trim($_POST['email']));
$nascimento = mysqli_real_escape_string($conexao, trim($_POST['nascimento']));
$senha = mysqli_real_escape_string($conexao, trim(md5($_POST['senha'])));
$senhaConfirma = mysqli_real_escape_string($conexao, trim(md5($_POST['senhaConfirma'])));
$logradouro = mysqli_real_escape_string($conexao, trim($_POST['logradouro']));
$numero = mysqli_real_escape_string($conexao, trim($_POST['numero']));
$bairro = mysqli_real_escape_string($conexao, trim($_POST['bairro']));
$cidade = mysqli_real_escape_string($conexao, trim($_POST['cidade']));
$cep = mysqli_real_escape_string($conexao, trim($_POST['cep']));


$sql = "select count(*) as total from usuarios where email = '$email' or cpf = '$cpf'";
$result = mysqli_query($conexao, $sql);
$row = mysqli_fetch_assoc($result);

if (strlen($cpf) != 11) {
    $_SESSION['cpf_incorreto'] = true;
    header('Location: ../cadastrar.php');
    exit;
};

if (strlen($cep) != 8) {
    $_SESSION['cep_incorreto'] = true;
    header('Location: ../cadastrar.php');
    exit;
};

if ($row['total'] == 1) {
    $_SESSION['usuario_existe'] = true;
    header('Location: ../cadastrar.php');
    exit;
}

if ($senha != $senhaConfirma) {
    $_SESSION['senha_incorreta'] = true;
    header('Location: ../cadastrar.php');
    exit;
};

$sql = "insert into usuarios values ('$cpf', '$nome', '$email', '$nascimento', '$senha',
'$logradouro', '$numero', '$bairro', '$cidade', '$cep')";

if ($conexao->query($sql) === TRUE) {
    $_SESSION['status_cadastro'] = true;
}

$conexao->close();

header('Location: ../cadastrar.php');
exit;
