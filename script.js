let sections = document.querySelectorAll("section");
let navLinks = document.querySelectorAll("header nav a");
let toggles = document.getElementsByClassName("toggleFAQ");
let contentDiv = document.getElementsByClassName("contentFAQ");
let icons = document.getElementsByClassName("icon");
const paragraphs = document.querySelectorAll(".paragraph");
const logos = document.querySelectorAll(".javaromalogo");
const fades = document.querySelectorAll(".fadein");

// Add scroll event listener for logos
document.addEventListener("scroll", function () {
  logos.forEach((logo) => {
    if (isInView(logo)) {
      logo.classList.add("javaromalogo--visible");
    }
  });
});

// Add scroll event listener for paragraphs
document.addEventListener("scroll", function () {
  paragraphs.forEach((paragraph) => {
    if (isInView(paragraph)) {
      paragraph.classList.add("paragraph--visible");
    }
  });
});

document.addEventListener("scroll", function () {
  fades.forEach((fade) => {
    if (isInView(fade)) {
      fade.classList.add("fadein--visible");
    }
  });
});

// Function to check if an element is in view
function isInView(element) {
  const rect = element.getBoundingClientRect();
  return (
    rect.bottom > 0 &&
    rect.top <
      (window.innerHeight - 150 || document.documentElement.clientHeight - 150)
  );
}

for (let i = 0; i < toggles.length; i++) {
  toggles[i].addEventListener("click", () => {
    if (parseInt(contentDiv[i].style.height) != contentDiv[i].scrollHeight) {
      contentDiv[i].style.height = contentDiv[i].scrollHeight + "px";
      toggles[i].style.color = "#0084e9";
      icons[i].classList.remove("fa-plus");
      icons[i].classList.add("fa-minus");
    } else {
      contentDiv[i].style.height = "0px";
      toggles[i].style.color = "#111130";
      icons[i].classList.remove("fa-minus");
      icons[i].classList.add("fa-plus");
    }

        for(let j=0; j<contentDiv.length; j++){
            if(j!==i){
                contentDiv[j].style.height ="0px";
                toggles[j].style.color = "#111130";
                icons[j].classList.remove('fa-minus');
                icons[j].classList.add('fa-plus');
            }
        }
    });
}

// Add event listener for profile icon
document.querySelector('.profile-icon').addEventListener('click', function(event) {
    const dropdown = document.querySelector('.profile-dropdown');
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    event.preventDefault(); // Prevents link from being followed
});
