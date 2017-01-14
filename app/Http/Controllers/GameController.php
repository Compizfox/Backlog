<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;

class GameController extends Controller {
	public function index(Request $request) {
		// Start Eloquent query
		$gamesQuery = Game::with('status')
				->visible()
				->orderBy('name');

		// Completion filter
		if($request->has('completion')) {
			$gamesQuery = $gamesQuery->completed($request->completion);
		}

		// Orphaned filter
		if($request->has('purchased')) {
			$gamesQuery = $gamesQuery->purchased($request->purchased);
		}

		return view('game.index', ['games' => $gamesQuery->get()]);
	}

	public function show(Game $game) {
		return view('game.show', ['game' => $game]);
	}

	public function edit(Game $game) {
		return view('game.edit', ['game' => $game]);
	}

	public function update(Request $request, Game $game) {
		$this->validate($request, [
				'name'      => 'required|string',
				'status'    => 'required|exists:statuses,id',
				'appid'     => 'integer',
				'playtime'  => 'integer',
				'note'      => 'string',
		]);

		// Update properties
		$game->name = $request->name;
		$game->status_id = $request->status;
		$game->appid = $request->appid;
		$game->appid_lock = $request->appid_lock;
		$game->playtime = $request->playtime;
		$game->note = $request->note;
		$game->hidden = isset($request->hidden);
		$game->save();

		return redirect()->action('GameController@edit', ['id' => $game->id])->with('status', 'Game modified!');
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
		// Retrieve array of games with purchase count (for determining owned/orphaned status)
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
				})->sortBy(function ($row) {
					return $row['category'] . " " . $row['label'];
				})->values();

		return response()->json($gamesArray);
	}
}
