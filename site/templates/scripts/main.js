let VALUES = {
  homeInit: false,
  homeActive: false,
  currentMode: null, // Permet de stocker si on est en mode 'desktop' ou 'mobile'
  newMobileActive: null,
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
      const optionsNew = initNav();
      initNews(optionsNew);
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
  if (VALUES.pageType !== "home") return;

  if (isDesktopLayout.value && VALUES.currentMode !== "desktop") {
    disableListeners(options); // Désactiver les listeners mobiles
    desktopNav(options); // Activer les listeners desktop
    VALUES.currentMode = "desktop"; // On marque qu'on est en mode desktop
  } else if (!isDesktopLayout.value && VALUES.currentMode !== "mobile") {
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

function initNews(options) {
  if (isDesktopLayout.value && VALUES.currentMode !== "desktop") {
    disableListeners(options);
    newsDesktopNav(options);
    VALUES.currentMode = "desktop";
  } else if (!isDesktopLayout.value && VALUES.currentMode !== "mobile") {
    disableListeners(options);
    mobileNewsNav(options);
    VALUES.currentMode = "mobile";
  }
}

function initNav() {
  const items = document.querySelectorAll(".interactive_item");
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
      if (isDesktopLayout.value) {
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
      if (isDesktopLayout.value) {
        event.preventDefault();
        options.targetNav.scrollTo({
          top: options.decayNav,
          behavior: "smooth",
        });
      }
    };

    item.addEventListener("mouseenter", onMouseEnter);
    item.addEventListener("click", onClick);

    item._listeners = { onMouseEnter, onClick };
  });

  VALUES.homeActive = true;
}

function newsDesktopNav(options) {
  options.items.forEach((item) => {
    const onMouseEnter = () => {
      if (isDesktopLayout.value) {
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
      if (isDesktopLayout.value) {
        options.targetNav.scrollTo({
          top: options.decayNav,
          behavior: "smooth",
        });
      }
    };

    item.addEventListener("mouseenter", onMouseEnter);
    item.addEventListener("click", onClick);

    item._listeners = { onMouseEnter, onClick };
  });

  VALUES.homeActive = true;
}

// Gestion mobile
function mobileNav(options) {
  options.items.forEach((item) => {
    const onClickOrTouch = () => {
      if (!isDesktopLayout.value) {
        const link = `${item.dataset.parent}/?valeur=${item.dataset.project}&filter=${item.dataset.filter}`;
        window.location.href = link;
      }
    };

    item.addEventListener("click", onClickOrTouch);
    item._listeners = { onClickOrTouch };
  });

  VALUES.homeActive = true;
}

function mobileNewsNav(options) {
  options.items.forEach((item) => {
    item.addEventListener("click", function (event) {
      if (event.target.parentNode.hasAttribute("href")) return;

      const isActive = this.classList.contains("active");

      // Désactiver tous les éléments
      options.items.forEach((el) => {
        if (el) el.classList.remove("active");
      });

      // Si l'élément était déjà actif, on le replie (ne pas scroll)
      if (isActive) {
        this.classList.remove("active");
      } else {
        console.log(this);
        this.classList.add("active");
        setTimeout(() => {
          this.scrollIntoView({
            behavior: "smooth",
            block: "start",
          });
        }, 500);
      }
    });
  });

  options.items.forEach((item) => {
    item.removeEventListener("mouseenter", item._listeners?.onMouseEnter);
    item.removeEventListener("click", item._listeners?.onClick);
  });
}

function disableListeners(options) {
  options.items.forEach((item) => {
    if (item._listeners) {
      item.removeEventListener("mouseenter", item._listeners.onMouseEnter);
      item.removeEventListener("click", item._listeners.onClick);
      item.removeEventListener("click", item._listeners.onClickOrTouch);
    }
  });

  VALUES.homeActive = false;
}

function enableListeners(options) {
  options.items.forEach((item) => {
    if (item._listeners) {
      item.addEventListener("mouseenter", item._listeners.onMouseEnter);
      item.addEventListener("click", item._listeners.onClick);
      item.addEventListener("click", item._listeners.onClickOrTouch);
    }
  });

  VALUES.homeActive = true;
}
