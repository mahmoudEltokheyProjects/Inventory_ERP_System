// $(document).ready(function() {
//     // ++++++++++++++++++ When Click on Button with id="update_image" ++++++++++++++++++
//     $("#update_image").on('click', function(e){
//         // Prevent Form Submission
//         e.preventDefault();
//         // To Prevent Repeating of Adding "upload file" button more than once
//         if( $("#update_image").length )
//         {
//             // Add "upload File" inputField inside div with id="oldImage"
//             $("#oldImage").html(`<input onchange="readURL(this)" type="file" name="photo" id="photo" />`);
//             // Hide "button" with id="update_image"
//             $("#update_image").hide();
//             // Show "button" with id="cancel_update_image"
//             $("#cancel_update_image").show();
//         }
//     });
//     // ++++++++++++++++++ When Click on Button with id="cancel_update_image" ++++++++++++++++++
//     $("#cancel_update_image").on('click', function(e){
//         // Prevent Form Submission
//         e.preventDefault();
//         // Add "upload File" inputField inside div with id="oldImage"
//         $("#oldImage").html('');
//         // Show "button" with id="update_image"
//         $("#update_image").show();
//         // Hide "button" with id="cancel_update_image"
//         $("#cancel_update_image").hide();
//     });

// });
// // ++++++++++++++++++++++++++++++++++++++ readURL() : get src of uploaded image ++++++++++++++++++++++++++++++++++++++
// function readURL(input)
// {
//     if( input.files && input.files[0] )
//     {
//         var reader = new FileReader();
//         reader.onload = function(e)
//         {
//             $("#uploadedimg").attr('src',e.target.result);
//         }
//         reader.readAsDataURL(input.files[0]);
//     }
// }

$(document).ready(function()
{
    // +++++++++++++++++++++++++++++++ handleUpdateClick() +++++++++++++++++++++++++++++++
    // Function to handle click on "Update" button
    function handleUpdateClick(updateBtnId, cancelBtnId, oldElementId,elementType)
    {
        // Add "upload File" inputField inside div with id=oldElementId
        $(`#${oldElementId}`).html(`<input onchange="readURL(this,'${elementType}')" type="file" name="${elementType}" id="${elementType}_input" />`);
        // Hide "button" with id=updateBtnId
        $(`#${updateBtnId}`).hide();
        // Show "button" with id=cancelBtnId
        $(`#${cancelBtnId}`).show();
    }
    // +++++++++++++++++++++++++++++++ handleCancelUpdateClick() +++++++++++++++++++++++++++++++
    // Function to handle click on "Cancel Update" button
    function handleCancelUpdateClick(updateBtnId, cancelBtnId, oldElementId)
    {
        // Clear content inside div with id=oldElementId
        $(`#${oldElementId}`).html('');
        // Show "button" with id=updateBtnId
        $(`#${updateBtnId}`).show();
        // Hide "button" with id=cancelBtnId
        $(`#${cancelBtnId}`).hide();
    }
    // +++++++++++++++++++++++++++++++ Toggle "Upload Photo" +++++++++++++++++++++++++++++++
    // "Update Image" button
    $("#update_image").on('click', function(e)
    {
        e.preventDefault();
        handleUpdateClick('update_image', 'cancel_update_image', 'oldImage','photo');
    });
    // +++++++++++++++++++++++++++++++ Cancel "Upload Photo" +++++++++++++++++++++++++++++++
    // "Cancel Update Image" button
    $("#cancel_update_image").on('click', function(e)
    {
        e.preventDefault();
        handleCancelUpdateClick('update_image', 'cancel_update_image', 'oldImage');
    });
    // +++++++++++++++++++++++++++++++ Toggle "Upload Logo" +++++++++++++++++++++++++++++++
    // "Update Logo" button
    $("#update_logo").on('click', function(e)
    {
        e.preventDefault();
        handleUpdateClick('update_logo', 'cancel_update_logo', 'oldLogo','logo');
    });
    // +++++++++++++++++++++++++++++++ Cancel "Upload Logo" +++++++++++++++++++++++++++++++
    // "Cancel Update Logo" button
    $("#cancel_update_logo").on('click', function(e)
    {
        e.preventDefault();
        handleCancelUpdateClick('update_logo', 'cancel_update_logo', 'oldLogo');
    });

});
// +++++++++++++++++++++++++++++++ readURL() +++++++++++++++++++++++++++++++
// Function to read the URL of the uploaded image and display it ,  get src of uploaded image
function readURL(input,elementType)
{
    if (input.files && input.files[0])
    {
        var reader = new FileReader();
        reader.onload = function(e)
        {
            $(`#${elementType}`).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
