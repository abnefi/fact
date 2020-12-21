$(".searchClientAjax").select2({
    width: '100%',
    dropdownParent: $('#modal_facture_avoir'),
    ajax: {
        url: Routing.generate("get_compte_client_by_name"),
        method: "POST",
        dataType: 'json',
        delay: 500,
        data: function (params) {
            return {
                keyword: params.term,
                // page: params.page,
                typeRequete: 'all',
                // nbreParpage: 10
            };
        },
        processResults: function (data, params) {
            console.log(data);
            // params.page = params.page || 1;

            return {

                results: data.items

            };
        },
        cache: true
    },
    placeholder: 'Rechercher un client',
    minimumInputLength: 3,
});
