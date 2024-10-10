document.addEventListener('DOMContentLoaded', function() {
    // Attach click event to delete buttons
    document.querySelectorAll('.delete-image').forEach(item => {
      item.addEventListener('click', function() {
        const imageToDelete = this.dataset.image;

        // If you want to visually remove the image immediately
        this.closest('.image-container').remove();

        // If you want to mark the image for deletion on form submit
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'delete_images[]'; // Use an array to collect deleted image paths
        input.value = imageToDelete;
        document.getElementById('editCBDForm').appendChild(input);
      });
    });
  });