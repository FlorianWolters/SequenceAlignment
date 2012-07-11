/**
 * This program is free software: you can redistribute it and/or modify it under
 * the terms of the GNU Lesser General Public License as published by the Free
 * Software Foundation, either version 3 of the License, or (at your option) any
 * later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public License for more
 * details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see http://gnu.org/licenses/lgpl.txt.
 *
 * @fileOverview Stepwise display of local sequence alignment calculation
 * @author       <a href="mailto:schnieders.a@gmail.com">Andreas Schnieders</a>
 * @copyright    2012 Andreas Schnieders
 * @license      http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version      0.1.0
 * @see          <a href="http://github.com/FlorianWolters/SequenceAlignment">SequenceAlignment</a>
 * @since        File available since Release 0.1.0
 */

// // Some helper-variables for messing around
var numRows         = 0;
var numColums       = 0;
var totalCells      = 0;
var numRowsShown    = 0;
var fillCellIndex   = 0;

function initCells()
{
    for(i = fillCellIndex; i < totalCells; ++i)
    {
        var nextRow = (i / numColums)|0;

        if( (i) != nextRow*numColums )
        {
            $('#matrix').find($('td:eq(' + i + ')')).removeClass("valueShown");
            $('#matrix').find($('td:eq(' + i + ')')).addClass("valueHidden");
            $('#matrix').find($('td:eq(' + i + ')')).text("*");
        }
    }
}

// TODO: DOCUMENTATION
function initIndexes()
{
    // Initialisation of helper variables
    numRows       = $('#matrix').find('tr').length;
    numColums     = $('#matrix').find($('tr:eq(0)')).find('td').length;
    totalCells    = $('#matrix').find($('tr')).find('td').length;
    numRowsShown  = 1;

    // Cells are indexed row by row from 0 to (numRows*numColums)
    // First alignment value is to be set in the second cell of the second row
    fillCellIndex = numColums + 1;
}

// TODO: DOCUMENTATION
function nextStep()
{
    $('#matrix').find($('td:eq(' + fillCellIndex + ')')).removeClass("valueHidden");
    $('#matrix').find($('td:eq(' + fillCellIndex + ')')).addClass("valueShown");
    $('#matrix').find($('td:eq(' + fillCellIndex + ')')).text("*");

    var nextRow = (fillCellIndex / numColums)|0;
    ++nextRow;

    //if($('#matrix').find($('td:eq(' + (fillCellIndex+1) + ')')).html() == "")
    if( (fillCellIndex+1) != nextRow*numColums )
    {
        ++fillCellIndex;
    }
    else
    {
        fillCellIndex += 2;
    }

    // Demo of coloring calculation-relevant table-cells for visualisation
    // instead of using tooltips
    /*
    if(fillCellIndex > 2*numColums)
    {
        $('#matrix').find($('td:eq(' + (fillCellIndex+1) + ')')).css('background-color', '#006699');
        $('#matrix').find($('td:eq(' + (fillCellIndex-numColums+1) + ')')).css('background-color', '#CC3333');
        $('#matrix').find($('td:eq(' + (fillCellIndex-numColums) + ')')).css('background-color', '#CC3333');
    }
    */
}

// TODO: DOCUMENTATION
function nextRow()
{
    if(fillCellIndex > totalCells) return;
    // |0 to 'cast' double-division-result to integer
    var currentRow = (fillCellIndex / numColums)|0;
    ++currentRow; // Because row-count starts from 0

    for(i = fillCellIndex; i < (currentRow*numColums); ++i)
    {
        $('#matrix').find($('td:eq(' + i + ')')).removeClass("valueHidden");
        $('#matrix').find($('td:eq(' + i + ')')).addClass("valueShown");

        $('#matrix').find($('td:eq(' + i + ')')).text("*");
        fillCellIndex = i;
    }

    // Demo of coloring calculation-relevant table-cells for visualisation
    // instead of using tooltips
    /*
    if(fillCellIndex > 2*numColums)
    {
        $('#matrix').find($('td:eq(' + (fillCellIndex+1) + ')')).css('background-color', '#006699');
        $('#matrix').find($('td:eq(' + (fillCellIndex-numColums+1) + ')')).css('background-color', '#CC3333');
        $('#matrix').find($('td:eq(' + (fillCellIndex-numColums) + ')')).css('background-color', '#CC3333');
    }
    */
    fillCellIndex += 2;
}

// TODO: DOCUMENTATION
function completeAlignment()
{
    for(i = fillCellIndex; i < totalCells; ++i)
    {
        var nextRow = (i / numColums)|0;

        if( (i) != nextRow*numColums )
        {
            $('#matrix').find($('td:eq(' + i + ')')).removeClass("valueHidden");
            $('#matrix').find($('td:eq(' + i + ')')).addClass("valueShown");
            $('#matrix').find($('td:eq(' + i + ')')).text("*");
        }
    }

    initIndexes();

    // Demo of coloring calculation-relevant table-cells for visualisation
    // instead of using tooltips
    /*
    if(fillCellIndex > 2*numColums)
    {
        $('#matrix').find($('td:eq(' + (fillCellIndex+1) + ')')).css('background-color', '#006699');
        $('#matrix').find($('td:eq(' + (fillCellIndex-numColums+1) + ')')).css('background-color', '#CC3333');
        $('#matrix').find($('td:eq(' + (fillCellIndex-numColums) + ')')).css('background-color', '#CC3333');
    }
    */
}

// TODO: DOCUMENTATION
function reset()
{
    initIndexes();
    initCells();
}

$(document).ready(function() {

    initIndexes();
    initCells();

    // Stepwise enter the calculated alignment values cell by cell
    $('#nextStep').click(function(event){
        nextStep();
        event.preventDefault();
    });

    // Stepwise enter the calculated alignment values row by row
    $('#nextRow').click(function(event){
        nextRow();
        event.preventDefault();
    });

    // Display full aligment table at once
    $('#completeAlignment').click(function(event){
        completeAlignment();
        event.preventDefault();
    });

    // Reset alignment table, clear all values and colors
    $('#reset').click(function(event){
        reset();
        event.preventDefault();
    });

    // Send Form on Enter. Only works from inputs that do not allow
    // carriage returns
    $(function() {
        $('form').each(function() {
            $('input').keypress(function(e) {
                // Enter pressed?
                if(e.which == 10 || e.which == 13) {
                    this.form.submit();
                }
            });

            $('input[type=submit]').hide();
        });
    });
});
