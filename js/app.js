"use strict"

const URL = "api/productos/";

let productos = [];


async function getAll() {
    try {
        let response = await fetch(URL);
        if (!response.ok) {
            throw new Error('Recurso no existe');
        }
        productos = await response.json();

        

        showProductos();
    } catch(e) {
        console.log(e);
    }
}



function showProductos() {
    let tbody = document.querySelector("#tabla-productos");
    tbody.innerHTML = "";
    for (const producto of productos) {

        let html = `<tr>
                        <th scope='row'> ${producto.id} </th>
                        <td> ${producto.producto} </td>
                        <td> ${producto.precio} </td>
                        <td> ${producto.nombre} </td>
                        <td>
                        <a href='#' data-producto="${producto.id}" class="btn btn-danger btn-sm btn-eliminar">Eliminar</a>
                        </td>
                    </tr>`;
        tbody.innerHTML += html

        const btnsEliminar = document.querySelectorAll('a.btn-eliminar');
        for (const btnEliminar of btnsEliminar) {
            btnEliminar.addEventListener('click', deleteProducto);
        }

    }
}



async function deleteProducto(e) {
    e.preventDefault();
    
    try {
        let id = e.target.dataset.producto;
        let response = await fetch(URL + id, {method: 'DELETE'});
        if (!response.ok) {
            throw new Error('Recurso no existe');
        }

        // eliminar la tarea del arreglo global
        productos = productos.filter(productos => productos.id != id);
        showProductos();
    } catch(e) {
        console.log(e);
    }
}

getAll();