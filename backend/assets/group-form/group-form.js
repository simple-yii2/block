$('#groupform-enableimage').on('change', function() {
    var $groups = $('.field-groupform-imagewidth, .field-groupform-imageheight');
    if (this.checked) {
        $groups.removeClass('hidden');
    } else {
        $groups.addClass('hidden');
    };
});
