<?php

class Usuario {

    private $id;
    private $deslogin;
    private $dessenha;
    private $dtcadastro;

    public function getId(){

        return $this->id;

    }

    public function setId($value){

        $this->id = $value;

    }

    public function getDeslogin(){

        return $this->deslogin;

    }

    public function setDeslogin($value){

        $this->deslogin = $value;

    }

    public function getDessenha(){

        return $this->dessenha;

    }

    public function setDessenha($value){

        $this->dessenha = $value;

    }

    public function getDtcadastro(){

        return $this->dtcadastro;

    }

    public function setDtcadastro($value){

        $this->dtcadastro = $value;

    }

    public function loadById($id){

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM tb_usuarios WHERE id = :ID", array(

            ":ID"=>$id

        ));

        if (count($results) > 0) {

            $this->setData($results[0]);

        }

    }

    public static function getList(){

        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin;");

    }

    public static function search($login){

        $sql = new Sql();

        return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(

            ':SEARCH'=>"%".$login."%"

        ));

    }

    public function login($login, $password){

        $sql = new Sql();

        $results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array(

            ":LOGIN"=>$login,
            ":PASSWORD"=>$password,

        ));

        if (count($results) > 0) {

            $this->setData($results[0]);

        } else {

            throw new Exception("Login e/ou senha inválidos.");

        }

    }

    public function setData($data){

        $this->setId($data['id']);
        $this->setDeslogin($data['deslogin']);
        $this->setDessenha($data['dessenha']);
        $this->setDtcadastro(new DateTime($data['dtcadastro']));

    }

    public function insert(){

        $sql = new Sql();

        $results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array( //criou procedure no mysql (usa o CALL no mysql e usa parenteses, se fosse mslserver seria EXECUTE)

            ':LOGIN'=>$this->getDeslogin(),
            ':PASSWORD'=>$this->getDessenha()

        ));

        if (count($results) > 0) {

            $this->setData($results[0]);

        }

    }

    public function update($login, $password)
    {
        $this->setDeslogin($login);
        $this->setDessenha($password);


        $sql = new Sql();

        $sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE id = :ID", array(

             ':LOGIN'=>$this->getDeslogin(),
            ':PASSWORD'=>$this->getDessenha(),
            ':ID'=>$this->getID()
        ));
    }

    public function delete()
    {
        $sql = new Sql();

        $sql->query("DELETE FROM tb_usuarios WHERE id= :ID", array(

            ':ID'=>$this->getID()
        ));

        $this->setId(0);
        $this->setDeslogin("");
        $this->setDessenha("");
        $this->setDtcadastro(new DateTime());
    }


   


    public function __construct($login = "", $password = "") //se inserir os dados ele chama, senão ele chama sem dados mesmo assim
    {

        $this->setDeslogin($login);
        $this->setDessenha($password);

    }


    public function __toString(){

        return json_encode(array(

            "id"=>$this->getId(),
            "deslogin"=>$this->getDeslogin(),
            "dessenha"=>$this->getDessenha(),
            "dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")

        ));

    }

}

?>