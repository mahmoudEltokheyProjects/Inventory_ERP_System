$(document).ready(function(){

    // ================ start_balance_status ================
    // when "account" is "parent" , and it's value is "0" (balanced) , set "start_balance" with "0"
    $("#start_balance_status").on('change', function(){
        if( $(this).val() == "" )
        {
            $("#start_balance").val('');
        }
        else
        {
            // "start_balance" is "balanced"
            if( $(this).val() == 3 )
            {
                $("#start_balance").val(0);
            }
            else
            {
                $("#start_balance").val('');
            }
        }
    });
    // ================ start_balance_status ================
    // when writing on "start_balance" inputField and "start_balance_status" not selected then Give "error message"
    $("#start_balance").on('input', function(){
        // start_balance_status
        var start_balance_status = $('#start_balance_status').val();
        if(start_balance_status == "")
        {
            swal({
                title: "خطأ",
                text: "لابد من اختيار حالة رصيد اول المدة",
                icon: "error",
                button: "تاكيد",
            });
            // clear "start_balance"
            $(this).val("");
            return false;
        }
        // if "start_balance" equal "0" and "start_balance_status" not equal "3" [ Not Balanced] , then "start_balance" must be greater than "0"
        if(  $(this).val() == 0 && start_balance_status != 3)
        {
            swal({
                title: "خطأ",
                text: 'رصيد اول المدة لابد ان يكون اكبر من الصفر',
                icon: "error",
                button: "تاكيد",
            });
            // clear "start_balance"
            $(this).val("");
            return false;
        }
       });
    // ++++++++++++++++++++++++++++++++++++ Create "Customer" Form Validation +++++++++++++++++++++++++++++++++++
    $("#submit").on("click", function(){
        // ++++++++ 1- "name" is "required" ++++++++
        var name = $("#name").val();
        if( name == "")
        {
            swal({
                title: "خطأ",
                text: "اسم المورد مطلوب",
                icon: "error",
                button: "تاكيد",
            });
            return false;
        }
        // ++++++++ 2- "suppliers_categories_id" is "required" ++++++++
        var suppliers_category = $("#suppliers_categories_id").val();
        if( suppliers_category == "")
        {
            swal({
                title: "خطأ",
                text: "فئة المورد مطلوبة",
                icon: "error",
                button: "تاكيد",
            });
            return false;
        }
        // ++++++++ 3- "start_balance_status" is "required" ++++++++
        var start_balance_status = $("#start_balance_status").val();
        if( start_balance_status == "")
        {
            swal({
                title: "خطأ",
                text: 'اختار حالة رصيد اول المدة',
                icon: "error",
                button: "تاكيد",
            });
            return false;
        }
        // ++++++++ 4- "start_balance" is "required" ++++++++
        var start_balance = $("#start_balance").val();
        if( start_balance == "")
        {
            swal({
                title: "خطأ",
                text: 'رصيد اول المدة مطلوب',
                icon: "error",
                button: "تاكيد",
            });
            return false;
        }
        // ++++++++ 5- "active" is "required" ++++++++
        var active = $("#active").val();
        if( active == "")
        {
            swal({
                title: "خطأ",
                text: 'اختار حالة التفعيل',
                icon: "error",
                button: "تاكيد",
            });
            return false;
        }
        // ++++++++ 6- "is_archived" is "required" ++++++++
        var is_archived = $("#is_archived").val();
        if( is_archived == "")
        {
            swal({
                title: "خطأ",
                text: 'اختار حالة الارشفة',
                icon: "error",
                button: "تاكيد",
            });
            return false;
        }
    });
    // ++++++++++++++++++++++++++++++++++++ Ajax Search +++++++++++++++++++++++++++++++++++
    // +++++++++ 1- first filter : search_by_text inputField +++++++++
    $("#search_by_text").on('input', function(){
        // call "make_search()" method
        make_search();
    });
    // ---------------- search_by_text [radio button] : "Name" or "account_number" or "customer_code" : بحث [اسم - رقم الحساب - كود العميل ] ----------------
    // +++++++++ search radio button +++++++++
    $("input[type=radio][name=search_by_text_radio]").on('change', function(){
        // call "make_search()" method
        make_search();
    });
    // ============== make_search() function =================
    function make_search()
    {
        // Search By "Name" or "Barcode" or "Code"
        var search_by_text = $("#search_by_text").val();
        // [search_by_text] "radio button" value
        var search_by_text_radio = $("input[type='radio'][name='search_by_text_radio']:checked").val();
        // +++++++++ ajax url +++++++++
        var ajax_search_url = $("#ajax_search_url").val();
        // +++++++++ token_search +++++++++
        var token_search = $("#token_search").val();
        // +++++++++ make "ajax request" +++++++++
        jQuery.ajax({
            url: ajax_search_url,
            method:"POST",
            cache:false,
            data:
            {
                ajax_search_url      : ajax_search_url      ,
                _token               : token_search         ,
                search_by_text       : search_by_text       ,
                search_by_text_radio : search_by_text_radio ,
            },
            success: function(response)
            {
                console.log(response);
                $("#ajax_responce_serarchDiv").html(response);
            } ,
            error: function(e) {

            }
        });
    }
    // ++++++++++++++++++++++ Ajax Search Pagination ++++++++++++++++++++++++++
    // When click on "any link" in pagination , don't reload page
    $(document).on("click", "#ajax_pagination_in_search a", function (e)
    {
        e.preventDefault();
        // Search By "Name"
        var search_by_text = $("#search_by_text").val();
        // [search_by_text] "radio button" value
        var search_by_text_radio = $("input[type='radio'][name='search_by_text_radio']:checked").val();
        // +++++++++ token_search +++++++++
        // search token
        var token_search = $("#token_search").val();
        var url = $(this).attr("href");
        // ajax request
        jQuery.ajax({
            url: url,
            type: "post",
            dataType: "html",
            cache: false,
            data:
            {
                _token:token_search,
                search_by_text:search_by_text,
                search_by_text_radio:search_by_text_radio,
            },
            success: function (data)
            {
                $("#ajax_responce_serarchDiv").html(data);
            },
            error: function (e)
            {

            },
        });
    });
});
