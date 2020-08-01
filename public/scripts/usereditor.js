window.addEventListener("load", begin);

function begin() {
    let deletebuttons = document.getElementsByClassName("deletebutton");

    for (let i = 0; i <= deletebuttons.length - 1; i++) {
        deletebuttons[i].addEventListener("click", suppr);
    }

    document.getElementById("addbutton").addEventListener("click", add);
}

function add(e) {
    let cell = e.target.parentElement;

    let inner = document.getElementsByClassName("products")[0].innerHTML;
    document.getElementsByClassName("products")[0].innerHTML = "";
    cell.innerHTML = inner;
    $(".productselect").select2();
    document.getElementsByClassName("addvalidatebutton")[0].addEventListener("click", addvalidate);
}

function addvalidate(e) {
    let selector = document.getElementsByClassName("productselect")[0];
    let name = selector.options[selector.selectedIndex].value;

    window.location.href = "https://monboulangerlivreur.fr/public/router.php?request=actionAddProduct&name=" + name;
}

function suppr(e) {
    let row = e.target.parentElement.parentElement;

    let name = row.getElementsByTagName("td")[0].innerText.split(" - ")[0];
    window.location.href = "https://monboulangerlivreur.fr/public/router.php?request=actionDeleteProduct&name=" + name;
}