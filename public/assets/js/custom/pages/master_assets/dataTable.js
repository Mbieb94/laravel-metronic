"use strict";

let columns = $("input[name='data-columns']").val();
let datatableUrl = $("meta[name='datatable-url']").attr('content');
let firstSegment = $("meta[name='first-segment']").attr('content');
let firstSegmentApi = $("meta[name='first-segment-api']").attr('content');
let isAllowToUpdate = $("meta[name='permission']").attr('update');
let isAllowToTrash = $("meta[name='permission']").attr('trash');
let isAllowToRestore = $("meta[name='permission']").attr('restore');
let isAllowToDelete = $("meta[name='permission']").attr('delete');
let dataStatus = $("meta[name='status']").attr('content');

var KTDatatablesServerSide = function () {
    var table;
    var dt;
    var params;

    var searchAdvance = [];
    var initDatatable = function () {
        dt = $("#kt_datatable_example_1").DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: true,
            fixedColumns: {
                left: 2,
                right: 1
            },
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
                    render: function (data, key, items) {
                        return `
                            <a href="${firstSegment}/${items.id}" class="text-bold text-nowrap">${data}</a>
                        `;
                    }
                },
                {
                    targets: -4,
                    render: function (data, key, items) {
                        if(!data) return '';
                        let date = data.replace(/\./g, '-');
                        return `
                            <span class="d-flex text-nowrap">${date}</span>
                        `;
                    }
                },
                {
                    targets: -3,
                    render: function (data, key, items) {
                        let number = data;
                        let color = 'text-info';
                        if (number) number = number.toLocaleString('en-US');
                        if (data < 0) color = 'text-danger';
                        return `
                            <a href="#" class="fw-bold fs-6 ${color}">${number}</a>
                        `;
                    }
                },
                {
                    targets: -2,
                    render: function (data, key, items) {
                        let number = data;
                        let color = 'text-info';
                        if (number) number = number.toLocaleString('en-US');
                        if (data < 0) color = 'text-danger';
                        return `
                            <a href="#" class="fw-bold fs-6 ${color}">${number}</a>
                        `;
                    }
                },
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    className: 'text-end',
                    render: function (data, type, row) {
                        var dom = `
                            <a href="javascript:;" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="left" data-kt-menu-flip="top-end">
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

                        // if (isAllowToUpdate) {
                        dom += `<div class="px-3 menu-item">
                                        <a href="#" data-remote="${hostUrl}/modal/AssetImages/${row['asset_code']}" class="px-3 menu-link d-flex justify-content-between"  data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                                            <span>Images</span>    <i class="fas fa-image"></i> 
                                        </a>
                                    </div>`;
                        // }

                        // if (isAllowToUpdate) {
                        dom += `<div class="px-3 menu-item">
                                        <a href="#" data-remote="${hostUrl}/modal/AssetVideos/${row['asset_code']}" class="px-3 menu-link d-flex justify-content-between" data-kt-user-table-filter="edit_row" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                                            <span>Videos</span>    <i class="fas fa-video"></i> 
                                        </a>
                                    </div>`;
                        // }

                        // if (isAllowToUpdate) {
                        // dom += `<div class="px-3 menu-item">
                        //                 <a href="#" data-remote="${hostUrl}/modal/AssetDescriptions/${row['asset_code']}" class="px-3 menu-link d-flex justify-content-between" data-kt-user-table-filter="edit_row" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                        //                     <span>Desc</span>    <i class="fas fa-list-alt"></i> 
                        //                 </a>
                        //             </div>`;
                        // }

                        // if (isAllowToUpdate) {
                        dom += `<div class="px-3 menu-item">
                                        <a href="#" data-remote="${hostUrl}/modal/qrcode/${row['asset_code']}" class="px-3 menu-link d-flex justify-content-between" data-kt-user-table-filter="edit_row" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                                            <span>QR Code</span>    <i class="fas fa-qrcode"></i> 
                                        </a>
                                    </div>`;
                        // }

                        // if (isAllowToUpdate) {
                        dom += `<div class="px-3 menu-item">
                                        <a href="#" data-remote="${hostUrl}/modal/view/${row['asset_code']}" class="px-3 menu-link d-flex justify-content-between" data-kt-user-table-filter="edit_row" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                                            <span>View</span>    <i class="fas fa-eye"></i> 
                                        </a>
                                    </div>`;
                        // }

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
                        dom += `</div>`;

                        return dom;
                    },
                },
            ],
        });

        table = dt.$;

        dt.on('xhr', function () {
            params = dt.ajax.params();
        });

        $.fn.dataTable.ext.errMode = function (settings, helpPage, message) {
            let messages = message;
            let icon = 'error';
            switch (helpPage) {
                case 4:
                    icon = 'warning';
                    messages = 'Data is not completed, please check your data (Cost Centre, Room, Physical Asset, Status, Impairment) ';
                    break;

                default:
                    // messages = 'Oppss .. Something went wrong'
                    break;
            }

            Swal.fire({
                icon: icon,
                title: icon + ' !',
                text: messages
            });
        };

        dt.on('draw', function () {
            initToggleToolbar();
            toggleToolbars();
            handleDeleteRows();
            handleRestoreRows();
            KTMenu.createInstances();
        });
    }

    var handleSearchDatatable = function () {
        const filterSearch = document.querySelector('[data-kt-user-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            dt.search(e.target.value).draw();
        });
    }

    // Filter Datatable
    var handleFilterDatatable = () => {
        $('form#searchform').on("keyup change", function (e) {
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
                    text: "Are you sure want to delete " + customerName + "?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes Delete!",
                    cancelButtonText: "No Cancel",
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
                                    text: customerName + "Deleted",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Yes",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                }).then(function () {
                                    dt.draw();
                                });
                            },
                            error: function (err) {
                                
                            }
                        });
                    } else if (result.dismiss === 'cancel') {
                        Swal.fire({
                            text: customerName + " Not Deleted.",
                            icon: "error",
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

    var handleRestoreRows = () => {
        // Select all delete buttons
        const deleteButtons = document.querySelectorAll('[data-kt-user-table-filter="restore_row"]');

        deleteButtons.forEach(d => {
            // Delete button on click
            d.addEventListener('click', function (e) {
                e.preventDefault();
                const url = $(this).data('remote');

                Swal.fire({
                    text: "Are you sure want to restore this data?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, Restore",
                    cancelButtonText: "No, Cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-success",
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
                                    text: "Data restored succesfully.",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Yes",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                }).then(function () {
                                    dt.draw();
                                });
                            },
                            error: function (err) {
                                Swal.fire({
                                    text: "Data not restored.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Yes",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                });
                            }
                        });
                    } else if (result.dismiss === 'cancel') {
                        Swal.fire({
                            text: "Data not restored.",
                            icon: "error",
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

    var initToggleToolbar = function () {
        const container = document.querySelector('#kt_datatable_example_1');
        const checkboxes = container.querySelectorAll('[type="checkbox"]');

        const deleteSelected = document.querySelector('[data-kt-user-table-select="delete_selected"]');

        checkboxes.forEach(c => {
            c.addEventListener('click', function () {
                setTimeout(function () {
                    toggleToolbars();
                }, 50);
            });
        });

        deleteSelected.addEventListener('click', function () {
            var selectedId = [];
            var checkbox = $('[type="checkbox"]:checked');
            checkbox.each(function (key, items, data) {
                if ($(items).val() != 'on') selectedId.push($(items).val());
            });

            var selectedList = selectedId.join(",");

            Swal.fire({
                text: "Are you sure want to delete selected rows ?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                showLoaderOnConfirm: true,
                confirmButtonText: "Yes, Delete",
                cancelButtonText: "No, Cancel",
                customClass: {
                    confirmButton: "btn fw-bold btn-danger",
                    cancelButton: "btn fw-bold btn-active-light-primary"
                },
            }).then(function (result) {
                if (result.value) {
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
                                text: "You have deleted all selected rows!",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Yes!",
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
                        text: "Selected rows not deleted.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Yes, Please!",
                        customClass: {
                            confirmButton: "btn fw-bold btn-primary",
                        }
                    });
                }
            });
        });
    }

    var toggleToolbars = function () {
        const container = document.querySelector('#kt_datatable_example_1');
        const toolbarBase = document.querySelector('[data-kt-user-table-toolbar="base"]');
        const toolbarSelected = document.querySelector('[data-kt-user-table-toolbar="selected"]');
        const selectedCount = document.querySelector('[data-kt-user-table-select="selected_count"]');
        const allCheckboxes = container.querySelectorAll('tbody [type="checkbox"]');
        let checkedState = false;
        let count = 0;

        allCheckboxes.forEach(c => {
            if (c.checked) {
                checkedState = true;
                count++;
            }
        });

        if (checkedState) {
            selectedCount.innerHTML = count;
            toolbarBase.classList.add('d-none');
            toolbarSelected.classList.remove('d-none');
        } else {
            toolbarBase.classList.remove('d-none');
            toolbarSelected.classList.add('d-none');
        }
    }

    var exportAll = () => {
        const button = document.querySelector('[data-kt-export="all"]');
        button.addEventListener('click', function (e) {
            $('.app-page-loader').show();
            e.preventDefault();
            const url = $(this).data('remote');

            $.ajax({
                url: url,
                type: 'GET',
                data: params,
                success: function (resp) {
                    switch (resp.status) {
                        case 200:
                            window.location.href = resp.directory;
                            break;
                        case 201:
                            Swal.fire({
                                title: 'Oppss ..',
                                text: resp.message,
                                icon: "warning",
                                buttonsStyling: false,
                                confirmButtonText: "Yes, I got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary"
                                }
                            });
                            break;
                        case 500:
                            Swal.fire({
                                title: 'Oppss ..',
                                text: resp.message,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Yes, I got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-danger"
                                }
                            });
                            break;
                        default:
                            break;
                    }

                    $('.app-page-loader').hide();
                },
                error: function (xhr, status, error) {
                    $('.app-page-loader').hide();
                    Swal.fire({
                        icon: 'error',
                        title: status,
                        text: error
                    });
                }
            });
        });
    }

    var exportPrimary = () => {
        const button = document.querySelector('[data-kt-export="primary"]');
        button.addEventListener('click', function (e) {
            $('.app-page-loader').show();
            e.preventDefault();
            const url = $(this).data('remote');

            $.ajax({
                url: url,
                type: 'GET',
                data: params,
                success: function (resp) {
                    switch (resp.status) {
                        case 200:
                            window.location.href = resp.directory;
                            break;
                        case 201:
                            Swal.fire({
                                title: 'Oppss ..',
                                text: resp.message,
                                icon: "warning",
                                buttonsStyling: false,
                                confirmButtonText: "Yes, I got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary"
                                }
                            });
                            break;
                        case 500:
                            Swal.fire({
                                title: 'Oppss ..',
                                text: resp.message,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Yes, I got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-danger"
                                }
                            });
                            break;
                        default:
                            break;
                    }

                    $('.app-page-loader').hide();
                },
                error: function (xhr, status, error) {
                    $('.app-page-loader').hide();
                    Swal.fire({
                        icon: 'error',
                        title: status,
                        text: error
                    });
                }
            });
        });
    }

    var exportSub = () => {
        const button = document.querySelector('[data-kt-export="sub"]');
        button.addEventListener('click', function (e) {
            e.preventDefault();
            $('.app-page-loader').show();
            const url = $(this).data('remote');

            $.ajax({
                url: url,
                type: 'GET',
                data: params,
                success: function (resp) {
                    switch (resp.status) {
                        case 200:
                            window.location.href = resp.directory;
                            break;
                        case 201:
                            Swal.fire({
                                title: 'Oppss ..',
                                text: resp.message,
                                icon: "warning",
                                buttonsStyling: false,
                                confirmButtonText: "Yes, I got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary"
                                }
                            });
                            break;
                        case 500:
                            Swal.fire({
                                title: 'Oppss ..',
                                text: resp.message,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Yes, I got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-danger"
                                }
                            });
                            break;
                        default:
                            break;
                    }

                    $('.app-page-loader').hide();
                },
                error: function (xhr, status, error) {
                    $('.app-page-loader').hide();
                    Swal.fire({
                        icon: 'error',
                        title: status,
                        text: error
                    });
                }
            });
        });
    }

    var exportPdf = () => {
        const button = document.querySelector('[data-kt-export="pdf"]');

        button.addEventListener('click', function (e) {
            e.preventDefault();
            $('.app-page-loader').show();
            const url = $(this).data('remote');
            $.ajax({
                type: "GET",
                url: url,
                data: params,
                success: function (response) {
                    switch (response.status) {
                        case 200:
                            var link = document.createElement('a');
                            link.href = response.directory;
                            link.download = response.filename;
                            link.click();
                            break;

                        case 201:
                            Swal.fire({
                                title: 'Oppss ..',
                                text: response.message,
                                icon: "warning",
                                buttonsStyling: false,
                                confirmButtonText: "Yes, I got it!",
                                customClass: {
                                    confirmButton: "btn fw-bold btn-primary"
                                }
                            });
                            break;
                    }

                    $('.app-page-loader').hide();
                },
                error: function (xhr, status, error) {
                    $('.app-page-loader').hide();
                    Swal.fire({
                        icon: 'error',
                        title: status,
                        text: error
                    });
                }
            });
        });
    }


    return {
        init: function () {
            initDatatable();
            handleSearchDatatable();
            handleFilterDatatable();
            initToggleToolbar();
            handleDeleteRows();
            handleRestoreRows();
            handleFilterDatatable();
            exportAll();
            exportPrimary();
            exportSub();
            exportPdf();
        }
    }
}();

KTUtil.onDOMContentLoaded(function () {
    KTDatatablesServerSide.init();
});