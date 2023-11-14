



Productos:
Obtener todos los productos
    Ruta: /productos
    Método: GET
    Descripción: Obtiene una lista de todos los productos disponibles.
    Ejemplo de uso:
             localhost/tp3/api/productos


Obtener un producto por ID
    Ruta: /productos/:ID
    Método: GET
    Descripción: Obtiene un producto específico por su ID.
    Ejemplo de uso:
            localhost/tp3/api/productos/123



 Obtener productos ordenados por campo
    Ruta: /api/productos?sort=:campo
    Método: GET
    Descripción: Obtiene productos ordenados según el campo especificado.
    Parámetros: 
            campo: Campo por el cual ordenar los productos.
    Ejemplos de uso:
                localhost/tp3/api/productos?sort=nombre
               



Obtener productos ordenados en un sentido específico
    Ruta: api/productos?order=:sentido
    Método: GET
    Descripción: Obtiene productos ordenados en un sentido específico (ascendente o descendente).
    Parámetros:
            sentido: Sentido de orden (asc o desc).
    Ejemplo de uso:
             localhost/tp3/api/productos?order=asc        



 Obtener productos filtrados
    Ruta: /productos?[campo]=[condicion]
    Método: GET
    Descripción: Obtiene productos según un filtro específico.
    Ejemplos de uso:
              localhost/tp3/api/productos?precio=5  
              localhost/tp3/api/productos?producto=aro de basquet



Obtener productos paginados
    Ruta: /productos?page= &perpage= 
    Método: GET
    Descripción: Obtiene productos paginados.
    Ejemplos de uso:
            localhost/tp3/api/productos?perpage=2          ->           (aparezcan 2 por paginas)  
            localhost/tp3/api/productos?perpage=2&page=2     ->         ( ir a la pagina dos)   

            

Agregar un nuevo producto (debera estar autenticado)
    Ruta: /productos
    Método: POST
    Descripción: Agrega un nuevo producto.
    Ejemplos de uso:
            localhost/tp3/api/productos
            Body:  {                                              {
                "producto":"aro de basquet",                     "producto":"notebook",                       
                "precio":200,                                    "precio":500,
                "categoriaID":18                                 "categoriaID":20
                }                                             }
                                                                    



Eliminar un producto por ID
    Ruta: /productos/:ID
     Método: DELETE
    Descripción: Elimina un producto por su ID.
    Ejemplo de uso:
             localhost/tp3/api/productos/123


Editar un producto por ID (debera estar autenticado)
    Ruta: /productos/:ID
    Método: PUT
    Descripción: Edita un producto por su ID.
    Ejemplo de uso:
            localhost/tp3/api/productos/123(id del producto)
                {                                              
                    "producto": "Producto Modificado",
                    "precio": 12,
                    "categoriaID": 18                              
                }    
            


Categorías:

Obtener productos por categoría
    Ruta: /categorias/:ID
    Método: GET
    Descripción: Obtiene productos por su categoría.
    Ejemplo de uso:
           localhost/tp3/api/categorias/20



Obtener todas las categorías
    Ruta: /categorias
    Método: GET
    Descripción: Obtiene una lista de todas las categorías disponibles.
    Ejemplo de uso:
            localhost/tp3/api/categorias



Eliminar una categoría por ID
    Ruta: /categorias/:ID
    Método: DELETE
    Descripción: Elimina una categoría por su ID.
    Ejemplo de uso:
            localhost/tp3/api/categorias/18



Agregar una nueva categoría (debera estar autenticado)
    Ruta: /categorias
    Método: POST
    Descripción: Agrega una nueva categoría.
    Ejemplo de uso:
            localhost/tp3/api/categorias
            Body: {
            "nombre": "Nueva Categoría"
            }



Editar una categoría por ID (debera estar autenticado)
    Ruta: /categorias/:ID
    Método: PUT
    Descripción: Edita una categoría por su ID.
    Ejemplo de uso:
            localhost/tp3/api/categorias/19
            Body: {
                "nombre": "Categoría Modificada"
            }



Autenticación:

Obtiene un token de autenticación para un usuario
    ruta:localhost/tp3/user/token
    descripcion: Obtiene un token de autenticación para un usuario.
    usuario:webadmin
    contraseña:admin
    Método: GET
    Realiza una solicitud GET a la ruta `/user/token` para obtener un token de autenticación.