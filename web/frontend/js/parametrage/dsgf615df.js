
/*

Recuperation de la liste des sociétés en attentes d'activation

*/
// document.getElementById('listeAttente').onclick=function (){
//     document.getElementById('listeAttente').style.backgroundColor='#14346c';
//     document.getElementById('listeAttente').style.color='white';
// }

$('.bnow').click(function () {
    $(this).addClass('activebtnnow')

    var id = $(this).attr('id')

    $('.bnow').each(function (a){
        if($( this ).attr('id') !== id){
            $( this ).removeClass('activebtnnow')
        }
    })

    $.ajax({
        type: 'POST',
        url: Routing.generate('societe_et_user_en_attente_activation_incomplete'),
        data: {
            monId:id,
        },
        success: function (response) {
            $('#tablesoc').attr('hidden', true);
            $('#maliste').empty().html(response);
        }
    })


})

$('.anow').click(function () {
    $(this).addClass('activebtnnow')

    var id = $(this).attr('id')

    $('.anow').each(function (a){
        if($( this ).attr('id') !== id){
            $( this ).removeClass('activebtnnow')
        }
    })

    $.ajax({
        type: 'POST',
        url: Routing.generate('configagence_en_attente_for_super_admin'),
        data: {
            monId:id,
        },
        success: function (response) {
            $('#tableagence').attr('hidden', true);
            $('#maliste').empty().html(response);
        }
    })


})

$('.ubnow').click(function () {
    $(this).addClass('activebtnnow')

    var id = $(this).attr('id')

    $('.ubnow').each(function (a){
        if($( this ).attr('id') !== id){
            $( this ).removeClass('activebtnnow')
        }
    })

    $.ajax({
        type: 'POST',
        url: Routing.generate('user_activation_verifier'),
        data: {
            monId:id,
        },
        success: function (response) {
            $('#tableuser').attr('hidden', true);
            $('#mliste').empty().html(response);
        }
    })


})

$('.dbnow').click(function () {
    $(this).addClass('activebtnnow')

    var id = $(this).attr('id')

    $('.dbnow').each(function (a){
        if($( this ).attr('id') !== id){
            $( this ).removeClass('activebtnnow')
        }
    })

    $.ajax({
        type: 'POST',
        url: Routing.generate('demande_attente_autoriser'),
        data: {
            monId:id,
        },
        success: function (response) {
            $('#tabledemande').attr('hidden', true);
            $('#mliste').empty().html(response);
        }
    })


})
