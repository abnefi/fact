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
            $wrapperTheme.data('index', index + 1);
            // Display the form in the page before the "new" link
            // $(this).before(newForm);
            $wrapperTheme.append(newForm);
            // $wrapperTheme.before(newForm);
        });
    });
})(jQuery);

function initEditForm() {
//Description article
    $(".articles_wrapper").find('.article_item').each(function () {
        console.log($(this).find('.remove_article'));
    })
}