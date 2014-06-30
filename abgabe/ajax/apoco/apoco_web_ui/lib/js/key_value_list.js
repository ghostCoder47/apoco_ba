

function KeyValueList() {
    
    var keyValuePairs = new Array();
    var elements = 0;
    
    
    this.addKeyValue = function(kv) {
     
        if (KeyValuePair.prototype.isPrototypeOf(kv)) {
            
            keyValuePairs[elements] = kv;
            elements++;            
        }
    };
    
    
    this.toParams = function() {
        
        var params;
        for (var index in keyValuePairs) {
            
            if (index > 0) {
                
                params +="&";
            } else if (index == 0) {
                
                params = "?";
            }
            params += keyValuePairs[index].key + "=" + keyValuePairs[index].value;
        }    
        return params;
    };
    
}