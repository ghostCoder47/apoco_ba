


function Updater() {
    
    this.update = function() {
        
        update();
    };
}


function btn_heute() {
    
    calendar.jumpToCurrentDay();
    redrawCalendarWidget();
}

function btn_prevDay() {
    
    calendar.prevDay();
    redrawCalendarWidget();
}

function btn_nextDay() {
    
    calendar.nextDay(); 
    redrawCalendarWidget();
}


function btn_tag() {
    
    calendar.resolutionModif(CALENDAR_RESOLUTION_MODIF.TAG); 
    try {
        
        enableHeute();
        
    } catch (ERROR){}
    try {
        
        enablePrevDay();
    } catch (ERROR) {}
    try {
                
        enableNextDay();
    } catch (ERROR) {}
    try {
                
        enableMahlzeiten();
    } catch (ERROR) {}
    redrawCalendarWidget();
}


function btn_woche() {
    
    calendar.resolutionModif(CALENDAR_RESOLUTION_MODIF.WOCHE);
    try {
        
        enableHeute();
        
    } catch (ERROR){}
    try {
        
        enablePrevDay();
    } catch (ERROR) {}
    try {
                
        enableNextDay();
    } catch (ERROR) {}
    try {
                
        enableMahlzeiten();
    } catch (ERROR) {}
    
    redrawCalendarWidget();
}


function btn_monat() {
    
    calendar.resolutionModif(CALENDAR_RESOLUTION_MODIF.MONAT); 
    try {
        
       enableMahlzeiten();
    } catch (ERROR){}
    
    disablePrevDay();
    disableNextDay();
    
    redrawCalendarWidget();
}


// function btn_therapiezeit() {
//     
    // btn_heute();
    // calendar.resolutionModif(CALENDAR_RESOLUTION_MODIF.THERAPIEZEIT); 
    // drawer.viewModif(VIEW_VALUES_MODIF.ALL);
    // disableHeute();
    // disablePrevDay();
    // disableNextDay();
    // disableMahlzeiten();
    // redrawCalendarWidget();
// }


function btn_rr_hf() {
    
    drawer.viewModif(VIEW_VALUES_MODIF.RR_HF); 
    redrawCalendarWidget();
}


function btn_kcal_kg() {
    
    drawer.viewModif(VIEW_VALUES_MODIF.KCAL_KG); 
    redrawCalendarWidget();
}


function btn_all() {
    
    drawer.viewModif(VIEW_VALUES_MODIF.ALL); 
    redrawCalendarWidget();
}


function btn_mahlzeiten() {
    
    drawer.viewModif(VIEW_VALUES_MODIF.MEAL);
    redrawCalendarWidget();       
}


function btn_opt_tageslimit() {
        
    drawer.changeViewTageslimit();
    redrawCalendarWidget();  
}


function btn_opt_wunschgewicht() {
    
    drawer.changeViewWunschgewicht();
    redrawCalendarWidget();  
}


function btn_prevMonth() {
    
    calendar.prevMonth(); 
    redrawCalendarWidget();
}


function btn_nextMonth() {
    
    calendar.nextMonth(); 
    redrawCalendarWidget();
}


function disableHeute() {
    
    var btn_heute = document.getElementById("btn_heute");
    var disable = document.createAttribute("disabled");
    btn_heute.setAttributeNode(disable);
}


function enableHeute() {
    
    var btn_heute = document.getElementById("btn_heute");
    var disable = btn_heute.getAttributeNode("disabled");
    if (null != disable) btn_heute.removeAttributeNode(disable);
}


function disablePrevDay() {
    
    var btn_prev = document.getElementById("btn_prev-day");
    var disable = document.createAttribute("disabled");  
    btn_prev.setAttributeNode(disable);  
}


function enablePrevDay() {
    
    var btn_prev = document.getElementById("btn_prev-day");
    var disable = btn_prev.getAttributeNode("disabled");
    if (null != disable) btn_prev.removeAttributeNode(disable);
}


function disableNextDay() {
    
    var btn_next = document.getElementById("btn_next-day");
    var disable = document.createAttribute("disabled");
    btn_next.setAttributeNode(disable);
}


function enableNextDay() {
    
    var btn_next = document.getElementById("btn_next-day");
    var disable = btn_next.getAttributeNode("disabled");
    if (null != disable) btn_next.removeAttributeNode(disable);
}


function disableMahlzeiten() {
    
    var btn_meal = document.getElementById("btn_mahlzeiten");
    var disable = document.createAttribute("disabled");
    btn_meal.setAttributeNode(disable);
}


function enableMahlzeiten() {
    
    var btn_meal = document.getElementById("btn_mahlzeiten");
    var disable = btn_meal.getAttributeNode("disabled");
    btn_meal.removeAttributeNode(disable);    
}


function btn_chng_goal_weight() {
    
    var wunschgewicht = prompt('Zielgewicht eingeben');
    if (wunschgewicht > 20) {
        
        var ajaxManager = new AjaxManager();                  
        var paramList = new KeyValueList();  
        var kv = new KeyValuePair("wunschgewicht", wunschgewicht);    
        paramList.addKeyValue(kv);
        kv = new KeyValuePair("user_id", drawer.getUserID());
        paramList.addKeyValue(kv);
        ajaxManager.insertWunschgewicht(new Updater(), paramList);       
        document.getElementById("pat_zielgewicht").innerHTML = wunschgewicht;
    }
    
    
    
}


function btn_chng_tageslimit() {
    
    var tageslimit = prompt('Tageslimit eingeben');
    if (tageslimit > 0) {
     
        var ajaxManager = new AjaxManager();                  
        var paramList = new KeyValueList();  
        var kv = new KeyValuePair("tageslimit", tageslimit);    
        paramList.addKeyValue(kv);
        kv = new KeyValuePair("user_id", drawer.getUserID());
        paramList.addKeyValue(kv);
        ajaxManager.insertTageslimit(new Updater(), paramList);
        document.getElementById("pat_tageslimit").innerHTML = tageslimit;
    }
}


function btn_detailansicht() {    
    
    pageChooser.changePage(PAGE_MODIF.PAT_DETAILS);    
    var btn_detailansicht = document.getElementById("btn_detailansicht");
    var display = document.createAttribute("style");
    display.nodeValue = "Display:none;";
    btn_detailansicht.setAttributeNode(display);
    drawer.performDrawing();
    show_navi_btns();
    show_footer_btns();
    show_calendar();
}


function btn_back() {
    
    btn_heute();
    btn_woche();
    
    hide_navi_btns();
    hide_footer_btns();
    hide_calendar();
    hide_patient_info();
    
    calendar.jumpToCurrentDay();    
    pageChooser.changePage(PAGE_MODIF.PAT_LISTE);
    var btn_detailansicht = document.getElementById("btn_detailansicht");
    var display = btn_detailansicht.getAttributeNode("style");
    btn_detailansicht.removeAttributeNode(display);
    drawer.setDrawModif(DRAW_MODIF.PAT_VIEW);
    drawer.performDrawing();
}

function update() {
    
    drawer.setDrawModif(DRAW_MODIF.PAT_VIEW);
    drawer.performDrawing();    
}


function show_navi_btns() {
    
    var navi_btns = document.getElementById("head-navigation-buttons");
    var style = navi_btns.getAttributeNode("style");
    if (null != style) navi_btns.removeAttributeNode(style);
}

function hide_navi_btns() {
    
    var navi_btns = document.getElementById("head-navigation-buttons");
    var style = document.createAttribute("style");
    style.nodeValue = "Display: none;";
    if (null != style) navi_btns.setAttributeNode(style);
}

function show_footer_btns() {
    
    var footer_btns = document.getElementById("footer_buttons");
    var style = footer_btns.getAttributeNode("style");
    footer_btns.removeAttributeNode(style);
}

function hide_footer_btns() {
    
    var footer_btns = document.getElementById("footer_buttons");
    footer_btns.setAttribute("style", "Display: none;");
    // var style = document.createAttribute("style");
    // style.nodeValue = "Display: none;";
    // footer_btns.setAttributeNode(style);
}


function show_calendar() {
    
    var calendar = document.getElementById("calender-holder");
    var style = calendar.getAttributeNode("style");
    if (null != style) calendar.removeAttributeNode(style);
}


function hide_calendar() {
    
    var calendar = document.getElementById("calender-holder");
    var style = document.createAttribute("style");
    style.nodeValue = "Display: none;";
    calendar.setAttributeNode(style);
}


function hide_patient_info() {
    
    var patient_info = document.getElementById("patient_info");
    var style = document.createAttribute("style");
    style.nodeValue = "Display: none;";
    patient_info.setAttributeNode(style);
}


function show_patient_info() {
    
    var patient_info = document.getElementById("patient_info");
    var style = patient_info.getAttributeNode("style");
    if (null != style) patient_info.removeAttributeNode(style);
}


function buttonInit() {
    
    hide_footer_btns();
    hide_navi_btns();    
    hide_calendar();
    hide_patient_info();
        
    document.getElementById("btn_heute").onclick                = btn_heute; 
    document.getElementById("btn_prev-day").onclick             = btn_prevDay; 
    document.getElementById("btn_next-day").onclick             = btn_nextDay; 
    document.getElementById("btn_tag").onclick                  = btn_tag; 
    document.getElementById("btn_woche").onclick                = btn_woche; 
    document.getElementById("btn_monat").onclick                = btn_monat; 
    // document.getElementById("btn_therapiezeit").onclick     = btn_therapiezeit; 
    document.getElementById("btn_rr-hf").onclick                = btn_rr_hf; 
    document.getElementById("btn_kcal-kg").onclick              = btn_kcal_kg; 
    document.getElementById("btn_all").onclick                  = btn_all; 
    document.getElementById("btn_mahlzeiten").onclick           = btn_mahlzeiten;
    document.getElementById("btn_prev-month").onclick           = btn_prevMonth;
    document.getElementById("btn_next-month").onclick           = btn_nextMonth;
    document.getElementById("btn_chng-goal-weight").onclick        = btn_chng_goal_weight;
    document.getElementById("btn_chng-tageslimit").onclick      = btn_chng_tageslimit;
    document.getElementById("btn_detailansicht").onclick        = btn_detailansicht;
    document.getElementById("btn_back").onclick                 = btn_back;
    document.getElementById("btn_opt_tageslimit").onclick       = btn_opt_tageslimit;
    document.getElementById("btn_opt_wunschgewicht").onclick    = btn_opt_wunschgewicht;
}


