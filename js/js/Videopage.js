$(document).on('click', '#close-preview', function(){ 
    $('.-preview').popover('hide');
    // Hover befor close the preview
    $('.video-preview').hover(
        function () {
           $('.video-preview').popover('show');
        }, 
         function () {
           $('.video-preview').popover('hide');
        }
    );    
});

$(function() {
    // Create the close button
    var closebtn = $('<button/>', {
        type:"button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;',
    });
    closebtn.attr("class","close pull-right");
    // Set the popover default content
    $('.video-preview').popover({
        trigger:'manual',
        html:true,
        title: "<strong>Preview</strong>"+$(closebtn)[0].outerHTML,
        content: "There's no video",
        placement:'bottom'
    });
    // Clear event
    $('.video-preview-clear').click(function(){
        $('.video-preview').attr("data-content","").popover('hide');
        $('.video-preview-filename').val("");
        $('.video-preview-clear').hide();
        $('.video-preview-input input:file').val("");
        $(".video-preview-input-title").text("Browse"); 
    }); 
    // Create the preview video
    $(".video-preview-input input:file").change(function (){     
        /*var img = $('<img/>', {
            id: 'dynamic',
            width:250,
            height:200
        });  */    
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview video into the popover data-content
        reader.onload = function (e) {
            $(".video-preview-input-title").text("Change");
            $(".video-preview-clear").show();
            $(".video-preview-filename").val(file.name);            
            //img.attr('src', e.target.result);
            //$(".video-preview").attr("data-content",$(img)[0].outerHTML).popover("show");
        }        
        reader.readAsDataURL(file);
    });  
});