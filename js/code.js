$(document).ready(function(){
    $("#catdown").each(function(){
        var popup=$(this).find(".module-catalog");
        if(popup)

        {
            $(this).hover(function(){
                popup.show();
            },function(){
                popup.hide();
            });
        }
    });
$(".writecontact").click(function(){
    $("#commentid").addClass("comne");
});
$(".link-send-contact").click(function(){
    $("#commentid").addClass("comne");
});
$("#close").click(function(){
    $("#popup").addClass("close");
});
$(".close_bottom").click(function(){
    $("#popup_bottom").addClass("close");
    $(".close_bottom").addClass("close");
    $(".close_buttom").removeClass("close");
});
$(".close_buttom").click(function(){
    $("#popup_bottom").removeClass("close");
    $(".close_buttom").addClass("close");
    $(".close_bottom").removeClass("close");
});
$(".buttton_close").click(function(){
    $("#an").addClass("close");
    $("#hien").removeClass("close");
    $(".module-regis_email h3").addClass("close");
    $(".buttton_block").removeClass("close");
    $(".buttton_close").addClass("close");
});
$(".buttton_block").click(function(){
    $("#an").removeClass("close");
    $("#hien").addClass("close");
    $(".module-regis_email h3").removeClass("close");
    $(".buttton_block").addClass("close");
    $(".buttton_close").removeClass("close");
});
$("#closeButton").click(function(){
    $("#commentid").removeClass("comne");
});
$(".hiencom").click(function(){
    $("#con-detail").addClass("comne");
});
$("#closeDetailButton").click(function(){
    $("#con-detail").removeClass("comne");
});
$("ul.catalogtop li").each(function(){
    var popup=$(this).find(".subcatalog");
    if(popup)

    {
        $(this).hover(function(){
            popup.show();
        },function(){
            popup.hide();
        });
    }
});
$("ul.subcatalog li").each(function(){
    var popup=$(this).find(".subcatalog-2");
    if(popup)

    {
        $(this).hover(function(){
            popup.show();
        },function(){
            popup.hide();
        });
    }
});
$("#member").each(function(){
    var popup=$(this).find(".update_login");
    if(popup)

    {
        $(this).hover(function(){
            popup.show();
        },function(){
            popup.hide();
        });
    }
});
});