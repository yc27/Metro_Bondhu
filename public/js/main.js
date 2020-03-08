// function to adjust top position of main section
function adjustMainTop() {
    var navbarHight = document.getElementById("top-navbar").scrollHeight;
	$("#main").css("top", navbarHight);
	$("#Side-Navbar").css("top", navbarHight);
};
adjustMainTop();
$(window).resize(function() {
	adjustMainTop();
});

// side nav-bar collapse function
var sidebarToggle = document.getElementById("Sidenav-Toggle");
sidebarToggle.addEventListener("click", function() {
    var content = document.getElementById("Side-Navbar");
    content.classList.toggle("active");
});

// get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
// tab change function
function openMenu(evt, menu) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    var active = document.getElementsByClassName(menu);
    for (i = 0; i < active.length; i++) {
        active[i].className += " active";
    }
    document.getElementById(menu).style.display = "block";
}