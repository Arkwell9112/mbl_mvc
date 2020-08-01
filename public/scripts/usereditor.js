window.addEventListener("load", begin);

function begin() {
    let deletebuttons = document.getElementsByClassName("deletebutton");
    let editbuttons = document.getElementsByClassName("editorbutton");

    for (let i = 0; i <= deletebuttons.length - 1; i++) {
        deletebuttons[i].addEventListener("click", suppr);
    }

    for (let i = 0; i <= editbuttons.length - 1; i++) {
        editbuttons[i].addEventListener("click", edit);
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

function edit(e) {
    let row = e.target.parentElement.parentElement;
    let cells = row.getElementsByTagName("td");

    for (let i = 1; i <= 7; i++) {
        if (cells[i].innerText != "Non livré.") {
            cells[i].innerHTML = "<input name='" + i + "' size='2' value='" + cells[i].innerText + "'>";
        }
    }

    cells[8].innerHTML = "<span class='editbutton editvalidatebutton'>Valider</span>";
    row.getElementsByClassName("editvalidatebutton")[0].addEventListener("click", editvalidate);
}

function editvalidate(e) {
    let row = e.target.parentElement.parentElement;
    let cells = e.target.parentElement.parentElement.getElementsByTagName("td");
    let table = "[";

    for (let i = 1; i <= 7; i++) {
        let input = cells[i].getElementsByTagName("input");
        if (input.length == 1) {
            table = table + '"' + input[0].value + '"';
        } else {
            table = table + '"-1"';
        }
        if (i == 7) {
            table = table + "]";
        } else {
            table = table + ",";
        }
    }

    let name = row.getElementsByTagName("td")[0].innerText.split(" - ")[0];
    window.location.href = "https://monboulangerlivreur.fr/public/router.php?request=actionEditProduct&name=" + name + "&table=" + table;
}