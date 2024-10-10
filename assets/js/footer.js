// let questions = document.querySelectorAll('.footer-help'); 
// let footerAnswers = document.querySelectorAll('.footer-answer'); 

// let n = "";
// questions.forEach(function (question) {

//     question.addEventListener('click', function () {
//         // Masque toutes les réponses du pied de page
//         footerAnswers.forEach(function (element) {
//             element.style.display = "none";
//         });
//         // Obtient l'élément frère suivant (la réponse) de la question cliquée
//         let answer = this.nextElementSibling;

//         // Affiche les valeurs de la variable 'n' et du texte de la question cliquée dans la console
//         console.log("value question " + question.textContent);
//         // Si la question cliquée est la même que celle précédemment affichée
//         if (question.textContent === n) {
//             // Cache la réponse et réinitialise 'n'
//             answer.style.display = "none";
//             n = "";
//             return;
//         }
//         answer.style.display = "block";
//         n = question.textContent;

//     });
// });
