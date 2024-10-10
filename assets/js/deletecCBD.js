$(document).ready(function() {
    // Handle delete button click
    $(document).on('click', '.delete-btn', function() {
        var userId = $(this).data('id');
        Swal.fire({
            title: 'តើអ្នកប្រាកដទេ?',
            text: 'អ្នក​នឹង​មិន​អាច​ស្តា​ពូជ​ពោត​នេះឡើង​វិញទេ​!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'បាទ លុបវាចោល!',
            cancelButtonText: 'បោះបង់'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'delete_corn_breeding_data.php', // Adjust URL to your delete script
                    type: 'POST',
                    data: {
                        id: userId
                    },
                    success: function(response) {
                        console.log('Response:', response); // Debugging: Log the response
                        if (response === 'success') {
                            console.log('Removing row with ID: #user-' + userId); // Log the row being removed
                            $('#user-' + userId).remove(); // Remove the row from the table
                            Swal.fire('បានលុប!', 'ឈ្មោះពូជត្រូវបានលុប.', 'success');
                        } else {
                            Swal.fire('Error!', 'មានបញ្ហាពេលលុប.', 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error); // Debugging: Log AJAX errors
                        Swal.fire('Error!', 'An error occurred while deleting the user.', 'error');
                    }
                });
            }
        });
    });
});