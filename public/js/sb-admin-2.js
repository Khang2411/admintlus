

// Toggle the side navigation, sidebarToggleTop
document.getElementById("sidebarToggle").addEventListener('click', function (e) {
    document.querySelector("body").classList.toggle("sidebar-toggled");
    document.querySelector(".sidebar").classList.toggle("toggled");
    if (document.querySelector(".sidebar").classList.contains("toggled")) {
        document.querySelector('.sidebar .collapse').collapse('hide');
    };
});

document.getElementById("sidebarToggleTop").addEventListener('click', function (e) {
    document.querySelector("body").classList.toggle("sidebar-toggled");
    document.querySelector(".sidebar").classList.toggle("toggled");

});

// Close any open menu accordions when window is resized below 768px
window.addEventListener('resize', function() {
    if (screen.width < 768) {
        document.querySelector("body").classList.add("sidebar-toggled");
        document.querySelector(".sidebar").classList.add("toggled");
    };

    // Toggle the side navigation when window is resized below 480px
    if (screen.width< 480 && !document.querySelector(".sidebar").classList.contains("toggled")) {
        document.querySelector("body").classList.add("sidebar-toggled");
        document.querySelector(".sidebar").classList.add("toggled");

    };
});

// Prevent the content wrapperz from scrolling when the fixed side navigation hovered over


// Scroll to top button appear
let mybutton = document.getElementById("btn-back-to-top");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () {
    scrollFunction();
};
function scrollFunction() {
    if (
        document.body.scrollTop > 20 ||
        document.documentElement.scrollTop > 20
    ) {
        mybutton.style.display = "block";
    } else {
        mybutton.style.display = "none";
    }
}
// When the user clicks on the button, scroll to the top of the document
mybutton.addEventListener("click", backToTop);

function backToTop() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
    //  or  window.scrollTo(250, 110);
}


