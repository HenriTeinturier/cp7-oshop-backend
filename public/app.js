const app = {
    init: function () {

        // slider.init(); // activation slider image
        
        console.log('chargement ok du mauvais fichier');
        // SOUMISSION FORMULAIRE NEWSLETTER
        document.querySelector('form').addEventListener('submit', app.handleNewsLetterSubmit);
    },

    handleNewsLetterSubmit: function(event) {
        
        console.log('chargement function') ;
        let tableau = [];
        // recuperer les infos de l'input
        let  inputValue = document.querySelector('#emplacement1').value; 
        if (Number(inputValue)) {
            console.log("c'est un nombre entier")
            if (tableau.includes(inputValue)) {
                console.log('ce nombre est deja dans le tableau');
                event.preventDefault();
            } else {
                tableau.push(inputValue)
            }
        } else {event.preventDefault};
        inputValue = document.querySelector('#emplacement2').value;
        if (Number(inputValue)) {
            console.log("c'est un nombre entier")
            if (tableau.includes(inputValue)) {
                console.log('ce nombre est deja dans le tableau');
                event.preventDefault();
            } else {
                tableau.push(inputValue)
            }
        } else {event.preventDefault};
        inputValue = document.querySelector('#emplacement3').value;
        if (Number(inputValue)) {
            console.log("c'est un nombre entier")
            if (tableau.includes(inputValue)) {
                console.log('ce nombre est deja dans le tableau');
                event.preventDefault();
            } else {
                tableau.push(inputValue)
            }
        } else {event.preventDefault};
        inputValue = document.querySelector('#emplacement4').value;
        if (Number(inputValue)) {
            console.log("c'est un nombre entier")
            if (tableau.includes(inputValue)) {
                console.log('ce nombre est deja dans le tableau');
                event.preventDefault();
            } else {
                tableau.push(inputValue)
            }
        } else {event.preventDefault};
        inputValue = document.querySelector('#emplacement5').value;
        if (Number(inputValue)) {
            console.log("c'est un nombre entier")
            if (tableau.includes(inputValue)) {
                console.log('ce nombre est deja dans le tableau');
                event.preventDefault();
            } else {
                tableau.push(inputValue)
            }
        } else {event.preventDefault};
        
        

        
    },

}







// ATTENTE CHARGEMENT COMPLET PAGE
document.addEventListener('DOMContentLoaded', app.init);



// reste à "corriger" optimiser:
// affichage des commentaires contenant 1 2 ou 3 etoiles en fonction de si les cases sont cochées ou pas.
// actriver encart newsletter au scroll
// eviter de crer un id btn-suivant et btn-precedent mais plutôt utiliser le aria-label="suivant" ou "precedent"
// eviter d'utiliser deux fonctions pour boutons suivant et precedent?
// optimiser les variables, noms de variables et leur placement.

//BONUS NEWSLETTER
//afficher newsletter si on scroll un peu dans la page: 300px
//https://www.w3schools.com/jsref/tryit.asp?filename=tryjsref_onscroll_addeventlistener
//