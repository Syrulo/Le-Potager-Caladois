document.addEventListener("DOMContentLoaded", function() {
    const cookieName = "cookieConsent";
    const revokeCookiesLink = document.getElementById("revokeCookies");
    const cookieModal = document.getElementById("cookieModal");

    // Vérifie si le cookie "cookieConsent" existe
    if (!getCookie(cookieName)) {
        // Affiche la modale si le cookie n'existe pas
        cookieModal.style.display = "block";
    } else {
        // Met à jour le texte du lien en fonction de l'état du cookie
        updateRevokeLinkText();
    }

    // Gestion du clic sur le bouton "Accepter"
    document.getElementById("acceptCookies").addEventListener("click", function() {
        setCookie(cookieName, "accepted", 30); // Durée de 30 jours
        cookieModal.style.display = "none";
        updateRevokeLinkText();
    });

    // Gestion du clic sur le bouton "Refuser"
    document.getElementById("rejectCookies").addEventListener("click", function() {
        setCookie(cookieName, "rejected", 30); // Durée de 30 jours
        cookieModal.style.display = "none";
        updateRevokeLinkText();
    });

    // Fonction pour définir un cookie
    function setCookie(name, value, days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        const expires = "expires=" + date.toUTCString();
        document.cookie = name + "=" + value + ";" + expires + ";path=/";
    }

    // Fonction pour récupérer un cookie
    function getCookie(name) {
        const value = "; " + document.cookie;
        const parts = value.split("; " + name + "=");
        if (parts.length === 2) return parts.pop().split(";").shift();
    }

    // Fonction pour effacer un cookie
    function eraseCookie(name) {
        document.cookie = name + '=; Max-Age=-99999999;';
    }

    // Fonction pour mettre à jour le texte du lien de révocation
    function updateRevokeLinkText() {
        const cookieConsent = getCookie(cookieName);
        if (cookieConsent === "accepted") {
            revokeCookiesLink.textContent = "Révoquer le consentement des cookies";
        } else {
            revokeCookiesLink.textContent = "Accepter le consentement des cookies";
        }
    }

    // Révoquer le consentement aux cookies
    revokeCookiesLink.addEventListener("click", function(event) {
        event.preventDefault(); // Empêche le lien de recharger la page
        const cookieConsent = getCookie(cookieName);
        if (cookieConsent === "accepted") {
            eraseCookie(cookieName); // Efface le cookie
            alert("Votre consentement aux cookies a été réinitialisé. La prochaine fois que vous visiterez cette page, vous pourrez refaire votre choix.");
            location.reload(); // Rafraîchit la page pour afficher la modale
        } else {
            cookieModal.style.display = "block"; // Réouvre la modale
        }
    });

});

