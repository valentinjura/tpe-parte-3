<?php
    require_once 'config.php';
    require_once 'libs/router.php';
    require_once 'app/controllers/productos.api.controller.php';
    require_once 'app/controllers/categorias.api.controller.php';
    require_once 'app/controllers/user.api.controller.php';

    $router = new Router();

    #                 endpoint                   verbo                  controller                   Método
    
    $router->addRoute('productos',              'GET',          'ProductosApiController',       'getProductos'   );
    $router->addRoute('productos/:ID',          'GET',          'ProductosApiController',       'getProductos'   );
    
    $router->addRoute('productos',              'POST',         'ProductosApiController',       'insertProducto');
    $router->addRoute('productos/:ID',          'DELETE',       'ProductosApiController',       'deleteProducto');
    $router->addRoute('productos/:ID',          'PUT',          'ProductosApiController',       'editProducto');


    $router->addRoute('categorias/:ID',         'GET',          'CategoriasApiController',      'getCategorias');
    $router->addRoute('categorias',             'GET',          'CategoriasApiController',      'getCategorias');
    $router->addRoute('categorias/:ID',         'DELETE',       'CategoriasApiController',      'deleteCategoria');
    $router->addRoute('categorias',             'POST',         'CategoriasApiController',      'insertCategoria');
    $router->addRoute('categorias/:ID',         'PUT',          'CategoriasApiController',      'editCategoria');

    $router->addRoute('user/token',             'GET',          'UserApiController',            'getToken'   );
    

    
    

    $router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
    