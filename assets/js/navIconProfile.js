document.addEventListener('DOMContentLoaded', function() {
const profileIcon = document.querySelector('.nav_icon_profile'); 
const profileMenu = document.querySelector('.nav_liste_content_iconprofile');

    if (profileIcon && profileMenu) {
        profileIcon.addEventListener('click', function() {
            console.log(222);
            profileMenu.classList.toggle('active'); 
        });
    }
});


// document.addEventListener('DOMContentLoaded', function() {
//     const profileIcon = document.querySelector('.nav_icon_profile'); 
//     const profileMenu = document.querySelector('.nav_liste_content_iconprofile');

//     if (profileIcon && profileMenu) {
//         profileIcon.addEventListener('click', function(event) {
//             event.stopPropagation();
//             profileMenu.classList.toggle('active'); 
//         });

//         document.addEventListener('click', function(event) {
//             if (!profileMenu.contains(event.target) && !profileIcon.contains(event.target)) {
//                 profileMenu.classList.remove('active');
//             }
//         });
//     }
// });
