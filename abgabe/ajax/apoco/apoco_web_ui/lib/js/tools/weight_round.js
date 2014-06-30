


function weightRound(weight) {
    
    var maxscal = 90;
    
    while (weight > maxscal) {
        
        maxscal += 20
    }
    return maxscal;
}
