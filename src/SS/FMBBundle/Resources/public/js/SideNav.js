$(document).ready(function () {
    /**
     *  init sidenavi
     *  first param String direction left or right
     *  second param conf Object css data
     **/
    SideNavi.init('right', {
        container: '#sideNavi',
        defaultitem: '.side-navi-item-default',
        item: '.side-navi-item',
        data: '.side-navi-data',
        tab: '.side-navi-tab',
        active: '.active'
    });
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    });
});