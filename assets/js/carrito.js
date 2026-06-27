function agregarCarrito(id, stock) {

    if (stock <= 0) {
        alert("No hay stock disponible");
        return;
    }

    fetch("../api/agregar_carrito.php", {
        method: "POST",

        headers: {
            "Content-Type":
                "application/x-www-form-urlencoded"
        },
        body: "id=" + id
    })
        .then(res => res.json())

        .then(data => {

            document.getElementById(
                "contadorCarrito"
            ).innerText =
                data.cantidad;


            mostrarToast(
                "Producto agregado"
            );
        });
}

function actualizarContador() {

    fetch("../api/carrito_count.php")

        .then(res => res.json())

        .then(data => {

            document.getElementById(
                "contadorCarrito"
            ).innerText =
                data.cantidad;
        });

}

actualizarContador();

const buscador =
    document.getElementById("buscar");

if (buscador) {

    buscador.addEventListener(
        "keyup",
        function () {

            let texto =
                this.value.toLowerCase();

            let productos =
                document.querySelectorAll(
                    ".producto"
                );

            productos.forEach(p => {

                let nombre =
                    p.dataset.nombre;

                if (
                    nombre.includes(texto)
                ) {
                    p.style.display = "block";
                } else {
                    p.style.display = "none";
                }
            });
        });
}

function filtrar(categoria, btn) {

    let bloques = document.querySelectorAll(".categoria-bloque");

    bloques.forEach(bloque => {

        let cat = bloque.dataset.categoria;

        if (categoria === "all" || cat === categoria) {
            bloque.style.display = "block";
        } else {
            bloque.style.display = "none";
        }
    });

    // botón activo (opcional)
    document.querySelectorAll(".btn-categoria")
        .forEach(b => b.classList.remove("active"));

    btn.classList.add("active");
}