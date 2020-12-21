/**
 * Created by Roquib on 10/02/2020.
 */

var prixUnitaire=0;

(function ($) {
    $(document).ready(function () {
        var $wrapperTheme = $('.articles_wrapper');
        $wrapperTheme.on('click', '.remove_article', function (e) {
            e.preventDefault();
            // var indexLine = $(this).data('id');
            $(this).closest('.article_item')
                .fadeOut()
                .remove();
            // $('#second_line_item_' + indexLine).fadeOut().remove();
        });
        $('#addDetail').on('click', function (e) {
            //     // alert('hello');
            e.preventDefault();
            // Get the data-prototype explained earlier
            var prototypeTheme = $wrapperTheme.data('prototype');
            // get the new index
            var index = $wrapperTheme.data('index');
            console.log(index);
            // Replace '__name__' in the prototype's HTML to
            // instead be a number based on how many items we have
            var newForm = prototypeTheme.replace(/__name__/g, index);
            // var newForm = prototypeTheme.replace(/__name__|id="second_line_item"/gi, function (x) {
            //     // return x.toUpperCase();
            //     if (x == '__name__') {
            //         return index;
            //     }
            //     else {
            //         return 'id="second_line_item_' + index + '"';
            //     }
            // });
            // increase the index with one for the next item
            $wrapperTheme.data('index', index + 1);
            // Display the form in the page before the "new" link
            // $(this).before(newForm);
            $wrapperTheme.append(newForm);
            // $wrapperTheme.before(newForm);
            $(".select_article:last").chosen({
                width: "100%",
                placeholder_text_single: "Sélectionner une option"
            });
            $(".textarea_description:last").hide();
            // $(".textarea_description:last").addClass("hidden")
            // $(".box_taxe_specifique:last").hide();
            $(".box_prix_origine:last").hide();
            $(".div_taxable:last").hide()
            $(".div_changement_prix:last").hide();

            eventChangeArticle();
            eventAddDescription();
            eventChangeTauxRemise();
            eventChangementPrixUnitaireTTC();
            eventChangementPrixVenteUnitaire();
            eventEditQuantite();
            eventChangeTypeProduit($(".select_type_produit:last"));
            var selectProduit = $(this).parents('div.article_item').find('select.select_article');
            ajaxFacture.getProduitsByType($(".select_type_produit:last").val(), selectProduit);
            // initPopoverDescription($(".add_description:last"), $(".div_description:last"));
        });
    });
})(jQuery);

function eventChangeTypeProduit(selectType) {
    // $(".select_type_produit").change(function () {
    selectType.change(function () {
        var selectProduit = $(this).parents('div.article_item').find('select.select_article');
        ajaxFacture.getProduitsByType($(this).val(), selectProduit);
    })
}


function initPopoverDescription(btn_description, div_description) {
    // console.log(div_description.html());
    // div_description.find('.textarea_description').show();
    btn_description.popover({
        placement: 'bottom',
        title: 'Description',
        html: true,
        content: div_description.html()
    })
}

function eventChangeArticle() {
    $(".select_article:last").change(function () {

        var idProduit = $(this).val();
        var inputUniteMesure = $(this).parents('div.article_item').find('select.unite_mesure');
        var inputPrixVenteUnitaire = $(this).parents('div.article_item').find('input.prix_vente_unitaire');
        var inputPrixUnitaireTTC = $(this).parents('div.article_item').find('input.prix_unitaire_ttc');
        // var indexLine = $(this).parents('div').find('.remove_article').data('id'); //On recupère l'index de la ligne produit à partir du bouton de suppression
        // var checkBoxTaxable = $('#second_line_item_' + indexLine).find('.checkbox_taxable');
        var checkBoxTaxable = $(this).parents('div.article_item').find('.checkbox_taxable');
        // var inputDernierPrixOrigine = $('#second_line_item_' + indexLine).find('.dernier_prix_origine');
        var inputDernierPrixOrigine = $(this).parents('div.article_item').find('.dernier_prix_origine');
        // .find('prix_vente_unitaire').val();
        console.log('Id du produit: ' + idProduit);
        $.ajax({
            type: "POST"
            , url: Routing.generate('get_infos_produit', {'id': idProduit})
            , data: {
                // type_document: "attestation_travail",
            },
            success: function (response) {
                // console.log('work') ;
                // $('#divTest').html(response);
                // console.log(response['uniteMesure']);
                // var type = response['type'];
                // console.log(type);
                // if (type = 'service') {
                inputUniteMesure.val(response['uniteMesure']);
                // console.log(response['taxable']);
                // }

                /*if (type = 'article') {
                    inputQuantite.attr("max", response['qteDispo']);

                    inputQuantite.unbind('change').on('change', function (e) {
                      if (inputQuantite.val() > response['qteDispo']) {
                          inputQuantite.val(response['qteDispo'])
                          calculerValeursLigne($(this));
                      }
                    })
                }*/

                // console.log('taxe spécifique: ' + response['valeurTaxeSpecifique']);
                inputPrixVenteUnitaire.data("taxespecifique", response['valeurTaxeSpecifique']);
                // inputPrixVenteUnitaire.attr("data-taxespecifique", response['valeurTaxeSpecifique']);
                // inputPrixVenteUnitaire.data("id", response['valeurTaxeSpecifique']);
                inputPrixVenteUnitaire.val(response['prixUnitaire']);
                prixUnitaire = response['prixUnitaire'];
                inputPrixUnitaireTTC.val(response['prixUnitaireTTC']);
                inputDernierPrixOrigine.val(response['prixUnitaireTTC']);
                checkBoxTaxable.prop("checked", response['taxable']);
                setTimeout(function () {
                    calculerValeursLigne($(this));
                }, 2000);
            }
        })
    })
}

function eventAddDescription() {
    $(".add_description:last").on('click', function () {
        // alert('work');
        $(this).hide();
        // $(".textarea_description:last").hide();
        $(this).parents('div.article_item').find('.textarea_description').show();
    })
}


function eventEditQuantite() {

    $('.quantite_produit:last').on('keyup', function () {
        calculerValeursLigne($(this));
    })

    $('.quantite_produit:last').on('change', function () {
        calculerValeursLigne($(this));
    })

}

function eventChangeTauxRemise() {
    $('.tauxremise:last').on('keyup', function () {
        calculerValeursLigne($(this));
    })

    $('.tauxremise:last').unbind('change').on('change', function (e) {
        calculerValeursLigne($(this));
    })

}

function eventChangementPrixVenteUnitaire() {
    console.log('work !');
    $(".prix_vente_unitaire:last").on('keyup', function () {

        calculerValeursLigne($(this));
        // console.log('work !');
    })
    $('.prix_vente_unitaire:last').on('change', function () {
        calculerValeursLigne($(this));
        // calculTotauxGlobauxFacture();
    })
    // calculTotauxGlobauxFacture();
}

function calculerValeursLigne(changedElement) {
    // console.log(changedElement.parents('div.article_item'));
    var inputPrixVenteUnitaire = changedElement.parents("div.article_item").find('input.prix_vente_unitaire');
    var prixVenteUnitaire = changedElement.parents('div.article_item').find('input.prix_vente_unitaire').val();
    var inputPrixUnitaireTTC = changedElement.parents('div.article_item').find('input.prix_unitaire_ttc');
    // var indexLine = changedElement.parents('div.article_item').find('.remove_article').data('id'); //On recupère l'index de la ligne produit à partir du bouton de suppression
    // var checkBoxTaxable = $('#second_line_item_' + indexLine).find('.checkbox_taxable');
    var checkBoxTaxable = changedElement.parents('div.article_item').find('.checkbox_taxable');
    // var inputDernierPrixOrigine = $('#second_line_item_' + indexLine).find('.dernier_prix_origine');
    var inputDernierPrixOrigine = changedElement.parents('div.article_item').find('.dernier_prix_origine');
    // var checkBoxChangementPrixUnitaireTTC = $('#second_line_item_' + indexLine).find('.checkbox_prix_origine');
    var checkBoxChangementPrixUnitaireTTC = changedElement.parents('div.article_item').find('.checkbox_prix_origine');
    var inputQuantite = changedElement.parents('div.article_item').find('input.quantite_produit');
    // var inputSousTotalTTC = $('#second_line_item_' + indexLine).find('.sousTotalTTC');
    var inputSousTotalTTC = changedElement.parents('div.article_item').find('.sousTotalTTC');

    var tauxSousRemise = changedElement.parents('div.article_item').find('input.tauxremise').val();

    var monPrix = prixUnitaire - prixUnitaire*(tauxSousRemise/100);

    inputPrixVenteUnitaire.val(monPrix);

    // console.log(inputPrixUnitaireTTC.html());
    var tauxTVA = $(".taux_tva").val();
    // console.log('taxe spécifique: ' + inputPrixVenteUnitaire.data('taxespecifique'), inputPrixVenteUnitaire.val());
    var taxeSpecifique = inputPrixVenteUnitaire.data('taxespecifique');
    // var taxeSpecifique = $(this).attr('data-taxespecifique');
    // console.log(changedElement.parents('div.article_item'));
    // console.log('checkbox: ' + checkBoxTaxable.prop("checked"));
    if (checkBoxTaxable.prop("checked") == true) {
        var prixUnitaireTTC = prixVenteUnitaire * (1 + (tauxTVA / 100) + (taxeSpecifique / 100));
    }
    else {
        var prixUnitaireTTC = prixVenteUnitaire * (1 + (taxeSpecifique / 100));
    }
    // console.log(prixVenteUnitaire, tauxTVA, taxeSpecifique, 'PU TTC: ' + prixUnitaireTTC);
    inputPrixUnitaireTTC.val(prixUnitaireTTC);
    var sousTotalTTC = inputQuantite.val() * prixUnitaireTTC;
    inputSousTotalTTC.val(sousTotalTTC);
    if (prixUnitaireTTC != inputDernierPrixOrigine.val())
    { //En cas de changement du prix unitaire TTC
        checkBoxChangementPrixUnitaireTTC.prop("checked", true);
        // $('#second_line_item_' + indexLine).find('.box_prix_origine').show();
        changedElement.parents('div.article_item').find('.box_prix_origine').show();
    }
    else {
        checkBoxChangementPrixUnitaireTTC.prop("checked", false);
        // $('#second_line_item_' + indexLine).find('.box_prix_origine').hide();
        changedElement.parents('div.article_item').find('.box_prix_origine').hide();

    }
    // console.log('changement prix origine:' + sousTotalTTC, inputQuantite.val(), inputPrixVenteUnitaire.val(), taxeSpecifique);
    console.log("changement prix origine: " + checkBoxChangementPrixUnitaireTTC.prop("checked"));
    calculTotauxGlobauxFacture();
}

function eventChangementPrixUnitaireTTC() {
    $(".checkbox_prix_origine:last").change(function () {
        // alert('work');
        // $(this).hide();
        if ($(this).prop("checked") == true) {
            $(this).parents('div').find('.box_prix_origine').show();
        }
        else {
            $(this).parents('div').find('.box_prix_origine').hide();
        }
    })
}

function calculTotauxGlobauxFacture() {
    var totalHT = 0;
    var totalTVA = 0;
    var totalTaxeSpecifique = 0;
    var totalAIB = 0;
    var totalTTC = 0;

    $(".prix_vente_unitaire").each(function () {
        var prixVenteUnitaire = $(this).val();
        var quantite = $(this).parents('div.article_item').find('input.quantite_produit').val();
        // var prixUnitaireTTC = $(this).parents('div').find('input.prix_unitaire_ttc').val();
        // var indexLine = $(this).parents('div').find('.remove_article').data('id'); //On recupère l'index de la ligne produit à partir du bouton de suppression
        var checkBoxTaxable = $(this).parents('div.article_item').find('.checkbox_taxable');
        // var inputSousTotalTTC = $('#second_line_item_' + indexLine).find('.sousTotalTTC').val();

        totalHT += (quantite * prixVenteUnitaire);
        var tauxTVA = $(".taux_tva").val();
        var taxeSpecifique = $(this).data('taxespecifique');
        // var taxeSpecifique = $(this).attr('data-taxespecifique');
        if (checkBoxTaxable.prop("checked") == true) {
            totalTVA += quantite * prixVenteUnitaire * (tauxTVA / 100);
            totalTaxeSpecifique += quantite * prixVenteUnitaire * (taxeSpecifique / 100);
            totalTTC += quantite * prixVenteUnitaire * (1 + (tauxTVA / 100) + (taxeSpecifique / 100));
        }
        else {
            totalTaxeSpecifique += quantite * prixVenteUnitaire * (taxeSpecifique / 100);
            totalTTC += quantite * prixVenteUnitaire * (1 + (taxeSpecifique / 100));
        }
        // console.log('totaux globaux: ' + taxeSpecifique, totalTTC);
    });
    var tauxAIB = $(".taux_aib").val();
    totalAIB = totalHT * (tauxAIB / 100);
    totalTTC += totalAIB;
    // $("#totalHT").html(totalHT);
    $(".total_ht").val(totalHT);
    // $("#totalTVA").html(totalTVA);
    $(".total_tva").val(totalTVA);
    if (totalTaxeSpecifique > 0) {
        $("#totalTaxeSpecifique").html(totalTaxeSpecifique);
        $("#rowTotal_TaxeSpecifique").show();
    }
    else {
        $("#rowTotal_TaxeSpecifique").hide();
    }
    // $("#totalAIB").html(totalAIB);
    $(".total_aib").val(totalAIB);
    // $("#totalTTC").html(totalTTC);
    $(".total_ttc").val(totalTTC);
    console.log("Total TTC: " + totalTTC);
}

function initEditForm() {
    // console.log('work');
    // console.log($(".articles_wrapper").length);
//Description article
    $(".articles_wrapper").find('.add_description').each(function () {
        // $(".articles_wrapper").find('.second_line_item').each(function () {
        var description = $(this).parents("div.article_item").find('.textarea_description').val();
        // console.log(description);
        if (description === '') { //Si il n'y a aucune description on affiche le bouton et on cache le textarea
            $(this).show();
            $(this).parents("div.article_item").find('.textarea_description').hide();
        }
        else {
            $(this).hide();
            $(this).parents("div.article_item").find('.textarea_description').show();
        }
        $(this).on('click', function () {
            // alert('work');
            $(this).hide();
            // $(".textarea_description:last").hide();
            $(this).parents('div.article_item').find('.textarea_description').show();
        })
    });

    //masquer cases à cocher taxable
    $(".articles_wrapper").find('.div_taxable').each(function () {
        $(this).hide();
    });

    //masquer cases à cocher changement prix unitaire TTC
    $(".articles_wrapper").find('.div_changement_prix').each(function () {
        $(this).hide();
    });

    //Taxe spécifique
    $(".articles_wrapper").find('.checkbox_taxe_specifique').each(function () {
        var hasTaxeSpecifique = $(this).parents("td").find('.checkbox_taxe_specifique').prop("checked");

        // console.log(hasTaxeSpecifique);
        if (hasTaxeSpecifique == true) {
            $(this).parents('div.article_item').find('.box_taxe_specifique').show();
        }
        else {
            $(this).parents('div.article_item').find('.box_taxe_specifique').hide();
        }
        $(this).change(function () {
            if ($(this).prop("checked") == true) {
                $(this).parents('div.article_item').find('.box_taxe_specifique').show();
            }
            else {
                $(this).parents('div.article_item').find('.box_taxe_specifique').hide();
            }
        })
    });

    //Prix origine
    $(".articles_wrapper").find('.checkbox_prix_origine').each(function () {
        var changePrixOrigine = $(this).parents("div.article_item").find('.checkbox_prix_origine').prop("checked");

        // console.log('Prix origine changé: '+ changePrixOrigine);
        // $(this).parents('div.article_item').find('.box_prix_origine').hide();
        if (changePrixOrigine == true) {
            $(this).parents('div.article_item').find('.box_prix_origine').show();
        }
        else {
            $(this).parents('div.article_item').find('.box_prix_origine').hide();
        }
        $(this).change(function () {
            if ($(this).prop("checked") == true) {
                $(this).parents('div.article_item').find('.box_prix_origine').show();
            }
            else {
                $(this).parents('div.article_item').find('.box_prix_origine').hide();
            }
        })
    });

    $(".articles_wrapper").find('.prix_vente_unitaire').each(function () {
        // console.log('parent_prix: '+$(this).parents('div.article_item'));
        //affectation de la valeur taxable pour chaque produit
        var checkBoxTaxable = $(this).parents('div.article_item').find('input.checkbox_taxable');
        var inputQuantite = $(this).parents('div.article_item').find('input.quantite_produit');
        var inputPrixVenteUnitaire = $(this);
        var inputDernierPrixOrigine = $(this).parents('div.article_item').find('.dernier_prix_origine');
        var idProduit = $(this).parents('div.article_item').find('.select_article').val();
        var selectProduit = $(this).parents('div.article_item').find('.select_article');
        var selectTypeProduit = $(this).parents('div.article_item').find('.select_type_produit');
        var qtDispo = 1;

        //Event change type produit
        eventChangeTypeProduit(selectTypeProduit);
        $.ajax({
            type: "POST"
            , url: Routing.generate('get_infos_produit', {'id': idProduit})
            , data: {
                // type_document: "attestation_travail",
            },
            success: function (response) {

                if (type = 'article') {
                    inputQuantite.attr("max", response['qteDispo']);
                }
                // console.log('taxe spécifique: ' + response['valeurTaxeSpecifique']);
                inputPrixVenteUnitaire.data("taxespecifique", response['valeurTaxeSpecifique']);
                inputDernierPrixOrigine.val(response['prixUnitaireTTC']);
                checkBoxTaxable.prop("checked", response['taxable']);
                qtDispo = response['qteDispo'];
                // console.log('taxable: '+checkBoxTaxable.prop("checked"), checkBoxTaxable, response['taxable']);
                setTimeout(function () {
                    calculerValeursLigne(inputPrixVenteUnitaire);
                }, 1000);
            }
        })
        // calculerValeursLigne($(this));
        inputQuantite.on('keyup', function () {
            calculerValeursLigne($(this));
            // calculTotauxGlobauxFacture();
        })

        inputPrixVenteUnitaire.on('keyup', function () {
            calculerValeursLigne($(this));
            // console.log('work !');
        })
        // calculTotauxGlobauxFacture();
        //évènement changement article
        selectProduit.change(function () {

            var idProduit = $(this).val();
            var inputUniteMesure = $(this).parents('div.article_item').find('select.unite_mesure');
            var inputQuantite = $(this).parents('div.article_item').find('input.quantite_produit');
            var inputPrixVenteUnitaire = $(this).parents('div.article_item').find('input.prix_vente_unitaire');
            var inputPrixUnitaireTTC = $(this).parents('div.article_item').find('input.prix_unitaire_ttc');
            // var indexLine = $(this).parents('div').find('.remove_article').data('id'); //On recupère l'index de la ligne produit à partir du bouton de suppression
            // var checkBoxTaxable = $('#second_line_item_' + indexLine).find('.checkbox_taxable');
            var checkBoxTaxable = $(this).parents('div.article_item').find('.checkbox_taxable');
            // var inputDernierPrixOrigine = $('#second_line_item_' + indexLine).find('.dernier_prix_origine');
            var inputDernierPrixOrigine = $(this).parents('div.article_item').find('.dernier_prix_origine');
            // .find('prix_vente_unitaire').val();
            console.log('Id du produit: ' + idProduit);
            $.ajax({
                type: "POST"
                , url: Routing.generate('get_infos_produit', {'id': idProduit})
                , data: {
                    // type_document: "attestation_travail",
                },
                success: function (response) {
                    inputUniteMesure.val(response['uniteMesure']);

                    if (type = 'article') {
                        inputQuantite.attr("max", response['qteDispo']);
                    }
                    inputPrixVenteUnitaire.data("taxespecifique", response['valeurTaxeSpecifique']);
                    inputPrixVenteUnitaire.val(response['prixUnitaire']);
                    inputPrixUnitaireTTC.val(response['prixUnitaireTTC']);
                    inputDernierPrixOrigine.val(response['prixUnitaireTTC']);
                    checkBoxTaxable.prop("checked", response['taxable']);
                    setTimeout(function () {
                        calculerValeursLigne($(this));
                    }, 2000);
                }
            })
        })
    });

    // $(".add_description:last").on('click', function () {
    //     // alert('work');
    //     $(this).hide();
    //     $(".textarea_description:last").hide();
    //     $(this).parents('div').find('.textarea_description').show();
    // })
}