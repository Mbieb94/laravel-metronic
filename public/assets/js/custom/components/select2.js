var Select2Reference = function() {
    return {
        init: function(obj = null) {
            $("select.select2ajax").on("change", async function (e) {
                const select = $(this);
                const table = select.data('model');
                const key = select.data('key');
                const display = select.data('display');
                const token = $('meta[name="token"]').attr('content');
                const url = await hostUrl + `/api/v1/select2ajax?model=${table}&key=${key}&display=${display}`;
        
                $(this).select2({
                    width: '100%',
                    allowClear: true,
                    delay: 250,
                    placeholder: `Select ${table}`,
                    ajax: {
                        url: url,
                        headers: {
                            'Authorization': 'Bearer ' + token
                        },
                        data: function (params) {
                            var query = {
                                search: params.term
                            }
        
                            return query;
                        },
                        processResults: function (data, params) {
                            return {
                                results: data.results,
                            };
                        }
                    }
                });
            }).trigger("change");
        }
    };
}();

var SysparamReference = function () {
    return {
        init: function () {
            $("select.sysparam-reference").on("change", async function (e) {
                const select = $(this);
                const display = select.data('display');
                const group = select.data('group');
                // console.log(group);
                const token = $('meta[name="token"]').attr('content');
                const url = await hostUrl + `/api/v1/sysparam?group=${group}&display=${display}`;
        
                $(this).select2({
                    width: '100%',
                    allowClear: true,
                    delay: 250,
                    placeholder: `Select ${group}`,
                    ajax: {
                        url: url,
                        headers: {
                            'Authorization': 'Bearer ' + token
                        },
                        data: function (params) {
                            var query = {
                                search: params.term
                            }
        
                            return query;
                        },
                        processResults: function (data, params) {
                            return {
                                results: data.results,
                            };
                        }
                    }
                });
            }).trigger("change");
        }
    }
}();

jQuery(document).ready(function() {
    Select2Reference.init();
    SysparamReference.init();
});