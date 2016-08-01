<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Game;

class GameController extends Controller {
	public function index() {
		$games = Game::all();

		return view('game.index', ['games' => $games]);
	}

	public function create() {
		return view('game.create');
	}

	public function store(Request $request) {
		//
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

	public function destroy($id) {
		//
	}
	
	public function getCategorisedJson() {
		// Retrieve array of orphaned and non-orphaned game names
		$orphanedGames = Game::has('purchases', '<', 1)->orderBy('name')->pluck('name')->toArray();
		$ownedGames = Game::has('purchases', '>=', 1)->orderBy('name')->pluck('name')->toArray();

		// Generate array of assoc array with label (name) and category (orphaned or not) as keys
		$mapFunction = function($label) use(&$category) {
			return ['label' => $label, 'category' => $category];
		};

		$category = 'Orphaned';
		$aOrphanedGames = array_map($mapFunction, $orphanedGames);
		$category = 'Already purchased';
		$aOwnedGames = array_map($mapFunction, $ownedGames);

		return response()->json(array_merge($aOrphanedGames, $aOwnedGames));
	}
}
