<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea#myeditorinstance', // Adjust this selector to match your textarea
        plugins: 'advcode table lists checklist image', // Add 'image' to your plugin list
        toolbar: 'undo redo | blocks | bold italic | bullist numlist checklist | code | table | image',
        images_upload_url: '{{ route("project.image-upload") }}', // Use the route name for image upload
        images_upload_base_path: '/storage/project_image', // Base path for image URLs
        images_upload_credentials: true, // Include credentials in CORS requests if needed
        // ... any other configuration options
    });
</script>
