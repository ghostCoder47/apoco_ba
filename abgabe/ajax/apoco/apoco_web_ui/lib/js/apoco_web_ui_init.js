
function buildCalenerTable() {
    
    
    var calendar_holder = document.getElementById("calender-holder");      
    // calendar_holder.innerHTML = "";
          
    var tbody = document.createElement("tbody");
        
    var table = document.createElement("table");
    
    var table_class = document.createAttribute("class");
    table_class.nodeValue = "calendar-table";
    table.setAttributeNode(table_class);
        
    var bodyRow = document.createElement("tr");
    var bodyRow_class = document.createAttribute("class");
    bodyRow_class.nodeValue = "calendar-date-row";
    bodyRow.setAttributeNode(bodyRow_class);
        
    var prevMonth = document.createElement("th");
    var prevButton = document.createElement("button");
    var prevButton_id = document.createAttribute("id");
    prevButton_id.nodeValue = "btn_prev-month";
    var prevButton_class = document.createAttribute("class");
    prevButton_class.nodeValue = "calender-button";
    prevButton.textContent = "<";
    prevButton.setAttributeNode(prevButton_id);
    prevButton.setAttributeNode(prevButton_class);
    prevMonth.appendChild(prevButton);
        
        
        
    var monthHead = document.createElement("th");
    monthHead.colSpan = "5";
    var monthHead_id = document.createAttribute("id");
    monthHead_id.nodeValue = "month_date";
    
    monthHead.setAttributeNode(monthHead_id);
    
        
        
    var nextMonth = document.createElement("th");
    var nextButton = document.createElement("button");
    var nextButton_id = document.createAttribute("id");
    nextButton_id.nodeValue = "btn_next-month";
    var nextButton_class = document.createAttribute("class");
    nextButton_class.nodeValue = "calender-button";
    nextButton.textContent = ">";
    nextButton.setAttributeNode(nextButton_id);
    nextButton.setAttributeNode(nextButton_class);
    nextMonth.appendChild(nextButton);
    
       
       
        
    var calendarHeader = document.createElement("tr");
    var calendarHeader_class = document.createAttribute("class");
    calendarHeader_class.nodeValue = "calendar-header";
    calendarHeader.setAttributeNode(calendarHeader_class);
    
   
    var mo = document.createElement("td");
    mo.textContent = "Mo";
    var mo_class = document.createAttribute("class");    
    mo_class.nodeValue = "calendar-header-day";
    mo.setAttributeNode(mo_class);
    
    var di = document.createElement("td");
    di.textContent = "Di";
    var di_class = document.createAttribute("class");
    di_class.nodeValue = "calendar-header-day";
    di.setAttributeNode(di_class);
    
    var mi = document.createElement("td");
    mi.textContent = "Mi";
    var mi_class = document.createAttribute("class");
    mi_class.nodeValue = "calendar-header-day";
    mi.setAttributeNode(mi_class);
    
    var don = document.createElement("td");
    don.textContent = "Do";
    var don_class = document.createAttribute("class");
    don_class.nodeValue = "calendar-header-day";
    don.setAttributeNode(don_class);
    
    var fr = document.createElement("td");
    fr.textContent = "Fr";
    var fr_class = document.createAttribute("class");
    fr_class.nodeValue = "calendar-header-day";
    fr.setAttributeNode(fr_class);
    
    var sa = document.createElement("td");
    sa.textContent = "Sa";
    var sa_class = document.createAttribute("class");
    sa_class.nodeValue = "calendar-header-day";
    sa.setAttributeNode(sa_class);
    
    var so = document.createElement("td");
    so.textContent = "So";
    var so_class = document.createAttribute("class");
    so_class.nodeValue = "calendar-header-day";
    so.setAttributeNode(so_class);
    
    calendarHeader.appendChild(mo);
    calendarHeader.appendChild(di);
    calendarHeader.appendChild(mi);
    calendarHeader.appendChild(don);
    calendarHeader.appendChild(fr);
    calendarHeader.appendChild(sa);
    calendarHeader.appendChild(so);
    
                                  
                                  
    bodyRow.appendChild(prevMonth);
    bodyRow.appendChild(monthHead);
    bodyRow.appendChild(nextMonth);
    tbody.appendChild(bodyRow);
    tbody.appendChild(calendarHeader);     
     
                                    
    for(var row = 0; row < 6; row++) {
            
        var calRow = document.createElement("tr");
        var calRow_class = document.createAttribute("class");
        var calRow_id = document.createAttribute("id");
        calRow_class.nodeValue = "calendar-row";
        calRow_id.nodeValue = "calRow_" + row;
        calRow.setAttributeNode(calRow_class);
        calRow.setAttributeNode(calRow_id);
         
        for (var col = 0; col < 7; col++) {
                
            var calDay = document.createElement("td");
            var calDay_class = document.createAttribute("class");  
            calDay.setAttributeNode(calDay_class);
            calRow.appendChild(calDay);
        }
        tbody.appendChild(calRow);  
    }    
        
    table.appendChild(tbody);        
    calendar_holder.appendChild(table);   
    redrawCalendarWidget();     
    // drawGraph();
           
}

function redrawCalendarWidget() {      
   
    
    var monthHead = document.getElementById("month_date");
    monthHead.innerHTML = calendar.getMonthName(calendar.viewedMonthStart.getMonth()) + " " + calendar.viewedMonthStart.getFullYear();
                 
    for(var row = 0; row < 6; row++) {
            
        var calRow = document.getElementById("calRow_" + row);
        calRow.innerHTML = "";
   
        for (var col = 0; col < 7; col++) {
                
            var calDay = document.createElement("td");
            var calDay_class = document.createAttribute("class");                
                
            if (calendar.drawMatrix[row][col][CMZ.ONMONTH]) {
                    
                calDay_class.nodeValue = "calendar-day-onmonth";
            } else {
                    
                calDay_class.nodeValue = "calendar-day-offmonth";
            }
                            
            if (calendar.drawMatrix[row][col][CMZ.MARKED]) {                
                    
                calDay_class.nodeValue = calDay_class.nodeValue + " " + "calendar-day-marked";
            } 
                           
            if (calendar.drawMatrix[row][col][CMZ.CURRENT_DAY]) {
                    
                calDay_class.nodeValue = calDay_class.nodeValue + " " + "calendar-day-today";
            }  
            calDay.setAttributeNode(calDay_class);
                
                            
            calDay.innerHTML =  "<span>" + calendar.drawMatrix[row][col][CMZ.DAY_NUMBER] + "</span>";                            
            calDay.datum        = new Date(calendar.drawMatrix[row][col][CMZ.DATUM]);  
            calDay.calendar = calendar;
                            
            calDay.onclick = function() {                
                    
                calendar.lastMarkedDate = new Date(calendar.markedDate);
                calendar.markedDate = new Date(this.datum);
                    
                loop1:
                for (var row = 0; row < 6; row++) {
                          
                    for ( var col = 0; col < 7; col++) {            
                       
                        if (calendar.drawMatrix[row][col][CMZ.DATUM].getTime() == calendar.markedDate.getTime()) {
                           
                            for (var i = 0; i < 7; i++) {
                 
                                calendar.markedWeek[i] = new Date(calendar.drawMatrix[row][i][CMZ.DATUM].getTime()); 
                            }
                            break loop1;
                        }
                    }
                }                    
    
                this.calendar.recalculate();   
                redrawCalendarWidget();
            };
                          
            calRow.appendChild(calDay);
        }            
    } 
    displayCurrentDate();
    drawer.performDrawing();
}


function displayCurrentDate() {
    
    var currentDateText = document.getElementById("currentDate");
    
    switch (calendar.calendarResolutionModif) {
        
        case CALENDAR_RESOLUTION_MODIF.TAG:
            
            currentDateText.innerHTML = calendar.getDayName(calendar.markedDate.getDay()) 
            + " " 
            + calendar.markedDate.getDate() 
            + ". " 
            + calendar.getMonthName(calendar.markedDate.getMonth()) 
            + "  " 
            + calendar.markedDate.getFullYear();
        break;
        
        
        case CALENDAR_RESOLUTION_MODIF.WOCHE:
            
            currentDateText.innerHTML = calendar.markedWeek[0].getDate() 
            + ". " 
            + (calendar.markedWeek[0].getMonth() == calendar.markedWeek[6].getMonth() ? " - " : calendar.getMonthName(calendar.markedWeek[0].getMonth()) 
            + (calendar.markedWeek[0].getFullYear() == calendar.markedWeek[6].getFullYear() ? "" : " " + calendar.markedWeek[0].getFullYear()) + " - ")
            + calendar.markedWeek[6].getDate() 
            + ". " 
            + calendar.getMonthName(calendar.markedWeek[6].getMonth()) 
            + "  " 
            + calendar.markedWeek[6].getFullYear();
        
        break;
        
                
        case CALENDAR_RESOLUTION_MODIF.MONAT:
            
            currentDateText.innerHTML = calendar.getMonthName(calendar.viewedMonthStart.getMonth())
            + " " 
            + calendar.viewedMonthStart.getFullYear();
        
        break;
        
        
        case CALENDAR_RESOLUTION_MODIF.THERAPIEZEIT:
        
            currentDateText.innerHTML = "THERAPIEZEIT";
            
        break;
        
    }
}

/*
function drawGraph() {
        
        var draw_holder = document.getElementById("draw-holder"); 
        
        draw_holder.innerHTML = "";
        
        
        switch (calendar.calendarResolutionModif) {
            
            
            case CALENDAR_RESOLUTION_MODIF.TAG:
            
                var inhalt = "";        
                switch (calendar.viewValuesModif) {
                
                case VIEW_VALUES_MODIF.ALL:
                
                    inhalt = "ALL</br>";
                    inhalt += calendar.markedDate.getFullYear() + "-" + (calendar.markedDate.getMonth() + 1) + "-" + calendar.markedDate.getDate();                                   
                    break;
                
                
                case VIEW_VALUES_MODIF.RR_HF:
                
                    inhalt = "RR_HF</br>";
                    inhalt += calendar.markedDate.getFullYear() + "-" + (calendar.markedDate.getMonth() + 1) + "-" + calendar.markedDate.getDate();                       
                    break;
                
                
                case VIEW_VALUES_MODIF.KCAL_KG:
                
                    inhalt = "KCAL_KG</br>";
                    inhalt += calendar.markedDate.getFullYear() + "-" + (calendar.markedDate.getMonth() + 1) + "-" + calendar.markedDate.getDate();
                    break;
                
                
                case VIEW_VALUES_MODIF.MEAL:
                
                    inhalt = "MEAL</br>";
                    inhalt += calendar.markedDate.getFullYear() + "-" + (calendar.markedDate.getMonth() + 1) + "-" + calendar.markedDate.getDate();
                    break;
            }     
            draw_holder.innerHTML = inhalt;
            break;
            
            
            case CALENDAR_RESOLUTION_MODIF.WOCHE:
            
            var inhalt = "";        
            switch (calendar.viewValuesModif) {
                
                case VIEW_VALUES_MODIF.ALL:
                
                    inhalt = "ALL</br>";
                    for (var i = 0; i<7; i++) {
                            
                        inhalt += " " + calendar.markedWeek[i].getFullYear() + "-" + (calendar.markedWeek[i].getMonth() + 1) + "-" + calendar.markedWeek[i].getDate() + "</br>";    
                    }     
                    break;
                
                
                case VIEW_VALUES_MODIF.RR_HF:
                    
                    inhalt = "RR_HF</br>";
                    for (var i = 0; i<7; i++) {
                            
                        inhalt += " " + calendar.markedWeek[i].getFullYear() + "-" + (calendar.markedWeek[i].getMonth() + 1) + "-" + calendar.markedWeek[i].getDate() + "</br>";    
                    } 
                    break;
                
                
                case VIEW_VALUES_MODIF.KCAL_KG:
                    
                    inhalt = "KCAL_KG</br>";
                    for (var i = 0; i<7; i++) {
                            
                        inhalt += " " + calendar.markedWeek[i].getFullYear() + "-" + (calendar.markedWeek[i].getMonth() + 1) + "-" + calendar.markedWeek[i].getDate() + "</br>";    
                    } 
                    break;
                    
                    
                case VIEW_VALUES_MODIF.MEAL:
                    
                    inhalt = "MEAL</br>";
                    for (var i = 0; i<7; i++) {
                            
                        inhalt += " " + calendar.markedWeek[i].getFullYear() + "-" + (calendar.markedWeek[i].getMonth() + 1) + "-" + calendar.markedWeek[i].getDate() + "</br>";    
                    } 
                    break;
            }        
                 
            draw_holder.innerHTML = inhalt;
            break;
            
            
            case CALENDAR_RESOLUTION_MODIF.MONAT:
            
                var inhalt = "";        
                switch (calendar.viewValuesModif) {
                    
                    case VIEW_VALUES_MODIF.ALL:                    
                        
                        inhalt = "ALL</br>";
                        inhalt += " " + calendar.viewedMonthStart.getFullYear() + "-" + (calendar.viewedMonthStart.getMonth() + 1) + "-" + calendar.viewedMonthStart.getDate() + "</br>";                            
                        break;
                    
                    
                    case VIEW_VALUES_MODIF.RR_HF:
                        
                        inhalt = "RR_HF</br>";
                        inhalt += " " + calendar.viewedMonthStart.getFullYear() + "-" + (calendar.viewedMonthStart.getMonth() + 1) + "-" + calendar.viewedMonthStart.getDate() + "</br>";                            
                        break;                
                    
                    
                    case VIEW_VALUES_MODIF.KCAL_KG:
                        
                        inhalt = "KCAL_KG</br>";
                        inhalt += " " + calendar.viewedMonthStart.getFullYear() + "-" + (calendar.viewedMonthStart.getMonth() + 1) + "-" + calendar.viewedMonthStart.getDate() + "</br>";                            
                        break;
                        
                        
                    case VIEW_VALUES_MODIF.MEAL:
                        
                        inhalt = "MEAL</br>";
                        inhalt += " " + calendar.viewedMonthStart.getFullYear() + "-" + (calendar.viewedMonthStart.getMonth() + 1) + "-" + calendar.viewedMonthStart.getDate() + "</br>";                            
                        break;
                }    
                                 
            draw_holder.innerHTML = inhalt;
            break;
            
            
            case CALENDAR_RESOLUTION_MODIF.THERAPIEZEIT:
            
                var inhalt = "";        
                switch (calendar.viewValuesModif) {
                    
                    case VIEW_VALUES_MODIF.ALL:
                        
                        inhalt = "ALL</br>";
                        inhalt += "THERAPIEZEIT";                            
                        break;
                    
                    
                    case VIEW_VALUES_MODIF.RR_HF:
                        
                        inhalt = "RR_HF</br>";
                        inhalt += "THERAPIEZEIT";                            
                        break;
                    
                    
                    case VIEW_VALUES_MODIF.KCAL_KG:
                        
                        inhalt = "KCAL_KG</br>";
                        inhalt += "THERAPIEZEIT";                            
                        break;
                        
                        
                    case VIEW_VALUES_MODIF.MEAL:
                        
                        inhalt = "MEAL</br>";
                        inhalt += "THERAPIEZEIT";                            
                        break;
                }        
                 
            draw_holder.innerHTML = inhalt;
            break;
        }     
    }

*/


function init() {
    
    calendar = new Calendar();    
    pageChooser = new PageChooser();
    drawer = new Drawer(calendar, pageChooser);  
    buildCalenerTable();   
    buttonInit();
}

window.onload=init();