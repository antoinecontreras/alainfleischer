let VALUES = {
  homeInit: false,
};
document.addEventListener("contextmenu", function (e) {
  if (e.target.tagName === "IMG") e.preventDefault();
});
window.onload = function () {};
document.addEventListener("DOMContentLoaded", function () {
  VALUES.pageType = document.body.getAttribute("data-page-type");

  switch (VALUES.pageType) {
    case "home":
      initHash();
      const options = initNav();
      if (isDesktopLayout.value) desktopNav(options);
      break;
    case "bio":
      break;
    case "news":
      break;

    default:
      break;
  }
});
window.addEventListener("resize", function () {
  initdesktopNav();
});
function initdesktopNav() {
  if (VALUES.pageType !== "home") return;
  const options = initNav();
  if (VALUES.homeInit == false && isDesktopLayout.value) desktopNav(options);
  else if (VALUES.homeInit && isDesktopLayout.value) enableListeners(options);
  else if (VALUES.homeInit && isDesktopLayout.value==false) disableListeners(options);
}
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
let isDesktopLayout = {
  get value() {
    const screenWidth = window.innerWidth;
    return screenWidth >= 1300;
  },
};
function initNav() {
  const items = document.querySelectorAll(".collection_item");
  const nav = document.querySelectorAll(".nav_item");
  const targetNav = document.querySelector(".collection_nav");
  let decayNav;
  let options = {
    items: items,
    nav: nav,
    targetNav: targetNav,
    decayNav: decayNav,
  };
  return options;
}

function desktopNav(options) {
  options.items.forEach((item) => {
    const onMouseEnter = () => {
      options.targetNav.scrollTo({
        top: 0,
        behavior: "instant",
      });
      options.nav.forEach((navItem) => navItem.classList.remove("active"));
      const searchTarget = document.getElementById(item.id);
      if (searchTarget) {
        searchTarget.classList.add("active");
        options.decayNav =
          searchTarget.querySelector(".nav_cartel").offsetHeight;
      }
    };

    const onClick = () => { 
      options.targetNav.scrollTo({
        top: options.decayNav,
        behavior: "smooth",
      });
    };
    item.addEventListener("mouseenter", onMouseEnter);
    item.addEventListener("click", onClick);
    item._listeners = { onMouseEnter, onClick };
  });
  VALUES.homeInit = true;
}
function disableListeners(options) {
  options.items.forEach((item) => {
    if (item._listeners) {
      item.removeEventListener("mouseenter", item._listeners.onMouseEnter);
      item.removeEventListener("click", item._listeners.onClick);
      delete item._listeners;
    }
  });
}
function enableListeners(options) {
  options.items.forEach((item) => {
    if (item._listeners) {
      item.addEventListener("mouseenter", item._listeners.onMouseEnter);
      item.addEventListener("click", item._listeners.onClick);
    }
  });
}
