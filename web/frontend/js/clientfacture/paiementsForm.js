/**
 * Created by Roquib on 20/02/2020.
 */


(function ($) {
    $(document).ready(function () {
        var $wrapperTheme = $('.paiements_wrapper');
        $wrapperTheme.on('click', '.remove_paiement', function (e) {
            e.preventDefault();
            $(this).closest('.article_item')
                .fadeOut()
                .remove();
        });
        console.log('workiiiing !');
        $('#addPaiement').on('click', function (e) {
            //     // alert('hello');
            e.preventDefault();
            // Get the data-prototype explained earlier
            var prototypeTheme = $wrapperTheme.data('prototype');
            // get the new index
            var index = $wrapperTheme.data('index');
            // console.log(index);
            // Replace '__name__' in the prototype's HTML to
            // instead be a number based on how many items we have
            var newForm = prototypeTheme.replace(/__name__/g, index);

            // increase the index with one for the next item
            $wrapperTheme.data('index', index + 1);
            // Display the form in the page before the "new" link
            // $(this).before(newForm);
            $wrapperTheme.append(newForm);
            // $wrapperTheme.before(newForm);
            $('.date_paiement:last').flatpickr({
                // altInput: true,
                // altFormat: "d/m/Y",
                dateFormat: "Y-m-d",
                // defaultDate: 'today'
            })
            $('.date_paiement:last').css("background-color", "white");
        });

    });
})(jQuery);

// function verifierMontant() {
//
// }