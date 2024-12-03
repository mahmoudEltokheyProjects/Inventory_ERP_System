$(document).ready(function ()
{
    // ++++++++++++++++++++++++++++++++++++ does_has_retail_unit selectbox : هل للصنف وحدة تجزئه ++++++++++++++++++++++++
    $(document).on("change", "#does_has_retail_unit", function (e) {
        // parent unit
        var inv_uom_parent_id = $("#inv_uom_parent_id").val();
        // if "parent_uom" isn't "selected" : لم يتم اختيار الوحدة الاب
        if (inv_uom_parent_id == "")
        {
            swal({
                title: "خطأ",
                text: "لابد من اختيار وحدة القياس الاب اولا",
                icon: "error",
                button: "تاكيد",
            });
            // set selected "does_has_retail_unit" with "null" : value will be ""  هل للصنف وحدة تجزئه هخلي قيمتها فارغ
            $("#does_has_retail_unit").val("");
        }
        // if "parent_uom" is "selected" : تم اختيار وحدة اب
        else
        {
            if ($(this).val() == 1)
            {
                // Appear : "وحدة القياس التجزئه الابن بالنسبة للاب"
                $("#retial_uom_id_div").show();
            }
            else
            {
                // Hide : "عدد وحدات التجزئه بالنسبة للاب" , "وحدة القياس التجزئه الابن بالنسبة للاب"
                $(".related_retail_counter").hide();
                // Hide : "وحدة القياس التجزئه الابن بالنسبة للاب"
                $("#retial_uom_id_div").hide();
            }
            $("#retial_uom_id").val("");
        }
    });
    // ++++++++++++++++++++++++++++++++++++ Show/Hide "Div" with "class=related_retail_counter" ++++++++++++++++++++++++
    // ======= "اظهار / اخفاء "عدد وحدات التجزئه بالنسبة للاب" , "وحدة القياس التجزئه الابن بالنسبة للاب =======
    $(document).on("change", "#inv_uom_parent_id", function (e) {
        // ================== "inv_uom_parent_id" is selected : "لو تم اختيار "وحدة القياس الاب ==================
        if ($(this).val() != "")
        {
            // get selected "inv_uom_parent" text
            var parent_uom_name = $("#inv_uom_parent_id option:selected").text();
            // set "parent_uom_name_span" with "inv_uom_parent_id" value هحط اسم الوحدة الاب بين الاقواس
            $(".parent_uom_name_span").text(parent_uom_name);
            // get selected "does_has_retail_unit" value  : value will be "0" or "1" هل للصنف وحدة تجزئه
            var does_has_retail_unit = $("#does_has_retail_unit").val();
            // ======== if "does_has_retail_unit" == 1 : نعم" : للصنف وحدة تجزئه" ========
            if (does_has_retail_unit == 1)
            {
                // retail_uom : لو تم اختيار وحدة تجزئه
                var retial_uom_id = $("#retial_uom_id").val();
                if(retial_uom_id != "")
                {
                    // Appear : "عدد وحدات التجزئه بالنسبة للاب" , "السعر القطاعي بوحدة قياس التجزئه"
                    $(".related_retail_counter").show();
                    // Appear : "وحدة القياس التجزئه الابن بالنسبة للاب"
                    $("#retial_uom_id_div").show();
                }
                else
                {
                    // Hide : "عدد وحدات التجزئه بالنسبة للاب" , "وحدة القياس التجزئه الابن بالنسبة للاب"
                    $(".related_retail_counter").hide();
                    // Hide : "وحدة القياس التجزئه الابن بالنسبة للاب"
                    $("#retial_uom_id_div").hide();
                }
            }
            // ======== if "does_has_retail_unit" == 0 : لا" : الصنف ليس له وحدة تجزئه" ========
            else
            {
                // Hide : "عدد وحدات التجزئه بالنسبة للاب" , "وحدة القياس التجزئه الابن بالنسبة للاب"
                // $("#retial_uom_id_div").hide();
                // Hide : "عدد وحدات التجزئه بالنسبة للاب" , "وحدة القياس التجزئه الابن بالنسبة للاب"
                $(".related_retail_counter").hide();
            }
            // Appear "elements" with "class=related_parent_counter" : الاسعار الخاصه بالوحدة الاساسية
            $(".related_parent_counter").show();
        }
        // ================== "inv_uom_parent_id" isn't selected : "لو لم يتم اختيار "وحدة القياس الاب ==================
        else
        {
            // Set "parent_uom_name_span" with "" : هحط فراغ بين الاقواس
            $(".parent_uom_name_span").text("");
            // Hide "retial_uom "اخفاء "وحدة القياس التجزئه الابن بالنسبة للاب
            $(".related_retail_counter").hide();
            // Set selected "does_has_retail_unit" value with empty : value will be "empty" هل للصنف وحدة تجزئه هخليه فارغ
            $("#does_has_retail_unit").val("");
            // Hide "elements" with "class=related_parent_counter" : الاسعار الخاصه بالوحدة الاساسية
            $(".related_parent_counter").hide();
            // Hide "elements" with "class=retial_uom_id_div" : وحدة القياس التجزئه الابن بالنسبة للاب
            $("#retial_uom_id_div").hide();
        }
    });
    // ++++++++++++++++++++++++ Show/Hide "Div" with "class=related_retail_counter" ++++++++++++++++++++++++
    // ======= وحدة القياس التجزئه الابن بالنسبة للاب =======
    $(document).on("change", "#retial_uom_id", function (e) {
        // ================== "retial_uom_id" is selected : "لو تم اختيار "وحدة القياس التجزئه ==================
        if ($(this).val() != "")
        {
            // get selected "inv_uom_child" text
            var child_uom_name = $("#retial_uom_id option:selected").text();
            // set "child_uom_name_span" with "retial_uom_id" value هحط اسم وحدة التجزئه الابن بين الاقواس
            $(".child_uom_name_span").text(child_uom_name);
            // Appear : "السعر القطاعي بوحدة قياس التجزئه" , "وحدة القياس التجزئه الابن بالنسبة للاب" , "عدد وحدات التجزئه بالنسبة للاب"
            $(".related_retail_counter").show();
        }
        else
        {
            // Set "parent_uom_name_span" with "" : هحط فراغ بين الاقواس
            $(".parent_uom_name_span").text("");
            // Hide : "السعر القطاعي بوحدة قياس التجزئه" , "وحدة القياس التجزئه الابن بالنسبة للاب" , "عدد وحدات التجزئه بالنسبة للاب"
            $(".related_retail_counter").hide();
        }
    });
    // ++++++++++++++++++++++++++++++++++++ Create "item_card" Form Validation +++++++++++++++++++++++++++++++++++
    $("#do_add_item_card").on("click", function(){
        // ++++++++ 1- "item name" is "required" ++++++++
        var name = $("#name").val();
        if( name == "")
        {
            swal({
                title: "خطأ",
                text: "من فضلك ادخل اسم الصنف",
                icon: "error",
                button: "تاكيد",
            });
            return false;
        }
        // ++++++++ 2- "item_type" is "required" ++++++++
        var item_type = $("#item_type").val();
        if( item_type == "")
        {
            swal({
                title: "خطأ",
                text: "من فضلك ادخل نوع الصنف",
                icon: "error",
                button: "تاكيد",
            });
            return false;
        }
        // ++++++++ 3- "inv_itemCard_category" is "required" ++++++++
        var inv_itemCard_category = $("#inv_itemCard_category_id").val();
        if( inv_itemCard_category == "")
        {
            swal({
                title: "خطأ",
                text: "من فضلك اختر فئة الصنف",
                icon: "error",
                button: "تاكيد",
            });
            return false;
        }
        // ++++++++ 4- "inv_uom_parent" is "required" ++++++++
        var inv_uom_parent = $("#inv_uom_parent_id").val();
        if( inv_uom_parent == "")
        {
            swal({
                title: "خطأ",
                text: "من فضلك اختر وحدة القياس الاب",
                icon: "error",
                button: "تاكيد",
            });
            return false;
        }
        // ++++++++ 4- "does_has_retail_unit" is "required" ++++++++
        var does_has_retail_unit = $("#does_has_retail_unit").val();
        if( does_has_retail_unit == "")
        {
            swal({
                title: "خطأ",
                text: "من فضلك اختر هل للصنف وحدة تجزئه",
                icon: "error",
                button: "تاكيد",
            });
            return false;
        }
        // ========== Validation on fields related to "retail" ==========
        // ========== الاسعار الخاصة بالوحدة الاساسية ==========
        if( does_has_retail_unit == 1)
        {
            // ++++++++ 5- retial_uom_id  is "required" : وحدة القياس التجزئه الابن بالنسبة للاب ++++++++
            var retial_uom_id = $("#retial_uom_id").val();
            if( retial_uom_id == "")
            {
                swal({
                    title: "خطأ",
                    text: "من فضلك اختر وحدة القياس التجزئه الابن بالنسبة للاب",
                    icon: "error",
                    button: "تاكيد",
                });
                return false;
            }
            // ++++++++ 6- retail_uom_to_uom is "required" : عدد وحدات التجزئه بالنسبة للاب ++++++++
            var retail_uom_to_uom = $("#retail_uom_to_uom").val();
            if( retail_uom_to_uom == "")
            {
                swal({
                    title: "خطأ",
                    text: "من فضلك ادخل عدد وحدات التجزئه بالنسبة للاب",
                    icon: "error",
                    button: "تاكيد",
                });
                return false;
            }
            // ++++++++ 7- price is "required" : السعر القطاعي بوحدة القياس الاساسية ++++++++
            var price = $("#price").val();
            if( price == "")
            {
                swal({
                    title: "خطأ",
                    text: "من فضلك ادخل السعر القطاعي بوحدة القياس الاساسية",
                    icon: "error",
                    button: "تاكيد",
                });
                return false;
            }
            // ++++++++ 8- nos_gomla_price is "required" : سعر النص جملة قطاعي مع الوحدة الاساسية ++++++++
            var nos_gomla_price = $("#nos_gomla_price").val();
            if( nos_gomla_price == "")
            {
                swal({
                    title: "خطأ",
                    text: "من فضلك ادخل سعر النص جملة قطاعي مع الوحدة الاساسية",
                    icon: "error",
                    button: "تاكيد",
                });
                return false;
            }
            // ++++++++ 9- gomla_price is "required" : سعر الجملة بوحدة القياس الاساسية ++++++++
            var gomla_price = $("#gomla_price").val();
            if( gomla_price == "")
            {
                swal({
                    title: "خطأ",
                    text: "من فضلك ادخل سعر الجملة بوحدة القياس الاساسية",
                    icon: "error",
                    button: "تاكيد",
                });
                return false;
            }
            // ++++++++ 10- cost_price is "required" : سعر تكلفة الشراء للصنف بوحدة القياس الاساسية ++++++++
            var cost_price = $("#cost_price").val();
            if( cost_price == "")
            {
                swal({
                    title: "خطأ",
                    text: "من فضلك ادخل سعر تكلفة الشراء للصنف بوحدة القياس الاساسية",
                    icon: "error",
                    button: "تاكيد",
                });
                return false;
            }
        }
        // ========== Validation on fields related to "retail" ==========
        // ========== الاسعار الخاصة بوحدة التجزئه ==========
        if( does_has_retail_unit == 1)
        {
            // ++++++++ 11- price_retail is "required" : السعر القطاعي بوحدة قياس التجزئه ++++++++
            var price_retail = $("#price_retail").val();
            if( price_retail == "")
            {
                swal({
                    title: "خطأ",
                    text: "من فضلك ادخل السعر القطاعي بوحدة قياس التجزئه",
                    icon: "error",
                    button: "تاكيد",
                });
                return false;
            }
            // ++++++++ 12- nos_gomla_price_retail is "required" : من فضلك ادخل سعر النص جملة قطاعي مع وحدة التجزئه ++++++++
            var nos_gomla_price_retail = $("#nos_gomla_price_retail").val();
            if( nos_gomla_price_retail == "")
            {
                swal({
                    title: "خطأ",
                    text: "من فضلك ادخل سعر النص جملة قطاعي مع وحدة التجزئه",
                    icon: "error",
                    button: "تاكيد",
                });
                return false;
            }
            // ++++++++ 13- gomla_price_retail is "required" : من فضلك ادخل سعر الجملة بوحدة قياس التجزئه ++++++++
            var gomla_price_retail = $("#gomla_price_retail").val();
            if( gomla_price_retail == "")
            {
                swal({
                    title: "خطأ",
                    text: "من فضلك ادخل سعر الجملة بوحدة قياس التجزئه",
                    icon: "error",
                    button: "تاكيد",
                });
                return false;
            }
            // ++++++++ 14- cost_price_retail is "required" : من فضلك ادخل سعر تكلفة الشراء للصنف بوحدة قياس التجزئه ++++++++
            var cost_price_retail = $("#cost_price_retail").val();
            if( cost_price_retail == "")
            {
                swal({
                    title: "خطأ",
                    text: "من فضلك ادخل سعر تكلفة الشراء للصنف بوحدة قياس التجزئه",
                    icon: "error",
                    button: "تاكيد",
                });
                return false;
            }

        }
        // ++++++++ 15- has_fixed_price is "required" : هل للصنف سعر ثابت ++++++++
        var has_fixed_price = $("#has_fixed_price").val();
        if( has_fixed_price == "")
        {
            swal({
                title: "خطأ",
                text: "من فضلك اختار هل للصنف سعر ثابت بالفواتير",
                icon: "error",
                button: "تاكيد",
            });
            return false;
        }
        // ++++++++ 16- active is "required" : الحالة ++++++++
        var active = $("#active").val();
        if( active == "")
        {
            swal({
                title: "خطأ",
                text: "من فضلك اختار حالة التفعيل",
                icon: "error",
                button: "تاكيد",
            });
            return false;
        }

    });
    // ++++++++++++++++++++++++++++++++++++ Update "item_card" Form Validation +++++++++++++++++++++++++++++++++++
    $("#do_edit_item_cards").on("click", function(){
        // ++++++++ 1- "barcode" is "required" in Update Form ++++++++
        var barcode = $("#barcode").val();
        if( barcode == "")
        {
            swal({
                title: "خطأ",
                text: "من فضلك ادخل باركود الصنف",
                icon: "error",
                button: "تاكيد",
            });
            return false;
        }
        // ++++++++ 2- "item barcode" is "required" ++++++++
        var name = $("#name").val();
        if( name == "")
        {
            swal({
                title: "خطأ",
                text: "من فضلك ادخل اسم الصنف",
                icon: "error",
                button: "تاكيد",
            });
            return false;
        }
        // ++++++++ 2- "item_type" is "required" ++++++++
        var item_type = $("#item_type").val();
        if( item_type == "")
        {
            swal({
                title: "خطأ",
                text: "من فضلك ادخل نوع الصنف",
                icon: "error",
                button: "تاكيد",
            });
            return false;
        }
        // ++++++++ 3- "inv_itemCard_category" is "required" ++++++++
        var inv_itemCard_category = $("#inv_itemCard_category_id").val();
        if( inv_itemCard_category == "")
        {
            swal({
                title: "خطأ",
                text: "من فضلك اختر فئة الصنف",
                icon: "error",
                button: "تاكيد",
            });
            return false;
        }
        // ++++++++ 4- "inv_uom_parent" is "required" ++++++++
        var inv_uom_parent = $("#inv_uom_parent_id").val();
        if( inv_uom_parent == "")
        {
            swal({
                title: "خطأ",
                text: "من فضلك اختر وحدة القياس الاب",
                icon: "error",
                button: "تاكيد",
            });
            return false;
        }
        // ++++++++ 4- "does_has_retail_unit" is "required" ++++++++
        var does_has_retail_unit = $("#does_has_retail_unit").val();
        if( does_has_retail_unit == "")
        {
            swal({
                title: "خطأ",
                text: "من فضلك اختر هل للصنف وحدة تجزئه",
                icon: "error",
                button: "تاكيد",
            });
            return false;
        }
        // ========== Validation on fields related to "retail" ==========
        // ========== الاسعار الخاصة بالوحدة الاساسية ==========
        if( does_has_retail_unit == 1)
        {
            // ++++++++ 5- retial_uom_id  is "required" : وحدة القياس التجزئه الابن بالنسبة للاب ++++++++
            var retial_uom_id = $("#retial_uom_id").val();
            if( retial_uom_id == "")
            {
                swal({
                    title: "خطأ",
                    text: "من فضلك اختر وحدة القياس التجزئه الابن بالنسبة للاب",
                    icon: "error",
                    button: "تاكيد",
                });
                return false;
            }
            // ++++++++ 6- retail_uom_to_uom is "required" : عدد وحدات التجزئه بالنسبة للاب ++++++++
            var retail_uom_to_uom = $("#retail_uom_to_uom").val();
            if( retail_uom_to_uom == "")
            {
                swal({
                    title: "خطأ",
                    text: "من فضلك ادخل عدد وحدات التجزئه بالنسبة للاب",
                    icon: "error",
                    button: "تاكيد",
                });
                return false;
            }
            // ++++++++ 7- price is "required" : السعر القطاعي بوحدة القياس الاساسية ++++++++
            var price = $("#price").val();
            if( price == "")
            {
                swal({
                    title: "خطأ",
                    text: "من فضلك ادخل السعر القطاعي بوحدة القياس الاساسية",
                    icon: "error",
                    button: "تاكيد",
                });
                return false;
            }
            // ++++++++ 8- nos_gomla_price is "required" : سعر النص جملة قطاعي مع الوحدة الاساسية ++++++++
            var nos_gomla_price = $("#nos_gomla_price").val();
            if( nos_gomla_price == "")
            {
                swal({
                    title: "خطأ",
                    text: "من فضلك ادخل سعر النص جملة قطاعي مع الوحدة الاساسية",
                    icon: "error",
                    button: "تاكيد",
                });
                return false;
            }
            // ++++++++ 9- gomla_price is "required" : سعر الجملة بوحدة القياس الاساسية ++++++++
            var gomla_price = $("#gomla_price").val();
            if( gomla_price == "")
            {
                swal({
                    title: "خطأ",
                    text: "من فضلك ادخل سعر الجملة بوحدة القياس الاساسية",
                    icon: "error",
                    button: "تاكيد",
                });
                return false;
            }
            // ++++++++ 10- cost_price is "required" : سعر تكلفة الشراء للصنف بوحدة القياس الاساسية ++++++++
            var cost_price = $("#cost_price").val();
            if( cost_price == "")
            {
                swal({
                    title: "خطأ",
                    text: "من فضلك ادخل سعر تكلفة الشراء للصنف بوحدة القياس الاساسية",
                    icon: "error",
                    button: "تاكيد",
                });
                return false;
            }
        }
        // ========== Validation on fields related to "retail" ==========
        // ========== الاسعار الخاصة بوحدة التجزئه ==========
        if( does_has_retail_unit == 1)
        {
            // ++++++++ 11- price_retail is "required" : السعر القطاعي بوحدة قياس التجزئه ++++++++
            var price_retail = $("#price_retail").val();
            if( price_retail == "")
            {
                swal({
                    title: "خطأ",
                    text: "من فضلك ادخل السعر القطاعي بوحدة قياس التجزئه",
                    icon: "error",
                    button: "تاكيد",
                });
                return false;
            }
            // ++++++++ 12- nos_gomla_price_retail is "required" : من فضلك ادخل سعر النص جملة قطاعي مع وحدة التجزئه ++++++++
            var nos_gomla_price_retail = $("#nos_gomla_price_retail").val();
            if( nos_gomla_price_retail == "")
            {
                swal({
                    title: "خطأ",
                    text: "من فضلك ادخل سعر النص جملة قطاعي مع وحدة التجزئه",
                    icon: "error",
                    button: "تاكيد",
                });
                return false;
            }
            // ++++++++ 13- gomla_price_retail is "required" : من فضلك ادخل سعر الجملة بوحدة قياس التجزئه ++++++++
            var gomla_price_retail = $("#gomla_price_retail").val();
            if( gomla_price_retail == "")
            {
                swal({
                    title: "خطأ",
                    text: "من فضلك ادخل سعر الجملة بوحدة قياس التجزئه",
                    icon: "error",
                    button: "تاكيد",
                });
                return false;
            }
            // ++++++++ 14- cost_price_retail is "required" : من فضلك ادخل سعر تكلفة الشراء للصنف بوحدة قياس التجزئه ++++++++
            var cost_price_retail = $("#cost_price_retail").val();
            if( cost_price_retail == "")
            {
                swal({
                    title: "خطأ",
                    text: "من فضلك ادخل سعر تكلفة الشراء للصنف بوحدة قياس التجزئه",
                    icon: "error",
                    button: "تاكيد",
                });
                return false;
            }

        }
        // ++++++++ 15- has_fixed_price is "required" : هل للصنف سعر ثابت ++++++++
        var has_fixed_price = $("#has_fixed_price").val();
        if( has_fixed_price == "")
        {
            swal({
                title: "خطأ",
                text: "من فضلك اختار هل للصنف سعر ثابت بالفواتير",
                icon: "error",
                button: "تاكيد",
            });
            return false;
        }
        // ++++++++ 16- active is "required" : الحالة ++++++++
        var active = $("#active").val();
        if( active == "")
        {
            swal({
                title: "خطأ",
                text: "من فضلك اختار حالة التفعيل",
                icon: "error",
                button: "تاكيد",
            });
            return false;
        }

    });

    // ++++++++++++++++++++++++++++++++++++ Search Filters +++++++++++++++++++++++++++++++++++
    // ---------------- search_by_text [inputField] : Search By "Name" or "Barcode" or "Code" : بحث [اسم - باركود - كود الصنف] ----------------
    $(document).on("input", "#search_by_text", function (e) {
        // call "search function"
        make_search();
    });
    // ---------------- search_by_text [radio button] : "Name" or "Barcode" or "Code" : بحث [اسم - باركود - كود الصنف] ----------------
    $(document).on("change", "input[type='radio'][name='search_by_text_radio']", function (e) {
        // call "search function"
        make_search();
    });
    // ---------------- Search By "item_type" : "بحث "نوع الصنف ----------------
    $(document).on("change", "#item_type_search", function (e) {
        // call "search function"
        make_search();
    });
    // ---------------- Search By "inv_itemCard_category_id_search" : "بحث "فئة الصنف ----------------
    $(document).on("change", "#inv_itemCard_category_id_search", function (e) {
        // call "search function"
        make_search();
    });
    // =============== Search Function ===============
    function make_search()
    {
        // Search By "Name" or "Barcode" or "Code"
        var search_by_text = $("#search_by_text").val();
        // [search_by_text] "radio button" value
        var search_by_text_radio = $("input[type='radio'][name='search_by_text_radio']:checked").val();
        // Search By "item_type"
        var item_type_search = $("#item_type_search").val();
        // Search By "inv_itemCard_category"
        var inv_itemCard_category_id_search = $("#inv_itemCard_category_id_search").val();
        // search token
        var token_search = $("#token_search").val();
        // search url
        var ajax_search_url = $("#ajax_search_url").val();
        // ajax request
        jQuery.ajax({
            url: ajax_search_url,
            type: "post",
            dataType: "html",
            cache: false,
            data:
            {   search_by_text:search_by_text , item_type_search:item_type_search , search_by_text_radio:search_by_text_radio ,
                inv_itemCard_category_id_search:inv_itemCard_category_id_search , _token:token_search
            },
            success: function (data)
            {
                console.log(data);
                $("#ajax_responce_serarchDiv").html(data);
            },
            error: function () {},
        });
    }
    // ++++++++++++++++++++++ Ajax Search Pagination ++++++++++++++++++++++++++
    // When click on "any link" in pagination , don't reload page
    $(document).on("click", "#ajax_pagination_in_search a ", function (e)
    {
        e.preventDefault();
        // Search By "Name" or "Barcode" or "Code"
        var search_by_text = $("#search_by_text").val();
        // Search By "item_type"
        var item_type_search = $("#item_type_search").val();
        // Search By "inv_itemCard_category"
        var inv_itemCard_category_id_search = $("#inv_itemCard_category_id_search").val();
        // search token
        var token_search = $("#token_search").val();
        var url = $(this).attr("href");
        // ajax request
        jQuery.ajax({
            url: url,
            type: "post",
            dataType: "html",
            cache: false,
            data:{search_by_text:search_by_text , item_type_search:item_type_search , inv_itemCard_category_id_search:inv_itemCard_category_id_search , _token:token_search},
            success: function (data) {
                $("#ajax_responce_serarchDiv").html(data);
            },
            error: function () {

            },
        });
    });
});
// ++++++++++++++++++++++++++++++++++++ Create "item_card" Form Validation +++++++++++++++++++++++++++++++++++
    // uom_id :  validation error للصفحة في حالة وجود reload الحفاظ علي قيمة"وحدة القياس الاب" داخل الاقواس في حدوث
    var uom_id = $("#inv_uom_parent_id").val();
    // ========== if select any option from "وحدة القياس الاب" selectbox , but the selected option inside ".parent_uom_name_span" span ==========
    if( uom_id != "" )
    {
        var uom_name = $("#inv_uom_parent_id option:selected").text();
        $(".parent_uom_name_span").text(uom_name);
    }
    // retial_uom_id :  validation error للصفحة في حالة وجود reload الحفاظ علي قيمة"وحدة القياس التجزئه الابن" داخل الاقواس في حدوث
    var retial_uom = $("#retial_uom_id").val();
    // ========== if select any option from "وحدة القياس التجزئه الابن بالنسبة للاب" selectbox , but the selected option inside ".child_uom_name_span" span ==========
    if( retial_uom != "" )
    {
        var retail_uom_to_uom_name = $("#retial_uom_id option:selected").text();
        $(".child_uom_name_span").text(retail_uom_to_uom_name);
    }



