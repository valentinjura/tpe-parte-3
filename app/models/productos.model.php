<?php
require_once './app/models/model.php';
class ProductosModel extends Model{

    function getProductos($sort,$order){
        $query = $this->db->prepare("SELECT A.id,A.producto,A.precio,A.stock,B.nombre FROM productos A INNER JOIN categorias B ON A.categoriaID=B.CategoriaID ORDER BY $sort $order");
        
        $query-> execute();

        $productos =$query->fetchAll(PDO::FETCH_OBJ);

        return $productos;
    }
    

    function getProductoEspecifico($id){
        $query = $this->db->prepare('SELECT A.id,A.producto,A.precio,A.stock,B.nombre FROM productos A INNER JOIN categorias B ON A.categoriaID=B.CategoriaID WHERE A.id=?');
        $query-> execute([$id]);

        $productos =$query->fetch(PDO::FETCH_OBJ);

        return $productos;
    }

    function getProductosPorFiltro($tabla,$filtro,$condicion){
        $query = $this->db->prepare("SELECT A.id,A.producto,A.precio,A.stock,B.nombre FROM productos A INNER JOIN categorias B ON A.categoriaID=B.CategoriaID WHERE $tabla.$filtro=?");
        $query-> execute([$condicion]);

        $productos =$query->fetchAll(PDO::FETCH_OBJ);

        return $productos;
    }

    function getProductosPaginados($indice,$perPage){
        $query = $this->db->prepare("SELECT A.id,A.producto,A.precio,A.stock,B.nombre FROM productos A INNER JOIN categorias B ON A.categoriaID=B.CategoriaID LIMIT $perPage OFFSET $indice");
        
        $query-> execute();

        $productos =$query->fetchAll(PDO::FETCH_OBJ);

        return $productos;
    }


    function insertProducto($producto, $precio, $categoria) {        
    
        $query = $this->db->prepare('INSERT INTO productos (producto, precio, categoriaID) VALUES(?,?,?)');
        $query->execute([$producto, $precio, $categoria]);
    
        return $this->db->lastInsertId();
    }

    function deleteProducto($id){        
        
        $query = $this->db->prepare('DELETE FROM productos WHERE id=?');
        $query->execute([$id]);
    }

    function editProducto($producto, $precio, $categoria, $id){
        $query = $this->db->prepare('UPDATE productos SET producto=?, precio=?, categoriaID=? WHERE id=?');
        $query->execute([$producto, $precio, $categoria,$id]);

    }

    function getProductosByCategoria($categoriaID){ 
        $query = $this->db->prepare('SELECT A.id,A.producto,A.precio,A.stock,B.nombre FROM productos A INNER JOIN categorias B ON A.categoriaID=B.CategoriaID WHERE A.categoriaID=?' );
        $query-> execute([$categoriaID]);

        $productos =$query->fetchAll(PDO::FETCH_OBJ);

        return $productos;
    }

    

}