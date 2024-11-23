document.addEventListener('DOMContentLoaded', () => {

    console.log("Loaded");
    let logoutButton = document.querySelector("#btn-logout");
    logoutButton.addEventListener('click', (e) => {
        $.ajax({
            url: "./app/controllers/LogoutController.php",
            type: "POST",
            success: function (response) {
                let responseFetch = JSON.parse(response);
                if (responseFetch.status) {

                    window.location.reload();

                }

            }

        });

    });



});