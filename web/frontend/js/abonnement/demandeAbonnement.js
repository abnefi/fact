/**
 * Created by Abed on 30/11/2020.
 */
$("#configbundle_configabonnementsociete_typeAbonnement:last").change(function (e) {

  let idAbonnement = $(this).val();
  let inputDuree = $("#configbundle_configabonnementsociete_duree");
  let inputMontant = $("#montant_abonnement");

  if (idAbonnement == 1) {
    $("#reabonneAuto").hide('slow')
    $("#divBanque").attr("class", 'col-md-6')
  } else {
    $("#divBanque").attr("class", 'col-md-3')
    $("#reabonneAuto").show('slow')
  }

  console.log('Id dabonnement: ' + idAbonnement);
  $.ajax({
    type: "POST"
    , url: Routing.generate('get_prix_duree_for_abonnement', {'id': idAbonnement})
    , data: {
      // type_document: "attestation_travail",
    },
    success: function (response) {
      console.log("abed")

      inputDuree.val(response['duree_abonnement'])
      inputMontant.val(response['prix_abonnement'])

      console.log(inputDuree.val())
    }
  })
})

