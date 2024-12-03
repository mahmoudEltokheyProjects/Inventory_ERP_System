$(document).ready(function () {
    $(document).on("input", "#search_by_text", function (e) {
        var search_by_text = $(this).val();
        var token_search = $("#token_search").val();
        var ajax_search_url = $("#ajax_search_url").val();

        jQuery.ajax({
            url: ajax_search_url,
            type: "post",
            dataType: "html",
            cache: false,
            data: { search_by_text: search_by_text, _token: token_search },
            success: function (data) {
                $("#ajax_responce_serarchDiv").html(data);
            },
            error: function () {},
        });
    });
    // ++++++++++++++++++++++ Ajax Search Pagination ++++++++++++++++++++++++++
    // When click on "any link" in pagination , don't reload page
    $(document).on("click", "#ajax_pagination_in_search a ", function (e)
    {
        e.preventDefault();
        // "search inputField" value
        var search_by_text = $("#search_by_text").val();
        // "pagination page" url
        var url = $(this).attr("href");
        // "search" token
        var token_search = $("#token_search").val();

        jQuery.ajax({
            url: url,
            type: "post",
            dataType: "html",
            cache: false,
            data: { search_by_text : search_by_text, _token : token_search },
            success: function (data) {
                $("#ajax_responce_serarchDiv").html(data);
            },
            error: function () {

            },
        });
    });
});
