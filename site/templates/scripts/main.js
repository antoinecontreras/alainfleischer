let VALUES = {
  homeInit: false,
  homeActive: false,
  currentMode: null, // Permet de stocker si on est en mode 'desktop' ou 'mobile'
  newMobileActive: null,
  counterScroll: 0,
  showGallery: false,
};
let currentItem = null; 
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
    case "bio":
      initBioLinks();
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

function initBioLinks() {
  const links = document.querySelectorAll(".bio-link");

  // Gestion du hash au chargement de la page
  const hash = window.location.hash;
  if (hash) {
    activateBioLink(hash.substring(1));
  } else if (links.length > 0) {
    // Si aucun hash, activer le premier lien par défaut
    activateBioLink(links[0].getAttribute("href").substring(1));
  }

  // Ajouter l'événement de clic sur chaque lien
  links.forEach(link => {
    link.addEventListener("click", function (event) {
      event.preventDefault();
      const target = this.getAttribute("href").substring(1); // Récupère le texte après le #
      activateBioLink(target);
    });
  });
}

function activateBioLink(target) {
  const links = document.querySelectorAll(".bio-link");

  // Supprimer la classe active de tous les liens
  links.forEach(link => {
    link.classList.remove("active");
  });

  // Activer le lien correspondant au hash
  const activeLink = document.querySelector(`.bio-link[href="#${target}"]`);
  if (activeLink) {
    activeLink.classList.add("active");

    // Mettre à jour l'URL pour refléter l'état actif
    window.location.hash = target;
  }
}
function initdesktopNav(options) {
  if (VALUES.pageType !== "home") return;

  // Conserver l'élément actuel pendant le redimensionnement
  if (isDesktopLayout.value && VALUES.currentMode !== "desktop") {
    disableListeners(options); // Désactiver les listeners mobiles
    desktopNav(options); // Activer les listeners desktop
    VALUES.currentMode = "desktop";
  } else if (!isDesktopLayout.value && VALUES.currentMode !== "mobile") {
    disableListeners(options); // Désactiver les listeners desktop
    mobileNav(options); // Activer les listeners mobiles
    VALUES.currentMode = "mobile";
  }
  
  // Restaurer l'état de currentItem après le redimensionnement
  if (currentItem && isDesktopLayout.value) {
    currentItem.classList.add("active");
    options.currentItem = currentItem; // Associer l'item actuel dans les options
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
  options = {
    items: items,
    nav: nav,
    targetNav: targetNav,
    decayNav: decayNav,
  };
  return options;
}
function simulateClick(e) {
  if (VALUES.counterScroll <= 1) {
    VALUES.counterScroll;
    VALUES.showGallery = true;
  }
  if (options.currentItem) options.currentItem.click();
}
function desktopNav(options) {
  options.items.forEach((item) => {
    const onMouseEnter = () => {
      if (isDesktopLayout.value) {
        // Mettre à jour currentItem lorsqu'un élément est survolé
        currentItem = item; // Mémoriser l'élément en cours
        options.currentItem = item; // Stocker aussi dans les options pour simulateClick

        // Logique de gestion de l'item actif
        options.nav.forEach((navItem) => navItem.classList.remove("active"));
        const searchTarget = document.getElementById(item.id);
        if (searchTarget) {
          searchTarget.classList.add("active");
          options.active = document.querySelector(".nav_item.active");
          options.cartel = searchTarget.querySelector(".nav_cartel");
          options.gallery = searchTarget.querySelector(".nav_gallery");
          options.imgs = searchTarget.querySelectorAll(".nav_gallery img");
        }

        options.gallery.scrollTo({ top: 0, behavior: "instant" });
        options.active.scrollTo({ top: 0, behavior: "instant" });
        VALUES.counterScroll = 0;
        VALUES.showGallery = false;
      }
    };

    const onClick = (event) => {
      if (!isDesktopLayout.value) return;
      event.preventDefault();

      const { showGallery, counterScroll } = VALUES;
      const { active, cartel, gallery, imgs } = options;

      if (!showGallery) {
        const offset = cartel.offsetHeight;
        active.scrollBy({ top: offset, behavior: "smooth" });

        if (counterScroll === 1) {
          VALUES.showGallery = true;
          VALUES.counterScroll = 0;
        }
      } else {
        if (counterScroll < imgs.length) {
          gallery.scrollBy({ top: 100, behavior: "smooth" });
        } else {
          VALUES.counterScroll = 0;
          gallery.scrollTo({ top: 0, behavior: "smooth" });
        }
      }
      VALUES.counterScroll++;
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
        VALUES.counterScroll = 0;
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
      if (isActive) {
        this.classList.remove("active");
      } else {
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
