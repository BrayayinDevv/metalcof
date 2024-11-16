


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


//agregar al carrito
function agregarAlCarrito(producto) {
    let datosCarrito = JSON.parse(localStorage.getItem("datosCarrito")) || {};

    // Si el producto no está en el carrito, agregarlo
    if (!datosCarrito[producto.id_producto]) {
        datosCarrito[producto.id_producto] = { ...producto, cantidad: 1 };
    } else {
        // Si ya existe, incrementa la cantidad
        datosCarrito[producto.id_producto].cantidad += 1;
    }

    alert("Cantidad de productos agregados al stock:" + datosCarrito[producto.id_producto].cantidad)
    localStorage.setItem("datosCarrito", JSON.stringify(datosCarrito));
}





