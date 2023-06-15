<script>
window.addEventListener('DOMContentLoaded', (event) => {
    var welcomeHeading = document.getElementById('welcome-heading');
    var welcomeMessage = document.getElementById('welcome-message');

    // Controleren of de gebruiker is ingelogd en animatie toevoegen
    if (welcomeHeading && welcomeMessage) {
        var isLogged = <?php echo ($isLogged ? 'true' : 'false'); ?>;
        
        if (isLogged) {
            welcomeHeading.classList.add('fade-in');
            welcomeMessage.classList.add('fade-in');
        }
    }
});
</script>
