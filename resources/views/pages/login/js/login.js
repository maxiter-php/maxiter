document.addEventListener('DOMContentLoaded', () => {

    let loginForm = document.querySelector("#login-form");
    loginForm.addEventListener("submit", (e) => {
        e.preventDefault();

        let data = new FormData(loginForm);
        let dataObj = Object.fromEntries(data);

        $.ajax({
            url: "../../../../app/controllers/LoginController.php",
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