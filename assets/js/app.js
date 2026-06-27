
const btn =
document.getElementById(
    "themeBtn"
);

if (btn) {

    btn.addEventListener(
        "click",
        () => {
            
            document.body.classList.toggle(
                "dark"
            );

            localStorage.setItem(
                "theme",
                document.body.classList.contains(
                    "dark"
                )
            );
        }
    );

}

if (
    localStorage.getItem(
        "theme"
    ) == "true"
) {

    document.body.classList.add(
        "dark"
    );

}

function mostrarToast(texto){

    const toast =
    document.getElementById(
        "toast"
    );

    toast.innerText = 
    texto;

    toast.classList.add(
        "show"
    );

    setTimeout(()=>{

        toast.classList.remove(
            "show"
        );
    },2500);

}

if('serviceWolker' in navigator){

    navigator.serviceWorker.register(
        '/sw.js'
    );
}