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
    // Shared variables
    var table;
    var dt;
    var filterPayment;

    var searchAdvance = [];
    var initDatatable = function () {
        dt = $("#kt_datatable_example_1").DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: true,
            // order: [[0, 'desc']],
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
                    render: function (data, key, items) {
                        return `
                            <a href="${firstSegment}/${items.id}" class="text-bold">${data}</a>
                        `;
                    }
                },
                {
                    targets: -2,
                    orderable: false,
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
                        dom += `</div>`;

                        return dom;
                    },
                },
            ],
        });

        table = dt.$;

        dt.on('draw', function () {
            if(getCookie('datatable') == 'card') {
                changeToCardList();
            }
            initToggleToolbar();
            toggleToolbars();
            handleDeleteRows();
            handleRestoreRows();
            handleCookies();
            KTMenu.createInstances();
        });
    }

    var changeToCardList = function () {
        // return false;
        var data = dt.rows().data();
        $("#card-list").remove();
        let card = `<div class="row g-6 g-xl-9 mb-10" id="card-list">`;

        data.each(function(dataRow){
            const { id, get_users, name } = dataRow;

            card += `<div class="col-md-6 col-xl-4">
                <div class="card border-hover-primary">
                    <div class="card-header border-0 pt-9">
                        <div class="card-title m-0">
                            <div class="symbol symbol-50px w-50px bg-light">
                                <img src="assets/media/svg/brand-logos/plurk.svg" alt="image" class="p-3">
                            </div>
                        </div>
                        <div class="card-toolbar">
                            <div class="me-0">
                                <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <i class="ki-solid ki-dots-horizontal fs-2x"></i>
                                </button>
                        
                                <!--begin::Menu 3-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true" style="">
                                    <!--begin::Heading-->
                                    <div class="menu-item px-3">
                                        <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
                                            ACTIONS
                                        </div>
                                    </div>
                                    <!--end::Heading-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="${firstSegment}/${id}/edit" class="menu-link px-3">
                                            Edit
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a data-remote="${firstSegmentApi}/${id}/trash" href="javascript:;" class="menu-link px-3" data-kt-user-table-filter="delete_row">
                                            Delete
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu 3-->
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-9">
                        <div class="fs-3 fw-bold text-dark text-uppercase">${ name }</div>
                        <p class="text-gray-400 fw-semibold fs-5 mt-1 mb-7">CRM App application to HR efficiency</p>
                        <div class="d-flex flex-wrap mb-5">
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                                <div class="fs-6 text-gray-800 fw-bold">Nov 10, 2023</div>
                                <div class="fw-semibold text-gray-400">Due Date</div>
                            </div>
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                                <div class="fs-6 text-gray-800 fw-bold">$284,900.00</div>
                                <div class="fw-semibold text-gray-400">Budget</div>
                            </div>
                        </div>
                        <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip" aria-label="This project 50% completed" data-bs-original-title="This project 50% completed" data-kt-initialized="1">
                            <div class="bg-primary rounded h-4px" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        ${ get_users }
                    </div>
                </div>
            </div>`;
        });

        card += `</div>`;

        $('#kt_datatable_example_1').hide();
        $(card).insertAfter('#kt_datatable_example_1');
    } 

    var handleSearchDatatable = function () {
        const filterSearch = document.querySelector('[data-kt-user-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            // let tables = $("#kt_datatable_example_1_wrapper").find('.table-responsive');
            // if($(tables).hasClass('row g-6 g-xl-9')) $(tables).html(``);
            dt.search(e.target.value).draw();
        });
    }

    var handleDeleteRows = () => {
        const deleteButtons = document.querySelectorAll('[data-kt-user-table-filter="delete_row"]');

        deleteButtons.forEach(d => {
            d.addEventListener('click', function (e) {
                e.preventDefault();
                const url = $(this).data('remote');
                const parent = e.target.closest('tr');
                // const customerName = parent.querySelectorAll('td')[1].innerText;

                Swal.fire({
                    text: "Are you sure want to delete this data ?",
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
                                console.log(resp)
                                Swal.fire({
                                    text: "Data Deleted",
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
                                console.log(err)
                            }
                        });
                    } else if (result.dismiss === 'cancel') {
                        Swal.fire({
                            text: "Data is not Deleted.",
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

    var handleCookies = function () {
        $('.switcher').on('click', function (e) {
            let cookieName = $(this).data('switcher');
            
            setCookie('datatable', cookieName, 30);

            $("#card-list").remove();
            if(cookieName == 'table') {
                $('#kt_datatable_example_1').show();
            }

            dt.draw();
        });
    }

    var setCookie = function (cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        let expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    var getCookie = function (cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');
        for(let i = 0; i <ca.length; i++) {
          let c = ca[i];
          while (c.charAt(0) == ' ') {
            c = c.substring(1);
          }
          if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
          }
        }
        return "";
    }

    var checkCookie = function (cookieName) {
        let cookie = getCookie(cookieName);
        if (cookie != "") {
            alert("Welcome again " + cookie);
        } else {
            cookie = prompt("Please enter your name:", "");
            if (cookie != "" && cookie != null) {
                setCookie(cookieName, cookie, 365);
            }
        }
    }

    return {
        init: function () {
            initDatatable();
            handleSearchDatatable();
            initToggleToolbar();
            handleDeleteRows();
            handleRestoreRows();
            handleCookies();
        }
    }
}();

KTUtil.onDOMContentLoaded(function () {
    KTDatatablesServerSide.init();
});