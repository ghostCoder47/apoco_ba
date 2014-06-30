


function AjaxManager() {
    
    
    this.getUserList = function(callbackObject, keyValueList) {
        
        var url = "/apoco/apoco_web_ui/db_url/user_list.php";
        go(callbackObject, keyValueList, url);
    };
    
    
    this.getUserPreview = function(callbackObject, keyValueList) {
                
        var url = "/apoco/apoco_web_ui/db_url/user_preview.php";
        go(callbackObject, keyValueList, url);        
    };
    
    
    this.insertWunschgewicht = function(callbackObject, keyValueList) {
        
        var url = "/apoco/apoco_web_ui/db_url/insert_wunschgewicht.php";
        go(callbackObject, keyValueList, url);
    };
    
    
    this.insertTageslimit = function(callbackObject, keyValueList) {
        
        var url = "/apoco/apoco_web_ui/db_url/insert_tageslimit.php";
        go(callbackObject, keyValueList,url);
    };
    
    
    this.getGraphDataALL = function(callbackObject, keyValueList) {
        
        var url = "/apoco/apoco_web_ui/db_url/get_graph_data_all.php";
        go(callbackObject, keyValueList, url);
    };
    
    //not in use
    this.getGraphDataRR_HF = function(callbackObject, keyValueList) {
        
        var url = "/apoco/apoco_web_ui/db_url/get_graph_data_rr_hf.php";
        go(callbackObject, keyValueList, url);
    };
    
    //not in use
    this.getGraphDataKCAL_KG = function(callbackObject, keyValueList) {
        
        var url = "/apoco/apoco_web_ui/db_url/get_graph_data_kcal_kg.php";
        go(callbackObject, keyValueList, url);
    };
    
    //not in use
    this.getGraphDataMEAL = function(callbackObject, keyValueList) {
        
        var url = "/apoco/apoco_web_ui/db_url/get_graph_data_meal.php";
        go(callbackObject, keyValueList, url);
    };
    
    
    function go(callbackObject, keyValueList, url) {
        
        var ajax = new AJAX();
        var params = keyValueList.toParams();  
        ajax.sndReqGET(url, params, callbackObject);    
    }
    
    
    
}
