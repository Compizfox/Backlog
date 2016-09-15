<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Game;

class GameController extends Controller {
	public function index(Request $request) {
		// Start Eloquent query
		$gamesQuery = Game::with('status')
			->orderBy('name');

		// Completion filter
		if($request->has('completion')) {
			$gamesQuery = $gamesQuery->whereHas('status', function($q) use($request) {
				$q->where('completed', '=', $request->completion);
			});
		}

		// Orphaned filter
		if($request->has('purchased')) {
			$gamesQuery = $gamesQuery->has('purchases');
		}

		return view('game.index', ['games' => $gamesQuery->get()]);
	}

	public function show($id) {
		//
	}

	public function edit($id) {
		//
	}

	public function update(Request $request, $id) {
		//
	}

	public function destroy(Game $game) {
		$game->delete();

		return redirect()->back()->with('status', 'Game deleted!');
	}

	public function destroyMany(Request $request) {
		Game::destroy($request->checkedGames);

		return redirect()->back()->with('status', 'Games deleted!');
	}

	public function patchMany(Request $request) {
		// Get game query builder from array of IDs
		$gamesQuery = Game::whereIn('id', $request->checkedGames);

		if(isset($request->updateStatus)) {
			$gamesQuery->update(['status_id' => $request->status]);
		}

		if(isset($request->setHidden)) {
			$gamesQuery->update(['hidden' => true]);
		}

		return redirect()->back()->with('status', 'Games updated!');
	}
	
	public function getCategorisedJson() {
		// Retrieve array of games with purchase count (for determinging owned/orphaned status)
		$games = Game::withCount('purchases')
			->orderBy('name')
			->get();

		$gamesArray = $games
			->map(function ($game) {
				if($game->purchases_count == 0) $category = 'Orphaned';
				else $category = 'Already purchased';

				return [
					'label' => $game->name,
					'category' => $category,
					'id' => $game->id
				];
			})->sortBy(function($row) {
				return $row['category'] . " " . $row['label'];
			})->values();

		return response()->json($gamesArray);
	}
}
