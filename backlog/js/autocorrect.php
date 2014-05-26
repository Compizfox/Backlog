<?php
/*
    Date:   2014-05-25
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
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Backlog. If not, see <http://www.gnu.org/licenses/>.
*/

require_once("../include/classes.php");

$gamelist = getGameList("orphaned");
$gamearray = array(array());
foreach ($gamelist as $label) {
    $row['label'] = $label;
    $row['category'] = "Orphaned";
    $gamearray[] = $row;
}

$gamelist = getGameList();
foreach ($gamelist as $label) {
    $row['label'] = $label;
    $row['category'] = "Already in database";
    if(!in_array(array('label' => $label, 'category' => 'Orphaned'), $gamearray)) $gamearray[] = $row;
}

$autocompletelist = json_encode($gamearray);
?>

$.widget( 'custom.catcomplete', $.ui.autocomplete, {
    _renderMenu: function( ul, items ) {
        var that = this,
        currentCategory = '';
        $.each( items, function( index, item ) {
            if ( item.category != currentCategory ) {
                ul.append( '<li class="ui-autocomplete-category">' + item.category + '</li>' );
                currentCategory = item.category;
            }
            that._renderItemData( ul, item );
        });
    }
});

$(function() {
    var availableTags = <?=$autocompletelist?>;
    
    $('body').delegate('.autocomplete', 'focusin', function() {
        $( '.autocomplete' ).catcomplete({
            source: availableTags
        });
    });
});