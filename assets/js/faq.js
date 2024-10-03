let questions = document.querySelectorAll('.faq-question');
let faqAnswer = document.querySelectorAll('.faqAnswer');

let n = "";
questions.forEach(function (question) {

    question.addEventListener('click', function () {
        // Masque toutes les réponses FAQ
        faqAnswer.forEach(function (element) {
            element.style.display = "none";
        });
    // Obtient l'élément frère suivant (la réponse) de la question cliquée
        let answer = this.nextElementSibling;
        
    // Affiche les valeurs de la variable 'n' et du texte de la question cliquée dans la console
        console.log("value question " + question.textContent);
    // Si la question cliquée est la même que celle précédemment affichée
        if (question.textContent === n) {
            // Cache la réponse et réinitialise 'n'
            answer.style.display = "none";
            n = ""
            return
        }
            answer.style.display = "block";
            n = question.textContent
 
    });
});
// Importation du fichier de styles CSS pour la FAQ


// const burger = document.querySelector('.burger');
// const navLinksContainer = document.querySelector('.nav_links_container');

// burger.addEventListener('click', () => {
//     burger.classList.toggle('active');
//     navLinksContainer.classList.toggle('active');
// });


// let menuList = document.getElementById(".burger")
// nav_links_container.maxHeight = "0px";

// function toggleMenu() {
//     if (nav_links_container.maxHeight == "0px") {
//         nav_links_container.maxHeight = "300px";
//     } else {
//         nav_links_container.maxHeight = "0px";
//     }
// }