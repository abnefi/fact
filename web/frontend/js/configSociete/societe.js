$('#configbundle_configsociete_typeEntreprise_0').change(function () {
    $('.assujetiTva').show();
    $('.estprofessionLiberale').hide();
    $('.formeJuridique').show();

    let value = $("input[name='configbundle_configsociete[typeEntreprise]']:checked").val();

    if (value === 'societe'){
        $('.estprofessionLiberale').hide();
        $('.assujetiTva').show();

        document.getElementById('configbundle_configsociete_assujetiTva').required = true;
        document.getElementById('configbundle_configsociete_estProfessionLiberale').required = false;
    }else{
        document.getElementById('configbundle_configsociete_assujetiTva').required = false;
        document.getElementById('configbundle_configsociete_estProfessionLiberale').required = true;
    }
})

$('#configbundle_configsociete_typeEntreprise_1').change(function () {
    $('.assujetiTva').hide();
    $('.estprofessionLiberale').show();
    $('.formeJuridique').show();

    let value = $("input[name='configbundle_configsociete[typeEntreprise]']:checked").val();

    if (value === 'societe'){
        $('.estprofessionLiberale').hide();
        $('.assujetiTva').show();

        document.getElementById('configbundle_configsociete_assujetiTva').required = true;
        document.getElementById('configbundle_configsociete_estProfessionLiberale').required = false;
    }else{
        document.getElementById('configbundle_configsociete_assujetiTva').required = false;
        document.getElementById('configbundle_configsociete_estProfessionLiberale').required = true;
    }
})

$('#configbundle_configsociete_typeEntreprise_2').change(function () {
    $('.assujetiTva').hide();
    $('.estprofessionLiberale').show();
    $('.formeJuridique').hide();

    let value = $("input[name='configbundle_configsociete[typeEntreprise]']:checked").val();

    if (value === 'societe'){
        $('.estprofessionLiberale').hide();
        $('.assujetiTva').show();

        document.getElementById('configbundle_configsociete_assujetiTva').required = true;
        document.getElementById('configbundle_configsociete_estProfessionLiberale').required = false;
    }else{
        document.getElementById('configbundle_configsociete_assujetiTva').required = false;
        document.getElementById('configbundle_configsociete_estProfessionLiberale').required = true;
    }
})

window.onload = function () {

    let value = $("input[name='configbundle_configsociete[typeEntreprise]']:checked").val();

    if (value === 'societe'){
        $('.estprofessionLiberale').hide();
        $('.assujetiTva').show();
        $('.formeJuridique').show();

        document.getElementById('configbundle_configsociete_assujetiTva').required = true;
        document.getElementById('configbundle_configsociete_estProfessionLiberale').required = false;
    }else{
        $('.assujetiTva').hide();
        $('.estprofessionLiberale').show();

        document.getElementById('configbundle_configsociete_assujetiTva').required = false;
        document.getElementById('configbundle_configsociete_estProfessionLiberale').required = true;
    }

    if (value === 'etablisement'){
        $('.formeJuridique').show();
    }

    if (value === 'entrepriseIndividuelle'){
        $('.formeJuridique').hide();
    }
}

// let value = $("input[name='configbundle_configsociete[typeEntreprise]']:checked").val();
// if ( value == 'societe'){
//     document.getElementById('configbundle_configsociete_assujetiTva').required = true;
//     $('.assujetiTva').show();
//     $('.estprofessionLiberale').hide();
// }else{
//     document.getElementById('configbundle_configsociete_assujetiTva').required = false;
//     $('.assujetiTva').hide();
//     $('.estprofessionLiberale').show();
// }

//todo: mask téléphone
$('.telMask').mask('+(000).00.00.00.00', {placeholder: '+(229).__.__.__.__'});