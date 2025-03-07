// This is the SweetAlert easy-to-use function, include 
// it in your footer page using script src tag!
// 
// @author Victor Béser

function swal(verification, text, title) {

    if (verification == true) {
        if (title != null) {
            Swal.fire({
                title: title,
                text: text,
                icon: "success"
            });
        } else {
            Swal.fire({
                title: "Boa!",
                text: text,
                icon: "success"
            });
        }
    } else if (verification == false) {
        if (title != null) {
            Swal.fire({
                title: title,
                text: text,
                icon: "error"
            });
        } else {
            Swal.fire({
                title: "Oops!",
                text: text,
                icon: "error"
            });
        }
    } else {
        console.log("Not a valid value fo verification variable!");
        return;
    }

}