

$(document).ready(function() {
    if ($(".ipPluginSimpleSlideshowImages").children().length == 0) {
        return;
    }
    
    var options = $(".ipPluginSimpleSlideshowImages").data('options');
    $(".ipPluginSimpleSlideshowImages").cycle(options);

    $('.ipPluginSimpleSlideshowImages').show();
    $(".ipPluginSimpleSlideshowTabs").show();

});
