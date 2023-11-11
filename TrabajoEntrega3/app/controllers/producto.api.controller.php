<?php
    require_once 'app/model/producto.model.php';
    require_once 'app/controllers/api.controller.php';

    class ProductoApiController extends ApiController{
        private $model;

        function __construct() {
            parent::__construct();
            $this->model = new productoModel();       
        }

        function get($params = []){
            if(empty($params)){
               $productos = $this->model->getProductos();
               $this->view->response($productos, 200);
            }else{
                $producto = $this->model->getProducto($params [':ID']);
                $this->view->response($producto, 200);
                if(empty($producto)){
                    if ($params[':subrecurso']){
                        switch($params[':subrecurso']){
                            case 'ordenar':
                                $productos = $this->model->getProductos();
                                    if($productos){
                                        usort($productos, function ($a, $b) {
                                            return $a['precio'] <=> $b['precio'];
                                    });
                                    foreach ($productos as $producto) {
                                        $this->view->response("Nombre: " . $producto['nombre'] . " - Precio: " . $producto['precio'] . "descripcion: ". $producto['descripcion'], 200); 
                                    }
                                }else{
                                    $this->view->response("error en la consulta " , 404);
                                }
                            break;    

                            default:
                            $this->view->response("error en la consulta " , 404);
                            break;
                        }
                    
                }        }
            
                $producto = $this->model->getProducto($params[':ID']);
                if(!empty($producto)){
                   
                } else{
                    $this->view->response('El producto con el id='.$params[':ID'].' no existe.' , 404);       
                }
            }   
        }
        function agregarProducto($params = []) {
            $body = $this->getData();
   
            $producto = $body->producto;
            $descripcion = $body->descripcion;
            $precio = $body->precio;
            $id_categoria = $body->id_categoria;
   
            $id = $this->model->insertarProducto($producto, $precio, $descripcion, $id_categoria);
   
            $this->view->response('producto insertado con id='.$id, 201);
        }

        function borrarProducto($params = []){
            $id = $params[':ID'];
            $producto = $this->model->getProducto($id);

            if($producto) {
                $this->model->borrarProducto($id);
                $this->view->response('producto con id='.$id.' fue borrado.', 200);
            } else {
                $this->view->response('el producto con id='.$id.' no existe.', 404);
            }
    }

        function updateProducto($params = []) {
            $id = $params[':ID'];
            $producto = $this->model->getProducto($id);
            if($producto) {
                $body = $this->getData();
                $producto = $body->producto;
                $descripcion = $body->descripcion;
                $precio = $body->precio;
                $id_producto = $body->id_producto;

                if(!empty($producto) && !empty($descripcion) && ($precio > 0 )&& !empty($id_producto)){
                $this->model->actualizarProducto($producto,$precio,$descripcion, $id_producto);
                $this->view->response('El producto con id='.$id.' fue actualizado.', 200);
                }else{
                    $this->view->response('Falata completar bien algun campo', 404);
                }
            } else {
                $this->view->response('El producto con id='.$id.' no existe.', 404);
        }    }    
}




