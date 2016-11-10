<?php

namespace App\Http\Controllers;

use DB;

class StatisticsController extends Controller {
	public function summary() {
		return view('summary', [
			'purchaseCount' => DB::table('purchases')->count(),
			'gameCount'     => DB::table('games')->count(),
			'dlcCount'      => DB::table('dlc')->count()
		]);
	}

	public function getPurchases() {
		$purchases = DB::table('purchases')
			->join(DB::raw('(SELECT purchase_id FROM games JOIN(game_purchase) ON(games.id = game_purchase.game_id) UNION ALL SELECT purchase_id FROM dlc JOIN(dlc_purchase) ON(dlc.id = dlc_purchase.dlc_id)) playable'), 'playable.purchase_id', '=', 'purchases.id')
			->select(DB::raw("count(*) AS count, DATE_FORMAT(purchased_at, '%Y-%m') AS label"))
			->where('purchased_at', '!=', NULL)
			->groupBy(DB::raw('YEAR(purchased_at), MONTH(purchased_at)'))
			->get();

		return response()->json($this->chartData($purchases));
	}

	public function getPlaythroughs() {
		$rows = DB::table('playthroughs')
			->select(DB::raw("count(*) AS count, DATE_FORMAT(ended_at, '%Y-%m') AS label"))
			->where('ended_at', '!=', NULL)
			->groupBy(DB::raw('YEAR(ended_at), MONTH(ended_at)'))
			->get();

		return response()->json($this->chartData($rows));
	}

	public function getStatusShare() {
		$share = DB::table('statuses')
			->join(DB::raw('(SELECT status_id FROM games UNION ALL SELECT status_id FROM dlc) playable'), 'playable.status_id', '=', 'statuses.id')
			->select(DB::raw('COUNT(*) AS count, statuses.name, color'))
			->groupBy('statuses.id')
			->get();

		foreach($share as $row) {
			$chartdata['labels'][] = $row->name;
			$chartdata['datasets'][0]['data'][] = $row->count;
			$chartdata['datasets'][0]['backgroundColor'][] = $row->color;
		}

		return response()->json($chartdata);
	}

	public function getShopShare() {
		$purchases = DB::table('purchases')
			->join(DB::raw('(SELECT purchase_id FROM games JOIN(game_purchase) ON(games.id = game_purchase.game_id) UNION ALL SELECT purchase_id FROM dlc JOIN(dlc_purchase) ON(dlc.id = dlc_purchase.dlc_id)) playable'), 'playable.purchase_id', '=', 'purchases.id')
			->select(DB::raw("count(*) AS count, shop AS label"))
			->where('shop', '!=', NULL)
			->groupBy('shop')
			->get();

		return response()->json($this->chartData($purchases));
	}

	private function chartData($rows) {
		foreach($rows as $row) {
			$chartdata['labels'][] = $row->label;
			$chartdata['datasets'][0]['data'][] = $row->count;
		}

		return $chartdata;
	}
}
