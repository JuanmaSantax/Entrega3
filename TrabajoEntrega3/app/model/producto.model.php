<?php
require_once 'modelHelper.php';

// pagina de conexion con la tabla productos de la bd jj_autopartes
class productoModel extends ModelHelper  {
    function getProductos(){
        $consulta = $this->bd->prepare('SELECT * FROM productos');//trae todo de la bd productos
        $consulta->execute();
        $productos = $consulta->fetchAll(PDO::FETCH_OBJ);// el fetchAll me devuelve un arreglo (formato objeto) de productos ya que trae todos
        return $productos;//productos en eun arreglo de productos 
    }
    function getProducto($id){
        $consulta = $this->bd->prepare('SELECT * FROM productos WHERE id_producto = ?');
        $consulta->execute([$id]);
        $producto = $consulta->fetch(PDO::FETCH_OBJ);
        return $producto;
    }

    

    function getProductosCategoria($categoria){
        $consulta = $this->bd->prepare('SELECT * FROM productos WHERE id_categoria=?' );
        $consulta->execute([$categoria]);
        $productos = $consulta->fetchAll(PDO::FETCH_OBJ);
        return $productos;
    }

    //insertamos producto en la BD
    function insertarProducto($producto, $descripcion, $precio,$id_categoria){
      /*  los values con signo de pregunta por que hay q validarlos*/ 
         $consulta = $this->bd->prepare('INSERT INTO productos (producto, descripcion, precio,id_categoria) VALUES(?,?,?,?)');
         $consulta->execute([$producto, $descripcion, $precio, $id_categoria]);

        return $this->bd-> lastInsertID(); // funcion por defecto
    }
    function editarProducto($id){
        $consulta = $this->bd->prepare('SELECT producto, precio, descripcion, id_producto FROM productos  WHERE id_producto = ?');
        $consulta->execute([$id]);
        $modificar = $consulta->fetchAll(PDO::FETCH_OBJ);
        return $modificar;
    }
    function actualizarProducto( $producto, $precio, $descripcion,  $id_producto){
        $consulta = $this->bd->prepare("UPDATE productos SET producto = ?, precio = ?, descripcion = ?  WHERE id_producto = ?");
        $consulta->execute([$producto, $precio, $descripcion, $id_producto]);
    }
    function borrarProducto($id){
        $consulta = $this->bd->prepare('DELETE FROM productos WHERE id_producto = ?');// dejo el signo de pregunta por que esta bindiado
        $consulta->execute([$id]);
    }
    function getIdcategoriaPorId($id){
        $consulta = $this->bd->prepare('SELECT id_categoria FROM productos  WHERE id_producto = ?');
        $consulta->execute([$id]);

        $idCategoria = $consulta->fetch(PDO::FETCH_OBJ);
        return $idCategoria;
    }
    function eliminarProductosPorCategoria($categoria){
        $consulta = $this->bd->prepare ('DELETE FROM productos WHERE id_categoria = ?');
        $consulta->execute([$categoria]);
    }

}