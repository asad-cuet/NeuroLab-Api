
function initializeDropzone(dropzoneElement, fileInput, previewContainer, uploadOptions) {
const fileIcon = dropzoneElement.querySelector(".upload-file__icon");
const fileText = dropzoneElement.querySelector(".upload-file__text");
const fileSize = dropzoneElement.querySelector(".upload-file__size");

// Handle clicking the custom box to trigger file input
dropzoneElement.addEventListener("click", function () {
    fileInput.click(); // Trigger hidden file input click
});

// Listen for file selection via file input
fileInput.addEventListener("change", function (event) {
    const files = event.target.files;
    handleFiles(files); // Pass the files to the handleFiles function
});

// Function to handle the selected or dropped files
function handleFiles(files) {
    // Check if multiple files are selected for single image upload
    if (uploadOptions.maxFiles === 1 && files.length > 1) {
    alert("Please upload only one image.");
    fileInput.value = ""; // Reset file input
    return;
    }

    // Hide elements when files are uploaded
    fileIcon.style.display = "none";
    fileText.style.display = "none";
    fileSize.style.display = "none";

    previewContainer.style.display = "grid";

    // If there are already files in the preview and single upload is enabled, remove them
    if (uploadOptions.maxFiles === 1) {
    previewContainer.innerHTML = ""; // Clear previous previews for single file upload
    }

    for (let i = 0; i < files.length; i++) {
    const file = files[i];
    const reader = new FileReader();

    reader.onload = function (e) {
        const imagePreview = document.createElement("div");
        imagePreview.classList.add("uploaded-image-preview");

        const img = document.createElement("img");
        img.src = e.target.result;
        img.alt = "Uploaded File";
        img.classList.add("uploaded-file");
        imagePreview.appendChild(img);

        const fileInfo = document.createElement("div");
        fileInfo.classList.add("file-info");

        const fileName = document.createElement("div");
        fileName.classList.add("file-name");
        fileName.textContent = file.name;
        fileInfo.appendChild(fileName);

        const fileSize = document.createElement("div");
        fileSize.classList.add("file-size");
        fileSize.textContent = (file.size / 1024).toFixed(2) + " KB";
        fileInfo.appendChild(fileSize);

        imagePreview.appendChild(fileInfo);

        const removeBtn = document.createElement("button");
        removeBtn.textContent = "×";
        removeBtn.classList.add("remove-btn");
        removeBtn.addEventListener("click", function () {
        previewContainer.removeChild(imagePreview);
        fileInput.value = ""; // Clear the file input when no files are left
        fileIcon.style.display = "block"; // Show the upload icon again
        fileText.style.display = "block"; // Show the upload text again
        fileSize.style.display = "block"; // Show the file size text again
        });
        imagePreview.appendChild(removeBtn);

        previewContainer.appendChild(imagePreview);
    };

    reader.readAsDataURL(file);
    }
}

// Apply the settings dynamically
new Dropzone(dropzoneElement, {
    url: uploadOptions.url || "/upload", // Customize URL if needed
    maxFiles: uploadOptions.maxFiles || 1, // Default to 1 file upload
    maxFilesize: uploadOptions.maxFilesize || 2, // Max file size 2MB
    acceptedFiles: uploadOptions.acceptedFiles || "image/*", // Default to images
    dictDefaultMessage: uploadOptions.dictDefaultMessage || "",
    previewsContainer: previewContainer,
    init: function () {
    this.on("addedfile", function (file) {
        handleFiles([file]);

        // If more than the allowed number of files is uploaded, remove the previous one
        if (this.files.length > uploadOptions.maxFiles) {
        this.removeFile(this.files[0]);
        }
    });
    }
});
}

// Initialize single image upload
document.querySelectorAll('.upload-file-section-single').forEach(section => {
const dropzoneElement = section.querySelector('.upload-file__box');
const fileInput = section.querySelector('.file-input');
const previewContainer = section.querySelector('.uploaded-images');

const uploadOptions = {
    maxFiles: 1, // Single file upload
    acceptedFiles: "image/*", 
    maxFilesize: 2, // 2MB max size for image files
    dictDefaultMessage: "Click to upload an image"
};

initializeDropzone(dropzoneElement, fileInput, previewContainer, uploadOptions);
});