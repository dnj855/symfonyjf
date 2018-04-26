var jokers = [];
jokers.push(document.getElementById("joker1"));
jokers.push(document.getElementById("joker2"));
jokers.push(document.getElementById("joker3"));
jokers.push(document.getElementById("joker4"));
jokers.push(document.getElementById("joker5"));
jokers.push(document.getElementById("joker6"));
jokers.push(document.getElementById("joker7"));
jokers.push(document.getElementById("joker8"));
jokers.push(document.getElementById("joker9"));
jokers.push(document.getElementById("joker10"));

var bets = [];
bets.push(document.getElementById("bet1"));
bets.push(document.getElementById("bet2"));
bets.push(document.getElementById("bet3"));
bets.push(document.getElementById("bet4"));
bets.push(document.getElementById("bet5"));
bets.push(document.getElementById("bet6"));
bets.push(document.getElementById("bet7"));
bets.push(document.getElementById("bet8"));
bets.push(document.getElementById("bet9"));
bets.push(document.getElementById("bet10"));

var saveButton = document.getElementById('save');

for (let i = 0; i < bets.length; i++) {
    bets[i].addEventListener("input", function (ev) {
        if (ev.target.value === "") {
            jokers[i].disabled = true;
            jokers[i].checked = false;
            handleSaveButton();
        } else {
            jokers[i].disabled = false;
            handleSaveButton();
        }
    })
}

jokers.forEach(function (joker) {
    joker.addEventListener("click", function () {
        handleSaveButton();
    })
});

function handleSaveButton() {
    var betHelp = document.getElementById("betHelp");
    var jokerHelp = document.getElementById("jokerHelp");
    if (checkIfValid()) {
        saveButton.disabled = false;
        document.getElementById("betHelp").innerHTML = "";
        document.getElementById("jokerHelp").innerHTML = "";
    } else {
        saveButton.disabled = true;
        if (!checkIfBetValid()) {
            betHelp.textContent = "";
            betHelp.textContent = "Tu dois remplir les 10 paris.";
        } else {
            betHelp.textContent = "";
        }
        if (!checkIfJokerValid()) {
            jokerHelp.textContent = "";
            jokerHelp.textContent = "Tu dois sélectionner un joker.";
        } else {
            jokerHelp.textContent = "";
        }
    }
}

function checkIfValid() {
    if (checkIfBetValid() && checkIfJokerValid()) {
        return true;
    } else {
        return false;
    }
}

function checkIfBetValid() {
    var values = [];
    bets.forEach(function (bet) {
        if (bet.value.length === 0) {
            values.push(false);
        }
    });
    return values.every(function (currentValue) {
        return currentValue === true;
    });
}

function checkIfJokerValid() {
    var checked = false;
    for (var i = 0; i < jokers.length; i++) {
        if (jokers[i].checked) {
            checked = true;
            break;
        }
    }
    return checked;
}

window.addEventListener("load", function () {
    for (let i = 0; i < bets.length; i++) {
        if (bets[i].value.length > 0) {
            jokers[i].disabled = false;
        } else {
            jokers[i].disabled = true;
            jokers[i].checked = false;
        }
    }
    handleSaveButton();
});