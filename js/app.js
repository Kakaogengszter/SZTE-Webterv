const burger = document.querySelector(".burger");
const navMenu = document.querySelector(".nav-menu");
const brand = document.querySelector(".brand");

burger.addEventListener("click", () => {
    burger.classList.toggle("active");
    navMenu.classList.toggle("active");
});

brand.addEventListener("click", () => {
    burger.classList.remove("active");
    navMenu.classList.remove("active");
});

document.querySelectorAll(".nav-link").forEach(n =>
    n.addEventListener("click", () => {
        burger.classList.remove("active");
        navMenu.classList.remove("active");
    })
);

/* Ez elvileg görgetésnél is ad valami animációt a navbarnak, de nem jött össze valamiért

window.onscroll = function() {myFunction()};

var navbar = document.getElementById("navbar");
var sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}
*/
