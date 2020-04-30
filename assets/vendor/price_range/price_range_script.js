$(document).ready(function () {
    $("#price-range-submit").hide(), $("#min_price,#max_price").on("change", function () {
        $("#price-range-submit").show();
        var e = parseInt($("#min_price").val()), i = parseInt($("#max_price").val());
        e > i && $("#max_price").val(e), $("#slider-range").slider({values: [e, i]})
    }), $("#min_price,#max_price").on("paste keyup", function () {
        $("#price-range-submit").show();
        var e = parseInt($("#min_price").val()), i = parseInt($("#max_price").val());
        e == i && (i = e + 100, $("#min_price").val(e), $("#max_price").val(i)), $("#slider-range").slider({values: [e, i]})
    }), $(function () {
        $("#slider-range").slider({
            range: !0,
            orientation: "horizontal",
            min: 0,
            max: 1e4,
            values: [0, 1e4],
            step: 100,
            slide: function (e, i) {
                if (i.values[0] == i.values[1]) return !1;
                $("#min_price").val(i.values[0]), $("#max_price").val(i.values[1])
            }
        }), $("#min_price").val($("#slider-range").slider("values", 0)), $("#max_price").val($("#slider-range").slider("values", 1))
    }), $("#slider-range,#price-range-submit").on("click", function () {
        var e = $("#min_price").val(), i = $("#max_price").val();
        $("#searchResults").text("Here List of products will be shown which are cost between " + e + " and " + i + ".")
    })
});