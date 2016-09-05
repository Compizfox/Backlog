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
		// Retrieve array of games with purchase count (for determinging owned/orphaned status)
		$games = Game::withCount('purchases')
			->orderBy('name')
			->get();

		$gamesArray = $games->map(function($game) {
			if($game->purchases_count == 0) $category = 'Orphaned';
			else $category = 'Already purchased';

			return ['label'    => $game->name,
			        'category' => $category,
			        'id'       => $game->id];
		});

		return response()->json($gamesArray);
	}
}
