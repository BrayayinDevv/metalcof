//Login//
document.getElementById("showRegister").addEventListener("click", function(event) {
    event.preventDefault();
    document.getElementById("loginContainer").classList.add("hidden");
    document.getElementById("registerContainer").classList.remove("hidden");
});

document.getElementById("showLogin").addEventListener("click", function(event) {
    event.preventDefault();
    document.getElementById("registerContainer").classList.add("hidden");
    document.getElementById("loginContainer").classList.remove("hidden");
});


//Barra-De-Busqueda//
function buscarProductos() {
    const input = document.querySelector('.search-bar input');
    const filter = input.value.toLowerCase();
    const productos = document.querySelectorAll('.product-card');

    productos.forEach(producto => {
        const nombre = producto.querySelector('h4').innerText.toLowerCase();
        const descripcion = producto.querySelector('p').innerText.toLowerCase();

        if (nombre.includes(filter) || descripcion.includes(filter)) {
            producto.style.display = "block";
        } else {
            producto.style.display = "none";
        }
    });
}

// Función para agregar productos al carrito
function agregarAlCarrito(producto) {
    console.log("Producto agregado:", producto);

    let datosCarrito = JSON.parse(localStorage.getItem("datosCarrito")) || {};
    console.log("Estado inicial del carrito:", datosCarrito);

    if (!datosCarrito[producto.id_producto]) {
        datosCarrito[producto.id_producto] = { ...producto, cantidad: 1 };
    } else {
        datosCarrito[producto.id_producto].cantidad += 1;
    }

    localStorage.setItem("datosCarrito", JSON.stringify(datosCarrito));
    console.log("Estado actualizado del carrito:", datosCarrito);

    actualizarContadorCarrito();
}

function actualizarContadorCarrito() {
    let datosCarrito = JSON.parse(localStorage.getItem("datosCarrito")) || {};
    console.log("Datos cargados de localStorage:", datosCarrito);

    let totalProductos = 0;

    for (const productoId in datosCarrito) {
        totalProductos += datosCarrito[productoId].cantidad;
    }

    console.log("Total de productos en el carrito:", totalProductos);

    const contadorCarrito = document.getElementById("carrito-contador");
    if (contadorCarrito) {
        contadorCarrito.textContent = totalProductos;
    }
}

document.addEventListener("DOMContentLoaded", () => {
    console.log("Página cargada, actualizando contador...");
    actualizarContadorCarrito();
});