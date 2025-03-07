function swal(verification, title, text) {

    if(verification == true) {
        Swal.fire({
            title: title,
            text: text,
            icon: "success"
          });
    } else if(verification == false) {
        Swal.fire({
            title: title,
            text: text,
            icon: "error"
          });
    } else {
        console.log("Not a valid value fo verification variable!");
        return;
    }

}