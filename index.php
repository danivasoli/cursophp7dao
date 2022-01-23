<?php

require_once("config.php");

//Carrega um usuário
//$root = new Usuario();
//$root->loadbyId(3);
//echo $root;

//Carrega uma lista de usuários
//$lista = Usuario::getList();
//echo json_encode($lista);

//Carrega uma lista de usuários buscando pelo login
//$search = Usuario::search("jo");
//echo json_encode($search);

//Carrega um usuário usando o login e a senha
//$usuario = new Usuario();
//$usuario->login("root", "!@#$");
//echo $usuario;

/*
Criando um novo usuario(insert)
$aluno = new Usuario("aluno", "@lun0");
$aluno->insert();
echo $aluno;*/

/*Fazendo um update(atualizando) - alterar um usuario
$usuario= new Usuario();
$usuario->loadById(8);
$usuario->update("professor", "!@#$%&!");
echo $usuario;*/

$usuario = new Usuario();

$usuario->loadByID(7);

$usuario->delete();

echo $usuario;




?>