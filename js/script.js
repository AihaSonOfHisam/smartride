$(document).ready(function() {
    $('#addFeedbackBtn').click(function(e) {
        e.preventDefault();
        
        // Check if the user has completed a rental (e.g., by checking the past_rental table in the database)
        // You need to implement the backend logic to verify this
        
        // If the user has completed a rental, open the feedback modal
        // Otherwise, show an error message or redirect them to a different page
        
        // For demonstration purposes, let's assume the user has completed a rental
        
        $('.modal-bg').fadeIn(); // Show the modal window
        
        // Handle form submission
        $('#feedbackForm').submit(function(e) {
            e.preventDefault();
            
            // Get the feedback text entered by the user
            var feedbackText = $('#feedbackText').val();
            
            // Send an AJAX request to the backend to store the feedback in the database
            // You need to implement the backend API endpoint to handle this
            
            // For demonstration purposes, let's assume the feedback is successfully stored
            
            // Display a success message or perform any desired action
            
            $('.modal-content').html('<p>Feedback submitted successfully!</p>');
        });
        
        // Close the modal on button click
        $('#closeModal').click(function() {
            $('.modal-bg').fadeOut(); // Hide the modal window
        });
    });
});
