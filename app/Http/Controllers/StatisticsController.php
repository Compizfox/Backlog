<?php

namespace App\Http\Controllers;

use DB;

class StatisticsController extends Controller {
    public function getPurchases() {
	    $rows = DB::table('games')
		    ->join('game_purchase', 'games.id' , '=', 'game_purchase.game_id')
		    ->join('purchases', 'game_purchase.game_id', '=', 'purchases.id')
		    ->select(DB::raw("count(*) AS count, DATE_FORMAT(purchased_at, '%Y-%m') AS date"))
		    ->where('purchased_at', '!=', NULL)
		    ->groupBy(DB::raw('YEAR(purchased_at), MONTH(purchased_at)'))
		    ->get();

	    foreach($rows as $row) {
		    $chartdata['labels'][] = $row->date;
		    $chartdata['datasets'][0]['data'][] = $row->count;
	    }

	    return response()->json($chartdata);
    }
}
