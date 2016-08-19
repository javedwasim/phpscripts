function show_message_box(id, text) {
    $("#msg_box_" + id).fadeIn(3000);
    $("#msg_err_" + id).html(text);
}

function hide_message_box(id) {
    $("#msg_box_" + id).hide();
}
function redirect_to(page) {
    setTimeout(function() {
        window.location = page;
    }, 4000);
}
function hide_div(id) {
    $(id).hide();
}
function show_div(id) {
    $(id).fadeIn(3000);
}
function success_message(id, msg) {
    $("#successmsgBx_" + id).fadeIn(3000);
    $("#msg_suc" + id).html(msg);
}
function show_loader(id) {
    return show_div("#spinner_" + id);
}
function hide_loader(id) {
    return hide_div("#spinner_" + id);
}
function FieldVal(id) {
    return document.getElementById(id).value;
}
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}
function add_error_cls(id) {
    return $(id).addClass("error");
}
function CreateSlideShow() {
    if (FieldVal('slideshow_title') === "" || FieldVal('slideshow_title') == 0) {
        show_message_box(1, 'Please enter slide show title!');
        $('#slideshow_title').focus();
        return false;
    }
    if (FieldVal('numberofslides') === "" || FieldVal('numberofslides') == 0) {
        show_message_box(1, 'Please enter number of slides');
        $('#numberofslides').focus();
        return false;
    }
    show_loader(1);
    hide_message_box(1);
    var querystring = $("#slideshowFrm").serialize();
    setTimeout(function() {
        $.ajax({
            type: 'POST',
            data: querystring,
            url: 'slides.php',
            success: function(resp) {
                hide_loader(1);
                $("#accordion").fadeTo("slow", 1);
                $("#accordion").html(resp);


            },
            error: function(resp) {
            }
        });
    }, 2000);
}

function fileupload(val) {
    document.getElementById("slidePicture_" + val).onchange = function() {
        var _validFileExtensions = [".jpg", ".jpeg", ".gif", ".png"];
        var sFileName = this.files[0].name;
        if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() === sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }
            if (!blnValid) {
                var msg = "Sorry, " + sFileName + " is invalid, allowed extensions are: " + _validFileExtensions.join(", ");
                show_div("#img_err_box_" + val);
                $("#img_err_" + val).html(msg);
                return false;
            }
        }
        hide_div("#img_err_box_" + val)// hid error div
        document.getElementById("uploadFile" + val).value = URL.createObjectURL(this.files[0]);
        var imagepath = URL.createObjectURL(this.files[0]);
        $('#my_image' + val).attr('src', imagepath);
        $('#my_image_link' + val).attr('href', imagepath);
        $('#slidepicdiv' + val).css('display', 'block');
    };
}
function saveSlide(numberofslides) {
    //alert(numberofslides);
    for (var i = 1; i <= numberofslides; i++) {
        if (FieldVal('slideTitle_' + i) === "") {
            show_message_box(2, 'Please enter title for slide ' + i + ' !');
            add_error_cls('#slideTitle_' + i);
            if (i > 1) {
                setTimeout(function() {
                    $('#slide_ancher_' + i).trigger("click");
                }, 2000);
            }
            return false;
        }
        if (FieldVal('slideContent_' + i) === "") {
            show_message_box(2, 'Please enter content for slide ' + i + '');
            add_error_cls('#slideContent_' + i);
            return false;
        }
        if (FieldVal('slidePicture_' + i) === "") {
            show_message_box(2, 'Please upload picture for slide ' + i + '!');
            add_error_cls('#slidePicture_' + i);
            return false;
        }
    }
    show_loader(2);
    hide_message_box(2);
    $('#save_slides_btn').prop('disabled', true);
    $('#save_slideshow_btn').prop('disabled', true);
    $("#existing_slide").css("opacity", 0.3);
    setTimeout(function() {
        $("#slides_frm").ajaxForm({target: '#ResponseBox'}).submit();
        hide_loader(2);
        $('#save_slides_btn').prop('disabled', false);
        $('#save_slideshow_btn').prop('disabled', false);
        update_existing_slide_view();
       }, 2000);

}
function update_existing_slide_view(){
         $.ajax({
            type: 'POST',
            data: {update_existing_slide_view:'update_existing_slide_view'},
            url: 'ajax.php',
            success: function(resp) {
                 $("#existing_slide").fadeTo("slow", 1);
             $('#existing_slide').html(resp)
            },
            error: function(resp) {
            }
        });
    
}
function SearchMember() {
    //alert("Test");
    show_div("#search_laoder");
    //hide_div("#membersBox");
    $("#membersBox").css("opacity", 0.3);
    //return false;
    var querystring = $("#search_member").serialize();
    setTimeout(function() {
        $.ajax({
            type: 'POST',
            data: querystring,
            url: 'ajax.php',
            success: function(resp) {
                //console.log(resp);

                hide_div("#search_laoder");
                //$("#membersBox").css( "opacity",1 );
                $("#membersBox").fadeTo("slow", 1);
                $("#membersBox").html(resp);


            },
            error: function(resp) {
            }
        });
    }, 2000);
}