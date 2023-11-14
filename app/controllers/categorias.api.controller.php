<?php
    require_once 'app/controllers/api.controller.php';
    require_once 'app/models/Categorias.model.php';
    require_once 'app/helpers/auth.api.helper.php';


    class CategoriasApiController extends ApiController {
        private $model;
        private $authHelper;

        function __construct() {
            parent::__construct();
            $this->model = new CategoriasModel();
            $this->authHelper = new AuthHelper();
        }


        function getCategorias($params = []) {
            if (empty($params)){

                $get=array_keys($_GET);

                if(isset($_GET['sort'])||isset($_GET['order'])||!isset($get[1])){
                    $this->getOrdenado();
                    return;
                }

                if(isset($_GET['categoriaID'])||isset($_GET['nombre'])){
                    $this->getFiltro($get);                   
                    return;
                }

                if(isset($_GET['page']) || isset($_GET['perpage'])){
                    $this->getPaginado();
                    return;
                }

                $this->view->response("No existen esos parametros", 400);
                return;
            
            }else{
                $categorias = $this->model->getCategoriaById($params[':ID']);
                    if ($categorias) {
                        $this->view->response($categorias, 200);
                    }else{
                        $this->view->response("No se encontraron categorías con ese id.", 404);
                    }

            }

        }
        

        function getOrdenado(){

            $sort =  $_GET['sort']??  'categoriaID'; //si no hay parametro de ordenamiento se asigna categoriaID
            $order =  $_GET['order']?? 'asc';//si no hay parametro de ordenamiento se asigna ASC

            // Verifica que la dirección de ordenamiento sea válida
            if (!in_array($order, ['asc', 'desc']) || !in_array($sort, ['categoriaID', 'nombre'])) {
                $this->view->response("Dirección de ordenamiento no válida", 400);
                return;
            }
            $categorias= $this->model->getAllCategorias($sort,$order);  
            $this->view->response($categorias,200);
            return;

        }

        function getFiltro($get){

            //obtengo los parametros
            $filtro=$get[1];
            $condicion=$_GET[$filtro];
            
            $categorias= $this->model->getCategoriasPorFiltro($filtro,$condicion);
            if(!empty($categorias)){
                $this->view->response($categorias,200);
                return;
            }else{
                $this->view->response("No hay categorias para ese filtro",400);
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
                
                $categorias= $this->model->getCategoriasPaginadas($indice,$perPage);
                $this->view->response($categorias,200);
                return;
            }else{
                $this->view->response('Los parámetros deben ser números', 400);
                return;
            }
        }


        function deleteCategoria($params = []) {
            $id = $params[':ID'];
            $categoria= $this->model->getCategoriaById($id);

            if($categoria) {
                $this->model->deleteCategoria($id);
                $this->view->response('la Categoria con id='.$id.' ha sido borrada.', 200);
            } else {
                $this->view->response('la Categoria con id='.$id.' no existe.', 404);
            }
        }


        function insertCategoria() {
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
            if(isset($body->nombre)){
                $nombre = $body->nombre;
                
                $categoriaID = $this->model->insertCategoria($nombre);

                // en una API REST es buena práctica es devolver el recurso creado
                $categoria = $this->model->getCategoriaById($categoriaID);
                $this->view->response($categoria, 201);
                return;
                
            }else{
                $this->view->response("Complete los datos", 400);
            }
        }

        function editCategoria($params = []){
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
                $categoriaID = $params[':ID'];
                $categoriaEspecifica = $this->model->getCategoriaById($categoriaID);

                if($categoriaEspecifica) {
                    $body = $this->getData();
                    if(isset($body->nombre)){
                        $nombre = $body->nombre;
                        $this->model->editCategoria($nombre, $categoriaID);
                        $this->view->response('La tarea con id='.$categoriaID.' ha sido modificada.', 200);
                    }else{
                        $this->view->response("Complete los datos", 400);
                    }
                } else {
                    $this->view->response('La tarea con id='.$categoriaID.' no existe.', 404);
                }
        }
    
    }
