var stroke = false;

function rect(obj, x, y, width, height, rx, ry) {
    
    
   obj.beginPath();
   obj.moveTo(x + rx, y);
   obj.lineTo(x + width - rx, y);
   obj.quadraticCurveTo(x + width, y, x + width, y + ry);
   obj.lineTo(x + width, y + height - ry);
   obj.quadraticCurveTo(x + width, y + height, x + width - rx, y + height);
   obj.lineTo(x + rx, y + height);
   obj.quadraticCurveTo(x, y + height, x, y + height - ry);
   obj.lineTo(x, y + ry);
   obj.quadraticCurveTo(x, y, x + rx, y);
   obj.fill();
   if(stroke) obj.stroke();
   obj.closePath();
}

function circle(obj, cx, cy, r) {
    
   obj.beginPath();
   obj.arc(cx, cy, r, 0, 2 * Math.PI, true);
   obj.fill();
   if(stroke) obj.stroke();
   obj.closePath();
}

function ellipse(obj, x, y, w, h) {
    
   x = x - w;
   y = y - h;
   w = w * 2;
   h = h * 2;
   var kappa = .5522848;
   ox = (w / 2) * kappa;
   oy = (h / 2) * kappa;
   xe = x + w;
   ye = y + h;
   xm = x + w / 2;
   ym = y + h / 2; 
   obj.beginPath();
   obj.moveTo(x, ym);
   obj.bezierCurveTo(x, ym - oy, xm - ox, y, xm, y);
   obj.bezierCurveTo(xm + ox, y, xe, ym - oy, xe, ym);
   obj.bezierCurveTo(xe, ym + oy, xm + ox, ye, xm, ye);
   obj.bezierCurveTo(xm - ox, ye, x, ym + oy, x, ym);
   obj.fill();
   if(stroke) obj.stroke();
   obj.closePath();
}

function polygon(obj, points) {
    
   xy = points.split(" ");
   obj.beginPath();
   if(xy.length > 0) {
       
      xyn = xy[0].split(",");
      obj.moveTo(xyn[0], xyn[1]);
   }
   for(i = 1; i < xy.length; i++) {
       
      xyn = xy[i].split(",");
      obj.lineTo(xyn[0], xyn[1]);
   }
   xyn = xy[0].split(",");
   obj.lineTo(xyn[0],xyn[1]);
   obj.fill();
   if(stroke) obj.stroke();
   obj.closePath();
}

function line(obj, x1, y1, x2, y2, sWidth) {
   
   obj.save(); 
   obj.beginPath();
   obj.moveTo(x1, y1);
   obj.lineTo(x2, y2);
   obj.lineWidth = sWidth;   
   obj.stroke();   
   obj.closePath();
}


function setFill(obj, col) {
   obj.fillStyle = col;
   obj.strokeStyle = col;
}

function setStroke(obj, col, sWidth) {
    
   stroke = true;
   obj.strokeStyle = col;
   obj.lineWidth = sWidth;
}

function unset(obj) {
    
   stroke = false;
   obj.fillStyle = "#000000";
   obj.strokeStyle = "#000000";
   obj.lineWidth = 1;
}

function setLinearFill(obj, col1x, col1y, col2x, col2y, col1, col2) {
    
    var gradient = obj.createLinearGradient(col1x, col1y, col2x, col2y);
    gradient.addColorStop(0, col1);
    gradient.addColorStop(1, col2); 
    obj.fillStyle = gradient;
}

function setRadialFill(obj, col1x, col1y, col1r, col2x, col2y, col2r, col1, col2) {
    
   var gradient = obj.createRadialGradient(col1x, col1y, col1r, col2x, col2y, col2r);
   gradient.addColorStop(0, col1);
   gradient.addColorStop(1, col2); 
   obj.fillStyle = gradient;
}

function text(obj, x, y, text, style) {
   
   obj.save(); 
   if(style) obj.font = style;
   obj.fillText(text, x, y);
}

function Point(x, y) {
    
    this.x = x;
    this.y = y;   
}

function Line(p1, p2) {
    
    this.x1 = p1.x;
    this.x2 = p2.x;
    this.y1 = p1.y;
    this.y2 = p2.y;
    
    this.p1 = p1;
    this.p2 = p2;
}

//deprecated
function ValueToXYKonverter() {
    
    this.datumToXForWeek = function(datum) {
        
        var date = new Date(datum);
        var minP = (60 / date.getMinutes()) * 100;
        var multiplier = 24 / date.getHours() + minP;
        return  multiplier;
    };
}

function convertDatumToPixel(datum, resolution) {
    
    
    switch (resolution) {            
                            
        case CALENDAR_RESOLUTION_MODIF.TAG:
                                    
            var max_time = new Date(calendar.markedDate.getFullYear(), calendar.markedDate.getMonth(), calendar.markedDate.getDate());                            
            max_time.setDate(max_time.getDate() + 1);
            max_time = max_time.getTime();
            var min_time = new Date(calendar.markedDate.getFullYear(), calendar.markedDate.getMonth(), calendar.markedDate.getDate());
                            
            min_time = min_time.getTime();
            var scal_time = max_time - min_time;
            var date = parseDateObj(datum);                                    
            date = date.getTime();
                            
            date = date - min_time;
                            
            date = date / scal_time;
                                                        
            return (725 * date + 41).toFixed(0) ;
            
        break;
                        
                        
        case CALENDAR_RESOLUTION_MODIF.WOCHE:
                            
            var max_time = new Date(calendar.markedWeek[6].getFullYear(), calendar.markedWeek[6].getMonth(), calendar.markedWeek[6].getDate());                            
            max_time.setDate(max_time.getDate() + 1);
            max_time = max_time.getTime();
            var min_time = new Date(calendar.markedWeek[0].getFullYear(), calendar.markedWeek[0].getMonth(), calendar.markedWeek[0].getDate());
                            
            min_time = min_time.getTime();
            var scal_time = max_time - min_time;
            var date = parseDateObj(datum);                                    
            date = date.getTime();
                            
            date = date - min_time;
                            
            date = date / scal_time;
                                                        
            return (725 * date + 41).toFixed(0) ;
                           
        break;
                        
                        
        case CALENDAR_RESOLUTION_MODIF.MONAT:
                   
            var max_time = new Date(calendar.viewedMonthStart.getFullYear(), calendar.viewedMonthStart.getMonth(), calendar.viewedMonthStart.getDate());  
            max_time.setMonth(max_time.getMonth() + 1);
            
            max_time = max_time.getTime();
            var min_time = new Date(calendar.viewedMonthStart.getFullYear(), calendar.viewedMonthStart.getMonth(), calendar.viewedMonthStart.getDate());
                            
            min_time = min_time.getTime();
            var scal_time = max_time - min_time;
            var date = parseDateObj(datum);                                    
            date = date.getTime();
                            
            date = date - min_time;
                            
            date = date / scal_time;                                         
            return (725 * date + 41).toFixed(0) ;
            
        break;
                        
                        
        case CALENDAR_RESOLUTION_MODIF.THERAPIEZEIT:
        break;
    }
}


function convertWeightToPixel(weight, max_weight, y_axis50, y_axis_max) {
    
    if (weight == 0) return 419;
    else if (weight <= 50) {
               
        return (420 - y_axis50 * (weight / 50)).toFixed(0);
    } else {                    
             
        return (420 - y_axis_max * (weight / max_weight)).toFixed(0);  
    }      
}


function convertKcalToPixel(kcal, max_kcal, y_axis_max) {
    
    return (420 - y_axis_max * (kcal / max_kcal)).toFixed(0);
}


function convertRRToPixel(rr, max_rr, y_axis_max) {
    
    if (rr == 0) return 418;
    return (420 - y_axis_max * (rr / max_rr)).toFixed(0);
}


function convertHFToPixel(hf, max_hf, y_axis_max) {
    
    return (420 - y_axis_max * (hf / max_hf)).toFixed(0);
}


function PointOfWeight(datum, weight, resolution) {
    
    
    if (datum == "start") this.datum = 41;
    else if (datum == "end") this.datum = 764;
    else this.datum = convertDatumToPixel(datum, resolution);
        
    this.weight = weight;
}


function PointOfKcal(datum, kcal, resolution) {
    
    if (datum == "start") this.datum = 41;
    else if (datum == "end") this.datum = 764;
    else this.datum = convertDatumToPixel(datum, resolution);
    
    this.kcal = kcal;
    
}


function PointOfRR(datum, sys, dia, resolution) {
    
    if (datum == "start") this.datum = 41;
    else if (datum == "end") this.datum = 764;
    else this.datum = convertDatumToPixel(datum, resolution);
    
    this.systolic = sys;
    this.diastolic = dia;
}


function PointOfHF(datum, hf, resolution) {
    
    if (datum == "start") this.datum = 41;
    else if (datum == "end") this.datum = 764;
    else this.datum = convertDatumToPixel(datum, resolution);
    
    this.hf = hf;
}


function parseDateObj(datum) {
    
    var d = datum;    
    var dat =  new Date(d.substr(0, 4), d.substr(5, 2), d.substr(8, 2), d.substr(11, 2), d.substr(14, 2), d.substr(17, 2));  
    dat.setMonth(dat.getMonth() -1);  
    return dat;
}


function GraphDrawer(ctx, res) {
    
        
    var context = ctx;
    var width = context.canvas.width;
    var height = context.canvas.height;
    var delta_margin = 10;
    var resolution = res.calendarResolutionModif;
    var calendar = res;
    
    //y-achsis scaling
    var kcal_y_axis     = [98, 196, 294, 392];             //ok
    var hf_y_axis       = [120, 240, 360];
    var rr_y_axis       = [58, 116, 174, 232, 290, 348];    //ok
    var weight_y_axis   = [100, 200, 300, 400];             //ok
    
    
    var res_tag_x_axis       = [90, 180, 270, 360, 450, 540, 630];
    var res_week_x_axis      = [103, 206, 309, 412, 515, 618, 725];
    var res_month_30_x_achis = [29, 53, 77, 101, 125, 149, 173, 197, 221, 245, 269, 293, 317, 341, 365, 389, 413, 437, 461, 485, 509, 533, 557, 581, 605, 629, 653, 677, 701, 725];
    var res_month_31_x_achis = [35, 58, 81, 104, 127, 150, 173, 196, 219, 242, 265, 288, 311, 334, 357, 380, 403, 426, 449, 472, 495, 518, 541, 564, 587, 610, 633, 656, 679, 702, 725];
    var res_month_28_x_achis = [50, 75, 100, 125, 150, 175, 200, 225, 250, 275, 300, 325, 350, 375, 400, 425, 450, 475, 500, 525, 550, 575, 600, 625, 650, 675, 700, 725];
    var res_month_29_x_achis = [25, 50, 75, 100, 125, 150, 175, 200, 225, 250, 275, 300, 325, 350, 375, 400, 425, 450, 475, 500, 525, 550, 575, 600, 625, 650, 675, 700, 725];
    
    var drawGraph = function() {
        
       
        setFill(context, "rgb(0%,0%,0%)");        
        
        var p1 = new Point(40, 10);
        var p2 = new Point(40, 420);
        var p3 = new Point(765, 420);
        var p4 = new Point(765, 10);  
             
        line(context, p1.x, p1.y, p2.x, p2.y, 1);
        line(context, p2.x, p2.y, p3.x, p3.y, 1);
        line(context, p3.x, p3.y, p4.x, p4.y, 1);
        
                
        //kcal
        var scLine1 = new Line(new Point(35, 420 - kcal_y_axis[0]), new Point(40, 420 - kcal_y_axis[0]));        
        var scLine2 = new Line(new Point(35, 420 - kcal_y_axis[1]), new Point(40, 420 - kcal_y_axis[1]));
        var scLine3 = new Line(new Point(35, 420 - kcal_y_axis[2]), new Point(40, 420 - kcal_y_axis[2]));
                      
        
        setFill(context, "rgb(100%,0%,0%)");
        line(context, scLine1.x1, scLine1.y1, scLine1.x2, scLine1.y2, 1);
        line(context, scLine2.x1, scLine2.y1, scLine2.x2, scLine2.y2, 1);
        line(context, scLine3.x1, scLine3.y1, scLine3.x2, scLine3.y2, 1);
       
        
        context.rotate(-90 * (Math.PI / 180));
        text(context, -27, 10, "[kcal]", "0.7em Arial");   
        context.rotate(90 * (Math.PI / 180)); 
        
        
        //HF
        var scLine1 = new Line(new Point(35, 420 - hf_y_axis[0]), new Point(40, 420 - hf_y_axis[0]));        
        var scLine2 = new Line(new Point(35, 420 - hf_y_axis[1]), new Point(40, 420 - hf_y_axis[1]));
        var scLine3 = new Line(new Point(35, 420 - hf_y_axis[2]), new Point(40, 420 - hf_y_axis[2]));
               
        setFill(context, "rgb(50%,50%,50%)");
        line(context, scLine1.x1, scLine1.y1, scLine1.x2, scLine1.y2, 1);
        line(context, scLine2.x1, scLine2.y1, scLine2.x2, scLine2.y2, 1);
        line(context, scLine3.x1, scLine3.y1, scLine3.x2, scLine3.y2, 1);
        
        context.rotate(-90 * (Math.PI / 180));
        text(context, -27, 22, "[bpm]", "0.7em Arial");   
        context.rotate(90 * (Math.PI / 180)); 
        
        
        //RR        
        var scLine1 = new Line(new Point(765, 420 - rr_y_axis[0]), new Point(770, 420 - rr_y_axis[0]));        
        var scLine2 = new Line(new Point(765, 420 - rr_y_axis[1]), new Point(770, 420 - rr_y_axis[1]));
        var scLine3 = new Line(new Point(765, 420 - rr_y_axis[2]), new Point(770, 420 - rr_y_axis[2]));
        var scLine4 = new Line(new Point(765, 420 - rr_y_axis[3]), new Point(770, 420 - rr_y_axis[3]));        
        var scLine5 = new Line(new Point(765, 420 - rr_y_axis[4]), new Point(770, 420 - rr_y_axis[4]));
        var scLine6 = new Line(new Point(765, 420 - rr_y_axis[5]), new Point(770, 420 - rr_y_axis[5]));
        
        setFill(context, "rgb(0%,80%,0%)");
        line(context, scLine1.x1, scLine1.y1, scLine1.x2, scLine1.y2, 1);
        line(context, scLine2.x1, scLine2.y1, scLine2.x2, scLine2.y2, 1);
        line(context, scLine3.x1, scLine3.y1, scLine3.x2, scLine3.y2, 1);
        line(context, scLine4.x1, scLine4.y1, scLine4.x2, scLine4.y2, 1);
        line(context, scLine5.x1, scLine5.y1, scLine5.x2, scLine5.y2, 1);
        line(context, scLine6.x1, scLine6.y1, scLine6.x2, scLine6.y2, 1);
                
        text(context, 770, 10, "[mmHg]", "0.7em Arial"); 
        
        
        //kg        
        var scLine1 = new Line(new Point(765, 420 - weight_y_axis[0]), new Point(770, 420 - weight_y_axis[0]));        
        var scLine2 = new Line(new Point(765, 420 - weight_y_axis[1]), new Point(770, 420 - weight_y_axis[1]));
        var scLine3 = new Line(new Point(765, 420 - weight_y_axis[2]), new Point(770, 420 - weight_y_axis[2]));
        
        setFill(context, "rgb(0%,0%,100%)");      
        
        
        text(context, 770, 22, "[kg]", "0.7em Arial");
        line(context, scLine1.x1, scLine1.y1, scLine1.x2, scLine1.y2, 1);
        line(context, scLine2.x1, scLine2.y1, scLine2.x2, scLine2.y2, 1);
        line(context, scLine3.x1, scLine3.y1, scLine3.x2, scLine3.y2, 1);       
        
        drawScal();
    };
    
    
    this.drawKcal = function(json, tageslimit) {        
        
        setFill(context, "rgb(100%,0%,0%)");         
      
        var kcal_kg = json.payload.kcal_kg;
        var kcal_nrg = json.payload.kcal_kg_nrg;
        var tageseinheiten = json.payload.tageseinheiten;
        
        var kcStart = new PointOfKcal("start", 0, resolution);
        var kcalPoints = new Array();
        var kcEnd = new PointOfKcal("end", 0, resolution);
        
        
                         
        
        if (kcal_kg.data != "none" && kcal_nrg.data != "none") {
            
            for (var index in kcal_kg.data) {
                
                
                kcalPoints[index] = new PointOfKcal(kcal_kg.data[index].m_addedOn, kcal_nrg.data[index].energy, resolution);  
            }            
        } 
                     
        
        //array to draw
        tmp_ar = new Array();         
           
        tmp_ar[tmp_ar.length] = kcStart;         
        for (var index in kcalPoints) {
            
            tmp_ar[tmp_ar.length] = kcalPoints[index];
        }
        tmp_ar[tmp_ar.length] = kcEnd;
        
        
        
              
        
        var dpa = new Array();
        
        switch (resolution) {
            
            case CALENDAR_RESOLUTION_MODIF.TAG:
            
            for (var index in tmp_ar) {
                
               dpa[dpa.length] = tmp_ar[index];                  
            }
            
            break;
            
            case CALENDAR_RESOLUTION_MODIF.WOCHE:
            
            var index_of_res_week_x_axis = 0;  
            for (var index in tmp_ar) {
            
               if (index == 0) {
                   
                   dpa[dpa.length] = tmp_ar[index];
               } else if (tmp_ar[index].datum < res_week_x_axis[index_of_res_week_x_axis] + 41) {
                   
                   dpa[dpa.length] = tmp_ar[index];
               } else {
                   
                   var tmp = new PointOfKcal("end", 0, resolution);
                   tmp.datum = res_week_x_axis[index_of_res_week_x_axis] + 40;
                   dpa[dpa.length] = tmp;
                   while (tmp_ar[index].datum > res_week_x_axis[index_of_res_week_x_axis] + 41) {
                       
                       index_of_res_week_x_axis++;
                   }
                   dpa[dpa.length] = tmp_ar[index];   
                           
               }           
            }
            
            break;
            
            case CALENDAR_RESOLUTION_MODIF.MONAT:
            
            var index_of_res_month_x_axis = 0;  
            var anzTage = calendar.getDaysInMonth(calendar.viewedMonthStart.getFullYear(), calendar.viewedMonthStart.getMonth());
            switch (anzTage) {
                
                case 30:
                
                var res_month_x_axis = res_month_30_x_achis;
                break;
                
                case 31:
                
                var res_month_x_axis = res_month_31_x_achis;
                break;
                
                case 28:
                
                var res_month_x_axis = res_month_28_x_achis;
                break;
                
                case 29:
                
                var res_month_x_axis = res_month_29_x_achis;
                break;
            }
            for (var index in tmp_ar) {
            
               if (index == 0) {
                   
                   dpa[dpa.length] = tmp_ar[index];
               } else if (tmp_ar[index].datum < res_month_x_axis[index_of_res_month_x_axis] + 41) {
                   
                   dpa[dpa.length] = tmp_ar[index];
               } else {
                   
                   var tmp = new PointOfKcal("end", 0, resolution);
                   tmp.datum = res_month_x_axis[index_of_res_month_x_axis] + 40;
                   dpa[dpa.length] = tmp;
                   while (tmp_ar[index].datum > res_month_x_axis[index_of_res_month_x_axis] + 41) {
                       
                       index_of_res_month_x_axis++;
                   }
                   dpa[dpa.length] = tmp_ar[index];   
                           
               }           
            }
            break;
            
            case CALENDAR_RESOLUTION_MODIF.THERAPIEZEITRAUM:
            break;
        }
        
        
        
        
        var kcal_sum = 0;
        var kcal_max = tageseinheiten.tageseinheiten;
        for (var index in dpa) {
            
            if (dpa[index].kcal != 0) {
                
                kcal_sum += parseInt(dpa[index].kcal);
                dpa[index].kcal = parseInt(kcal_sum);               
            } else {
                
                kcal_sum = 0;
            }
            
            kcal_max = kcal_max > kcal_sum ? kcal_max : kcal_sum;            
        }
        
        
        for (var index in dpa) {
            
            dpa[index].kcal = convertKcalToPixel(dpa[index].kcal, kcal_max, kcal_y_axis[2]);            
        }      
                  
        
        var kcalRound =   function(kcal) {
    
            var kcalscal = 10;   
            while (kcal > kcalscal) {
        
                kcalscal += 10;
            }
            return kcalscal;
        };
        
        var k2 = kcalRound(kcal_max);
        var k1 = (k2 * 2/3);
        var k0 = (k2 * 1/3);        
        
        //scal label
        text(context, 2, 420 - kcal_y_axis[0], k0.toFixed(1), "0.7em Arial");
        text(context, 2, 420 - kcal_y_axis[1], k1.toFixed(1), "0.7em Arial");
        text(context, 2, 420 - kcal_y_axis[2], k2.toFixed(1), "0.7em Arial");
                       
                        
        var index = 0;
                        
        while (index < dpa.length -1) {
            
            line(context, dpa[index].datum, dpa[index].kcal, dpa[++index].datum, dpa[--index].kcal, 1); 
            line(context, dpa[++index].datum, dpa[--index].kcal, dpa[++index].datum, dpa[index].kcal, 1);               
        }
        
        //draw limit
        if (tageslimit) {
            
            var target = convertKcalToPixel(tageseinheiten.tageseinheiten, kcal_max, kcal_y_axis[2]);
            setFill(context, "rgba(100%,0%,0%, 0.3)");
            line(context, 41, target, 765, target, 3);
        }
        
        
            
                 
    };
    
    
    this.drawBodyweight = function(json, wunsch_gewicht) {
        
        
        setFill(context, "rgb(0%,0%,100%)");
        var bodyweight = json.payload.bodyweight;
        var wunschgewicht = json.payload.targetweight;
        
        var bwStart;
        var bodyweightPoints = new Array();
        var bwEnd;
        
        var weight_max = wunschgewicht.wunschgewicht;
                        
        if (bodyweight.start != "none") {
            
            weight_max = weight_max > bodyweight.start.weight ? weight_max : bodyweight.start.weight;
            bwStart =  new PointOfWeight("start", bodyweight.start.weight, resolution);       
            
        } else {            
           
            bwStart = new PointOfWeight("start", 0, resolution);
        }       
           
        
        if (bodyweight.data != "none") {
            
            for (var index in bodyweight.data) {
                
                weight_max = weight_max > bodyweight.data[index].weight ? weight_max : bodyweight.data[index].weight;
                bodyweightPoints[index] = new PointOfWeight(bodyweight.data[index].added_on, bodyweight.data[index].weight, resolution);          
            }
        } 
        
        
        if (bodyweight.end != "none") {
            
            weight_max = weight_max > bodyweight.end.weight ? weight_max : bodyweight.end.weight;
            bwEnd = new PointOfWeight("end", bodyweight.end.weight, resolution);
        }
         else {            
            
            bwEnd = new PointOfWeight("end", 0, resolution);            
        }
        
        
        var weightRound =   function(weight) {
    
            var maxscal = 20;   
            while (weight > maxscal) {
        
                maxscal += 1;
            }
            return maxscal;
        };
        
        var w2 = weightRound(weight_max);
        var w1 = (w2 - 50) / 2 + 50;
        var w0 = 50;
        
        
        //scal label
        text(context, 785, 420 - weight_y_axis[0], w0.toFixed(1), "0.7em Arial");
        text(context, 785, 420 - weight_y_axis[1], w1.toFixed(1), "0.7em Arial");
        text(context, 785, 420 - weight_y_axis[2], w2.toFixed(1), "0.7em Arial");
        
        //array to draw
        dpa = new Array();       
        
        bwStart.weight = convertWeightToPixel(bwStart.weight, weight_max, weight_y_axis[0], weight_y_axis[2]);       
        dpa[dpa.length] = bwStart;              
        
        for (var index in bodyweightPoints) {
            
            bodyweightPoints[index].weight = convertWeightToPixel(bodyweightPoints[index].weight, weight_max, weight_y_axis[0], weight_y_axis[2]); 
            dpa[dpa.length] = bodyweightPoints[index];
        }
        
        bwEnd.weight = convertWeightToPixel(bwEnd.weight, weight_max, weight_y_axis[0], weight_y_axis[2]);                    
        dpa[dpa.length] = bwEnd;
                
        var index = 0;        
        while (index < dpa.length - 1) {
            
            line(context, dpa[index].datum, dpa[index].weight, dpa[++index].datum, dpa[--index].weight, 1);
            if (index == dpa.length - 2) break;
            line(context, dpa[++index].datum, dpa[--index].weight, dpa[++index].datum, dpa[index].weight, 1);
        }
        
        
        if (wunsch_gewicht) {
            
            var target = convertWeightToPixel(wunschgewicht.wunschgewicht, weight_max, weight_y_axis[0], weight_y_axis[2]);
            setFill(context, "rgba(0%,0%,100%, 0.2)");
            line(context, 41, target, 765, target, 3);
        }
                   
    };
    
    
    this.drawRRHF = function(json) {
        
        
        var rrhf = json.payload.bloodpressure;
        
        var rrStart;
        var hfStart;
        var rrPoints = new Array();
        var hfPoints = new Array();
        var rrEnd;
        var hfEnd;
        
        var rr_sys = 0;
        // var rr_dia = 0;
        var hf_max = 0;
                        
        if (rrhf.start != "none") {
                        
            rr_sys = rr_sys > rrhf.start.systolic ? rr_sys : rrhf.start.systolic;
            hf_max = parseInt(hf_max) > rrhf.start.pulse ? hf_max : rrhf.start.pulse;  
            
            rrStart =  new PointOfRR("start", rrhf.start.systolic, rrhf.start.diastolic, resolution);       
            hfStart = new PointOfHF("start", rrhf.start.pulse, resolution);
        } else {            
           
            rrStart =  new PointOfRR("start", 0, 0, resolution);       
            hfStart = new PointOfHF("start", 0, resolution);
        }       
           
        
        if (rrhf.data != "none") {
            
            for (var index in rrhf.data) {
                
                rr_sys = rr_sys > rrhf.data[index].systolic ? rr_sys : rrhf.data[index].systolic;   
                hf_max = parseInt(hf_max) > rrhf.data[index].pulse ? hf_max : rrhf.data[index].pulse;         
                
                rrPoints[rrPoints.length] =  new PointOfRR(rrhf.data[index].added_on, rrhf.data[index].systolic, rrhf.data[index].diastolic, resolution);       
                hfPoints[hfPoints.length] = new PointOfHF(rrhf.data[index].added_on, rrhf.data[index].pulse, resolution);        
            }
        } 
        
        
        if (rrhf.end != "none") {
            
            rr_sys = rr_sys > rrhf.end.systolic ? rr_sys : rrhf.end.systolic;
            hf_max = parseInt(hf_max) > rrhf.end.pulse ? hf_max : rrhf.end.pulse;         
            
            rrEnd =  new PointOfRR("end", rrhf.start.systolic, rrhf.start.diastolic, resolution);       
            hfEnd = new PointOfHF("end", rrhf.start.pulse, resolution);
        }
         else {            
            
            rrEnd =  new PointOfRR("end", 0, 0, resolution);       
            hfEnd = new PointOfHF("end", 0, resolution);            
        }
        
        
        var rrRound =   function(rr_max) {
    
            var maxscal = 20;   
            while (rr_max > maxscal) {
        
                maxscal += 1;
            }
            return maxscal;
        };
        
        
        var hfRound =   function(hf) {
    
            var maxscal = 20;   
            while (hf > maxscal) {
        
                maxscal += 1;
            }
            return maxscal;
        };
        
        var rr5 = rrRound(rr_sys);
        var rr4 = rr5 * 5/6;
        var rr3 = rr5 * 4/6;
        var rr2 = rr5 * 3/6;
        var rr1 = rr5 * 2/6;
        var rr0 = rr5 * 1/6;
        
        var hf2 = hfRound(hf_max);
        var hf1 = hf2 * 2/3;
        var hf0 = hf2 * 1/3;
        
        
        //scal label
        setFill(context, "rgb(0%,80%,0%)");
        text(context, 775, 420 - rr_y_axis[0], rr0.toFixed(1), "0.7em Arial");
        text(context, 775, 420 - rr_y_axis[1], rr1.toFixed(1), "0.7em Arial");
        text(context, 775, 420 - rr_y_axis[2], rr2.toFixed(1), "0.7em Arial");
        text(context, 775, 420 - rr_y_axis[3], rr3.toFixed(1), "0.7em Arial");
        text(context, 775, 420 - rr_y_axis[4], rr4.toFixed(1), "0.7em Arial");
        text(context, 775, 420 - rr_y_axis[5], rr5.toFixed(1), "0.7em Arial");
        
        
        
        // arr
        dpa = new Array();       
        
        rrStart.systolic = convertRRToPixel(rrStart.systolic, rr_sys, rr_y_axis[5]);       
        rrStart.diastolic = convertRRToPixel(rrStart.diastolic, rr_sys, rr_y_axis[5]);
        dpa[dpa.length] = rrStart;              
        
        for (var index in rrPoints) {
            
            rrPoints[index].systolic = convertRRToPixel(rrPoints[index].systolic, rr_sys, rr_y_axis[5]); 
            rrPoints[index].diastolic = convertRRToPixel(rrPoints[index].diastolic, rr_sys, rr_y_axis[5]);
            dpa[dpa.length] = rrPoints[index];
        }
        
        rrEnd.systolic = convertRRToPixel(rrEnd.systolic, rr_sys, rr_y_axis[5]);       
        rrEnd.diastolic = convertRRToPixel(rrEnd.diastolic, rr_sys, rr_y_axis[5]);               
        dpa[dpa.length] = rrEnd;
                
        var index = 0;           
        while (index < dpa.length - 1) {
            
            line(context, dpa[index].datum, dpa[index].systolic, dpa[++index].datum, dpa[--index].systolic, 1);
            if (index == dpa.length - 2) break;
            line(context, dpa[++index].datum, dpa[--index].systolic, dpa[++index].datum, dpa[index].systolic, 1);
        }
        index = 0; 
        while (index < dpa.length - 1) {
            
            line(context, dpa[index].datum, dpa[index].diastolic, dpa[++index].datum, dpa[--index].diastolic, 1);
            if (index == dpa.length - 2) break;
            line(context, dpa[++index].datum, dpa[--index].diastolic, dpa[++index].datum, dpa[index].diastolic, 1);
        }
        
        //hf
        dpa = new Array();          
        hfStart.hf = convertHFToPixel(hfStart.hf, hf_max, hf_y_axis[2]); 
        dpa[dpa.length] = hfStart;              
        
        for (var index in hfPoints) {
            
            hfPoints[index].hf = convertHFToPixel(hfPoints[index].hf, hf_max, hf_y_axis[2]); 
            dpa[dpa.length] = hfPoints[index];
        }
        
        hfEnd.hf = convertHFToPixel(hfEnd.hf, hf_max, hf_y_axis[2]);              
        dpa[dpa.length] = hfEnd;
        
        setFill(context, "rgb(50%,50%,50%)");
        text(context, 10, 420 - hf_y_axis[0], hf0.toFixed(1), "0.7em Arial");
        text(context, 10, 420 - hf_y_axis[1], hf1.toFixed(1), "0.7em Arial");
        text(context, 10, 420 - hf_y_axis[2], hf2.toFixed(1), "0.7em Arial");
        
        index = 0;        
        while (index < dpa.length - 1) {
                        
            line(context, dpa[index].datum, dpa[index].hf, dpa[++index].datum, dpa[--index].hf, 1);
            if (index == dpa.length - 2) break;            
            line(context, dpa[++index].datum, dpa[--index].hf, dpa[++index].datum, dpa[index].hf, 1);
        }
               
    };
    
    
    var drawScal = function() {
        
        setFill(context, "rgb(0%,0%,0%)");
        switch (resolution) {            
                            
            case CALENDAR_RESOLUTION_MODIF.TAG:
            
                var hourLabel = 3;
                for (var i = 0; i<7; i++) {
                    
                    var scLine = new Line(new Point(res_tag_x_axis[i] + 40, 420), new Point(res_tag_x_axis[i] + 40, 425));
                    line(context, scLine.p1.x, scLine.p1.y, scLine.p2.x, scLine.p2.y);
                    text(context, hourLabel < 10 ? res_tag_x_axis[i]  + 38 : res_tag_x_axis[i]  + 36, 437, hourLabel, "0.7em Arial");  
                    hourLabel += 3;
                }                  
                
            break;
                                                         
                            
            case CALENDAR_RESOLUTION_MODIF.WOCHE:
            
                for (var i = 0; i<6; i++) {
                    
                    var scLine = new Line(new Point(res_week_x_axis[i] + 40, 420), new Point(res_week_x_axis[i] + 40, 425));
                    line(context, scLine.p1.x, scLine.p1.y, scLine.p2.x, scLine.p2.y);
                    text(context, res_week_x_axis[i] - 33, 432, calendar.getDayName(calendar.markedWeek[i].getDay()), "0.7em Arial");  
                }
                    text(context, res_week_x_axis[6] - 33, 432, calendar.getDayName(calendar.markedWeek[6].getDay()), "0.7em Arial");  
                    
            break;
                            
                            
            case CALENDAR_RESOLUTION_MODIF.MONAT:
                
                var anzTage = calendar.getDaysInMonth(calendar.viewedMonthStart.getFullYear(), calendar.viewedMonthStart.getMonth());
                
                switch (anzTage) {
                    
                    case 30:
                                        
                    for (var i = 0; i<res_month_30_x_achis.length; i++) {
                    
                        var scLine = new Line(new Point(res_month_30_x_achis[i] + 40, 420), new Point(res_month_30_x_achis[i] + 40, 425));
                        line(context, scLine.p1.x, scLine.p1.y, scLine.p2.x, scLine.p2.y);
                        text(context, res_month_30_x_achis[i] + 22, 437, (i+1), "0.7em Arial");  
                    }
                    
                    break;
                    
                    
                    case 31:
                    
                    for (var i = 0; i<res_month_31_x_achis.length; i++) {
                    
                        var scLine = new Line(new Point(res_month_31_x_achis[i] + 40, 420), new Point(res_month_31_x_achis[i] + 40, 425));
                        line(context, scLine.p1.x, scLine.p1.y, scLine.p2.x, scLine.p2.y);
                        text(context, res_month_31_x_achis[i] + 22, 437, (i+1), "0.7em Arial");  
                    }
                    break;
                    
                    
                    case 28:
                    
                    for (var i = 0; i<res_month_28_x_achis.length; i++) {
                    
                        var scLine = new Line(new Point(res_month_28_x_achis[i] + 40, 420), new Point(res_month_28_x_achis[i] + 40, 425));
                        line(context, scLine.p1.x, scLine.p1.y, scLine.p2.x, scLine.p2.y);
                        text(context, res_month_28_x_achis[i] + 22, 437, (i+1), "0.7em Arial");  
                    }
                    break;
                    
                    
                    case 29:
                    
                    for (var i = 0; i<res_month_29_x_achis.length; i++) {
                    
                        var scLine = new Line(new Point(res_month_29_x_achis[i] + 40, 420), new Point(res_month_29_x_achis[i] + 40, 425));
                        line(context, scLine.p1.x, scLine.p1.y, scLine.p2.x, scLine.p2.y);
                        text(context, res_month_29_x_achis[i] + 22, 437, (i+1), "0.7em Arial");  
                    }  
                    break;
                }
                     
                
                              
            break;
                            
                           
            case CALENDAR_RESOLUTION_MODIF.THERAPIEZEIT:                          
                
                text(context, 350, 432, "Verlauf der gesammten Therapie", "0.7em Arial");  
            break; 
            
        }
    };
    
    
    
    drawGraph();
}
