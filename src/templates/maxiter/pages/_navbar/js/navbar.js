document.addEventListener('DOMContentLoaded', () => {
    
    let logoutButton = document.querySelector("#btn-logout");
    if (logoutButton) {
        logoutButton.addEventListener('click', (e) => {
            $.ajax({
                url: path.APP_BASE_URL + "app/controllers/LogoutController.php",
                type: "POST",
                success: function (response) {
                    let responseFetch = JSON.parse(response);
                    if (responseFetch.status) {
                        // window.location.reload();
                        console.log(responseFetch);
                    }
                },
                error: function (xhr, status, error) {
                    console.log("Error: ", error);
                }
            });
        });
    }
});
