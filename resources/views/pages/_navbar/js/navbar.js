document.addEventListener('DOMContentLoaded', () => {
    let absolutePath = window.location.origin;
    let logoutUrl = absolutePath + "/app/controllers/LogoutController.php";
    let logoutButton = document.querySelector("#btn-logout");
    if (logoutButton) {
        logoutButton.addEventListener('click', (e) => {
            $.ajax({
                url: logoutUrl,
                type: "POST",
                success: function (response) {
                    let responseFetch = JSON.parse(response);
                    if (responseFetch.status) {
                        window.location.reload();
                    }
                },
                error: function (xhr, status, error) {
                    console.log("Error: ", error);
                }
            });
        });
    }
});
