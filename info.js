// Fenster schließen/öffnen
function openWindow(window) {
    document.getElementById(window).style.display = "inline";
}

function closeWindow(window) {
        document.getElementById(window).style.display="none";
        return false;
}

// Wikihelp anzeigen/verbergen
function showWikihelp(window, link) {
    if(document.getElementById(window).style.display == "none") {
        openWindow(window);
        document.getElementById(link).innerHTML = "--";
    }
    else {
        closeWindow(window);
        document.getElementById(link).innerHTML = "+";
    }
    return false;
}

// Infoseite
function changeVisibilty(window, link) {
    if(document.getElementById(window).style.display == "none")
        showContent(window, link);
    else
        closeContent(window, link);
    return false;
}

function showContent(window, link) {
    openWindow(window);
    document.getElementById(link).innerHTML = "-";
}

function closeContent(window, link) {
    closeWindow(window);
    document.getElementById(link).innerHTML = "+";
}
