window.addEventListener("load", begin);

function begin() {
    let editbuttons = document.getElementsByClassName("editorbutton");
    let deletebuttons = document.getElementsByClassName("deletebutton");

    /*for (let i = 0; i <= editbuttons.length; i++) {
        editbuttons[i].addEventListener("click", edit);
    }
    for (let i = 0; i <= deletebuttons.length; i++) {
        deletebuttons[i].addEventListener("click", suppr);
    }*/

    document.getElementById("addbutton").addEventListener("click", add);
}

function add(e) {
    let cell = e.target.parentElement;

    cell.innerHTML = document.getElementById("products").innerHTML;
    document.getElementById("products").innerHTML = "";
    $(".productselect").select2();
    document.getElementsByClassName("addvalidatebutton")[0].addEventListener("click", addvalidate);
}

function addvalidate(e) {
    let selector = document.getElementById("productselect");
    let name = selector.options[selector.selectedIndex].value;

    window.location.href = "https://monboulangerlivreur.fr/public/router.php?request=actionAddProduct&name=" + name;
}