/**
* This program is free software: you can redistribute it and/or modify it under
* the terms of the GNU Lesser General Public License as published by the Free
* Software Foundation, either version 3 of the License, or (at your option) any
* later version.
*
* This program is distributed in the hope that it will be useful, but WITHOUT
* ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
* FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more
* details.
*
* You should have received a copy of the GNU Lesser General Public License
* along with this program. If not, see http://gnu.org/licenses/lgpl.txt.
*
* @fileOverview Stepwise display of local sequence alignment calculation
* @author <a href="mailto:schnieders.a@gmail.com">Andreas Schnieders</a>
* @copyright 2012 Andreas Schnieders
* @license http://gnu.org/licenses/lgpl.txt LGPL-3.0+
* @version 0.1.0
* @see <a href="http://github.com/FlorianWolters/SequenceAlignment">SequenceAlignment</a>
* @since File available since Release 0.1.0
*/

// // Some helper-variables for messing around
var numRows = 0;
var numColums = 0;
var totalCells = 0;
var numRowsShown = 0;
var fillCellIndex = 0;
var score = 0;
var scoreCellIndex = -1;
var firstClick = false;
var currentColumn = -1;
var currentRow = -1;
var lastRow = -1;
var cellValueSource = -1;

function initCells()
{
    for (i = 0; i < totalCells; ++i)
    {
        $('#matrix').find($('td:eq(' + i + ')')).css('background-color', '');
    }
    
    for (i = fillCellIndex; i < totalCells; ++i)
    {
        var nextRow = (i / numColums)|0;

        if (i != (nextRow * numColums))
        {
            $('#matrix').find($('td:eq(' + i + ')')).removeClass("valueShown");
            $('#matrix').find($('td:eq(' + i + ')')).addClass("valueHidden");
        }
    }
}

// TODO: DOCUMENTATION
function initIndexes()
{
    // Initialisation of helper variables
    numRows = $('#matrix').find('tr').length;
    numColums = $('#matrix').find($('tr:eq(0)')).find('td').length;
    totalCells = $('#matrix').find($('tr')).find('td').length;
    numRowsShown = 1;

    // Cells are indexed row by row from 0 to (numRows*numColums)
    // First alignment value is to be set in the second cell of the second row
    fillCellIndex = numColums + 1;
}

// TODO: DOCUMENTATION
function nextStepCalc()
{
    if(fillCellIndex >= (totalCells-1)) return;
    
    if(!firstClick) 
    {
        fillZeros();
        firstClick = true;
        return;
    }
        
    currentRow    = fillCellIndex - currentColumn;
    
    var nextRow   = (fillCellIndex / numColums)|0;
    nextRow++;
    
    if(currentRow != nextRow) 
    {
        $('#matrix').find($('td:eq(' + currentRow + ')')).css('background-color', '');
        lastRow = currentRow;
    }

    if ((fillCellIndex + 1) != (nextRow * numColums))
    {
        ++fillCellIndex;
    }
    else
    {
        $('#matrix').find($('td:eq(' + (numColums-1) + ')')).css('background-color', '');
        fillCellIndex += 3;
    }
    currentColumn = (fillCellIndex) % numColums;
    currentRow    = fillCellIndex - currentColumn;
    
    $('#matrix').find($('td:eq(' + (currentColumn-1) + ')')).css('background-color', '');
    $('#matrix').find($('td:eq(' + cellValueSource + ')')).css('background-color', '');
    
    var compareRow    = $('#matrix').find($('td:eq(' + currentRow + ')')).html();
    var compareColumn = $('#matrix').find($('td:eq(' + currentColumn + ')')).html();
    
    var match = false;
    
    match = (compareRow === compareColumn);
    
    //alert("compareRow(" + compareRow + ") == compareColumn(" + compareColumn + ")? " + (compareRow === compareColumn));        
    
    setTimeout(function(){
        getCellValueSource(fillCellIndex);
        //alert("fillCellIndex= " + fillCellIndex + " currentRow= " + currentRow + " numColumns= " + numColums);
        if(match) 
        {
            $('#matrix').find($('td:eq(' + currentColumn + ')')).css('background-color', '#00FF33');
            $('#matrix').find($('td:eq(' + currentRow + ')')).css('background-color', '#00FF33');
            $('#matrix').find($('td:eq(' + fillCellIndex + ')')).css('background-color', '#72FE95');       
            $('#matrix').find($('td:eq(' + cellValueSource + ')')).css('background-color', '#72FE95');
        }
        else 
        {
            $('#matrix').find($('td:eq(' + currentColumn + ')')).css('background-color', '#FF5353');
            $('#matrix').find($('td:eq(' + currentRow + ')')).css('background-color', '#FF5353');
            $('#matrix').find($('td:eq(' + fillCellIndex + ')')).css('background-color', '#FF7373');       
            $('#matrix').find($('td:eq(' + cellValueSource + ')')).css('background-color', '#FF7373');
        }
        
        $('#matrix').find($('td:eq(' + fillCellIndex + ')')).removeClass("valueHidden");
        $('#matrix').find($('td:eq(' + fillCellIndex + ')')).addClass("valueShown");  
        
    }, 200);
    
}

function getCellValueSource(index)
{
    var topLeftIndex = index-numColums-1;
    var topIndex     = index-numColums;
    var leftIndex    = index-1;

    var topLeftCellValue = $('#matrix').find($('td:eq(' + topLeftIndex + ')')).html();
    var topCellValue     = $('#matrix').find($('td:eq(' + topIndex + ')')).html(); 
    var leftCellValue    = $('#matrix').find($('td:eq(' + leftIndex + ')')).html(); 
    
    clearValueCellsBackgrounds();
    
    $('#matrix').find($('td:eq(' + topLeftIndex + ')')).css('background-color', '#C0C0C0');
    $('#matrix').find($('td:eq(' + topIndex + ')')).css('background-color', '#C0C0C0');
    $('#matrix').find($('td:eq(' + leftIndex + ')')).css('background-color', '#C0C0C0');

    var tmpMax   = topLeftCellValue;
    var maxIndex = topLeftIndex;

    //alert("1 topCellValue: " + topCellValue + " tmpMax: " + tmpMax + " (topCellValue|0 > tmpMax|0)= " + ((topCellValue|0) > (tmpMax|0)) );
    if((topCellValue|0) > (tmpMax|0)) 
    {
        maxIndex = topIndex;
        tmpMax   = topCellValue;
        //alert("2 tmpMax: " + tmpMax + " maxIndex: " + maxIndex + " topCellValue: " + topCellValue);
    }
    if((leftCellValue|0) > (tmpMax|0)) 
    {
        maxIndex = leftIndex;
        //alert("3 tmpMax: " + tmpMax + " maxIndex: " + maxIndex + " leftCellValue: " + leftCellValue);
    }
    cellValueSource = maxIndex;
}

// TODO: DOCUMENTATION
function nextRowCalc()
{    
    if(!firstClick) 
    {
        fillZeros();
        firstClick = true;
    }
    else
    {
        if(fillCellIndex > totalCells) return;
        
        for (i = 0; i < totalCells; ++i)
        {
            $('#matrix').find($('td:eq(' + i + ')')).css('background-color', '');
        }
        
        // |0 to 'cast' double-division-result to integer
        var currentRow = (fillCellIndex / numColums)|0;
        ++currentRow; // Because row-count starts from 0

        for (i = fillCellIndex; i < (currentRow*numColums); ++i)
        {
            $('#matrix').find($('td:eq(' + i + ')')).removeClass("valueHidden");
            $('#matrix').find($('td:eq(' + i + ')')).addClass("valueShown");
            fillCellIndex = i;

            highlightCalculationRelevantCells();
        }
        fillCellIndex += 2;
    }
}

// TODO: DOCUMENTATION
function completeAlignment()
{
    initCells();
    for (i = fillCellIndex; i < totalCells; ++i)
    {
        var nextRow = (i / numColums)|0;

        if (i != (nextRow * numColums))
        {
            $('#matrix').find($('td:eq(' + i + ')')).removeClass("valueHidden");
            $('#matrix').find($('td:eq(' + i + ')')).addClass("valueShown");
            
            fillCellIndex = i;
            //highlightCalculationRelevantCells();
        }
    }

    initIndexes();

}

function completeBacktrack()
{
    getScoreAndCellIndex();
    
    var currentBacktrackCellIndex = scoreCellIndex;
    var currentRow = ((currentBacktrackCellIndex/numColums)|0)-1;
    
    $('#matrix').find($('td:eq(' + (currentBacktrackCellIndex) + ')')).css('background-color', '#CC0000');    
    $('#matrix').find($('td:eq(' + (currentBacktrackCellIndex) + ')')).css('color', '#FFFFFF');
    
    while(currentRow > 1)
    {
        var topLeftIndex = currentBacktrackCellIndex-numColums-1;
        var topIndex     = currentBacktrackCellIndex-numColums;
        var leftIndex    = currentBacktrackCellIndex-1;

        var topLeftCellValue = $('#matrix').find($('td:eq(' + topLeftIndex + ')')).html();
        var topCellValue     = $('#matrix').find($('td:eq(' + topIndex + ')')).html(); 
        var leftCellValue    = $('#matrix').find($('td:eq(' + leftIndex + ')')).html(); 

        var tmpMax   = topLeftCellValue;
        var maxIndex = topLeftIndex;

        //alert("1 topCellValue: " + topCellValue + " tmpMax: " + tmpMax + " (topCellValue|0 > tmpMax|0)= " + ((topCellValue|0) > (tmpMax|0)) );
        if((topCellValue|0) > (tmpMax|0)) 
        {
            maxIndex = topIndex;
            tmpMax   = topCellValue;
            //alert("2 tmpMax: " + tmpMax + " maxIndex: " + maxIndex + " topCellValue: " + topCellValue);
        }
        if((leftCellValue|0) > (tmpMax|0)) 
        {
            maxIndex = leftIndex;
            //alert("3 tmpMax: " + tmpMax + " maxIndex: " + maxIndex + " leftCellValue: " + leftCellValue);
        }
        
        if((currentBacktrackCellIndex%numColums) == 1) {
            return;
        }

        $('#matrix').find($('td:eq(' + maxIndex + ')')).css('background-color', '#66FF33');
        
        currentBacktrackCellIndex = maxIndex;
        currentRow = ((currentBacktrackCellIndex/numColums)|0)-1;
    }

}

function clearValueCellsBackgrounds()
{
    for (i = numColums+1; i < totalCells; ++i)
    {
        var nextRow = (i / numColums)|0;

        if (i != (nextRow * numColums))
        {
            $('#matrix').find($('td:eq(' + i + ')')).css('background-color', '');
        }
    }
}

function highlightCalculationRelevantCells()
{
    /*
    // Demo of coloring calculation-relevant table-cells for visualisation
    // instead of using tooltips
    var currentCellValue     = $('#matrix').find($('td:eq(' + (fillCellIndex) + ')')).html();
    var topNextCellValue     = $('#matrix').find($('td:eq(' + (fillCellIndex-numColums) + ')')).html();
    var topLeftNextCellValue = $('#matrix').find($('td:eq(' + (fillCellIndex-numColums-1) + ')')).html();
    var leftNextCellValue    = $('#matrix').find($('td:eq(' + (fillCellIndex-1) + ')')).html();

    if (fillCellIndex > 2 * numColums)
    {
        if(currentCellValue != topNextCellValue) 
        {    
            $('#matrix').find($('td:eq(' + (fillCellIndex) + ')')).css('background-color', '#66FF33');
            $('#matrix').find($('td:eq(' + (fillCellIndex-numColums) + ')')).css('background-color', '#66FF33');
            $('#matrix').find($('td:eq(' + (fillCellIndex-numColums-1) + ')')).css('background-color', '#66FF33');
        }
    }
    */
}

function getScoreAndCellIndex()
{
    completeAlignment();
    score = $('#score').html();
    
    for(i = 8; i < totalCells; ++i)
    {
        if($('#matrix').find($('td:eq(' + (i) + ')')).html() === score)
        {
            scoreCellIndex = i;
        }
    }
}

function fillZeros()
{
    for (i = fillCellIndex; i < (2*numColums); ++i)
    {
        $('#matrix').find($('td:eq(' + i + ')')).html("0");
        $('#matrix').find($('td:eq(' + i + ')')).removeClass("valueHidden");
        $('#matrix').find($('td:eq(' + i + ')')).addClass("valueShown");
    }
    
    for( i = (2*numColums)+1; i<totalCells; i+=numColums)
    {
        $('#matrix').find($('td:eq(' + i + ')')).html("0");
        $('#matrix').find($('td:eq(' + i + ')')).removeClass("valueHidden");
        $('#matrix').find($('td:eq(' + i + ')')).addClass("valueShown");        
    }
    
    fillCellIndex = 2*numColums+1;
}

// TODO: DOCUMENTATION
function resetCalc()
{
    initIndexes();
    initCells();
    firstClick = false;
}

$(document).ready(function() {

    initIndexes();
    initCells();

    // Stepwise enter the calculated alignment values cell by cell
    $('#nextStepCalc').click(function(event){
        nextStepCalc();
        event.preventDefault();
    });

    // Stepwise enter the calculated alignment values row by row
    $('#nextRowCalc').click(function(event){
        nextRowCalc();
        event.preventDefault();
    });

    // Display full aligment table at once
    $('#completeAlignment').click(function(event){
        completeAlignment();
        event.preventDefault();
    });

    // Reset alignment table, clear all values and colors
    $('#resetCalc').click(function(event){
        resetCalc();
        event.preventDefault();
    });
    
    $('#nextStepBt').click(function(event){
        nextStepBt();
        event.preventDefault();
    });

    $('#completeBacktrack').click(function(event){
        completeBacktrack();
        event.preventDefault();
    });
    
    $('#resetBt').click(function(event){
        resetBt();
        event.preventDefault();
    });
    // Send Form on Enter. Only works from inputs that do not allow
    // carriage returns
    $(function() {
        $('form').each(function() {
            $('input').keypress(function () {
                // Check whether the "Enter" is pressed.
                if (e.which == 10 || e.which == 13) {
                    this.form.submit();
                }
            });

            $('input[type=submit]').hide();
        });
    });

});
