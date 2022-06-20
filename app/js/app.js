const app = {
    init: function () {

        // slider.init(); // activation slider image
        console.log('chargement ok du bon fichier');

        // SOUMISSION FORMULAIRE NEWSLETTER
        document.querySelector('form').addEventListener('submit', app.handleNewsLetterSubmit);
    },
// 
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
