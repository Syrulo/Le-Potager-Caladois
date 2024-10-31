/**
 * Script de gestion du consentement des cookies.
 * Ce script affiche une modale pour demander le consentement des cookies et met à jour le texte du lien de révocation en fonction de l'état des cookies.
 */
document.addEventListener("DOMContentLoaded", function () {
  // Nom du cookie utilisé pour stocker le consentement des cookies
  const cookieName = "cookieConsent";
  // Élément du lien pour révoquer le consentement des cookies
  const revokeCookiesLink = document.getElementById("revokeCookies");
  // Élément de la modale de consentement des cookies
  const cookieModal = document.getElementById("cookieModal");

  // Vérifie si le cookie "cookieConsent" existe
  if (!getCookie(cookieName)) {
    // Affiche la modale si le cookie n'existe pas
    cookieModal.style.display = "block";
    // Affiche la modale si le cookie n'existe pas
    cookieModal.style.display = "block";
    // Ajoute une classe pour rendre la modale visible
    cookieModal.classList.add("show");
  } else {
    // Met à jour le texte du lien en fonction de l'état du cookie
    updateRevokeLinkText();
  }

  // Gestion du clic sur le bouton "Accepter"
  document
    .getElementById("acceptCookies")
    .addEventListener("click", function () {
      // Définit le cookie "cookieConsent" sur "accepted" pour une durée de 30 jours
      setCookie(cookieName, "accepted", 30);
      // Cache la modale
      cookieModal.style.display = "none";
      // Met à jour le texte du lien de révocation
      updateRevokeLinkText();
    });

  // Gestion du clic sur le bouton "Refuser"
  document
    .getElementById("rejectCookies")
    .addEventListener("click", function () {
      // Définit le cookie "cookieConsent" sur "rejected" pour une durée de 30 jours
      setCookie(cookieName, "rejected", 30);
      // Cache la modale
      cookieModal.style.display = "none";
      // Met à jour le texte du lien de révocation
      updateRevokeLinkText();
    });

  /**
   * Définit un cookie avec un nom, une valeur et une durée d'expiration.
   *
   * @param {string} name - Le nom du cookie.
   * @param {string} value - La valeur du cookie.
   * @param {number} days - La durée de vie du cookie en jours.
   */
  function setCookie(name, value, days) {
    // Crée une nouvelle date
    const date = new Date();
    // Définit l'heure d'expiration du cookie en ajoutant le nombre de jours spécifié
    date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
    // Convertit la date d'expiration en une chaîne de caractères au format UTC
    const expires = "expires=" + date.toUTCString();
    // Définit le cookie avec le nom, la valeur, la date d'expiration et le chemin
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
  }

  /**
   * Récupère la valeur d'un cookie par son nom.
   *
   * @param {string} name - Le nom du cookie.
   * @returns {string|null} La valeur du cookie ou null s'il n'existe pas.
   */
  function getCookie(name) {
    // Ajoute un point-virgule et un espace au début de la chaîne des cookies
    const value = "; " + document.cookie;
    // Divise la chaîne des cookies en parties en utilisant le nom du cookie comme séparateur
    const parts = value.split("; " + name + "=");
    // Si la longueur des parties est de 2, cela signifie que le cookie existe
    if (parts.length === 2)
      // Retourne la valeur du cookie en supprimant les éventuels points-virgules restants
      return parts.pop().split(";").shift();
  }

  /**
   * Efface un cookie en définissant sa durée de vie à une valeur négative.
   *
   * @param {string} name - Le nom du cookie.
   */
  function eraseCookie(name) {
    // Définit le cookie avec une valeur vide et une durée de vie négative pour le supprimer
    document.cookie = name + "=; path=/; Max-Age=-99999999;";
  }

  /**
   * Met à jour le texte du lien de révocation en fonction de l'état du cookie "cookieConsent".
   */
  function updateRevokeLinkText() {
    // Récupère la valeur du cookie "cookieConsent"
    const cookieConsent = getCookie(cookieName);
    // Vérifie si le consentement aux cookies a été accepté
    if (cookieConsent === "accepted") {
      // Si accepté, met à jour le texte du lien pour révoquer le consentement
      revokeCookiesLink.textContent = "Révoquer le consentement des cookies";
    } else {
      // Sinon, met à jour le texte du lien pour accepter le consentement
      revokeCookiesLink.textContent = "Accepter le consentement des cookies";
    }
  }

  // Révoquer le consentement aux cookies
  revokeCookiesLink.addEventListener("click", function (event) {
    // Empêche le lien de recharger la page
    event.preventDefault();
    // Récupère la valeur du cookie "cookieConsent"
    const cookieConsent = getCookie(cookieName);
    // Vérifie si le consentement aux cookies a été accepté
    if (cookieConsent === "accepted") {
      // Affiche une alerte pour informer l'utilisateur que le consentement a été réinitialisé
      alert(
        "Votre consentement aux cookies a été réinitialisé. La prochaine fois que vous visiterez cette page, vous pourrez refaire votre choix."
      );
      // Efface le cookie "cookieConsent"
      eraseCookie(cookieName);
      // Rafraîchit la page pour afficher la modale de consentement des cookies
      location.reload();
    } else {
      // Si le consentement n'a pas été accepté, réouvre la modale de consentement des cookies
      cookieModal.style.display = "block";
    }
  });
});
