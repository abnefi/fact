var ajaxFacture = {
  getInfosSociete: function (inputDevise) {
    // console.log('good !');
    $.ajax({
      type: "POST"
      , url: Routing.generate('get_infos_societe')
      , data: {
        // type_document: "attestation_travail",
      },
      success: function (response) {
        console.log(response);
        // $('#divTest').html(response);
        inputDevise.val(response['idDevise']);
        console.log(inputDevise.val());
      }
    })
  },

  showFormNewPaiement: function (idFacture) {
    console.log('good !');
    $.ajax({
      type: "POST"
      , url: Routing.generate('clientfacture_newpaiement_form', {'id': idFacture})
      , data: {
        // type_document: "attestation_travail",
      },
      success: function (response) {
        console.log(response);
        $('#form_new_paiement').html(response);
        // inputDevise.val(response['idDevise']);
        // console.log(inputDevise.val()) ;
      }
    })
  },

  getProduitsByType: function (type, selectProduit) {
    console.log(type);
    // selectProduit.empty();
    selectProduit.children('option:not(:first)').remove();
    $.ajax({
      type: "POST",
      url: Routing.generate('get_produits_by_type'),
      data: {
        type_produit: type,
      },
      success: function (response) {
        console.log(response);
        $.each(response, function (index, value) {
          // console.log(value['designation']);
          selectProduit.append('<option value="' + value['id'] + '">' + value['designation'] + '</option>');
        })
        selectProduit.chosen({
          width: "100%",
          placeholder_text_single: "Sélectionner une option"
        });
        selectProduit.trigger("chosen:updated");
        // setTimeout(function   () {
        //     calculerValeursLigne();
        // }, 2000);
      }
    })
  },

  getAibByClient: function (idClient, inputTauxAib, inputtauxTva) {
    console.log(idClient);
    $.ajax({
      type: "POST",
      url: Routing.generate('get_aib_by_client', {'id': idClient}),
      data: {
        // type_document: "attestation_travail",
      },
      success: function (response) {
        console.log(" abed");
        console.log(response);
        // $('#divTest').html(response);
        inputTauxAib.val(response['tauxAib']);
        inputtauxTva.val(response['tauxTVA']);
        console.log(inputtauxTva.val());


        setTimeout(function () {
          calculTotauxGlobauxFacture();
        }, 2000);
      }
    })
  },

  filtrerFactures: function () {
    let tempsFactureActif = $("#check_temps_facture").prop('checked');
    let typeTemps = $("input[name='type_temps_facture']:checked").val();
    let tempsFacture = $('#temps_facture').val(); //valeur de la date ou de la période de facturation
    let selectClients = $('#select_clients').val();
    let selectTypesFacture = $('#type_facture').val();
    let selectEtatDeclaration = $('#select_etats').val();

    // var text = $('#type_facture option:selected').toArray().map(item => item.text).join();
    // console.log(selectTypesFacture.length,text);

    // console.log('work');
    $('#table_factures').empty();
    $('#table_factures').addClass("text-center");
    $("#table_factures").html('<div class="spinner-border text-primary"></div>');
    let data = {
      tempsFactureActif: tempsFactureActif,
      typeTemps: typeTemps,
      tempsFacture: tempsFacture,
      selectClients: selectClients,
      selectTypesFacture: selectTypesFacture,
      selectEtatDeclaration: selectEtatDeclaration,
    }
    console.log('data ajax', data)
    $.ajax({
      type: "POST",
      url: Routing.generate('filtrer_factures'),
      data,
      success: function (data) {
        $('#table_factures').removeClass("text-center");
        $('#table_factures').empty().html(data);
      }
    })
  },

  getFactureByClient: function () {

    // selectProduit.empty();
    var client = $('#client').val();


    $('#list_facture').html('<div class="spinner-border text-primary"></div>');
    $.ajax({
        type: "POST",
        url: Routing.generate('facture_by_client'),
        data: {
          client: client
        },
        success: function (data) {
          $('#list_facture').html(data)
        }
      }
    )
  },
  searchFactureByClient: function () {

    // selectProduit.empty();
    var client = $('#searchClient').val();


    $('#list_client').html('<div class="spinner-border text-primary"></div>');
    $.ajax({
        type: "POST",
        url: Routing.generate('Search_facture_by_client'),
        data: {
          search: client
        },
        success: function (data) {
          $('#list_client').html(data)
        }
      }
    )
  },
  getFactureByClientAll: function () {

    // selectProduit.empty();
    var client = $('#client').val();


    $('#list_facture').html('<div class="spinner-border text-primary"></div>');
    $.ajax({
        type: "POST",
        url: Routing.generate('facture_by_client_all'),
        data: {
          client: client
        },
        success: function (data) {
          $('#list_facture').html(data)
        }
      }
    )
  },
}

//list_users.html.twig
let style = ''
$(document).ready(function () {
  $("#stockbundle_stockarticle_hasTaxeSpecifique").change(function () {
    // alert('work');
    // $(this).hide();
    if ($(this).prop("checked") == true) {
      $('#div_taxe_specifique').show();
    }
    else {
      $('#div_taxe_specifique').hide();
    }
  })

  $("#div_taxe_specifique").hide();

  $('#stockbundle_stockarticle_stockAlerte').keyup(function () {
    var alertMin = parseInt($('.stockalert').val());
    var minstock = parseInt($('#stockMinimum').val());
    var inputmin = $('#stockMinimum');
    inputmin.attr('min', alertMin)
  })  // alert('it works !');*/

  $("#date_facture_radio").prop("checked", true);
  $('#temps_facture').attr('disabled', true);
  // $('#temps_facture').removeClass('periode');
  // $('#temps_facture').addClass('date_etat');
  // initDate();
  setTimeout(function () {
    style = $('#temps_facture').attr('style');
    $('#temps_facture').removeAttr('style');
  }, 500)
  $("#temps_facture").val('');


  $('.quantite_detail').each(function () {
    let input = $(this)
    input.on('change', function (e) {
      if (input.val().trim() === '') {
        input.val(1)
      }
      const prix = input.closest('tr').find('.prix_detail').val()

      input.closest('tr').find('.montant_detail').val(prix * input.val())
    })
  })
})

$("#check_temps_facture").change(function () {
  if ($(this).prop('checked') == true) {
    $("#temps_facture").removeAttr('disabled');
    $('#temps_facture').attr('style', style);
    initPeriode();
    ajaxFacture.filtrerFactures();
  } else {
    $("#temps_facture").removeAttr('style');
    $("#temps_facture").attr("disabled", true);
    $('#temps_facture').val('');
    ajaxFacture.filtrerFactures();
  }
})

$(document).ready(function () {
  $('.dt-buttons').hide();
  $('[data-toggle="popover"]').popover();
});

$(".operationsclientbundle_clientfacturevente_dateReglement").flatpickr({minDate: "today"});
