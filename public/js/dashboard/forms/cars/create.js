let brandsSp = $("#brand-sp");
let modelsSp = $("#model-sp");
let priceFieldInp = $("#price-field-val");
let priceInp = $("#price_inp");
let discountInp = $("#discount_price_inp");
let carColorsDiv = $("#car-colors");

let previouslySelected = [];

$(document).ready(() => {
    brandsSp.change(function () {
        let selectedBrandId = $(this).val();
        let selectedBrandName = brands.find(
            (brand) => brand.id == selectedBrandId
        ).name;
    });
    
    $("#colors-sp").change(function () {

        let currentlySelected   = $(this).val(); // ids [1, 2, 3]
        let currentIndex        = currentlySelected.length - 1;
        let lastSelectedColorId = null;
        let isAdding            = currentlySelected.length > previouslySelected.length;
        console.log(previouslySelected.length)
        
        if ( isAdding )
            {
                lastSelectedColorId = currentlySelected.find( ( element ) => ! previouslySelected.includes(element) );
              

            let selectedColor = colors.find( (color) => color['id'] == lastSelectedColorId );
          
            carColorsDiv.append(`<div class="rounded border border-3 p-5 mb-4" id="color-${lastSelectedColorId}">

                                                <!-- begin :: Row -->
                                                <div class="row text-center">

                                                    <!-- Begin :: Column -->
                                                    <div class="col-md-4 fv-row">
                                                        <h4>${ selectedColor['name'] }</h4>
                                                        <div class="rounded-circle w-80px h-80px m-auto" style="border:1px solid lightslategrey;background:${ selectedColor['hex_code']  }"></div>
                                                     <input type="hidden" name="colors[${currentIndex}][id]" value=${ selectedColor['id'] }  id="color_inp_${currentIndex}">
                                                        <p class="invalid-feedback" id="colors_${currentIndex}_color" ></p>
                                                    </div>
                                                    <!-- end   :: Column -->

                                                     <!-- begin :: Column -->
                                                    <div class="col-md-4 fv-row">
                                                        <!-- begin :: Upload image component -->
                                                        <label class="text-center fw-bold mb-4 d-block">${__("images")}</label>
                                                        <input type="file" class="d-none" name="colors[${currentIndex}][images][]" multiple id="inner_images_inp_${ selectedColor['id'] }">
                                                        <button class="btn btn-secondary m-auto" type="button" id="images_upload_btn_${ selectedColor['id'] }_inp" > <i class="bi bi-upload fs-8" ></i> 0 ${__('File selected')} </button>
                                                        <p class="invalid-feedback" id="colors_${currentIndex}_images" ></p>
                                                        <!-- end   :: Upload image component -->
                                                    </div>
                                                    <!-- end   :: Column -->

                                                       <!-- begin :: Column -->
                                                    <div class="col-md-4 fv-row">
                                                        <!-- begin -->
                                                        <label class="text-center fw-bold mb-4 d-block">${ __("stock")}</label>
                                                        <input type="number" class="form-control" name="colors[${currentIndex}][stock]" multiple id="colors_stock_inp_${ selectedColor['id'] }">
                                
                                                        <p class="invalid-feedback" id="colors_${currentIndex}_stock" ></p>
                                                        <!-- end   -->
                                                    </div>
                                                    <!-- end   :: Column -->

                                                </div>
                                                <!-- end   :: Row -->

                                            </div>`);
        }else
        {
            lastSelectedColorId = previouslySelected.find( ( element ) => ! currentlySelected.includes(element) )

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

    $(document).on("change", "[id*=_images_inp]", function () {
        let filesNumber = $(this)[0].files.length;
        $(this)
            .next()
            .html(
                `<i class="bi bi-upload fs-8" ></i> ${filesNumber} ${
                    filesNumber === 1 ? "file" : "files"
                } selected`
            );
    });
});

function changePriceField() {
    if (discountInp.val() && priceInp.val()) {
        priceFieldInp.html(
            `<span>${discountInp.val() + currency}  <del> ${
                priceInp.val() + currency
            } </del> </span>`
        );
    } else if (priceInp.val()) {
        priceFieldInp.html(priceInp.val() + currency);
    }
}
$(document).on("change", "input[name='car_Image']", function () {
    if (this.files.length > 0) {
        let fileName = this.files[0].name; // Get the file name
        $("#image").text(`Selected file: ${fileName}`);
    } else {
        $("#image").text("No file selected");
    }
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
        url: "/dashboard/car-validate", // Adjust to your endpoint
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

