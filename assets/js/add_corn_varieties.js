function insertData() {
    // Get form data
    var formData = $('#insertForm').serialize();
    console.log('FormData:', formData); // Log the serialized form data
    var breedName = $('#name').val();

    // Clear any previous error message
    $('#name-error').remove();

    // Check if breed name is empty
    if (breedName.trim() === '') {
        // Display an error message below the input field
        $('#name').after('<p id="name-error" class="text-danger">សូមបញ្ចូលឈ្មោះពូជពោត</p>');

        // Remove the error message after 5 seconds
        setTimeout(function () {
            $('#name-error').fadeOut('slow', function () {
                $(this).remove(); // Remove the error message from the DOM
            });
        }, 5000);

        return; // Do not proceed with the submission
    }

    // AJAX request to insert data
    $.ajax({
        type: 'POST',
        url: 'add_corn_varieties.php', // PHP script to handle data insertion
        data: formData,
        dataType: 'json', // Expect JSON response
        success: function (response) {
            console.log('AJAX Response:', response);

            // Clear any previous message
            $('#message').html('');

            if (response.status === 'success') {
                // Clear the input field after successful submission
                $('#name').val('');

                // Close the modal after success
                setTimeout(function () {
                    $('#myModal').modal('hide');
                }, 1000); // Close after 1 second

                // Reload the page to show the session message
                setTimeout(function () {
                    location.reload(); // Reload the page to reflect the changes
                }, 1000); // Wait 1 second before reloading

            } else {
                // Display error message
                $('#message').html('<div class="">' + response.message + '</div>');

                // Show error message for 5 seconds
                setTimeout(function () {
                    $('#message').fadeOut('slow', function () {
                        $(this).html('').show(); // Clear the message and reset
                    });
                }, 5000);
            }
        },
        error: function () {
            $('#message').html('<div class="alert alert-danger">An error occurred while processing the request.</div>');

            // Show error message for 5 seconds
            setTimeout(function () {
                $('#message').fadeOut('slow', function () {
                    $(this).html('').show(); // Clear the message and reset
                });
            }, 5000);
        }
    });
}
