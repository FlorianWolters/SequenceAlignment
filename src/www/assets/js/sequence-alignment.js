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

$(document).ready(function() {
     // Some variables for messing around
    var numRows       = $('#matrix').find('tr').length;
    var numColums     = $('#matrix').find($('tr:eq(0)')).find('td').length;
    var totalCells    = $('#matrix').find($('tr')).find('td').length;
    var numRowsShown  = 1;
    
    // Cells are indexed row by row from 0 to (numRows*numColums)
    // First alignment value is to be set in the second cell of the second row
    var fillCellIndex = numColums + 1;

// Deprecated code to initially hide table rows
//    for(i = 1; i < numRows; ++i)/
//    {
//        $('#matrix').find($('tr:eq(' + i + ')').hide());
//    }
        
    // Stepwise enter the calculated alignment values row by row
    $('#nextStep').click(function(event){
        
        for(i = fillCellIndex; i < fillCellIndex + numColums-1; ++i)
        {
            $('#matrix').find($('td:eq(' + i + ')')).text("*");
        }

        // Demo of coloring calculation-relevant table-cells for visualisation 
        // instead of using tooltips
        if(fillCellIndex > 2*numColums) 
        {
            $('#matrix').find($('td:eq(' + (fillCellIndex+1) + ')')).css('background-color', '#006699');
            $('#matrix').find($('td:eq(' + (fillCellIndex-numColums+1) + ')')).css('background-color', '#CC3333');
            $('#matrix').find($('td:eq(' + (fillCellIndex-numColums) + ')')).css('background-color', '#CC3333');
        }
        fillCellIndex += numColums;
        
// Deprecated code to show previously hidden table row
//$('#matrix').find($('tr:eq(' + numRowsShown + ')').show());
//++numRowsShown;

        event.preventDefault();
    });
    
});
