function toggleFavorito(productoId) {

    let datos = new FormData();

    datos.append(
        "producto_id",
        productoId
    );

    fetch(
        "../api/favoritos.php",
        {
            method: "POST",
            body: datos
        }
    )
    .then(res => res.json())
    .then(data => {

        if(data.success){

            const btn =
            document.querySelector(
                `[data-favorito="${productoId}"]`
            );

            if(data.accion === "agregado"){

                btn.innerHTML = "❤️";

            }else{

                btn.innerHTML = "🤍";

            }

        }

    });

}

function eliminarFavorito(productoId) {

    let datos = new FormData();

    datos.append(
        "producto_id",
        productoId
    );

    fetch(
        "../api/favoritos.php",
        {
            method: "POST",
            body: datos
        }
    )
    .then(res => res.json())
    .then(data => {

        if(data.success){

            location.reload();

        }

    });

}