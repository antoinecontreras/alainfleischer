document.addEventListener("contextmenu", function (e) {
  if (e.target.tagName === "IMG") e.preventDefault();
});
window.onload = function () {};
document.addEventListener("DOMContentLoaded", function () {
  var pageType = document.body.getAttribute("data-page-type");
  console.log(pageType);
  switch (pageType) {
    case "home":
      initHash();
      initNav();
      break;
    case "bio":
      break;
    case "news":
      break;

    default:
      break;
  }
});
function initHash() {
  const hash = window.location.hash;
  if (hash) {
    const filterTitle = hash.substring(1);
    highlightLink(filterTitle);
  } else {
    const firstFilter = document.querySelector(".filter-link");
    if (firstFilter) {
      highlightLink(firstFilter.innerText);
      firstFilter.click();
    }
  }
}
function highlightLink(filterTitle) {
  const links = document.querySelectorAll(".collection_filter a");
  links.forEach((link) => {
    link.classList.remove("active");
  });
  const activeLink = document.querySelector(
    `.collection_filter a[href="#${filterTitle}"]`
  );
  if (activeLink) {
    activeLink.classList.add("active");
  }
}

function initNav() {
  const items = document.querySelectorAll(".collection_item");
  const nav = document.querySelectorAll(".nav_item");

  items.forEach((item) => {
    item.addEventListener("click", () => {
      nav.forEach((navItem) => navItem.classList.remove("active"));
      const targetNav = document.getElementById(item.id);
      if (targetNav) {
        targetNav.classList.add("active");
      }
    });
  });
}
