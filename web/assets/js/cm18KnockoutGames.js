var gamesElt = document.querySelectorAll('div.cm18-game');
var submitsElt = document.querySelectorAll('div.cm18-submit');
games = [];

for (var i = 0; i < gamesElt.length; i++) {
    games.push(gamesElt[i].id);

    widgetsHome = [];
    widgetsAway = [];
    betsHome = [];
    betsAway = [];
    var submitButton = submitsElt[i].firstElementChild;

    widgetsHome[i] = gamesElt[i].childNodes[1].firstElementChild;
    widgetsAway[i] = gamesElt[i].childNodes[7].firstElementChild;
    betsHome[i] = gamesElt[i].childNodes[3].firstElementChild;
    betsAway[i] = gamesElt[i].childNodes[5].firstElementChild;

    if (((betsHome[i].value === "") && (betsAway[i].value === "")) || (betsHome[i].value !== betsAway[i].value)) {
        widgetsHome[i].style.visibility = 'hidden';
        widgetsAway[i].style.visibility = 'hidden';
    }
}

games.forEach(function (gameId) {
    var betHome = document.getElementById('betHome' + gameId).firstElementChild;
    var betAway = document.getElementById('betAway' + gameId).firstElementChild;
    betHome.addEventListener('input', function () {
        hideOrShowWidget(gameId);
        validation(gameId);
    });
    betAway.addEventListener('input', function () {
        hideOrShowWidget(gameId);
        validation(gameId);
    });
});

function hideOrShowWidget(gameId) {
    var betHome = document.getElementById('betHome' + gameId).firstElementChild;
    var betAway = document.getElementById('betAway' + gameId).firstElementChild;
    var widgetHome = document.getElementById('widgetHome' + gameId).firstElementChild;
    var widgetAway = document.getElementById('widgetAway' + gameId).firstElementChild;
    var alert = document.getElementById('alert' + gameId);
    if ((betHome.value === betAway.value) && (betHome.value !== "")) {
        widgetHome.style.visibility = 'visible';
        widgetAway.style.visibility = 'visible';
        alert.style.display = 'block'
    } else {
        widgetHome.style.visibility = 'hidden';
        widgetAway.style.visibility = 'hidden';
        alert.style.display = 'none'
    }

}