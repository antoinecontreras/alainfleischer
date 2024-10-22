let VALUES = {
  homeInit: false,
  homeActive: false,
  currentMode: null, // Permet de stocker si on est en mode 'desktop' ou 'mobile'
};

document.addEventListener("contextmenu", function (e) {
  if (e.target.tagName === "IMG") e.preventDefault();
});

document.addEventListener("DOMContentLoaded", function () {
  VALUES.pageType = document.body.getAttribute("data-page-type");

  switch (VALUES.pageType) {
    case "home":
      initHash();
      const options = initNav();
      initdesktopNav(options); // Initialisation selon la taille de l'écran
      VALUES.homeInit = true;
      break;
    case "projects":
      break;
    case "news":
      break;

    default:
      break;
  }
});

// Fonction exécutée lors du redimensionnement de la fenêtre
window.addEventListener("resize", function () {
  const options = initNav();
  initdesktopNav(options); // Réinitialiser le comportement en fonction de la nouvelle taille d'écran
});

function initdesktopNav(options) {
  // Si on est sur une autre page que "home", on ne fait rien
  if (VALUES.pageType !== "home") return;

  // Comportement pour large (desktop)
  if (isDesktopLayout.value && VALUES.currentMode !== "desktop") {
    // Si on passe à desktop et qu'on n'y était pas
    disableListeners(options); // Désactiver les listeners mobiles
    desktopNav(options); // Activer les listeners desktop
    VALUES.currentMode = "desktop"; // On marque qu'on est en mode desktop
  }
  // Comportement pour small (mobile)
  else if (!isDesktopLayout.value && VALUES.currentMode !== "mobile") {
    // Si on passe à mobile et qu'on n'y était pas
    disableListeners(options); // Désactiver les listeners desktop
    mobileNav(options); // Activer les listeners mobiles
    VALUES.currentMode = "mobile"; // On marque qu'on est en mode mobile
  }
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
  console.log(activeLink);
  if (activeLink) {
    activeLink.classList.add("active");
  }
}

let isDesktopLayout = {
  get value() {
    const screenWidth = window.innerWidth;
    return screenWidth >= 1300; // Détecte les écrans larges
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

// Comportement pour la version desktop (large)
function desktopNav(options) {
  options.items.forEach((item) => {
    const onMouseEnter = () => {
      if (isDesktopLayout.value) { // Vérification que c'est en mode desktop
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
      }
    };

    const onClick = (event) => {
      if (isDesktopLayout.value) { // Si en desktop, on fait défiler
        event.preventDefault(); // On empêche la redirection ici
        options.targetNav.scrollTo({
          top: options.decayNav,
          behavior: "smooth",
        });
      }
    };

    // Ajouter les listeners pour le desktop
    item.addEventListener("mouseenter", onMouseEnter); // Survol
    item.addEventListener("click", onClick); // Clic desktop (scroll)

    // Stocker les listeners pour pouvoir les désactiver ensuite
    item._listeners = { onMouseEnter, onClick };
  });

  // Marquer comme actif sur desktop
  VALUES.homeActive = true;
}

// Comportement pour la version mobile (small/hybride)
function mobileNav(options) {
  options.items.forEach((item) => {
    const onClickOrTouch = () => {
      if (!isDesktopLayout.value) { // Si c'est mobile
        const link = `${item.dataset.parent}/?valeur=${item.dataset.project}&filter=${item.dataset.filter}`; // Création de l'URL
        window.location.href = link; // Redirection
      } 
    };
    

    // Ajouter le click/touchstart pour mobile
    item.addEventListener("click", onClickOrTouch); // Pour le mobile (click)
    // item.addEventListener("touchstart", onClickOrTouch); // Pour le mobile (touch)

    // Stocker les listeners pour pouvoir les désactiver ensuite
    item._listeners = { onClickOrTouch };
  });

  // Marquer comme actif sur mobile
  VALUES.homeActive = true;
}

function disableListeners(options) {
  options.items.forEach((item) => {
    if (item._listeners) {
      // Désactiver les listeners de desktop
      item.removeEventListener("mouseenter", item._listeners.onMouseEnter);
      item.removeEventListener("click", item._listeners.onClick);

      // Désactiver les listeners de mobile
      item.removeEventListener("click", item._listeners.onClickOrTouch);
      // item.removeEventListener("touchstart", item._listeners.onClickOrTouch);
    }
  });

  // Marquer comme inactif
  VALUES.homeActive = false;
}

function enableListeners(options) {
  options.items.forEach((item) => {
    if (item._listeners) {
      // Réactiver les listeners précédemment stockés
      item.addEventListener("mouseenter", item._listeners.onMouseEnter);
      item.addEventListener("click", item._listeners.onClick);
      item.addEventListener("click", item._listeners.onClickOrTouch);
      // item.addEventListener("touchstart", item._listeners.onClickOrTouch);
    }
  });

  // Marquer comme actif
  VALUES.homeActive = true;
}
