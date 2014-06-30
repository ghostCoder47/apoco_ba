
var VIEW_VALUES_MODIF = Object.freeze( {
    
    "RR_HF":0,
    "KCAL_KG":1,
    "ALL":2,
    "MEAL":3
});


var DRAW_MODIF = Object.freeze( {
    
       "PAT_VIEW":0, 
       "GRAPH":1,
       "MEAL":2,
       "PAT_PREVIEW":3
});


function Drawer(calendar, pageChooser) {
    
    
    this.viewValuesModif = VIEW_VALUES_MODIF.ALL;    
    var json;
    var draw = DRAW_MODIF.PAT_VIEW;
    var page = pageChooser;
    var resolution = calendar;
    var user_id;
    var datum;
    var res;
    var tageslimit = true;
    var wunschgewicht = true;
    
    this.changeViewTageslimit = function() {
                
        tageslimit = !tageslimit;
        if (tageslimit) {
            
            var btn = document.getElementById("btn_opt_tageslimit");
            btn.textContent = "Tageslimit : on";
        } else {
            
            var btn = document.getElementById("btn_opt_tageslimit");
            btn.textContent = "Tageslimit : off";
        }
    };
    
    
    this.changeViewWunschgewicht = function() {
        
        wunschgewicht = !wunschgewicht;
        if (wunschgewicht) {
            
            var btn = document.getElementById("btn_opt_wunschgewicht");
            btn.textContent = "Wunschgewicht : on";
        } else {
            
            var btn = document.getElementById("btn_opt_wunschgewicht");
            btn.textContent = "Wunschgewicht : off";
        }
    };
    
    
    this.setDrawModif = function(draw_modif) {
        
        draw = draw_modif;
    };
    
    
    this.getUserID = function() {
        
        return user_id;
    };
    
    
    this.update = function(_json) {        
        
        json = _json;
        switch(draw) {
            
            case DRAW_MODIF.PAT_VIEW:
                
                drawPatListe();
            break;
            
            
            case DRAW_MODIF.GRAPH:
                
                drawGraph();
            break;
            
            
            case DRAW_MODIF.MEAL:
                
                drawMealList();
            break;
            
            
            case DRAW_MODIF.PAT_PREVIEW:
                
                drawPatientPreview();
            break;
        }         
    };
    
    
    this.performDrawing = function() {       
      
        switch(page.page_modif) {
            
            case PAGE_MODIF.PAT_LISTE:                
                
                switch (draw) {
                    
                    case DRAW_MODIF.PAT_VIEW:
                    
                        var ajaxManager = new AjaxManager();                  
                        var paramList = new KeyValueList();      
                        date = new DateFormater().format(resolution.currentDate);
                        var kv = new KeyValuePair("currentDate", date); 
                        paramList.addKeyValue(kv);
                        ajaxManager.getUserList(this, paramList);
                    break;
                    
                    
                    case DRAW_MODIF.PAT_PREVIEW:
                    
                        var ajaxManager = new AjaxManager();                  
                        var paramList = new KeyValueList();  
                        date = new DateFormater().format(resolution.currentDate);
                        var kv = new KeyValuePair("currentDate", date);    
                        paramList.addKeyValue(kv);
                        kv = new KeyValuePair("user_id", user_id);
                        paramList.addKeyValue(kv);
                        ajaxManager.getUserPreview(this, paramList);
                    break;
                    
                }               
                
            break;
            
            
            case PAGE_MODIF.PAT_DETAILS:            
                
                
                switch (this.viewValuesModif) {
                    
                    case VIEW_VALUES_MODIF.RR_HF:
                        
                        draw = DRAW_MODIF.GRAPH;
                        var ajaxManager = new AjaxManager();                  
                        var paramList = new KeyValueList();   
                        switchResolution();
                        
                        var kv = new KeyValuePair("date", datum); 
                        paramList.addKeyValue(kv);
                        kv = new KeyValuePair("resolution", res);
                        paramList.addKeyValue(kv);
                        kv = new KeyValuePair("user_id", user_id);
                        paramList.addKeyValue(kv);
                        ajaxManager.getGraphDataALL(this, paramList);
                        
                    break;
                    
                    
                    case VIEW_VALUES_MODIF.KCAL_KG:
                        
                        draw = DRAW_MODIF.GRAPH;
                        var ajaxManager = new AjaxManager();                  
                        var paramList = new KeyValueList(); 
                        switchResolution();   
                        
                        var kv = new KeyValuePair("date", datum); 
                        paramList.addKeyValue(kv);
                        kv = new KeyValuePair("resolution", res);
                        paramList.addKeyValue(kv);
                        kv = new KeyValuePair("user_id", user_id);
                        paramList.addKeyValue(kv);
                        ajaxManager.getGraphDataALL(this, paramList);
                        
                    break;
                    
                    
                    case VIEW_VALUES_MODIF.ALL:
                                                
                        draw = DRAW_MODIF.GRAPH;
                        var ajaxManager = new AjaxManager();                  
                        var paramList = new KeyValueList(); 
                        switchResolution();  
                                           
                        var kv = new KeyValuePair("date", datum); 
                        paramList.addKeyValue(kv);
                        kv = new KeyValuePair("resolution", res);
                        paramList.addKeyValue(kv);
                        kv = new KeyValuePair("user_id", user_id);
                        paramList.addKeyValue(kv);                        
                        ajaxManager.getGraphDataALL(this, paramList);
                        
                    break;
                    
                    
                    case VIEW_VALUES_MODIF.MEAL:
                        
                        draw = DRAW_MODIF.MEAL;
                        var ajaxManager = new AjaxManager();                  
                        var paramList = new KeyValueList(); 
                        switchResolution();  
                                           
                        var kv = new KeyValuePair("date", datum); 
                        paramList.addKeyValue(kv);
                        kv = new KeyValuePair("resolution", res);
                        paramList.addKeyValue(kv);
                        kv = new KeyValuePair("user_id", user_id);
                        paramList.addKeyValue(kv);                        
                        ajaxManager.getGraphDataMEAL(this, paramList);
                        
                    break;
                }
            break;
        }
    };
    
    
    var switchResolution = function() {
                
        switch (resolution.calendarResolutionModif) {
                            
            case CALENDAR_RESOLUTION_MODIF.TAG:
                                
                var tmp = new Date(resolution.markedDate.getFullYear()
                , resolution.markedDate.getMonth()
                , resolution.markedDate.getDate());
                datum = new DateFormater().format(tmp);
                res = "tag";
                                             
           break;
                                                         
                            
           case CALENDAR_RESOLUTION_MODIF.WOCHE:
                            
                var tmp = new Date(resolution.markedWeek[0].getFullYear()
                , resolution.markedWeek[0].getMonth()
                , resolution.markedWeek[0].getDate());
                datum = new DateFormater().format(tmp);
                res = "woche";
                                               
           break;
                            
                            
           case CALENDAR_RESOLUTION_MODIF.MONAT:
                            
                var tmp = new Date(resolution.viewedMonthStart.getFullYear()
                , resolution.viewedMonthStart.getMonth()
                , resolution.viewedMonthStart.getDate());
                datum = new DateFormater().format(tmp); 
                res = "monat"; 
                                     
           break;
                            
                           
           case CALENDAR_RESOLUTION_MODIF.THERAPIEZEIT:
                   
                res = "-";
           break; 
        }
        
    };
    
    
    var drawPatListe = function() {
        
        var draw_holder = document.getElementById("draw-holder");
        draw_holder.innerHTML = "";
        
        var div_head_table = document.createElement("div");
        draw_holder.appendChild(div_head_table);
        var div_patient_table = document.createElement("div");        
        draw_holder.appendChild(div_patient_table);
        
        var head_table = document.createElement("table");
        div_head_table.appendChild(head_table);
        
        var thead = document.createElement("thead");
        head_table.appendChild(thead);
        head_table.style.width = "790px";
        head_table.style.tableLayout = "fixed";
        
        
        var th_patient = document.createElement("th");
        th_patient.textContent = "Patient";
        th_patient.colSpan = "6";        
        var th_kaloriezunahme = document.createElement("th");
        th_kaloriezunahme.textContent = "Kaloriezunahme";
        th_kaloriezunahme.colSpan = "2";
        var th_rr_hf = document.createElement("th");
        th_rr_hf.textContent = "RR / HF";
        th_rr_hf.colSpan = "2";
        var th_gewicht = document.createElement("th");
        th_gewicht.textContent = "Gewicht";
        th_gewicht.colSpan = "2";
        var th_auswahl = document.createElement("th");
        th_auswahl.textContent = "Auswahl";
        th_auswahl.colSpan = "2";
        
        thead.appendChild(th_patient);
        thead.appendChild(th_kaloriezunahme);
        thead.appendChild(th_rr_hf);
        thead.appendChild(th_gewicht);
        thead.appendChild(th_auswahl);
        
        var div_table_wraper = document.createElement("div");
        div_table_wraper.id = "table-wraper";
        div_patient_table.appendChild(div_table_wraper);
        
        var div_table_scroll = document.createElement("div");
        div_table_scroll.id = "table-scroll";
        div_table_wraper.appendChild(div_table_scroll);
        
        var table = document.createElement("table");
        div_table_scroll.appendChild(table);
        
 
        
        for (var index in json.payload.user) {
            
            // new table row
            var tr = document.createElement("tr");
            table.appendChild(tr);
            
            //new patient name
            var td_patient = document.createElement("td");
            var td_patient_class = document.createAttribute("class");
            td_patient.setAttributeNode(td_patient_class);
            if (index % 2 == 0) {
                
                td_patient_class.nodeValue = "td-cell-even";     
            } else {
                
                td_patient_class.nodeValue = "td-cell-odd";     
            }
                           
            td_patient.colSpan = "6";
            td_patient.textContent = json.payload.user[index].vorname + " " + json.payload.user[index].nachname;
            
                ////////////////////////////////////////////////
            
            
            
            
            //new kcal info
            var td_kaloriezuname = document.createElement("td");
            var td_kaloriezuname_class = document.createAttribute("class");                       
            td_kaloriezuname.setAttributeNode(td_kaloriezuname_class);
            td_kaloriezuname_class.nodeValue = "cell-value";             
            td_kaloriezuname.colSpan = "2";
            
            var kcal_tooltip = document.createAttribute("title");            
            td_kaloriezuname.setAttributeNode(kcal_tooltip);
            
            var kcal = json.payload.kcal[index];
            if (kcal != "none") {
                
                var tageslimit = json.payload.tageslimit[index].tageseinheiten;
                if (kcal <= tageslimit) {
                                       
                    td_kaloriezuname_class.nodeValue = td_kaloriezuname_class.nodeValue + " " + "kcal-ok";
                    kcal_tooltip.nodeValue = "Kaloriezunahme innerhalbt\nvorgeschriebener Grenze";
                } else {
                    
                    td_kaloriezuname_class.nodeValue = td_kaloriezuname_class.nodeValue + " " + "kcal-alert";
                    kcal_tooltip.nodeValue = "Kaloriezunahme wurde überschritten";
                }
            } else {
                
                if (index % 2 == 0) {
                
                    td_kaloriezuname_class.nodeValue = td_kaloriezuname_class.nodeValue + " " + "td-cell-even";     
                } else {
                
                    td_kaloriezuname_class.nodeValue = td_kaloriezuname_class.nodeValue + " " + "td-cell-odd";     
                }
                kcal_tooltip.nodeValue = "keine Messwerte";
            }
            td_kaloriezuname.textContent = kcal == "none" ? "---" : kcal;     
                   
                ////////////////////////////////////////////////
            
            
            //new RR /HF info
            var td_rr_hf = document.createElement("td");
            var td_rr_hf_class = document.createAttribute("class");
            td_rr_hf.setAttributeNode(td_rr_hf_class);
            td_rr_hf_class.nodeValue = "cell-value";                        
            td_rr_hf.colSpan = "2";
            
            var rr_hf_tooltip = document.createAttribute("title");
            td_rr_hf.setAttributeNode(rr_hf_tooltip);
            
            var rr_hf = json.payload.bloodpressure[index];  
            if (rr_hf != "none") {
                
                switch (rr_hf.systolic) {
                    
                    
                    case 0:
                    
                        td_rr_hf_class.nodeValue = ttd_rr_hf_class.nodeValue + " " + "bp-optimal";
                        rr_hf_tooltip.nodeValue = "Blutdruck\nOptimal";
                    break;
                    
                    
                    case 1:
                        
                        td_rr_hf_class.nodeValue = td_rr_hf_class.nodeValue + " " + "bp-normal";
                        rr_hf_tooltip.nodeValue = "Blutdruck\nNormal";
                    break;
                    
                    
                    case 2:
                        
                        td_rr_hf_class.nodeValue = td_rr_hf_class.nodeValue + " " + "bp-hochnormal";
                        rr_hf_tooltip.nodeValue = "Blutdruck\nHochnormal";
                    break;
                    
                    
                    case 3:
                        
                        td_rr_hf_class.nodeValue = td_rr_hf_class.nodeValue + " " + "bp-hypertonie-grad1";
                        rr_hf_tooltip.nodeValue = "Blutdruck\nHypertonie Grad 1";
                    break;
                    
                    
                    case 4:
                        
                        td_rr_hf_class.nodeValue = td_rr_hf_class.nodeValue + " " + "bp-hypertonie-grad2";
                        rr_hf_tooltip.nodeValue = "Blutdruck\nHypertonie Grad 2";
                    break;
                    
                    
                    case 5:
                    
                        td_rr_hf_class.nodeValue = td_rr_hf_class.nodeValue + " " + "bp-hypertonie-grad3";
                        rr_hf_tooltip.nodeValue = "Blutdruck\nHypertonie Grad 3";
                    break;
                    
                    case 6:
                    
                        td_rr_hf_class.nodeValue = td_rr_hf_class.nodeValue + " " + "bp-isolierte-systolische-hypertonie";
                        rr_hf_tooltip.nodeValue = "Blutdruck\nIsolierte-Systolische Hypertonie";
                    break;
                    
                }
                
            } else {
                
                if (index % 2 == 0) {
                
                    td_rr_hf_class.nodeValue = td_rr_hf_class.nodeValue + " " + "td-cell-even";     
                } else {
                
                    td_rr_hf_class.nodeValue = td_rr_hf_class.nodeValue + " " + "td-cell-odd";     
                }
                rr_hf_tooltip.nodeValue = "keine Messwerte";
            }                      
            td_rr_hf.textContent = rr_hf == "none" ? "---" : Math.round(json.payload.bloodpressure[index].systolic_avg) 
                                                             + " / " 
                                                             + Math.round(json.payload.bloodpressure[index].diastolic_avg);            
            
                ////////////////////////////////////////////////
                
                
            
            //new weight info
            var td_gewicht = document.createElement("td");
            var td_gewicht_class = document.createAttribute("class");
            td_gewicht.setAttributeNode(td_gewicht_class);
            td_gewicht_class.nodeValue = "cell-value";                        
            td_gewicht.colSpan = "2";
            
            var gewicht_tooltip = document.createAttribute("title");
            td_gewicht.setAttributeNode(gewicht_tooltip);
            
            var gewicht = json.payload.bodyweight[index];
            if (gewicht != "none") {
                           
                var wunschgewicht = json.payload.targetweight[index];
                if (wunschgewicht != "none") {
                    
                    var abweichung = 100 - (wunschgewicht.wunschgewicht / gewicht.weight * 100);
                    
                    if (abweichung > 50) {
                        
                        td_gewicht_class.nodeValue = td_gewicht_class.nodeValue + " " + "gewicht-50";
                        gewicht_tooltip.nodeValue = "Abweichung über 50%";
                    } else if (abweichung > 30) {
                        
                        td_gewicht_class.nodeValue = td_gewicht_class.nodeValue + " " + "gewicht-30";
                        gewicht_tooltip.nodeValue = "Abweichung über 30%";
                    } else if (abweichung > 20) {
                        
                        td_gewicht_class.nodeValue = td_gewicht_class.nodeValue + " " + "gewicht-20";
                        gewicht_tooltip.nodeValue = "Abweichung über 20%";
                    } else if (abweichung > 10) {
                        
                        td_gewicht_class.nodeValue = td_gewicht_class.nodeValue + " " + "gewicht-10";
                        gewicht_tooltip.nodeValue = "Abweichung über 10%";
                    } else {
                        
                        td_gewicht_class.nodeValue = td_gewicht_class.nodeValue + " " + "gewicht-ok";
                        gewicht_tooltip.nodeValue = "Abweichung wenniger 10%";
                    }
                } else {
                    
                    td_gewicht_class.nodeValue = td_gewicht_class.nodeValue + " " + "gewicht-50";
                    gewicht_tooltip.nodeValue = "Zielgewicht nicht eingetragen";
                }                
                
            } else {
                
                if (index % 2 == 0) {
                
                    td_gewicht_class.nodeValue = td_gewicht_class.nodeValue + " " + "td-cell-even";     
                } else {
                
                    td_gewicht_class.nodeValue = td_gewicht_class.nodeValue + " " + "td-cell-odd";     
                }
                gewicht_tooltip.nodeValue = "keine Messwerte%";
            }           
            td_gewicht.textContent = gewicht == "none" ? "---" : json.payload.bodyweight[index].weight;            
            
            
                ////////////////////////////////////////////////
            
            
            
            //new button
            var td_auswahl = document.createElement("td");   
            var td_auswahl_class = document.createAttribute("class");
            td_auswahl.setAttributeNode(td_auswahl_class);
            if (index % 2 == 0) {
                
                td_auswahl_class.nodeValue = "td-cell-even cell-value";   
            } else {
                
                td_auswahl_class.nodeValue = "td-cell-odd cell-value";     
            }                
            td_auswahl.colSpan = "2";
            
            var auswahl_btn = document.createElement("button");
            auswahl_btn.value = json.payload.user[index]._id;  
            auswahl_btn.drawer = drawer;        
            auswahl_btn.onclick = function() {
                
                show_patient_info();
                user_id = this.value;
                draw = DRAW_MODIF.PAT_PREVIEW;
                this.drawer.performDrawing();                
            };           
            auswahl_btn.textContent = ">";
            td_auswahl.appendChild(auswahl_btn);
            
            
                ////////////////////////////////////////////////
            
            
            
            tr.appendChild(td_patient);
            tr.appendChild(td_kaloriezuname);
            tr.appendChild(td_rr_hf);
            tr.appendChild(td_gewicht);
            tr.appendChild(td_auswahl);
            
            
             
        }

    };
    
    
    var drawGraph = function() {
        
        
        var w = 805;
        var h = 440;
        
        var draw_holder = document.getElementById("draw-holder");
        draw_holder.style.background = "#FFF";
        draw_holder.innerHTML = "";        
        var canvas = document.createElement("canvas");
        
        draw_holder.appendChild(canvas);
        canvas.id = "graph_canvas";
        canvas.width = w;
        canvas.height = h;
        var ctx = canvas.getContext("2d");        
        var gd = new GraphDrawer(ctx, resolution);
        
        switch (drawer.viewValuesModif) {
                    
            case VIEW_VALUES_MODIF.RR_HF:
                        
                gd.drawRRHF(json);                        
                break;
                    
                    
            case VIEW_VALUES_MODIF.KCAL_KG:
                        
                gd.drawKcal(json, tageslimit); 
                gd.drawBodyweight(json, wunschgewicht);                       
                break;
                    
                    
            case VIEW_VALUES_MODIF.ALL:
                                                
                gd.drawKcal(json, tageslimit);
                gd.drawRRHF(json);
                gd.drawBodyweight(json, wunschgewicht);
                        
            break;
                    
                    
            case VIEW_VALUES_MODIF.MEAL:
                                            
                       
            break;
        }
        
    };
    
    
    var drawMealList = function() {
        
        var draw_holder = document.getElementById("draw-holder");
        draw_holder.style.background = "#FFF"; //"#F2CC0C";//"#DDD";
        draw_holder.innerHTML = "";
        
        var div_head_table = document.createElement("div");        
        
        div_head_table.id = "head_table";
        
        draw_holder.appendChild(div_head_table);        
        
        var head_table = document.createElement("table");
        head_table.style.width = "790px";
        head_table.style.tableLayout = "fixed";
        div_head_table.appendChild(head_table);
        
        var thead = document.createElement("thead");
        head_table.appendChild(thead);
        
        
        var th_datum = document.createElement("th");
        th_datum.textContent = "Datum";
        th_datum.colSpan = "3";   
        
        var th_markenname = document.createElement("th");
        th_markenname.textContent = "Markenname";
        th_markenname.colSpan = "5";   
        
        var th_produkt = document.createElement("th");
        th_produkt.textContent = "Produkt";
        th_produkt.colSpan = "5";   
        
        var th_gewicht = document.createElement("th");
        th_gewicht.textContent = "Gewicht";
        th_gewicht.colSpan = "2";   
        
        var th_energie = document.createElement("th");
        th_energie.textContent = "Energie";
        th_energie.colSpan = "2";   
                             
        
        thead.appendChild(th_datum);
        thead.appendChild(th_markenname);
        thead.appendChild(th_produkt);
        thead.appendChild(th_gewicht);
        thead.appendChild(th_energie);
        
        
        var div_meal_table = document.createElement("div");        
        draw_holder.appendChild(div_meal_table);
        
        var div_table_wraper = document.createElement("div");
        div_table_wraper.id = "table-wraper";
        div_meal_table.appendChild(div_table_wraper);
        
        var div_table_scroll = document.createElement("div");
        div_table_scroll.id = "table-scroll";
        div_table_wraper.appendChild(div_table_scroll);
        
        var table = document.createElement("table");
        div_table_scroll.appendChild(table);
        
       
        
        var payload = json.payload;
        if (payload != "none") {
            
                       
            var lastDatum = new Date(payload.mealrecord[0].added_on);
            lastDatum = 0;
            var even_odd = 0;
            for (var index in payload.mealrecord) {
                
                var ds = payload.mealrecord[index].added_on;               
                var datum = new Date(ds.substr(0, 4), ds.substr(5, 2), ds.substr(8, 2), ds.substr(11, 2), ds.substr(14, 2), ds.substr(17, 2)); 
               
                //monat muss korrigiert werden.. monat interval von 1 - 12 aber in JS von 0 - 11 !!!!
                datum.setMonth(datum.getMonth() -1); 
                
                              
                var datumInTime = datum.getTime();
                
                if (datumInTime > lastDatum) {
                    
                    lastDatum = new Date(datum.getFullYear(), datum.getMonth(), (datum.getDate() + 1));                                        
                    lastDatum = lastDatum.getTime();
                    
                    var tr = document.createElement("tr");
                    table.appendChild(tr);  
                    var td_datum = document.createElement("td");
                                       
                    td_datum.textContent = calendar.getDayName(datum.getDay()) + " " + datum.getDate() + " " + calendar.getMonthName(datum.getMonth());
                    td_datum.colSpan = "3";
                    tr.appendChild(td_datum);
                    even_odd = 0;
                } 
                    
                var tr = document.createElement("tr");
                table.appendChild(tr);  
                    
                //
                var td_time = document.createElement("td");
                tr.appendChild(td_time);
                  
                td_time.colSpan = "3";
                var td_time_class = document.createAttribute("class");
                td_time.setAttributeNode(td_time_class);
                if (even_odd % 2 == 0) {
                      
                    td_time_class.nodeValue = "td-cell-even";     
                } else {
                        
                    td_time_class.nodeValue = "td-cell-odd";     
                }
                td_time.textContent = (datum.getHours() < 10 ? ("0" + datum.getHours()) : datum.getHours())
                    + ":" 
                    + (datum.getMinutes() < 10 ? ("0" + datum.getMinutes()) : datum.getMinutes()) 
                    + " Uhr";
                    
                //
                var td_markenname = document.createElement("td");
                tr.appendChild(td_markenname);
                td_markenname.colSpan = "5";
                var td_markenname_class = document.createAttribute("class");
                td_markenname.setAttributeNode(td_markenname_class);
                if (even_odd % 2 == 0) {
                        
                    td_markenname_class.nodeValue = "td-cell-even";     
                } else {
                     
                    td_markenname_class.nodeValue = "td-cell-odd";     
                }
                td_markenname.textContent = payload.productdata[index].markenname;
                
                //
                var td_produkt = document.createElement("td");
                tr.appendChild(td_produkt);
                td_produkt.colSpan ="5";
                var td_produkt_class = document.createAttribute("class");
                td_produkt.setAttributeNode(td_produkt_class);
                if (even_odd % 2 == 0) {
                        
                    td_produkt_class.nodeValue = "td-cell-even";     
                } else {
                      
                    td_produkt_class.nodeValue = "td-cell-odd";     
                }
                td_produkt.textContent = payload.productdata[index].produkt;
                    
                //
                var td_gewicht = document.createElement("td");
                tr.appendChild(td_gewicht);
                td_gewicht.colSpan = "2";
                var td_gewicht_class = document.createAttribute("class");
                td_gewicht.setAttributeNode(td_gewicht_class);
                if (even_odd % 2 == 0) {
                        
                    td_gewicht_class.nodeValue = "td-cell-even";     
                } else {
                      
                    td_gewicht_class.nodeValue = "td-cell-odd";     
                }
                td_gewicht.textContent = payload.mealrecord[index].weight;
                  
                //
                var td_energie = document.createElement("td");
                tr.appendChild(td_energie);
                td_energie.colSpan = "2";
                var td_energie_class = document.createAttribute("class");
                td_energie.setAttributeNode(td_energie_class);
                if (even_odd % 2 == 0) {
                       
                    td_energie_class.nodeValue = "td-cell-even";     
                } else {
                        
                    td_energie_class.nodeValue = "td-cell-odd";     
                }
                td_energie.textContent = payload.mealrecord[index].kcal;
                    
                even_odd++;
                
                
            }
            
        } else {
            
            var tr = document.createElement("tr");
            table.appendChild(tr);            
            
            var td_info = document.createElement("td");
            td_info.textContent = "keinte Daten für diesen Zeitraum enthalten";
            td_info.colSpan = 10;
            tr.appendChild(td_info);
        }
        
    };
    
    
    var drawPatientPreview = function() {
        
        var pat_vorname = document.getElementById("pat_vorname");
        var pat_nachname = document.getElementById("pat_nachname");
        var pat_email = document.getElementById("pat_email");
        var pat_gewicht = document.getElementById("pat_gewicht");
        var pat_zielgewicht = document.getElementById("pat_zielgewicht");
        var pat_tageslimit = document.getElementById("pat_tageslimit");
        var pat_4ts_rr = document.getElementById("pat_4ts_rr");
        var pat_4ts_hf = document.getElementById("pat_4ts_hf");
                           
               
        pat_vorname.textContent = json["payload"].user.vorname;
        pat_nachname.textContent = json["payload"].user.nachname;
        pat_email.textContent = json["payload"].user.email;
        if (json["payload"].bodyweight != "none") {
            
            pat_gewicht.textContent = json["payload"].bodyweight.weight;
        } else pat_gewicht.textContent = "---";
        if (json["payload"].wunschgewicht != "none") {
            
            pat_zielgewicht.textContent = json["payload"].wunschgewicht.wunschgewicht;
        } else pat_zielgewicht.textContent = "---";
        
        pat_tageslimit.textContent = json["payload"].tageslimit.tageseinheiten;
        
        if (json["payload"].bloodpressure != "none" ) {            
            pat_4ts_rr.textContent = Math.round(json["payload"].bloodpressure.systolic_avg)
            + " / " 
            + Math.round(json["payload"].bloodpressure.diastolic_avg);
        } else pat_4ts_rr.textContent = "---";
                
        if (json["payload"].bloodpressure != "none") {
            
            pat_4ts_hf.textContent = Math.round(json["payload"].bloodpressure.pulse_avg);
        } else pat_4ts_hf.textContent = "---";
        
        
        
    };
    
    
    this.viewModif = function(modif) {
        
        this.viewValuesModif = modif;
    };
    
    
}

