/**
 * Created by Roquib on 13/02/2020.
//  */
//

(function ($) {
    $(document).ready(function () {
        var $wrapperTheme = $('.articles_wrapper');
        $wrapperTheme.on('click', '.remove_article', function (e) {
            e.preventDefault();
            $(this).closest('.article_item')
                .fadeOut()
                .remove();
        });
        $('#addDetail').on('click', function (e) {
            e.preventDefault();
            var prototypeTheme = $wrapperTheme.data('prototype');
            var index = $wrapperTheme.data('index');
            console.log(index);
            var newForm = prototypeTheme.replace(/__name__/g, index);
            $wrapperTheme.data('index', index + 1);
            $wrapperTheme.append(newForm);
            $(".select_article:last").chosen({
                width: "100%",
                placeholder_text_single: "Sélectionner une option"
            })
        });
    });
})(jQuery);