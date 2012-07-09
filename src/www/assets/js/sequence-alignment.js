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
 * @fileOverview A simple chat client based on the WebSocket protocol.
 * @author       <a href="mailto:schnieders.a@gmail.com">Andreas Schnieders</a>
 * @copyright    2012 Andreas Schnieders
 * @license      http://gnu.org/licenses/lgpl.txt LGPL-3.0+
 * @version      0.1.0
 * @see          <a href="http://github.com/FlorianWolters/SequenceAlignment">SequenceAlignment</a>
 * @since        File available since Release 0.1.0
 */
$(document).ready(function() {
     // The total number of rows.
    var numRows = $('#matrix').find('tr').length;
    var numRowsShown = 1;

    for(i = 1; i < numRows; ++i)
    {
        $('#matrix').find($('tr:eq(' + i + ')').hide());
        $('#matrix').find($('tr:eq(' + i + ')').find('td:first').show());
    }

    $('#stepButton').click(function(event){
        $('#matrix').find($('tr:eq(' + numRowsShown + ')').show());
        ++numRowsShown;
        event.preventDefault();
    });

});
