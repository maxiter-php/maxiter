document.addEventListener('DOMContentLoaded', () => {

    // Obtém a URL base da página
    let absolutePath = window.location.origin;

    // Aqui você pode apenas concatenar o caminho relativo, sem manipulações com "../"
    let loginUrl = absolutePath + "/app/controllers/LogoutController.php";

    let loginForm = document.querySelector("#login-form");
    loginForm.addEventListener("submit", (e) => {
        e.preventDefault();

        let data = new FormData(loginForm);
        let dataObj = Object.fromEntries(data);

        $.ajax({
            url: loginUrl,
            type: "POST",
            data: {
                user: dataObj.user,
                password: dataObj.password
            },
            success: function(response) {

                // console.log("Response",response);
                let responseFetch = JSON.parse(response);

                if(responseFetch.status == true) {

                    window.location.href = "../index/";
                    
                } else {
                    console.log(responseFetch.data);
                    Swal.fire({
                        title: "Oops!",
                        text: responseFetch.data,
                        icon: "error"
                      });
                }

            }
        });
    });

}); 