// Example JS file
document.addEventListener('contextmenu', function(e) {
    if (e.target.tagName === 'IMG') {
      e.preventDefault();
    }
  });
  window.onload = function() {
   // Récupérer le fragment d'URL
   const hash = window.location.hash;

   // Vérifier s'il y a un hash et appeler highlightLink
   if (hash) {
       const filterTitle = hash.substring(1); // Enlever le '#' pour obtenir le titre
       highlightLink(filterTitle);
   } else {
     // Si pas de hash, mettre par défaut le premier filtre
     const firstFilter = document.querySelector('.filter-link'); // Assurez-vous que c'est la première balise <a> avec class "filter-link"
     if (firstFilter) {
         console.log(firstFilter.innerText);
           highlightLink(firstFilter.innerText); // Utiliser le texte du premier lien
           firstFilter.click(); // Simuler un clic sur le premier lien
       }
   }
};
  function highlightLink(filterTitle) {
    // Retire la classe active de tous les liens
    const links = document.querySelectorAll('.collection_filter a');
    links.forEach(link => {
        link.classList.remove('active');
    });
    
    // Ajoute la classe active au lien qui a été cliqué
    const activeLink = document.querySelector(`.collection_filter a[href="#${filterTitle}"]`);
    if (activeLink) {
        activeLink.classList.add('active');
    }
}