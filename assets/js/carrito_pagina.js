function actualizar(id, accion) {

    fetch(
        "../api/actualizar_carrito.php",
        {

            method: "POST",

            headers: {
                "Content-Type":
                    "application/x-www-form-urlencoded"
            },

            body:
                "id=" + id +
                "&accion=" + accion

        })

        .then(res => res.json())

        .then(() => {

            location.reload();
        });
}

function eliminar(id) {

    fetch(
        "../api/eliminar_carrito.php",
        {

            method: "POST",

            headers: {
                "Content-Type":
                    "application/x-www-form-urlencoded"
            },

            body: "id=" + id

        })

        .then(res => res.json())

        .then(() => {

            location.reload();
        });

}

function crearPedido() {

    let metodoPago =
        document.getElementById("metodoPago").value;

    // VALIDACIÓN TARJETA
    if (metodoPago == "Tarjeta") {

        let numero =
            document.getElementById("numeroTarjeta").value;

        let titular =
            document.getElementById("titular").value;

        let vencimiento =
            document.getElementById("vencimiento").value;

        let cvv =
            document.getElementById("cvv").value;

        if (
            numero == "" ||
            titular == "" ||
            vencimiento == "" ||
            cvv == ""
        ) {
            alert("Completa los datos de la tarjeta");
            return;
        }
    }

    let datos = new FormData();
    datos.append("metodo_pago", metodoPago);

    fetch("../api/crear_pedido.php", {
        method: "POST",
        body: datos
    })
    .then(res => res.json())
    .then(data => {

        if (data.success) {
            alert("Pedido realizado correctamente");
            window.location.href = "pedidos.php";
        } else {
            alert("Error al realizar el pedido");
        }

    })
    .catch(error => {
        console.error(error);
        alert("Error de conexión");
    });
}
const metodoPago = document.getElementById("metodoPago");
const datosTarjeta = document.getElementById("datosTarjeta");

if (metodoPago && datosTarjeta) {

    metodoPago.addEventListener("change", () => {

        if (metodoPago.value == "Tarjeta") {
            datosTarjeta.style.display = "block";
        } else {
            datosTarjeta.style.display = "none";
        }

    });

}