<?php
/**
 * As classes DAO (Data Access Object) executam os codigos junto da execução do banco de dados (pode acessa-lo).
 */

class CategoriaDAO
{
    /**
     * Atributo (ou Propriedade) da classe que armazena a conexão com o banco (link/via)
     */
    private $conexao;


    /**
     * Método construtor, chamado quando se instancia uma classe, 
     * podendo abrir uma conexao com o banco.
     */
    function __construct() 
    {
        // DSN (Data Source Name), onde ficam as especificações do acesso ao banco de dados
         
        $dsn = "mysql:host=localhost:3307;dbname=db_sistema";
        $user = "root";
        $pass = "etecjau";
        
        // conexão criada e armazenada na propriedade definida para ela.
        $this->conexao = new PDO($dsn, $user, $pass);
    }


    /**
     * Método esta recebendo a model e pegando os dados referente a tabela para inserilos (insert)
     */
    function insert(CategoriaModel $model) 
    {
        // Trecho de código SQL com marcadores ? para substituir com os dados, no prepare   
        $sql = "INSERT INTO categorias 
                (descricao) 
                VALUES (?)";
        

        //a variavel stmt tera a consulta montada, alem de o prepare estar dentro da 
        //$conexao e recebendo com os marcadores correspondentes
       
        $stmt = $this->conexao->prepare($sql);

        // Aqui, o bindValue recebe o valor da determinada posição, que veio via
        //parâmetro da model
        $stmt->bindValue(1, $model->descricao);
        
        
        // A consulta é executada
        $stmt->execute();      
    }




/**
     * Recebe o Model preenchido com os dados e atualiza no banco 
     * (o id deve estar preenchido)
     */
    public function update(CategoriaModel $model)
    {
        $sql = "UPDATE categorias SET descricao=? WHERE id=? ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $model->descricao);
        $stmt->bindValue(2, $model->id);
        
        $stmt->execute();
    }


    /**
     * Método que seleciona e retorna todos (*) os registro da tabela no banco.
     */



    public function select()
    {
        $sql = "SELECT * FROM categorias ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }




/**
     * Retorna um item especifico da tabela do banco
     * Visto que, esse metodo precisa de um id inteiro.
     */
    public function selectById(int $id)
    {
        include_once 'Model/CategoriaModel.php';

        $sql = "SELECT * FROM categorias WHERE id = ?";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();

        return $stmt->fetchObject("CategoriaModel"); // Retornando um objeto específico PessoaModel
    }

/**
     * Deleta um item da tabela e precisa de um id inteiro
     */
    public function delete(int $id)
    {
        $sql = "DELETE FROM categorias WHERE id = ? ";

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
    }


}