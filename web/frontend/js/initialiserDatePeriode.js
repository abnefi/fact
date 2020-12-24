function initPeriode() {
    var annee = new Date().getFullYear()
    var moisDebut = new Date().getMonth()
    var periodeDebut = Date.parse(new Date(annee, moisDebut, 1));
    // console.log(periodeDebut);
    var mindate = new Date().getTime() - 31540000000
    $('.periode_facture').flatpickr(
        {
            mode: "range",
            locale: "fr",
            // altInput: true,
            // altFormat: "d/m/Y",
            dateFormat: "Y-m-d",
            minDate: mindate,
            defaultDate: [periodeDebut, "today"],
            conjunction: " au ",
            disable: [
                function (date) {
                    return !(date.getDate());
                }
            ]
        }
    );
    $('.periode_facture').on('focus', function () {
        $(this).blur();
    });
    // $('.periode').prop('readonly', false);
    $('.periode_facture').css("background-color", "white");
}

function initDate() {
    $('.date_etat').flatpickr({
        // altInput: true,
        // altFormat: "d/m/Y",
        dateFormat: "Y-m-d",
        defaultDate: 'today'
    })
    // $('.date_etat').on('focus', function () {
    //     $(this).blur();
    // });
    $('.date_etat').css("background-color", "white");
}

function initDatePresence() {
    $('.date_presence').flatpickr({
        // altInput: true,
        // altFormat: "d/m/Y",
        dateFormat: "Y-m-d",
        maxDate: "today"
    })
    $('.date_presence').css("background-color", "white");
}

