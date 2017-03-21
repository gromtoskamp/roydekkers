jQuery(document).ready(function() {
    tb_show('Reiki Companion', '#TB_inline?width=600&height=430&inlineId=reiki_homepage');
    jQuery('#TB_closeWindowButton').hide();
    jQuery('#TB_window').css({
        'z-index': '5000001',
        'height': '460px'
    })
    jQuery('#TB_overlay').css({
        'z-index': '5000000'
    })
})