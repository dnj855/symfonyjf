var match = RegExp('/^\\+33[6-7][0-9]{8}$/');
var phoneInputs = document.querySelectorAll("input[type=tel]");
var phoneInput = phoneInputs[0];
var phoneErrors = document.getElementById('phoneNumberErrors');
phoneInput.addEventListener('input', function (ev) {
    if (!match.test(ev)) {
        phoneErrors.textContent = "Entrer le numéro au format international (+336...)";
        phoneErrors.style.display = 'block';
    } else {
        phoneErrors.style.display = 'none';
    }
})