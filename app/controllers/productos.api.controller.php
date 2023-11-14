<?php
    require_once 'app/controllers/api.controller.php';
    require_once 'app/models/Categorias.model.php';
    require_once 'app/models/productos.model.php';
    require_once 'app/helpers/auth.api.helper.php';

    class ProductosApiController extends ApiController {
        private $model;
        private $modelCategorias; 
        private $authHelper;       

        function __construct() {
            parent::__construct();
            $this->model = new ProductosModel();
            $this->modelCategorias = new CategoriasModel();
            $this->authHelper = new AuthHelper();
        }     

        function getProductos($params = []) {
            if (empty($params)){

                
                $get=array_keys($_GET);//Convierto lo obtenido en _GET en un arreglo numerico para preguntar por la segunda posición 
                
                /*Pregunto si es estan definidos los parametros de ordenamiento
                o si no hay ninguno definido*/
                if(isset($_GET['sort'])||isset($_GET['order'])||!isset($get[1])){
                    $this->getOrdenado();
                    return;
                }

                //Pregunta si estan definidos los filtros
                if(isset($_GET['precio'])||isset($_GET['id'])||isset($_GET['producto'])||isset($_GET['nombre'])){
                    $this->getFiltro($get);                   
                    return;
                }

                //Pregunta si esta definido el paginado
                if(isset($_GET['page']) || isset($_GET['perpage'])){
                    $this->getPaginado();
                    return;
                }

                $this->view->response("No existen esos parametros", 400);
                return;


            } else{       
                
                //verifico que sea un numero (un ID)
                if(!is_numeric($params[':ID'])){
                    $this->view->response("No existen esos parametros", 400);
                    return;
                }

                $producto= $this->model->getProductoEspecifico($params[':ID']);
                if(!empty($producto)){
                    $this->view->response($producto,200);
                    return;
                }else{
                    $this->view->response("No existe producto con ese ID", 404);
                    return;
                }
            }
        }

        function getOrdenado(){

            $sort =  $_GET['sort']??  'id'; //si no hay parametro de ordenamiento se asigna ID
            $order =  $_GET['order']?? 'asc';//si no hay parametro de ordenamiento se asigna ASC

            // Verifica que la dirección de ordenamiento sea válida
            if (!in_array($order, ['asc', 'desc']) || !in_array($sort, ['id', 'producto', 'precio', 'nombre'])) {


                $this->view->response("Dirección de ordenamiento no válida", 400);
                return;
            }
            $productos= $this->model->getProductos($sort,$order);  
            $this->view->response($productos,200);
            return;

        }

        function getFiltro($get){

            //obtengo los parametros
            $filtro=$get[1];
            $condicion=$_GET[$filtro];
       
           
            //pregunto si el filtro es un campo de la tabla productos o de la tabla categorias
            if($filtro=="nombre"){
                $tabla="B";
            }else{
                $tabla="A";
            }
            
            $productos= $this->model->getProductosPorFiltro($tabla,$filtro,$condicion);
            if(!empty($productos)){
                $this->view->response($productos,200);
                return;
            }else{
                $this->view->response("No hay productos para ese filtro",400);
                return;
            }            
        }

        function getPaginado(){
            $page = $_GET['page']??1; //si no hay parametro se asigna 1 como pagina de inicio
            $perPage = $_GET['perpage']??5; //si no hay parametro se asigna 5 elementos por pagina

            //Se asegura que los parametros son numeros
            if(is_numeric($page)&& is_numeric($perPage)){
                
                // Calcula el índice de inicio para la paginación
                $indice = ($page - 1) * $perPage;
                
                $productos= $this->model->getProductosPaginados($indice,$perPage);
                $this->view->response($productos,200);
                return;
            }else{
                $this->view->response('Los parámetros deben ser números', 400);
                return;
            }
        }


        function deleteProducto($params = []) {
            $id = $params[':ID'];
            $producto = $this->model->getProductoEspecifico($id);

            if($producto) {
                $this->model->deleteProducto($id);
                $this->view->response('La tarea con id= '.$id.' eliminado con exito' , 200);
                return;
            } else {
                $this->view->response('La tarea con id='.$id.' no existe.', 404);
                return;
            }
        }

    
        function insertProducto() {
            $user = $this->authHelper->currentUser();
    
    if (!$user) {
        $this->view->response("Unauthorized", 401);
        return;
    }

    // Verificar si la propiedad $role está definida en el objeto $user
    if (property_exists($user, 'role') && $user->role !== 'ADMIN') {
        $this->view->response("Forbidden", 403);
        return;
    }
            $body = $this->getData();
            
            if(isset($body->producto,$body->precio,$body->categoriaID)){

                $producto = $body->producto;
                $precio= $body->precio;
                $categoriaID= $body->categoriaID;

                $categoria = $this->modelCategorias->getCategoriaById($categoriaID);

                if($categoria){

                    $id = $this->model->insertProducto($producto, $precio, $categoriaID);
                    $producto = $this->model->getProductoEspecifico($id);
                    if(!empty($producto)){    
                        $this->view->response($producto, 201);
                        return;
                    }
                }else{
                    $this->view->response('No existe categoria con ese ID', 404);
                    return;
                }
                    
                
            }else{
                $this->view->response("Complete los datos", 400);
                return;
            }
        }

        function editProducto($params = []) {
            $user = $this->authHelper->currentUser();
    
            if (!$user) {
                $this->view->response("Unauthorized", 401);
                return;
            }
        
            // Verificar si la propiedad $role está definida en el objeto $user
            if (property_exists($user, 'role') && $user->role !== 'ADMIN') {
                $this->view->response("Forbidden", 403);
                return;
            }
            $id = $params[':ID'];
            $productoEspecifico = $this->model->getProductoEspecifico($id);

            if($productoEspecifico) {
                $body = $this->getData();
                if(isset($body->producto,$body->precio,$body->categoriaID)){
                    $producto = $body->producto;
                    $precio = $body->precio;
                    $categoria = $body->categoriaID;

                    $this->model->editProducto($producto , $precio, $categoria, $id );

                    $this->view->response($productoEspecifico, 200);
                }else{
                    $this->view->response("Complete los datos", 400);
                    return;
                }
            } else {
                $this->view->response('La tarea con id='.$id.' no existe.', 404);
            }
        }

    }