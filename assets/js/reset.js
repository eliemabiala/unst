let togglePasswordVisibility = document.getElementById("togglePasswordVisibility")

let input = document.getElementById("password");
togglePasswordVisibility.addEventListener("click", function() {
        if (input.type === 'password') {
            input.type = 'text'; 
            togglePasswordVisibility.textContent = "👁️"
        } else {
            input.type = 'password';
            togglePasswordVisibility.textContent = "👁️‍🗨️"
        }
    
});
