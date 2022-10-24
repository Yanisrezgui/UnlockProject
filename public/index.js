let temps = 3600
const timerElement = document.getElementById("timer")

function diminuerTemps() {
    let minutes = parseInt(temps / 60, 10)
    let secondes = parseInt(temps % 60, 10)

    minutes = minutes < 10 ? "0" + minutes : minutes
    secondes = secondes < 10 ? "0" + secondes : secondes

    timerElement.innerText =  minutes + ":" + secondes 
    temps = temps <= 0 ? 0 : temps - 1
}

setInterval(diminuerTemps, 1000)

/* let b1 = document.getElementById('b1');

b1.addEventListener('click', message);

function message(){
    setTimeout(alert, 2000, 'Message d\'alerte après 2 secondes'); 
} */

