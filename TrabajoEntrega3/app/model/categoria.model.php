<?php
require_once 'app/modelHelper.php';
require_once 'config.php';

class categoriaModel extends ModelHelper{  
    function getCategorias(){
        $consulta = $this->bd->prepare('SELECT categoria FROM categorias');//trae todo de la bd categoria
        $consulta->execute();

        $categorias = $consulta->fetchAll(PDO::FETCH_OBJ);// el fetchAll me devuelve un arreglo (formato objeto) de productos ya que trae todos
        return $categorias;//productos en eun arreglo de productos 
    }
    function getCategoria($categoria){
        $consulta = $this->bd->prepare('SELECT id_categoria FROM categorias WHERE categoria = ?');//trae todo de la bd categoria
        $consulta->execute([$categoria]);

        $id = $consulta->fetch(PDO::FETCH_OBJ);// el fetchAll me devuelve un arreglo (formato objeto) de productos ya que trae todos
        return $id;//productos en eun arreglo de productos 
    }
    function getCategoriaPorId($id){
        $consulta = $this->bd->prepare('SELECT categoria FROM categorias WHERE id_categoria = ?');
        $consulta->execute([$id]);
        $Categoria = $consulta->fetchAll(PDO::FETCH_OBJ);
       
        return $Categoria; 
    }
    function getCategoriaEditar($id){
        $consulta = $this->bd->prepare('SELECT categoria, id_categoria FROM categorias WHERE id_categoria = ?');
        $consulta->execute([$id]);
        $Categoria = $consulta->fetchAll(PDO::FETCH_OBJ);
        return $Categoria; 
    }
    function editarCategoria($categoriaNueva, $categoriaVieja){
        $consulta = $this->bd->prepare('UPDATE categorias SET categoria = ? WHERE categoria = ?');
        $consulta->execute([$categoriaNueva, $categoriaVieja]);
        
    }
    function agregarCategoria($categoria){
        $consulta = $this->bd->prepare('INSERT INTO categorias(categoria) VALUES (?)');
        $consulta->execute([$categoria]);
        return $this->bd-> lastInsertID();
    }

    function eliminarCategoria($categoria){
        $consulta = $this->bd->prepare('DELETE FROM categorias WHERE id_categoria = ?');
        $consulta->execute([$categoria]);
    }
    //INSERT INTO `categorias` (`id_categoria`, `categoria`) VALUES (NULL, 'camion')
    //return $this->bd-> lastInsertID();
    
}