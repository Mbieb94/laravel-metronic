"use strict";
var columns = $('input#data-columns').val();
let datatableUrl = $("meta[name='datatable-url']").attr('content');
let firstSegment = $("meta[name='first-segment']").attr('content');
let firstSegmentApi = $("meta[name='first-segment-api']").attr('content');
let isAllowToUpdate = $("meta[name='permission']").attr('update');
let isAllowToTrash = $("meta[name='permission']").attr('trash');
let isAllowToRestore = $("meta[name='permission']").attr('restore');
let isAllowToDelete = $("meta[name='permission']").attr('delete');
let dataStatus = $("meta[name='status']").attr('content');
// Class definition
var KTDatatablesServerSide = function () {
    // Shared variables
    var table;
    var dt;
    var filterPayment;

    var searchAdvance = [];
    // Private functions
    var initDatatable = function () {
        dt = $("#kt_datatable_example_1").DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: true,
            fixedColumns: {
                left: 2,
                right: 1
            },
            // stateSave: true,
            select: {
                style: 'multi',
                selector: 'td:first-child input[type="checkbox"]',
                className: 'row-selected'
            },
            ajax: {
                url: datatableUrl,
                headers: {
                    'Authorization': `Bearer ${personalToken}`
                },
                data: function (data) {
                    data.params = searchAdvance;
                    data.search = data.search.value;

                    if (dataStatus) data.status = dataStatus;
                },
                complete: function (result) {
                    $("#kt_datatable_example_1").find("th:first-child").removeClass("sorting_asc");
                    $('[data-bs-toggle="tooltip"]').tooltip();
                }
            },
            columns: JSON.parse(columns),
            columnDefs: [
                {
                    targets: 0,
                    orderable: false,
                    render: function (data) {
                        return `
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="${data}" />
                            </div>`;
                    }
                },
                {
                    targets: 1,
                    render: function (data, type, row) {
                        return `
                        <div class="d-flex align-items-center">
                            ${row.photo}
                            <div class="d-flex justify-content-start flex-column">
                                <a href="${firstSegment}/${row.id}" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6 text-nowrap">${row.fullname}</a>
                                <span class="d-flex"><span class="text-gray-400 fw-semibold d-block fs-7 text-nowrap text-copy">${row.username}</span></span>
                            </div>
                        </div>
                        `;
                    }
                },
                {
                    targets: -5,
                    render: function (data) {
                        let color = 'danger';
                        if(data == 'Active') {
                            color = 'primary';
                        }

                        return `
                            <span class="badge py-3 px-4 fs-7 badge-light-${color}">${data}</span>
                        `;
                    }
                },
                {
                    targets: -4,
                    orderable: false
                },
                {
                    targets: -3,
                    orderable: false,
                    render: function (data) {
                        if(data == 0) return `<span class="badge py-3 px-4 fs-7 badge-light-danger">User never login</span>`;
                        return `<span class="badge py-3 px-4 fs-7 badge-light-primary">${data} Times</span>`;
                    }
                },
                {
                    targets: -2,
                    orderable: false,
                    render: function (data) {
                        if(data === null) return '';
                        let today = new Date();
                        let date = new Date(data.created_at);
                        let timeDiff = Math.abs(today.getTime() - date.getTime());
                        let daysCount = Math.ceil(timeDiff / (1000 * 3600 * 24));
                        
                        let color = 'info';
                        if(daysCount > 30) color = 'red';
                        return `<span class="badge py-3 px-4 fs-7 badge-light-${color}">${date.toString().split(' GMT')[0]}</span>`;
                    }
                },
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    className: 'text-end',
                    render: function (data, type, row) {
                        var dom = `
                            <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="left" data-kt-menu-flip="top-end">
                                <span class="m-0 svg-icon svg-icon-5"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Navigation/Angle-left.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <polygon points="0 0 24 0 24 24 0 24"/>
                                        <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="currentColor" fill-rule="nonzero" transform="translate(12.000003, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-12.000003, -11.999999) "/>
                                    </g>
                                </svg><!--end::Svg Icon--></span>
                                Action
                            </a>
                            <div class="py-4 menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px" data-kt-menu="true">
                        `;
                        if (isAllowToUpdate) {
                            dom += `<div class="px-3 menu-item">
                                        <a href="${firstSegment}/${data.id}/edit" class="px-3 menu-link d-flex justify-content-between" data-kt-user-table-filter="edit_row">
                                            <span>Edit</span>    <i class="fas fa-pencil"></i> 
                                        </a>
                                    </div>`;
                        }

                        if (isAllowToTrash) {
                            dom += `<div class="px-3 menu-item">
                                    <a data-remote="${firstSegmentApi}/${data.id}/trash" class="px-3 menu-link d-flex justify-content-between" data-kt-user-table-filter="delete_row">
                                        <span>Delete</span> <i class="fas fa-trash"></i> 
                                    </a>
                                </div>`;
                        }

                        if (isAllowToRestore) {
                            dom += `<div class="menu-item px-3">
                                    <a data-remote="${firstSegmentApi}/${data.id}/restore" class="menu-link px-3 d-flex justify-content-between" data-kt-user-table-filter="restore_row">
                                        <span>Restore</span> <i class="fas fa-rotate-left"></i> 
                                    </a>
                                </div>`;
                        }

                        if (isAllowToDelete) {
                            dom += `<div class="menu-item px-3">
                                    <a data-remote="${firstSegmentApi}/${data.id}" class="menu-link px-3 d-flex justify-content-between" data-kt-user-table-filter="delete_row">
                                        <span>Delete</span> <i class="fas fa-trash"></i>
                                    </a>
                                </div>`;
                        }
                    
                        if(data.status == 'Active') {
                            dom += `
                                <div class="px-3 menu-item">
                                    <a data-remote="${firstSegmentApi}/${data.id}/activation/1" class="px-3 menu-link justify-content-between" data-kt-user-table-filter="set_not_active">
                                        <span>Not Active</span> <i class="fas fa-ban"></i>
                                    </a>
                                </div>
                            `;
                        } else {
                            dom += `
                                <div class="px-3 menu-item">
                                    <a data-remote="${firstSegmentApi}/${data.id}/activation/2" class="px-3 menu-link justify-content-between" data-kt-user-table-filter="activate_user">
                                        <span>Activate</span> <i class="fas fa-check"></i>
                                    </a>
                                </div>
                            `;
                        }

                        dom += `</div>`;

                        return dom;
                    },
                },
            ],
            // Add data-filter attribute
            // createdRow: function (row, data, dataIndex) {
            //     $(row).find('td:eq(4)').attr('data-filter', data.CreditCardType);
            // }
        });

        table = dt.$;

        $.fn.dataTable.ext.errMode = function ( settings, helpPage, message ) { 
            Swal.fire({
                icon: 'error',
                title: 'Error !',
                text: message
            });
        };
        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        dt.on('draw', function () {
            initToggleToolbar();
            toggleToolbars();
            handleDeleteRows();
            handleActivationUser();
            handleNotActiveUser();
            KTMenu.createInstances();
        });
    }

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = function () {
        const filterSearch = document.querySelector('[data-kt-user-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            dt.search(e.target.value).draw();
        });
    }

    // Filter Datatable
    var handleFilterDatatable = () => {
        // Select filter options
        const filterButton = document.querySelector('[data-kt-user-table-filter="filter"]');

        // Filter datatable on submit
        filterButton.addEventListener('click', function () {
            var obj = $('form#searchform').serializeArray();
            searchAdvance = obj;
            dt.draw();
        });
    }

    var handleDeleteRows = () => {
        const deleteButtons = document.querySelectorAll('[data-kt-user-table-filter="delete_row"]');

        deleteButtons.forEach(d => {
            d.addEventListener('click', function (e) {
                e.preventDefault();
                const url = $(this).data('remote');
                const parent = e.target.closest('tr');
                const customerName = parent.querySelectorAll('td')[1].innerText;

                Swal.fire({
                    text: "Are you sure want to delete this row ?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, Delete!",
                    cancelButtonText: "No, Cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: url,
                            type: "POST",
                            headers: {
                                'Authorization': `Bearer ${personalToken}`
                            },
                            data: {
                                '_token': csrfToken
                            },
                            success: function (resp) {
                                Swal.fire({
                                    text: "Rows Deleted!",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Yes",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                }).then(function () {
                                    dt.draw();
                                });
                            }
                        });
                    } else if (result.dismiss === 'cancel') {
                        Swal.fire({
                            text: "Rows Not deleted!",
                            icon: "info",
                            buttonsStyling: false,
                            confirmButtonText: "Yes",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }
                        });
                    }
                });
            })
        });
    }

    // Init toggle toolbar
    var initToggleToolbar = function () {
        const container = document.querySelector('#kt_datatable_example_1');
        const checkboxes = container.querySelectorAll('[type="checkbox"]');

        const deleteSelected = document.querySelector('[data-kt-user-table-select="delete_selected"]');

        checkboxes.forEach(c => {
            // Checkbox on click event
            c.addEventListener('click', function () {
                setTimeout(function () {
                    toggleToolbars();
                }, 50);
            });
        });

        deleteSelected.addEventListener('click', function () {
            var selectedId = [];
            var checkbox = $('[type="checkbox"]:checked');
            checkbox.each(function(key, items, data) {
                if($(items).val() != 'on') selectedId.push($(items).val());
            });

            var selectedList = selectedId.join(",");

            Swal.fire({
                text: "Are you sure want to delete selected rows ?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                showLoaderOnConfirm: true,
                confirmButtonText: "Yes, delte!",
                cancelButtonText: "No, Cancel",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                },
            }).then(function (result) {
                if (result.value) {
                    // Simulate delete request -- for demo purpose only
                    const url = `${firstSegmentApi}/${selectedList}/trash`;
                    $.ajax({
                        url: url,
                        type: "POST",
                        headers: {
                            'Authorization': `Bearer ${personalToken}`
                        },
                        data: {
                            '_token': csrfToken
                        },
                        success: function (resp) {
                            Swal.fire({
                                text: "The selected rows has deleted!.",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Yes",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary",
                                }
                            }).then(function () {
                                dt.draw();
                            });

                            const headerCheckbox = container.querySelectorAll('[type="checkbox"]')[0];
                            headerCheckbox.checked = false;
                        }
                    });
                } else if (result.dismiss === 'cancel') {
                    Swal.fire({
                        text: "Rows is not deleted!",
                        icon: "info",
                        buttonsStyling: false,
                        confirmButtonText: "Yes",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    });
                }
            });
        });
    }

    var handleActivationUser = () => {
        // Select all delete buttons
        const buttons = document.querySelectorAll('[data-kt-user-table-filter="activate_user"]');

        buttons.forEach(d => {
            // Delete button on click
            d.addEventListener('click', function (e) {
                e.preventDefault();
                
                const url = $(this).data('remote');

                Swal.fire({
                    text: "Are you sure wan to activate this user ?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, Activate!",
                    cancelButtonText: "No, Cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-primary",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: url,
                            type: "PUT",
                            headers: {
                                'Authorization': `Bearer ${personalToken}`
                            },
                            data: {
                                '_token': csrfToken
                            },
                            success: function (resp) {
                                Swal.fire({
                                    text: resp.message,
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Yes",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                }).then(function () {
                                    dt.draw();
                                });
                            }
                        });
                    } else if (result.dismiss === 'cancel') {
                        Swal.fire({
                            text: "User is not active",
                            icon: "info",
                            buttonsStyling: false,
                            confirmButtonText: "Yes",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }
                        });
                    }
                });
            })
        });
    }

    var handleNotActiveUser = () => {
        const button = document.querySelectorAll('[data-kt-user-table-filter="set_not_active"]');

        button.forEach(d => {
            d.addEventListener('click', function (e) {
                e.preventDefault();
                const url = $(this).data('remote');

                Swal.fire({
                    text: "Are you sure want to non active this user ?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, Non Active!",
                    cancelButtonText: "No, Cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            url: url,
                            type: "PUT",
                            headers: {
                                'Authorization': `Bearer ${personalToken}`
                            },
                            data: {
                                '_token': csrfToken
                            },
                            success: function (resp) {
                                Swal.fire({
                                    text: resp.message,
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Yes",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                }).then(function () {
                                    dt.draw();
                                });
                            }
                        });
                    } else if (result.dismiss === 'cancel') {
                        Swal.fire({
                            text: "User is active.",
                            icon: "info",
                            buttonsStyling: false,
                            confirmButtonText: "Yes",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }
                        });
                    }
                });
            })
        });
    }

    // Reset Filter
    var handleResetForm = () => {
        // const resetButton = document.querySelector('[data-kt-user-table-filter="reset"]');
        // resetButton.addEventListener('click', function () {
        //     filterPayment[0].checked = true;
        //     dt.search('').draw();
        // });
    }

    // Toggle toolbars
    var toggleToolbars = function () {
        // Define variables
        const container = document.querySelector('#kt_datatable_example_1');
        const toolbarBase = document.querySelector('[data-kt-user-table-toolbar="base"]');
        const toolbarSelected = document.querySelector('[data-kt-user-table-toolbar="selected"]');
        const selectedCount = document.querySelector('[data-kt-user-table-select="selected_count"]');

        // Select refreshed checkbox DOM elements
        const allCheckboxes = container.querySelectorAll('tbody [type="checkbox"]');

        // Detect checkboxes state & count
        let checkedState = false;
        let count = 0;

        // Count checked boxes
        allCheckboxes.forEach(c => {
            if (c.checked) {
                checkedState = true;
                count++;
            }
        });

        // Toggle toolbars
        if (checkedState) {
            selectedCount.innerHTML = count;
            toolbarBase.classList.add('d-none');
            toolbarSelected.classList.remove('d-none');
        } else {
            toolbarBase.classList.remove('d-none');
            toolbarSelected.classList.add('d-none');
        }
    }

    // Public methods
    return {
        init: function () {
            initDatatable();
            handleSearchDatatable();
            initToggleToolbar();
            handleFilterDatatable();
            handleDeleteRows();
            handleActivationUser();
            handleNotActiveUser();
            handleResetForm();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatablesServerSide.init();
});