"use strict";
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Class definition
let KTDatatable = (function () {
    // Shared variables
    let table;
    let datatable;
    let filter;

    // Private functions
    let initDatatable = function () {
        datatable = $("#kt_datatable").DataTable({
            orderable: false,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            order: [[2, "desc"]], // Assuming the 'created_at' column is at index 2
            stateSave: false,
            // select: {
            //     style: "os",
            //     selector: "td:first-child",
            //     className: "row-selected",
            // },
            ajax: {
                url: "/dashboard/partners", // Update the URL to your API endpoint
                type: "GET",
            },
            columns: [
                { data: "id" },
                { data: "image" },
                { data: "created_at" },
                { data: null },
            ],
            // return meta.row + 1;
            columnDefs: [
                {
                    targets: 0,
                    orderable: false,
                    render: function (data, type, row, meta) {
                        // return `
                        //     <div ${isArabic == '1' ? '' : `class="d-flex align-items-center"`}>

                        //         <div class="d-flex flex-column justify-content-center">
                        //         <span class="mb-1 text-gray-800">${meta.row + 1}</span>
                        // </div></div>
                        //         `
                        return meta.row + 1;
                    }
                },
                {
                    targets: 1,
                    render: function (data, type, row) {
                        return `
                            <!--begin::Overlay-->
                                <div class="d-flex flex-column justify-content-center">
                            <a class="d-block overlay" data-action="preview_attachments" href="#">
                                <!--begin::Image-->
                                <div class="overlay-wrapper bgi-no-repeat bgi-position-center bgi-size-cover card-rounded h-100px"
                                    style="background-image:url('${row.full_image_path}')">
                                </div>
                                <!--end::Image-->

                                <!--begin::Action-->
                                <div class="overlay-layer card-rounded bg-dark bg-opacity-25 shadow">
                                    <i class="bi bi-eye-fill text-white fs-3x"></i>
                                </div>
                                <!--end::Action-->
                            </a>
                            <!--end::Overlay-->
                            </div>
                        `;
                    },
                },
                {
                    targets: -1,
                    data: null,
                    render: function (data, type, row) {
                        return `
                            <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                                ${__("Actions")}
                                <span class="svg-icon svg-icon-5 m-0">
                                    <i class="fa fa-angle-down mx-1"></i>
                                </span>
                            </a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="/dashboard/partners/${row.id
                            }/edit" class="menu-link px-3 d-flex justify-content-between edit-row" >
                                       <span> ${__("Edit")} </span>
                                       <span>  <i class="fa fa-edit text-primary"></i> </span>
                                    </a>

                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                <form action="{{ route('dashboard.partners.destroy',['partner'=>${row.id}]) }}" class="form" method="post">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                <a href="#" class="menu-link px-3 d-flex justify-content-between delete-row" data-row-id="${row.id
                            }" data-type="${__("partner")}">
                              
                                       <span> ${__("Delete")} </span>
                                       <span>  <i class="fa fa-trash text-danger"></i> </span>
                                    </a>
                                      </form>
                                </div>
                                <!--end::Menu item-->

                            </div>
                            <!--end::Menu-->
                        `;
                    },
                },
            ],
        });
        table = datatable.$;

        datatable.on("draw", function () {
            KTMenu.createInstances();
            handleFilterDatatable();
            handleDeleteRows();
            handlePreviewAttachments();

        });
    };

    // general search in datatable
    let handleSearchDatatable = () => {
        $("#general-search-inp").keyup(function () {
            datatable.search($(this).val()).draw();
        });
    };
    let handleDeleteRows = () => {
        $(".delete-row").click(function () {
            let rowId = $(this).data("row-id");
            let type = $(this).data("type");

            deleteAlert(type).then(function (result) {
                if (result.value) {
                    loadingAlert(__("deleting now ..."));

                    $.ajax({
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        url: "/dashboard/partners/" + rowId,
                        success: () => {
                            setTimeout(() => {
                                successAlert(`${__('You have deleted the') + ' ' + type + ' ' + __('successfully !')} `)
                                    .then(function () {
                                        datatable.draw();
                                    });
                            }, 1000);
                        },
                        error: (err) => {
                            let errorMessage = err.responseJSON.errors && err.responseJSON.errors["partner"] ? err.responseJSON.errors["partner"] : __("An error occurred.");
                            errorAlert(errorMessage);
                        },
                    });
                } else if (result.dismiss === "cancel") {
                    errorAlert(__("was not deleted !"));
                }
            });
        });
    };


    // Filter Datatable
    let handleFilterDatatable = () => {
        $(".filter-datatable-inp").each((index, element) => {
            $(element).change(function () {
                let columnIndex = $(this).data("filter-index"); // index of the searching column

                datatable.column(columnIndex).search($(this).val()).draw();
            });
        });
    };

    var handlePreviewAttachments = () => {
        // Select all edit buttons
        const previewButtons = $('[data-action="preview_attachments"]');
        $.each(previewButtons, function (indexInArray, button) {

            $(button).on('click', function (e) {
                e.preventDefault();

                let data = datatable.row(indexInArray).data();

                $(".attachments").html('');

                $(".attachments").append(`
                    <!--begin::Overlay-->
                    <a class="d-block overlay" data-fslightbox="lightbox-basic" href="${data.full_image_path}">
                        <!--begin::Action-->
                        <div class="overlay-layer card-rounded bg-dark bg-opacity-25 shadow">
                            <i class="bi bi-eye-fill text-white fs-3x"></i>
                        </div>
                        <!--end::Action-->

                    </a>
                    <!--end::Overlay-->
                `);
                refreshFsLightbox();
                $("[data-fslightbox='lightbox-basic']:first").trigger('click');
            })
        });
    }
    // Public methods
    return {
        init: function () {
            initDatatable();
            handleSearchDatatable();
            // handlePreviewAttachments();

        },
    };
})();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatable.init();
});
