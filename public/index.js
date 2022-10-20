const timerElement = document.getElementById("timer")
const pauseTimer = document.getElementById("settings");
const play = document.getElementById("padlock")
const rejouer = document.getElementById("rejouer")

let temps = 3600
let chrono = setInterval(diminuerTemps, 1000)

var modal = document.getElementById("myModal");
var span = document.getElementsByClassName("close")[0];

pauseTimer.addEventListener('click', pause)
play.addEventListener('click', start)
rejouer.addEventListener('click', function(){location.reload()})

function diminuerTemps() {
    let minutes = parseInt(temps / 60, 10)
    let secondes = parseInt(temps % 60, 10)

    minutes = minutes < 10 ? "0" + minutes : minutes
    secondes = secondes < 10 ? "0" + secondes : secondes

    timerElement.innerText = minutes + ":" + secondes
    temps = temps <= 0 ? 0 : temps - 1

    if (temps == 0) {
        clearInterval(chrono);
        chrono = null;
        setInterval
        setInterval(function () {timerElement.innerText = "Perdu"}, 1000);
        setInterval(function () {modal.style.display = "block"}, 1000);
    }
}

function pause () {
    clearInterval(chrono);
    chrono = null;
}

function start () {
    chrono = setInterval(diminuerTemps, 1000)
}

setInterval(chrono)


span.onclick = function() {
  modal.style.display = "none";
}

window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}