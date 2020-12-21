
$('#configbundle_configagence_societe_typeEntreprise_0').change(function () {
    $('.professionLiberale').hide();
    $('.assujetiTva').show();

    let value = $("input[name='configbundle_configagence[societe][typeEntreprise]']:checked").val();

    if (value === 'societe'){
        $('.professionLiberale').hide();
        $('.assujetiTva').show();

        document.getElementById('configbundle_configagence_societe_assujetiTva').required = true;
        document.getElementById('configbundle_configagence_societe_estProfessionLiberale').required = false;
    }else{
        document.getElementById('configbundle_configagence_societe_assujetiTva').required = false;
        document.getElementById('configbundle_configagence_societe_estProfessionLiberale').required = true;
    }

})

$('#configbundle_configagence_societe_typeEntreprise_1').change(function () {
    $('.professionLiberale').show();
    $('.assujetiTva').hide();

    let value = $("input[name='configbundle_configagence[societe][typeEntreprise]']:checked").val();

    if (value === 'societe'){
        $('.professionLiberale').hide();
        $('.assujetiTva').show();

        document.getElementById('configbundle_configagence_societe_assujetiTva').required = true;
        document.getElementById('configbundle_configagence_societe_estProfessionLiberale').required = false;
    }else{
        document.getElementById('configbundle_configagence_societe_assujetiTva').required = false;
        document.getElementById('configbundle_configagence_societe_estProfessionLiberale').required = true;
    }

})

$('#configbundle_configagence_societe_typeEntreprise_2').change(function () {
    $('.professionLiberale').show();
    $('.assujetiTva').hide();

    let value = $("input[name='configbundle_configagence[societe][typeEntreprise]']:checked").val();

    if (value === 'societe'){
        $('.professionLiberale').hide();
        $('.assujetiTva').show();

        document.getElementById('configbundle_configagence_societe_assujetiTva').required = true;
        document.getElementById('configbundle_configagence_societe_estProfessionLiberale').required = false;

    }else{
        document.getElementById('configbundle_configagence_societe_assujetiTva').required = false;
        document.getElementById('configbundle_configagence_societe_estProfessionLiberale').required = true;
    }
})

window.onload = function () {

    let value = $("input[name='configbundle_configagence[societe][typeEntreprise]']:checked").val();
    // alert(value)
    if (value === 'societe'){
        $('.professionLiberale').hide();
        $('.assujetiTva').show();

        document.getElementById('configbundle_configagence_societe_assujetiTva').required = true;
        document.getElementById('configbundle_configagence_societe_estProfessionLiberale').required = false;
    }else{
        document.getElementById('configbundle_configagence_societe_assujetiTva').required = false;
        document.getElementById('configbundle_configagence_societe_estProfessionLiberale').required = true;

    }

    if (value === 'etablisement'){
        $('.assujetiTva').hide();

        $('.professionLiberale').show();

        // $('#configbundle_configagence_societe_assujetiTva');

    }

    if (value === 'entrepriseIndividuelle'){
        $('.assujetiTva').hide();

        $('.professionLiberale').show();

        // $('#configbundle_configagence_societe_assujetiTva');

    }
}

/*application du chosen select*/
$(document).ready(function () {
  $("#configbundle_configagence_societe_fonctionRepresentant, #configbundle_configagence_societe_pays").chosen({
    width: "100%",
    placeholder_text_single: "Sélectionner une option"
  })
});

//todo: set devise value
$("#configbundle_configagence_societe_devise").val(1);

//todo: mask téléphone
$('.telMask').mask('+(000).00.00.00.00', {placeholder: '+(229).__.__.__.__'});


// todo: champ numéro ifu 13 chiffre