function validateForm() {
    var x = document.forms["myForm"]["fname", "lname", "email", "address", "myfile"].value;
    if (x == "") {
        alert("All fields must be filled out");
        return false;
    }
}