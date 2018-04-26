window.addEventListener("load", function () {
    window.close();
});

window.onunload = function(){
    window.opener.location.reload();
};