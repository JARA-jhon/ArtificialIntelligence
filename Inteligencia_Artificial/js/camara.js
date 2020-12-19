var localstream, canvas, video, cxt;

function turnOnCamera() {
    canvas = document.getElementById("canvas");
    cxt = canvas.getContext("2d");
    video = document.getElementById("video");

    if(!navigator.getUserMedia)
        navigator.getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia || 
    navigator.msGetUserMedia;
    if(!window.URL)
        window.URL = window.webkitURL;

    if (navigator.getUserMedia) {
        navigator.getUserMedia({"video" : true, "audio": false
        }, function(stream) {
            try {
                localstream = stream;
                video.srcObject = stream;
                video.play();
                $("#boton").click(function() {

                    //Pausar reproducción
                    video.pause();

                    //Obtener contexto del canvas y dibujar sobre él
                    let contexto = canvas.getContext("2d");
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    contexto.drawImage(video, 0, 0, canvas.width, canvas.height);

                    let foto = canvas.toDataURL(); //Esta es la foto, en base 64
                    //$estado.innerHTML = "Enviando foto. Por favor, espera...";
                    fetch("./guardar_foto.php", {
                            method: "POST",
                            body: encodeURIComponent(foto),
                            headers: {
                                "Content-type": "application/x-www-form-urlencoded",
                            }
                        })
                        .then(resultado => {
                            // A los datos los decodificamos como texto plano
                            return resultado.text()
                        })
                        .then(nombreDeLaFoto => {
                            // nombreDeLaFoto trae el nombre de la imagen que le dio PHP
                            console.log("La foto fue enviada correctamente");
                            // document.querySelector("#lbl_rutafoto").innerText =`C:/xampp/htdocs/ArtificialIntelligence/Inteligencia_Artificial/${nombreDeLaFoto}`;
                            // document.querySelector("#lbl_rutafoto").innerText =`${nombreDeLaFoto}`;
                            $("#lbl_rutafoto").val("C:/xampp/htdocs/ArtificialIntelligence/Inteligencia_Artificial/"+nombreDeLaFoto);

                             //$txt.set = `Foto guardada con éxito. Puedes verla <a target='_blank' href='./${nombreDeLaFoto}'> aquí</a>`;
                        })

                    //Reanudar reproducción
                    video.play();
                });
            } catch (error) {
                video.srcObject = null;
            }
        }, function(err){
            swal("Error", err, "error");
        });
    } else {
        swal("Mensaje", "User Media No Disponible" , "error");
        return;
    }
}

function turnOffCamera() {
    video.pause();
    video.srcObject = null;
    localstream.getTracks()[0].stop();
}

$("#radiotfoto").click(function() {
    $("#subirfoto").addClass("none");
    $("#video").removeClass("none");
    turnOnCamera();
    document.getElementById("subirfoto").value = null;
});

$("#radiosfoto").click(function() {
    $("#subirfoto").removeClass("none");
    $("#video").addClass("none");
    turnOffCamera();
});

// $boton.addEventListener("click", function() {
//     alert("Entra");
//         let contexto = canvas.getContext("2d");
//         canvas.width = video.videoWidth;
//         canvas.height = video.videoHeight;
//         contexto.drawImage(video, 0, 0, canvas.width, canvas.height);
    
//         let foto = canvas.toDataURL();
    
//         let enlace = document.createElement(contexto);
//         enlace.download = "foto.png";
//         enlace.href = foto;
//         enlace.click();
//     });

$("#ff").click( function() {

    //Pausar reproducción
    $video.pause();

    //Obtener contexto del canvas y dibujar sobre él
    let contexto = $canvas.getContext("2d");
    $canvas.width = $video.videoWidth;
    $canvas.height = $video.videoHeight;
    contexto.drawImage($video, 0, 0, $canvas.width, $canvas.height);

    let foto = $canvas.toDataURL(); //Esta es la foto, en base 64
    $estado.innerHTML = "Enviando foto. Por favor, espera...";
    fetch("./guardar_foto.php", {
            method: "POST",
            body: encodeURIComponent(foto),
            headers: {
                "Content-type": "application/x-www-form-urlencoded",
            }
        })
        .then(resultado => {
            // A los datos los decodificamos como texto plano
            return resultado.text()
        })
        .then(nombreDeLaFoto => {
            // nombreDeLaFoto trae el nombre de la imagen que le dio PHP
            console.log("La foto fue enviada correctamente");
            $estado.innerHTML = `Foto guardada con éxito. Puedes verla <a target='_blank' href='./${nombreDeLaFoto}'> aquí</a>`;
        })

    //Reanudar reproducción
    $video.play();
});

