var ajax = {


    compte_tontine_num_compte: function () {

        var selectedItem = $('#numero_compte').val();

        $('#compte_tontine_div_select_zone').html('<select class="form-control"> <option> Veuillez patienter ...</option></select>')
        $.ajax({
                type: "POST",
                url: Routing.generate('compte_tontine_select'),
                data: {
                    selectedItem: selectedItem
                },
                success: function (data) {
                    $('#compte_tontine_div').html(data)
                }
            }
        )
    },

    operationsHistorique: function () {

        var typeOperation = $('#typeOperation').val();
        var periode = $('#periode').val();
        $('#loarding').show();
        $.ajax({
                type: "POST",
                url: Routing.generate('ajax_operations'),
                data: {
                    typeOperation: typeOperation,
                    periode: periode
                },
                success: function (data) {
                    $('#loarding').hide();
                    $('#div_tablo').html(data)
                }
            }
        )
    },



    operationsMap: function () {

        var date = $('#date').val();
        $.ajax({
                type: "POST",
                url: Routing.generate('operation_ajax_map'),
                data: {
                    date: date
                },
                success: function (data) {

                    var locations = data.dat;

                    if(locations.length == 0){

                        $('#map').html(data.message);

                    }else{

                        var map = new google.maps.Map(document.getElementById('map'), {
                            zoom: 8,
                            center: new google.maps.LatLng(6.32, 1.69),
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        });

                        var infowindow = new google.maps.InfoWindow();
                        var marker, i;

                        for (i = 0; i < locations.length; i++) {

                            marker = new google.maps.Marker({
                                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                                icon: 'http://localhost:8080/module_tpe_server/web/frontend/img/marker.png',
                                map: map,
                                title: locations[i][0]

                            });

                            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                                return function () {
                                    infowindow.setContent(locations[i][0]);
                                    infowindow.open(map, marker);
                                }
                            })(marker, i));
                        }
                    }
                }
            }
        )
    },



    operationsAdmin: function () {

        var periodeR = $('#periodeR').val();
        $('#loarding').show();
        $.ajax({
                type: "POST",
                url: Routing.generate('operation_ajax_admin'),
                data: {
                    periodeR: periodeR
                },
                success: function (data) {
                    $('#loarding').hide();
                    $('#tablo_op_admin').html(data)
                }
            }
        )
    },



    allegement: function () {

        var montant = $('#montant').val();
        var agence = $('#agence').val();
        var collecteur = $('#collecteur').val();

        $('#loarding').show();
        $.ajax({
                type: "POST",
                url: Routing.generate('validation_allegement'),
                data: {
                    montant: montant,
                    collecteur: collecteur,
                    agence: agence
                },
                success: function (data) {
                    var data2 = JSON.parse(data);

                    if(data2.code === 'XX'){

                        jQuery("#myModal").modal('hide');
                        $('#loarding').hide();
                        $('#notif').html(data2.resultat).fadeOut(3000);

                    }else{

                        console.log(data2.resultat.codeContrat);
                        $('#loarding').hide();
                        jQuery("#modal-id").modal('show');
                        jQuery("#myModal").modal('hide');
                        $('#codeContratH').val(data2.resultat.codeContrat);
                        $('#agenceH').val(data2.resultat.numAgence);
                        $('#montantH').val(data2.resultat.valeur);
                    }

                }
            }
        )
    }

} ;