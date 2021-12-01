$("#form-type").on({
    "change": function () {
        var type = $(this);
        var first = $(".form-field-first");
        var second = $(".form-field-second");
        var third = $(".form-field-third");

        if ((type.val()) === "contact") {
            first.show();
            second.show();
            if(third.is(":visible")) {
                third.hide();
            }
        }
        if ((type.val()) === "descriptive") {
            first.show();
            third.show();
            if(second.is(":visible")) {
                second.hide();
            }
        }
    }
});
