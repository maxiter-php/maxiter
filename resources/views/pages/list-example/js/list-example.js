document.addEventListener('DOMContentLoaded', () => {
    console.log("List Example");
    $.ajax({
        url: "./app/controllers/UsersController.php",
        type: "GET",
        success: function (response) {
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