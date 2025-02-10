"use strict";

// Class definition
let KTDatatable = function () {

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
            order: [[5, 'desc']], // display records number and ordering type
            stateSave: false,
            select: {
                style: 'os',
                selector: 'td:first-child',
                className: 'row-selected'
            },
            ajax: {
                data: function () {
                    let datatable = $('#kt_datatable');
                    let info = datatable.DataTable().page.info();
                    datatable.DataTable().ajax.url(`/dashboard/request/service?page=${info.page + 1}&per_page=${info.length}`);
                }
            },
            columns: [
                {data: 'id'},
                {data: 'name'},
                {data: 'phone'},
                {data: 'car_brand'},
                {data: 'car_model'},
                {data: 'meter_reading'},
                {data:'service.name'  ,name:'service_id'},
                {data:'city.name' ,name:'city_id'},
                {data:'status.name', name:'status_id'}
                // {data: 'reply'},
                // {data: null},
            ],
            columnDefs: [
                {
                    targets: 1,
                    width:150,
                },
               
              
            ],

        });

        table = datatable.$;

        datatable.on('draw', function () {
            KTMenu.createInstances();
        });
    }

    // general search in datatable
    let handleSearchDatatable = () => {

        $('#general-search-inp').keyup( function () {
            datatable.search( $(this).val() ).draw();
        });

    }

    // Filter Datatable
    let handleFilterDatatable = () => {

        $('.filter-datatable-inp').each( (index , element) =>  {

            $(element).change( function () {

                let columnIndex = $(this).data('filter-index'); // index of the searching column

                datatable.column(columnIndex).search( $(this).val()).draw();
            });

        })
    }





    // Public methods
    return {
        init: function () {
            initDatatable();
            handleSearchDatatable();
            // handleFilterDatatable();

        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatable.init();
});
