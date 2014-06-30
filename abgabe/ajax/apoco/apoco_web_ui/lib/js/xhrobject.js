

function AJAX() {
    
    
    var xhrObj;
    var callbackObject;  
    
    
    this.sndReqGET = function(url, params, cbo) {  
        
        callbackObject = cbo;
        
        if (null == xhrObj) {
            
            alert("An Error occured when trying to initialize XMLHttpRequest!");
        } else {
            
            xhrObj.open("get", url + params, true);
            xhrObj.onreadystatechange = handleResponse;
            xhrObj.send(null);
        }       
        
    };
    
    
    this.sndReqPOST = function(url, params, cbo) {
        
        callbackObject = cbo;
        
        if (null == xhrObj) {
            
            alert("An Error occured when trying to initialize XMLHttpRequest!");
        } else {
            
            xhrObj.open("post", url, true);
            xhrObj.setRequestHeader("Content-type", "application/x-www-form-urlencoded");            
            xhrObj.setRequestHeader("Content-length", params.length);
            xhrObj.onreadystatechange = handleResponse;
            xhrObj.send(params);
        }      
    };
    
    
    var handleResponse = function() {
        
        if (xhrObj.readyState==4 && xhrObj.status==200) {
            
            var json = JSON.parse(xhrObj.responseText);
            if (json.success == 1) {
                
                if (null != callbackObject) {
                                        
                    callbackObject.update(json);               
                }
            }
        }       
    };
    
     var createXHRObject = function() {
    
        var resObject = null;
            
        try {
                
            // IE 6 +
            resObject = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (Error) {
                
            try {
                // IE 5
                resObject = new ActiveXObject("MSXML2.XMLHTTP");
            } catch (Error) {
                    
                try {
                    // MOZILA, Opera, Safari ...                    
                    resObject = new XMLHttpRequest();
                } catch (Error) {
                    
                    alert("Ajax mit diesem Browser nicht möglich");
                }
            }
        }
            
        return resObject;
    };
    
    xhrObj = createXHRObject();    
}

