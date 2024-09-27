<!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function toggleVisibility(id) {
            var element = document.getElementById(id);
            var triggerElement = event.currentTarget;
    
            if (element.style.display === 'none' || element.style.display === '') {
                element.style.display = 'block';
                if (triggerElement.classList.contains('motHistory') || triggerElement.classList.contains('outstandingRecalls')) {
                    triggerElement.classList.add('border-bottom-padding');
                }
            } else {
                element.style.display = 'none';
                if (triggerElement.classList.contains('motHistory') || triggerElement.classList.contains('outstandingRecalls')) {
                    triggerElement.classList.remove('border-bottom-padding');
                }
            }
        }

        function toggleHelpContent(event) {
            var helpContent = event.currentTarget.nextElementSibling;
            if (helpContent.style.display === 'none' || helpContent.style.display === '') {
                helpContent.style.display = 'block';
            } else {
                helpContent.style.display = 'none';
            }
        }
    </script>
</body>
</html>