var formElt = document.querySelector("form");
for (var i = 0; i < formElt.length; i++) {
    formElt[i].disabled = true;
}

var buttonsElt = document.getElementById("submitButtons");
buttonsElt.classList.add("d-none");