function togglePasswordVisibility(fieldId, iconElement) {
    let input = document.getElementById(fieldId);
    if (input) {
        if (input.type === 'password') {
            input.type = 'text';
            iconElement.textContent = '👁️'; 
        } else {
            input.type = 'password';
            iconElement.textContent = '👁️‍🗨️';
        }
    } else {
        console.error(`Élément avec l'ID ${fieldId} introuvable.`);
    }
}
