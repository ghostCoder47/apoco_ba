

var PAGE_MODIF = Object.freeze( {
    
   "PAT_LISTE":0,
   "PAT_DETAILS":1
});

function PageChooser() {
    
    this.page_modif = PAGE_MODIF.PAT_LISTE;
    
    this.changePage = function(modif) {
        
        this.page_modif = modif;
    };    
    
}

