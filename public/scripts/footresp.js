$(document).ready(function () {
    $('.cityselect').select2();
});

window.addEventListener("load", initiation);

let current = 1;
let rightarraow;
let leftarrow;
let aligner1;
let aligner2;
let aligner3;

// Si le footer n'est pas en bas de page on le met en bas de page.
// Si le footer est replacé et que l'événement de focus d'un input pour smartphone est déclenché on rend le footer invisible.
// Pour éviter que le footer ne masque les inputs sur smartphone.
function initiation() {
    rightarraow = document.getElementById("rightarrow");
    leftarrow = document.getElementById("leftarrow");
    rightarraow.addEventListener("click", right);
    leftarrow.addEventListener("click", left);
    aligner1 = document.getElementById("aligner1");
    aligner2 = document.getElementById("aligner2");
    aligner3 = document.getElementById("aligner3");
    let footer = document.getElementsByTagName("footer")[0];
    let bottom = footer.offsetTop + footer.offsetHeight;
    let form = document.getElementById("toreplaceform");
    let title = document.getElementsByClassName("title")[0];
    if (bottom < window.innerHeight) {
        footer.style.position = "fixed";
        footer.style.bottom = "0px";
        footer.style.width = "100%";
        let bottomtitle = document.getElementsByTagName("article")[0].offsetTop + title.offsetHeight;
        let delta = window.innerHeight - bottomtitle - footer.offsetHeight;
        delta = delta / 2 - form.offsetHeight / 2;
        form.style.marginTop = delta.toString() + "px";
        let inputs = document.getElementsByTagName("input");
        for (let i = 0; i <= inputs.length - 1; i++) {
            inputs[i].addEventListener("focus", makefocus);
            inputs[i].addEventListener("blur", undofocus);
        }
    }
}

function right() {
    current++;
    updateFooter();
}

function left() {
    current--;
    updateFooter();
}

// On met à jour le footer. On déplace vers la droite ou vers la gauche les éléments (Uniquement quand on est au format mobile).
function updateFooter() {
    if (current == 1) {
        leftarrow.style.display = "none";
        aligner1.style.left = "25%";
        aligner2.style.left = "125%";
        aligner3.style.left = "225%";
    } else if (current == 2) {
        leftarrow.style.display = "block";
        rightarraow.style.display = "block";
        aligner1.style.left = "-125%";
        aligner2.style.left = "25%";
        aligner3.style.left = "125%";
    } else {
        rightarraow.style.display = "none";
        aligner1.style.left = "-225%";
        aligner2.style.left = "-125%";
        aligner3.style.left = "25%";
    }
}

// Gestion des événements de focus pour smartphone.
function makefocus() {
    let footers = document.getElementsByTagName("footer");
    footers[0].style.display = "none";
}

function undofocus() {
    let footers = document.getElementsByTagName("footer");
    footers[0].style.display = "block";
}