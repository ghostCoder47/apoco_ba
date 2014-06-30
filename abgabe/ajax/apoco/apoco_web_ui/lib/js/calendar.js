

//MODIFIER
var CALENDAR_RESOLUTION_MODIF = Object.freeze( {
    
   "TAG":0,
   "WOCHE":1,
   "MONAT":2,
   "THERAPIEZEIT":3 
});




/*
 * CalendarMatrixZell
 */
var CMZ = Object.freeze( {
    
    "DAY_NUMBER":0,
    "ONMONTH":1,
    "DATUM":2,
    "HIGHLITE":3,
    "CURRENT_DAY":4,
    "MARKED":5   
});

function Calendar() {
    
    this.calendarResolutionModif;    
    this.currentDate;
    this.viewedMonthStart;
    this.markedDate;
    this.lastMarkedDate;
    this.drawMatrix;
    this.markedWeek;    
        
    
    this.recalculate = function() {
    
        var displayDate     = new Date(this.viewedMonthStart.getTime());
        var firstDayIndex   = displayDate.getDay();
        
        if (firstDayIndex == 0) {
            
            firstDayIndex = 7;    
        }
        displayDate.setDate(displayDate.getDate() - firstDayIndex +1);    
            

        for (var row = 0; row < 6; row++) {
            
            for ( var col = 0; col < 7; col++) {                
                
                this.drawMatrix[row][col][CMZ.DAY_NUMBER]  = displayDate.getDate();                                                     //Zahl für Kalenderzelle
                this.drawMatrix[row][col][CMZ.ONMONTH]     = displayDate.getMonth() == this.viewedMonthStart.getMonth() ? true:false;   //Markierung ob das ein Tag im Aktuellen, angezeigten Monat ist
                this.drawMatrix[row][col][CMZ.DATUM]       = new Date(displayDate.getTime());                                           //vollständiges Datum welches diese Zelle representiert
                this.drawMatrix[row][col][CMZ.HIGHLITE]    = false;                                                                     //existiert für diesen Tag ein Highlite
                this.drawMatrix[row][col][CMZ.CURRENT_DAY] = displayDate.getTime() == this.currentDate.getTime() ? true:false;          //Zelle representiert den Aktuellentag
                this.drawMatrix[row][col][CMZ.MARKED]      = false;                                                                     //gehöhrt die Zelle zu in der View dargestellten Daten                                 
                
                displayDate.setDate(displayDate.getDate() + 1); 
            }
        }
           
        
        if (this.calendarResolutionModif == CALENDAR_RESOLUTION_MODIF.WOCHE) {
            
            
            for (var row = 0; row < 6; row++) {
                           
                for ( var col = 0; col < 7; col++) {            
                           
                    for (var i = 0; i < 7; i++) {
                            
                        if (this.drawMatrix[row][col][CMZ.DATUM].getTime() == this.markedWeek[i].getTime()) {
                                
                            this.drawMatrix[row][col][CMZ.MARKED] = true;
                        }
                            
                    
                    }
                }       
            }          
           
            
        } else if (this.calendarResolutionModif == CALENDAR_RESOLUTION_MODIF.TAG) {
            
            
            loop1:
            for (var row = 0; row < 6; row++) {
                        
                for ( var col = 0; col < 7; col++) {            
                    
                    if (this.drawMatrix[row][col][CMZ.DATUM].getTime() == this.markedDate.getTime()) {
                        
                        this.drawMatrix[row][col][CMZ.MARKED] = true;                    
                        break loop1;
                    }
                }
            }
            
        }        
    };
    
    
    this.getDaysInMonth = function( iFullYear, iMonth ) {
        
        var iDaysInMonth = 32 - new Date( iFullYear, iMonth, 32 ).getDate();
        return iDaysInMonth;
    };
    


    this.getMonthName = function(month) {
        
        monthNames = ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];    
        return monthNames[month];
    };
    
    
    this.getDayName = function(day) {
        
        dayNames = ["Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag"];
        return dayNames[day];
    };
    
    
    this.prevMonth = function() {        
        
        this.viewedMonthStart.setMonth(this.viewedMonthStart.getMonth() -1);
        
        
        if (this.calendarResolutionModif == CALENDAR_RESOLUTION_MODIF.MONAT) {            
            
            this.markedDate = new Date(this.viewedMonthStart.getTime());
            var initDate = new Date(this.markedDate);
            for (var i = 0; i<7; i++) {                
                
                this.markedWeek[i] = new Date(initDate);
                initDate.setDate(initDate.getDate() + 1);
            }
        }    
        
        this.recalculate();
    };
    
        
    this.nextMonth = function() {
        
        this.viewedMonthStart.setMonth(this.viewedMonthStart.getMonth() +1);
        
        
        if (this.calendarResolutionModif == CALENDAR_RESOLUTION_MODIF.MONAT) {            
            
            this.markedDate = new Date(this.viewedMonthStart.getTime());
            var initDate = new Date(this.markedDate);
            for (var i = 0; i<7; i++) {                
                
                this.markedWeek[i] = new Date(initDate);
                initDate.setDate(initDate.getDate() + 1);
            }
        }    
        
        this.recalculate();
    };
    
    
    this.resolutionModif = function(modif) {
        
        this.calendarResolutionModif = modif;
        this.recalculate();
    };
    
    

    
    
    this.jumpToCurrentDay = function() {
        
        var firstRowIndex   = this.currentDate.getDay();    
        if (firstRowIndex == 0) {
            
            firstRowIndex = 7;    
        }
        
        var jumpDate = new Date(this.currentDate.getTime());
        jumpDate.setDate(jumpDate.getDate() - firstRowIndex +1); 
        
        this.viewedMonthStart.setFullYear(jumpDate.getFullYear());
        this.viewedMonthStart.setMonth(jumpDate.getMonth());
        
        for (var i = 0; i<7; i++) {
                        
            this.markedWeek[i] = new Date(jumpDate.getTime());
            jumpDate.setDate(jumpDate.getDate() + 1);        
        }    
        this.markedDate = new Date(this.currentDate.getTime());
        
        this.recalculate();
    };
    
    
    this.prevDay = function() {
        
        for (var i = 0; i<7; i++) {
                        
            this.markedWeek[i].setDate(this.markedWeek[i].getDate() - 1);        
        }  
        this.markedDate.setDate(this.markedDate.getDate() - 1);   
        
        
        this.recalculate();
    };
    
    
    this.nextDay = function() {
        
        for (var i = 0; i<7; i++) {
                        
            this.markedWeek[i].setDate(this.markedWeek[i].getDate() + 1);        
        }  
        this.markedDate.setDate(this.markedDate.getDate() + 1);   
        
        
        this.recalculate();
    };

    
    this.init = function() {
    
        this.calendarResolutionModif = CALENDAR_RESOLUTION_MODIF.WOCHE;        
        
        this.initDate            = new Date();
        this.currentDate         = new Date(this.initDate.getFullYear(), this.initDate.getMonth(), this.initDate.getDate());
        this.markedDate          = new Date(this.currentDate);
        this.lastMarkedDate      = new Date(this.currentDate);
        this.viewedMonthStart    = new Date(this.initDate.getFullYear(), this.initDate.getMonth(), 1);
        
        
        var displayDate     = new Date(this.viewedMonthStart.getTime());
        var firstDayIndex   = displayDate.getDay();
        
        if (firstDayIndex == 0) {
            
            firstDayIndex = 7;    
        }
        displayDate.setDate(displayDate.getDate() - firstDayIndex +1);    
            
        
        
        this.drawMatrix = new Array(6);        
        for (var i = 0; i < 6; i++) {
            
            this.drawMatrix[i] = new Array(7);
        }
        
        
        for (var row = 0; row < 6; row++) {
            
            for ( var col = 0; col < 7; col++) {
                
                this.drawMatrix[row][col] = new Object();
                this.drawMatrix[row][col][CMZ.DATUM]       = new Date(displayDate.getTime()); //vollständiges Datum welches diese Zelle representiert                                                              
                displayDate.setDate(displayDate.getDate() + 1); 
            }
        }
        
        
        this.markedWeek = new Array(7);    
        loop1:
        for (var row = 0; row < 6; row++) {
                    
            for ( var col = 0; col < 7; col++) {            
                
                if (this.drawMatrix[row][col][CMZ.DATUM].getTime() == this.markedDate.getTime()) {
                    
                    for (var i = 0; i < 7; i++) {
            
                        this.markedWeek[i] = new Date(this.drawMatrix[row][i][CMZ.DATUM].getTime()); 
                        this.drawMatrix[row][i][CMZ.MARKED] = true;
                    }
                    break loop1;
                }
            }
        }   
        
        this.recalculate();     
    };
    
    
    
    
    this.init();
}


function DateTools() {
    
    this.dateToString = function(date) {
        
        if (Date.prototype.isPrototypeOf(date)) {
            
            var string = date.getFullYear()
            + "-" 
            + (date.getMonth() + 1)
            + "-" 
            + date.getDate();
            return string;
        }
    };
    
    
    this.dayBeforeDateAsString = function(date) {
        
        if (Date.prototype.isPrototypeOf(date)) {            
          
            var tmp = new Date(date);            
            tmp.setDate(tmp.getDate() - 1);
            return this.dateToString(tmp);
        }
    };
    
    
    this.dayAfterDateAsString = function(date) {
        
        if (Date.prototype.isPrototypeOf(date)) {
                     
            var tmp = new Date(date);            
            tmp.setDate(tmp.getDate() + 1);
            return this.dateToString(tmp);
        }
    };
}
