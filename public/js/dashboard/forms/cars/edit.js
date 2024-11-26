// Existing variables
let brandsSp = $("#brand-sp");
let modelsSp = $("#model-sp");
let colorsSp = $("#colors-sp");
let drivingModeSp = $("#driving-mode-sp");
let priceFieldInp = $("#price-field-val");
let priceInp = $("#price_inp");
let discountInp = $("#discount_price_inp");
let carColorsDiv = $("#car-colors");
let undoDeleteBtn = $("#undo-delete-image");
let previouslySelected = [];
let updatedColorsImages = {};
let duplicatedImages = {};
let deletedImagesNames = [];
let deletedImages = []; // Array to store deleted images
let deletedColorsImages = [];            // This will store deleted images for undo functionality




$(document).ready(() => {
    initializeColorsSp();
    colorsWithUniqueImages = colorsWithUniqueImages.map(color => ({
        ...color,
        images: [...color.images] // Create a new array for images
    }));
    undoDeleteBtn.click(function () {
        let restoredImage = deletedColorsImages.pop();
        if (!restoredImage) return;
    
        let previousImagesArray = [...updatedColorsImages[restoredImage['color_id']].images];
        previousImagesArray.push(restoredImage['image']);
    
        updatedColorsImages[restoredImage['color_id']].images = previousImagesArray;
    
        // Show the restored image
        $(`#${cleanImageName(restoredImage['image'])}-deleted-image`).removeClass('d-none');
    
        if (deletedColorsImages.length === 0) {
            undoDeleteBtn.prop('disabled', true);
        } else {
            undoDeleteBtn.prop('disabled', false);
            $("#no-images-text").addClass('d-none');
        }
    });

    colorsSp.change(function () {
        let currentlySelected = $(this).val(); // Array of selected color IDs
        let currentIndex = currentlySelected.length - 1;
        let lastSelectedColorId = null;
        let isAdding = currentlySelected.length > previouslySelected.length;

        if (isAdding) {
            lastSelectedColorId = currentlySelected.find(
                (element) => !previouslySelected.includes(element)
            );

            // console.log("Last selected color ID:", lastSelectedColorId);

            // Find the selected color's details
            let selectedColor = colors.find(
                (color) => color['id'] == lastSelectedColorId
            );

            // Find the color in colorsWithUniqueImages
            let colorData = colorsWithUniqueImages.find(
                (color) => color['color_id'] == lastSelectedColorId
            );


            // Get the number of images for this color
            let carImagesCount = colorData && colorData.images.length > 0 ? `( ${colorData.images.length} )` : '';


            // Append the color div with the correct image count
            carColorsDiv.append(`
                <div class="rounded border border-3 p-5 mb-4" id="color-${lastSelectedColorId}">
                    <div class="row text-center">
                        <div class="col-md-4 fv-row">
                            <h4>${selectedColor['name']}</h4>
                            <div class="rounded-circle w-80px h-80px m-auto" style="border:1px solid lightslategrey;background:${selectedColor['hex_code']}"></div>
                            <input type="hidden" name="colors[${currentIndex}][id]" value="${selectedColor['id']}" id="color_inp_${currentIndex}">
                            <p class="invalid-feedback" id="colors_${currentIndex}_color"></p>
                        </div>
                        <div class="col-md-4 fv-row">
                            <label class="text-center fw-bold mb-4 d-block">${__("images")}</label>
                            <input type="file" class="d-none" name="colors[${currentIndex}][images][]" multiple id="images_inp_${selectedColor['id']}">
                            <button class="btn btn-secondary m-auto" type="button" id="images_upload_btn_${selectedColor['id']}"><i class="bi bi-upload fs-8"></i> 0 ${__('File selected')}</button>
                            <a class="text-primary mt-2 d-block" href="javascript:openImagesModal(${selectedColor['id']})">${__('preview photos') + ' ' + carImagesCount}</a>
                            <p class="invalid-feedback" id="colors_${currentIndex}_images"></p>
                        </div>
                    </div>
                </div>
            `);
        } else {
            lastSelectedColorId = previouslySelected.find(
                (element) => !currentlySelected.includes(element)
            );


            carColorsDiv.find(`[id=color-${lastSelectedColorId}]`).eq(0).remove();
        }

        previouslySelected = currentlySelected;
    });

    $("#discount-price-switch").change(function () {
        discountInp.prop("disabled", !$(this).prop("checked"));
    });

    $("#other-radio-btn").click(function () {
        $("#price-other-modal").modal("show");
    });

    $("#price-other-text-btn").click(function () {
        let priceFieldVal = $("#other_text_" + locale.trim() + "_inp").val();
        priceFieldInp.text(priceFieldVal);
        $("#price-other-modal").modal("hide");
    });

    priceInp.keyup(() => changePriceField());

    discountInp.keyup(function () {
        if (parseInt($(this).val()) >= parseInt(priceInp.val())) {
            $(this).val("");
            warningAlert(__("Discount price must be smaller than the price"));
        }

        changePriceField();
    });

    $(document).on("click", "[id*=images_upload_btn]", function () {
        $(this).prev().trigger("click");
    });

    $(document).on("change", "[id*=images_inp]", function () {
        let filesNumber = $(this)[0].files.length;
        $(this)
            .next()
            .html(
                `<i class="bi bi-upload fs-8" ></i> ${filesNumber} ${__(
                    "File selected"
                )}`
            );
    });
});

let changePriceField = () => {
    if (discountInp.val() && priceInp.val()) {
        priceFieldInp.html(
            `<span>${discountInp.val() + currency}  <del> ${
                priceInp.val() + currency
            } </del> </span>`
        );
    } else if (priceInp.val()) {
        priceFieldInp.html(priceInp.val() + currency);
    }
};

let openImagesModal = (colorId) => {
    $("#modal-title").text(__("images"));

    // Find the color object by color_id in colorsWithUniqueImages
    let selectedColor = colorsWithUniqueImages.find((color) => color.color_id === colorId);

    if (!selectedColor) {
        console.error("Color not found with ID:", colorId);
        return; // Exit if color not found
    }

    // Clear the existing images in the modal container
    $("#images-container").empty();

    // Display images or show "no images" text
    if (selectedColor.images && selectedColor.images.length > 0) {
        $("#no-images-text").addClass("d-none");
        selectedColor.images.forEach((image) => {
            $("#images-container").append(createImageContainer(image, colorId));
        });
    } else {
        $("#no-images-text").removeClass("d-none");
    }

    // Show the modal
    $("#edit-images-modal").modal("show");
};

// Helper function to create HTML for each image container
let createImageContainer = (image, colorId) => {
    let imageContainerId = cleanImageName(image) + "-deleted-image";
    let imagePath = getImagePathFromDirectory(image, "Cars");

    return `
        <div class="col-md-3 col-12 my-4 text-center" id="${imageContainerId}">
            <div class="image-input image-input-outline">
                <div class="image-input-wrapper w-100px h-100px" 
                     style="background-image: url('${imagePath}'); background-size: contain;"></div>

                <label onclick="deleteColorImage(${colorId}, '${image}')"
                       class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                       title="${__("Delete image")}">
                    <i class="bi bi-trash-fill fs-7 text-danger"></i>
                </label>
            </div>
        </div>`;
};



let deleteColorImage = (colorId, imageToDelete) => {
    // Find the color object in colorsWithUniqueImages by color_id
    let selectedColorIndex = colorsWithUniqueImages.findIndex(
        (color) => parseInt(color.color_id) === parseInt(colorId)
    );

    if (selectedColorIndex === -1) {
        console.error("Color not found with ID:", colorId);
        return; // Exit if color not found
    }

    // Deep clone the color object to avoid affecting other colors
    let selectedColor = { ...colorsWithUniqueImages[selectedColorIndex], images: [...colorsWithUniqueImages[selectedColorIndex].images] };

    // Add the deleted image to deletedColorsImages for undo functionality
    deletedColorsImages.push({
        color_id: colorId,
        image: imageToDelete,
    });

    // Remove the image from the selected color's images array
    selectedColor.images = selectedColor.images.filter((image) => image !== imageToDelete);

    // Update `colorsWithUniqueImages` with the modified color object
    colorsWithUniqueImages[selectedColorIndex].images = selectedColor.images;

    // Update `updatedColorsImages` to keep track of deletions
    if (!updatedColorsImages[colorId]) {
        updatedColorsImages[colorId] = { images: [] };
    }
    updatedColorsImages[colorId].images = [...selectedColor.images];

    // Hide the deleted image in the DOM
    let imageContainerId = cleanImageName(imageToDelete) + "-deleted-image";
    $(`#${imageContainerId}`).addClass("d-none");

    // Enable the undo button if there’s at least one deleted image
    undoDeleteBtn.prop("disabled", false);

    // Check if there are any remaining images, toggle "No images" text accordingly
    if (selectedColor.images.length === 0) {
        $("#no-images-text").removeClass("d-none");
    } else {
        $("#no-images-text").addClass("d-none");
    }
};

$("#save-imgs-btn").click(function () {
    // Update `colorsWithUniqueImages` with `updatedColorsImages`
    Object.entries(updatedColorsImages).forEach(([colorId, colorData]) => {
        let colorIndex = colorsWithUniqueImages.findIndex(
            (color) => color["color_id"] == colorId
        );

        if (colorIndex !== -1) {
            colorsWithUniqueImages[colorIndex].images = colorData.images;
        }
    });

    // Prepare form data with updated images and deleted images
    let formData = new FormData();
    formData.append("updated_colors_images", JSON.stringify(updatedColorsImages));
    console.log(deletedColorsImages)
    formData.append("deleted_images", JSON.stringify(deletedColorsImages));

    // AJAX request to send data to the backend
    $.ajax({
        url: `/dashboard/cars/${carId}/update-images`, // Update this URL to your actual route
        method: 'POST',
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
            // console.log("Images updated successfully:", response);
            $("#edit-images-modal").modal("hide");
            deletedColorsImages = []; // Reset deleted images array after successful update
        },
        error: function(error) {
            console.error("Error updating images:", error);
        }
    });
});

 


let validateStep = async (successCallback) => {
    // Disable the button and show a loading indicator
    nextBtn.attr("disabled", true).attr("data-kt-indicator", "on");

    // Prepare the form data
    let formData = new FormData(document.getElementById("submitted-form"));

    // Collect the single image file from the input
    let fileInput = document.querySelector("input[name='car_Image']");
    if (fileInput && fileInput.files.length > 0) {
        formData.append("car_Image", fileInput.files[0]); // Append the single image
    }
 
    // AJAX request for validation and submission
    $.ajax({
        url: `/dashboard/car-validate/${carId}`, // Adjust to your endpoint
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: formData,
        contentType: false,
        processData: false,
        success: () => {
            // On success, show an alert and redirect
            successAlert().then(() => window.location.replace("/dashboard/cars"));
            removeValidationMessages();
        },
        error: (response) => {
            removeValidationMessages();

            if (response.status === 422) {
                displayValidationMessages(response.responseJSON.errors);

                // Check for image-specific validation errors
                if (response.responseJSON.errors.car_Image) {
                    $("#image").text(response.responseJSON.errors.car_Image[0]); // Show error message
                }
            } else if (response.status === 403) {
                unauthorizedAlert();
            } else {
                errorAlert({ time: 5000 });
            }

            // Handle any errors for specific fields like "other_text_ar" or "other_text_en"
            if (
                response.status === 422 &&
                (response.responseJSON.errors["other_text_ar"] ||
                    response.responseJSON.errors["other_text_en"])
            ) {
                $("#price-other-modal").modal("show");
            }
        },
        complete: () => {
            // Re-enable the button and remove the loading indicator
            nextBtn.attr("disabled", false).removeAttr("data-kt-indicator");
        },
    });
};

// $("#next-btn").click(() => {
//     // console.log(carId)
//     // validateStep(null, carId !== null, carId); // Pass `isEdit` as true if carId is available
// });
let cleanImageName = (image) => {
    return image.replaceAll("/", "").replaceAll(".", "").replaceAll(" ", "");
};

let initializeColorsSp = () => {
    let tempArr = [];

    carColorsIds.forEach((id, index) => {
        tempArr.push(id);

        colorsSp.val(tempArr).trigger('change', true);
    });
};
