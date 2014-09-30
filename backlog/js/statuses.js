/*
Date: 2014-05-25
Author: Lars Veldscholte
lars@veldscholte.eu
http://lars.veldscholte.eu

Copyright 2014 Lars Veldscholte

This file is part of Backlog.

Backlog is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Backlog is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Backlog. If not, see <http://www.gnu.org/licenses/>.
*/

function addRow() {
    var newtr = document.createElement('tr');
    newtr.innerHTML = "<td><input type=\"number\" class=\"form-control\" name=\"id[]\" min=\"0\" required /></td><td><input type=\"text\" class=\"form-control\" name=\"name[]\" required /></td><td><input type=\"color\" class=\"form-control\" name=\"color[]\" required /></td><td><input type=\"hidden\" value=\"0\" name=\"completed[]\" /><input type=\"checkbox\" name=\"completed[]\" value=\"1\" /></td><td><a href=\"#\" onclick=\"removeRow(this); return false;\"><span class=\"glyphicon glyphicon-trash\"></a></td>";
    document.getElementById('dyn').appendChild(newtr);
}

function removeRow(caller) {
    var tr = caller.parentNode.parentNode;
    var tbody = tr.parentNode;
    
    tbody.removeChild(tr);
}

function checkboxes() {
    $( "#dyn").find("input:checked" ).each(function() {
        this.previousElementSibling.value = 1;
    });
}
