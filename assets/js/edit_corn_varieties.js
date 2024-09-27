// Function to open the update modal with the existing data
function openUpdateModal(id, currentName) {
    // Set the current breed name in the input field
    $("#updatedName").val(currentName);

    // Set the ID of the record being updated in the hidden field
    $("#update_id").val(id);

    // Show the update modal
    $("#updateModal").modal("show");
}
// Function to update data
function updateData(event) {
    event.preventDefault(); // Prevent the default form submission

    // Get updated data
    var updatedData = $("#updateForm").serialize();

    // AJAX request to update data
    $.ajax({
        type: "POST",
        url: "edit_corn_varieties.php", // Your PHP update script
        data: updatedData,
        dataType: 'json', // Expect JSON response
        success: function (response) {
            // Clear any existing messages
            $('#modal-message').html('');

            if (response.status === 'success') {
                // Success handled by PHP session, just close the modal and reload
                setTimeout(function () {
                    $("#updateModal").modal("hide");
                    location.reload(); // Reload the page to show the session message
                }, 1); // Close modal after 1 second
            } else if (response.status === 'error') {
                // Error or duplicate message (e.g., duplicate name)
                $('#modal-message').html('<div class="text-danger">' + response.message + '</div>');

                // Remove the message after 5 seconds
                setTimeout(function () {
                    $('#modal-message').fadeOut('slow');
                }, 5000);
            }
        },
        error: function () {
            // Handle any other error
            $('#modal-message').html('<div class="alert alert-danger">កំហុសក្នុងការកែប្រែពូជ។</div>'); // "Error updating the variety."
        }
    });
}

$(document).ready(function () {
    // Check if the session message exists
    if ($('#session-message').length) {
        // Fade out after 5 seconds
        setTimeout(function () {
            $('#session-message').fadeOut('slow', function () {
                $(this).remove(); // Remove the element from the DOM
            });
        }, 5000);
    }
});

