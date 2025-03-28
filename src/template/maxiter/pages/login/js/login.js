document.addEventListener('DOMContentLoaded', () => {

    let loginForm = document.querySelector("#login-form");
    loginForm.addEventListener("submit", (e) => {
        e.preventDefault();

        let data = new FormData(loginForm);
        let dataObj = Object.fromEntries(data);

        $.ajax({
            url: path.APP_BASE_URL + "app/controllers/UsersController.php",
            type: "POST",
            data: {
                user: dataObj.user,
                password: dataObj.password
            },
            success: function(response) {

                // console.log("Response",response);
                let responseFetch = JSON.parse(response);

                if(responseFetch.status == true) {

                    // Redirect home page
                    window.location.href = path.APP_BASE_URL + "home";
                    
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