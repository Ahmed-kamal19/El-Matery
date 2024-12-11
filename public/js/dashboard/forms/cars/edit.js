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
    // colorsWithUniqueImages = colorsWithUniqueImages.map(color => ({
    //     ...color,
    //     images: [...color.images] // Create a new array for images
    // }));
    
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
        } 
        else {
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
                            <!-- begin :: Column -->
                            <div class="col-md-4 fv-row">
                            <!-- begin -->
                            <label class="text-center fw-bold mb-4 d-block">${ __("stock")}</label>
                            <input type="number" class="form-control" name="colors[${currentIndex}][stock]" value="${colorData['stock']}" id="colors_stock_inp_${ selectedColor['id'] }">
    
                            <p class="invalid-feedback" id="colors_${currentIndex}_stock" ></p>
                            <!-- end   -->
                            </div>
                            <!-- end   :: Column -->
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

    // Sort the images by the sort order
    let selectedImages = carImageSorted
        .filter(item => item.color_id == colorId)
        .sort((a, b) => a.sort - b.sort);
       
    $("#images-container").empty();

    if (selectedImages.length > 0) {
        $("#no-images-text").addClass("d-none");
        selectedImages.forEach(item => {
            $("#images-container").append(createImageContainer(item.image, item.color_id,item.id));
        });
    } else {
        $("#no-images-text").removeClass("d-none");
    }

    $("#edit-images-modal").modal("show");
};
// Helper function to create HTML for each image container
let createImageContainer = (image, colorId,imageId) => {
    let imageContainerId = cleanImageName(image) + "-deleted-image" ;
    let imagePath = getImagePathFromDirectory(image, "Cars");
   
    return `
        <div class="col-md-3 col-12 my-4 text-center" id="${imageContainerId}">
            <div class="image-input image-input-outline">
                <div class="image-input-wrapper w-100px h-100px draggable draggable-handle" data-color-id="${colorId}"
                 data-id="${imageId}" 
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
    console.log(colorsWithUniqueImages)
    // Find the color object in colorsWithUniqueImages by color_id  
    let selectedColorIndex = colorsWithUniqueImages.findIndex(
        (color) => parseInt(color.color_id) === parseInt(colorId)
    );

    if (selectedColorIndex === -1) {
        console.error("Color not found with ID:", colorId);
        return; // Exit if color not found
    }
    // Deep clone the color object to avoid affecting other colors
    // let selectedColor = JSON.parse(JSON.stringify({ ...colorsWithUniqueImages[selectedColorIndex], images: [...colorsWithUniqueImages[selectedColorIndex].images] }));
    let selectedColor = { ...colorsWithUniqueImages[selectedColorIndex] };
    

    selectedColor.images = [...colorsWithUniqueImages[selectedColorIndex].images];
    // Add the deleted image to deletedColorsImages for undo functionality
    deletedColorsImages.push({
        color_id: colorId,
        image: imageToDelete,
    });
    
    
    // Remove the image from the selected color's images array
    // console.log(selectedColor.images)
    selectedColor.images = selectedColor.images.filter((image) => image !== imageToDelete);
    // console.log(selectedColor.images)

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
    

    // let imagesInContainer = $("#images-container .draggable").length;

    // if (imagesInContainer === 0) {
    //     $("#no-images-text").removeClass("d-none");
    // } else {
    //     $("#no-images-text").addClass("d-none");
    // }
};


$("#save-imgs-btn").click(function () {
    // Prepare form data with updated images and deleted images
    let formData = new FormData();
    formData.append("updated_images", JSON.stringify(carImageSorted));
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
            console.log("Images updated successfully:", response);
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

// let initializeColorsSp = () => {
//     let tempArr = [];

//     carColorsIds.forEach((id, index) => {
//         tempArr.push(id);

//         colorsSp.val(tempArr).trigger('change', true);
//     });
// };
let initializeColorsSp = () => {
    let tempArr = [];

    carImageSorted.forEach((item) => {
        if (!tempArr.includes(item.color_id)) {
            tempArr.push(item.color_id);
        }
    });

    colorsSp.val(tempArr).trigger('change', true);
};



document.addEventListener("DOMContentLoaded", function () {
    const container = document.querySelector("#images-container");
    let reorderedImages = []; // Store reordered images grouped by color

    // Store the original order of each color (to prevent overwriting)
    let originalImageOrder = {};

    // Initialize drag-and-drop sorting
    const swappable = new Draggable.Swappable(container, {
        draggable: ".draggable",
        handle: ".draggable-handle",
    });

    // Update the reorderedImages array after drag-and-drop
    swappable.on("swappable:stop", function () {
        const groupedImages = {}; // Temporary object to group images by color

        // Group images by color
        container.querySelectorAll('.draggable').forEach((dragItem) => {
            const imageId = dragItem.getAttribute('data-id');
            const colorId = dragItem.getAttribute('data-color-id');
      
            if (imageId && colorId) {
                const imageData = carColors.find(img => img.id == imageId && img.color_id == colorId);
                
                if (imageData) {
                    // Initialize group for the color if not exists
                    if (!groupedImages[colorId]) {
                        groupedImages[colorId] = [];
                    }

                    // Ensure no duplicates in the group
                    if (!groupedImages[colorId].some(img => img.id == imageData.id)) {
                        groupedImages[colorId].push(imageData);
                    }
                }
            }
        });
        // Now ensure that every color group has its images sorted correctly
        reorderedImages = Object.keys(groupedImages).map(colorId => ({
            color_id: colorId,
            images: groupedImages[colorId], // Images under each color
        }));

        // Log the current sorted images
        const filteredImages = reorderedImages.filter(colorGroup => colorGroup.images.length > 0);
       
        
        // Save the order of images for each color to prevent overwriting
        filteredImages.forEach(group => {
            originalImageOrder[group.color_id] = group.images; // Persist color-specific order
        });
      
        // Prepare the test array with the latest color order
        let test = [];
        for (let colorId in originalImageOrder) {
            test.push({ color_id: colorId, images: originalImageOrder[colorId] });
        }

        // Log the test array to check if each color is preserved
        console.log("Test Array with Sorted Colors:", test);

        // Now you can use the test array for submission
        // $("#next-btn").on("click", function (e) {
        //     e.preventDefault();  // Prevent page reload

            // Use the test array for the AJAX submission
            $.ajax({
                url: window.location.origin + "/dashboard/sort/image", // Dynamically resolve base URL
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                },
                contentType: "application/json",
                data: JSON.stringify({ images: test }),  // Send the test array for submission
                success: function (data) {
                    
                    console.log("Image order successfully updated:", data);
                },
                error: function (xhr, status, error) {
                    console.error("Error submitting image order:", xhr.responseText);
                },
            });
        // });
    });
});
