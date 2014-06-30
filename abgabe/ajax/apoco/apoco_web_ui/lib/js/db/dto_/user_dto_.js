


function UserDTO() {
    
    this.vorname;
    this.nachname;
    this.email;
    this.password;
    
    this.toJSONObj = function() {
        
        
        return JSON.parse(
            '{"vorname": "'
        + this.vorname 
        + '", "nachname": "'
        + this.nachname 
        + '", "email": "'
        + this.email 
        + '", "password": "'
        + this.password 
        + '"}' );
    }
}
