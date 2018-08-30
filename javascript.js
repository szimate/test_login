// A felhasználónév és a jelszó validálása jvaascrpt segítségével.

function validateForm() {
    var x = document.forms["myForm"]["name"].value;
    var y = document.forms["myForm"]["pass"].value;
    if (x === "" && y === "") {
        alert("Kérem adja meg a felhasználót és jelszavát")
        return false;
    }

    if (x === "") {
        alert("Kérem adja meg a felhasználónevet!")
        return false;
    }
    else if (y === "") {
        alert("Kérem adja meg a jelszót!")
        return false;
    }
}