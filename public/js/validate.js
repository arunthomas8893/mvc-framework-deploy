function myFunction() {
    document.getElementById("myDIV").style.display = "block";
}

function validateForm() {
    var x = document.forms["myForm"]["phone", "otp"].value;
    if (x == "") {
        alert("All fields must be filled out");
        return false;
    }
}