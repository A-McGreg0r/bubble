

function turnOffVisible() {
    document.getElementById("home-down").style.visibility = "hidden";
    document.getElementById("about-up").style.visibility = "hidden";
    document.getElementById("about-home").style.visibility = "hidden";
    document.getElementById("about-down").style.visibility = "hidden";
    document.getElementById("team-up").style.visibility = "hidden";
    document.getElementById("team-home").style.visibility = "hidden";
    document.getElementById("team-down").style.visibility = "hidden";
    document.getElementById("belief-up").style.visibility = "hidden";
    document.getElementById("belief-home").style.visibility = "hidden";
    document.getElementById("belief-down").style.visibility = "hidden";
    document.getElementById("project-up").style.visibility = "hidden";
    document.getElementById("project-home").style.visibility = "hidden";
    document.getElementById("project-down").style.visibility = "hidden";
    document.getElementById("contact-up").style.visibility = "hidden";
    document.getElementById("contact-home").style.visibility = "hidden";
}

function turnOnVisible() {
    document.getElementById("home-down").style.visibility = "visible";
    document.getElementById("about-up").style.visibility = "visible";
    document.getElementById("about-home").style.visibility = "visible";
    document.getElementById("about-down").style.visibility = "visible";
    document.getElementById("team-up").style.visibility = "visible";
    document.getElementById("team-home").style.visibility = "visible";
    document.getElementById("team-down").style.visibility = "visible";
    document.getElementById("belief-up").style.visibility = "visible";
    document.getElementById("belief-home").style.visibility = "visible";
    document.getElementById("belief-down").style.visibility = "visible";
    document.getElementById("project-up").style.visibility = "visible";
    document.getElementById("project-home").style.visibility = "visible";
    document.getElementById("project-down").style.visibility = "visible";
    document.getElementById("contact-up").style.visibility = "visible";
    document.getElementById("contact-home").style.visibility = "visible";
}

function openModal(id) {
    var modal = document.getElementById(id);
    if (modal && modal.style) {
        modal.style.display = 'block';
    } 
}

function closeModal(id) {
    var modal = document.getElementById(id);
    if (modal && modal.style) {
        modal.style.display = 'none';
    } 
}

targetElement.ontouchend = (e) => {
    e.preventDefault();
};