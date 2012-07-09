$(document).ready(function(){
    var numShown = 1; // Initial rows shown & index
    var numMore = 1; // Increment
    var numRows = $("#matrix").find("tr").length; // Total # rows
    var numRowsShown = 1;
   
    //$("#matrix").hide();
    //$("table").hide();
    for(i=1; i < numRows; i++)
    {
        $("#matrix").find($("tr:eq(" + i + ")").hide());
        $("#matrix").find($("tr:eq(" + i + ")").find('td:first').show());
    }
   
    $("#stepButton").click(function(event){
        $("#matrix").find($("tr:eq(" + numRowsShown + ")").show());
        numRowsShown++;
        

       //$("#matrix").show();
       //alert(numRows + " rows in table matrix");
       event.preventDefault();        
    });    
});