document.addEventListener('DOMContentLoaded', () => {
    console.log("List Example");
    $.ajax({
        url: path.APP_BASE_URL + "app/controllers/UsersController.php",
        type: "POST",
        data: {
            controller: 'getUsers' // Function in controller
        },
        success: function (response) {

            console.log(response);

            let tbody_table = document.querySelector("#tbody-table");
            tbody_table.innerHTML = "";

            let responseFetch = JSON.parse(response);
            responseFetch.data.forEach((item) => {
                
                let tr = document.createElement("tr");

                let td_name = document.createElement("td");
                td_name.innerText = item.last_name;
                let td_username = document.createElement("td");
                td_username.innerText = item.username; 
                let td_email = document.createElement("td");
                td_email.innerText = item.email;

                tr.appendChild(td_name);
                tr.appendChild(td_username);
                tr.appendChild(td_email);

                tbody_table.appendChild(tr);

            });
            
        }
    });

});