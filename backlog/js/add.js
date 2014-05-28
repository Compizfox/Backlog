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

window.onload = addInput;

var i = 0;
var j = new Array();

function addInput() {
    var newdiv = document.createElement('div');
    newdiv.setAttribute('class', 'form-group');
    newdiv.setAttribute('id', i);
    newdiv.innerHTML = "<label class=\"col-sm-1 control-label\">Game:</label> <div class=\"col-md-3\"><input class=\"form-control autocomplete\" type=\"text\" name=\"game[" + i + "][name]\" required autofocus></div> <label class=\"col-sm-1 control-label\">Status:</label> <div class=\"col-md-2\"><select class=\"form-control\" name=\"game[" + i + "][status]\"><?=addslashes(getStatusOptions())?></select></div> <label class=\"col-sm-1 control-label\">Note:</label><div class=\"col-md-3\"> <input class=\"form-control\" type=\"text\" name=\"game[" + i + "][notes]\"></div><label class=\"col-sm-1 control-label\"><a onclick=\"addDLC(this)\"><span class=\"glyphicon glyphicon-plus-sign\"></span> DLC</a></label>";
    document.getElementById('dyn').appendChild(newdiv);
    j[i] = 0;
    i++;
}

function addDLC(caller) {
    var game = caller.parentNode.parentNode;
    var gameid = game.id;
    var newdiv = document.createElement('div');
    newdiv.setAttribute('class', 'form-group');
    newdiv.innerHTML = "<div class=\"col-md-1\"></div><label class=\"col-sm-1 control-label\">DLC:</label> <div class=\"col-md-2\"><input class=\"form-control\" type=\"text\" name=\"game[" + gameid + "][" + j[gameid] +"][name]\" required autofocus></div> <label class=\"col-sm-1 control-label\">Status:</label> <div class=\"col-md-2\"><select class=\"form-control\" name=\"game[" + gameid + "][" + j[gameid] +"][status]\"><?=addslashes(getStatusOptions())?></select></div> <label class=\"col-sm-1 control-label\">Note:</label><div class=\"col-md-3\"> <input class=\"form-control\" type=\"text\" name=\"game[" + gameid + "][" + j[gameid] +"][notes]\"></div>";
    game.parentNode.insertBefore(newdiv, game.nextSibling);
    j[gameid]++;
}