


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
function agregarAlCarrito(producto){
    

    datosCarrito = JSON.parse(localStorage.getItem("datosCarrito"))

    if(!datosCarrito || !datosCarrito[0] ){
        datosCarrito = [producto.id_producto+producto.nombre_producto:{...producto, cantidad:1}]
    }else{
        
    }



    console.log(datosCarrito)
    localStorage.setItem("datosCarrito", JSON.stringify(datosCarrito));

}


