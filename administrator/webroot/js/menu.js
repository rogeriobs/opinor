$(document).ready(function () {
    $("#scoop").scoopmenu({
        themelayout: 'vertical',
        verticalMenuplacement: 'left', // value should be left/right
        verticalMenulayout: 'wide', // value should be wide/box/widebox
        MenuTrigger: 'hover',
        SubMenuTrigger: 'click',
        activeMenuClass: 'active',
        ThemeBackgroundPattern: 'pattern1',
        HeaderBackground: 'theme2',
        LHeaderBackground: 'theme2',
        NavbarBackground: 'theme4',
        ActiveItemBackground: 'theme0',
        SubItemBackground: 'theme2',
        ActiveItemStyle: 'style0',
        ItemBorder: false,
        ItemBorderStyle: 'solid',
        SubItemBorder: true,
        DropDownIconStyle: 'style1', // Value should be style1,style2,style3
        FixedNavbarPosition: false,
        FixedHeaderPosition: false,
        collapseVerticalLeftHeader: true,
        VerticalSubMenuItemIconStyle: 'style6', // value should be style1,style2,style3,style4,style5,style6
        VerticalNavigationView: 'view3',
        verticalMenueffect: {
            desktop: "shrink",
            tablet: "overlay",
            phone: "overlay",
        },
        defaultVerticalMenu: {
            desktop: "collapsed", // value should be offcanvas/collapsed/expanded/compact/compact-acc/fullpage/ex-popover/sub-expanded
            tablet: "collapsed", // value should be offcanvas/collapsed/expanded/compact/fullpage/ex-popover/sub-expanded
            phone: "offcanvas", // value should be offcanvas/collapsed/expanded/compact/fullpage/ex-popover/sub-expanded
        },
        onToggleVerticalMenu: {
            desktop: "collapsed", // value should be offcanvas/collapsed/expanded/compact/fullpage/ex-popover/sub-expanded
            tablet: "collapsed", // value should be offcanvas/collapsed/expanded/compact/fullpage/ex-popover/sub-expanded
            phone: "collapsed", // value should be offcanvas/collapsed/expanded/compact/fullpage/ex-popover/sub-expanded
        },
    });
});