<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="{{asset('js/main/popover.js')}}"></script>

<script>

    (function($) {
        $('.po__trigger--center').po({ alignment: 'center' });
    })(jQuery)

    $('.customer-data-ajax').select2({

        ajax: {
            url: '{{URL::to('get-customer')}}',
            dataType: 'json',
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 10) < data.total_count
                    }
                };
            },
            cache: true
        },
        placeholder: 'Search for a customer name',
        allowClear: true,
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
//        minimumInputLength: 1,
        templateResult: formatRepo
    });

    $('.maingroup-id-data-ajax').select2({
        ajax: {
            url: '{{URL::to('get-main-group-id')}}',
            dataType: 'json',
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 10) < data.total_count
                    }
                };
            },
            cache: true
        },
        placeholder: 'Search for a main group id',
        allowClear: true,
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        templateResult: formatRepo
    });

    $('.maingroup-data-ajax').select2({
        ajax: {
            url: '{{URL::to('get-main-group')}}',
            dataType: 'json',
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 10) < data.total_count
                    }
                };
            },
            cache: true
        },
        placeholder: 'Search for a main group name',
        allowClear: true,
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        templateResult: formatRepo
    });

    $('.dept-data-ajax').select2({
        ajax: {
            url: '{{URL::to('get-departmets')}}',
            dataType: 'json',
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 10) < data.total_count
                    }
                };
            },
            cache: true
        },
        placeholder: 'Search for a department',
        allowClear: true,
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        templateResult: formatRepo
    });

    $('.worktype-data-ajax').select2({
        ajax: {
            url: '{{URL::to('get-work-types')}}',
            dataType: 'json',
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 10) < data.total_count
                    }
                };
            },
            cache: true
        },
        placeholder: 'Search for a work type',
        allowClear: true,
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        templateResult: formatRepo
    });
    $('.policy_status-data-ajax').select2({});
    $('.agent-data-ajax').select2({

        ajax: {
            url: '{{URL::to('get-agents')}}',
            dataType: 'json',
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 10) < data.total_count
                    }
                };
            },
            cache: true
        },
        placeholder: 'Search for a agent name',
        allowClear: true,
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        templateResult: formatRepo
    });

    $('.case_manager-data-ajax').select2({

        ajax: {
            url: '{{URL::to('get-case-manager')}}',
            dataType: 'json',
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 10) < data.total_count
                    }
                };
            },
            cache: true
        },
        placeholder: 'Search for a underwriter',
        allowClear: true,
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        templateResult: formatRepo
    });

    $('.current_status-data-ajax').select2({

        ajax: {
            url: '{{URL::to('get-current-status')}}',
            dataType: 'json',
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 10) < data.total_count
                    }
                };
            },
            cache: true
        },
        placeholder: 'Search for a current status',
        allowClear: true,
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        templateResult: formatRepo
    });

    $('.insurer-data-ajax').select2({

        ajax: {
            url: '{{URL::to('filter-insurer')}}',
            dataType: 'json',
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 10) < data.total_count
                    }
                };
            },
            cache: true
        },
        placeholder: 'Search for a insurer',
        allowClear: true,
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        templateResult: formatRepo
    });



    function formatRepo (repo) {
        if (repo.loading) {
            return repo.text;
        }

        var markup = repo.name;

        return markup;
    }

    function submitFilterForm(){
        $('#filterForm').submit();
//        $('#datatable').DataTable().ajax.reload();
    }

</script>
