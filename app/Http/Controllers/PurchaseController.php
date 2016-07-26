<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Purchase;
use App\Game;
use App\Dlc;
use App\Status;

class PurchaseController extends Controller {
	public function index() {
		// Retrieve all purchases (eager load games and dlc) and pass it to the view
		return view('purchase.index', ['purchases' => Purchase::with('games', 'dlc')->get()]);
	}

	public function create() {
		return view('purchase.create', ['statuses' => Status::all()]);
	}

	public function store(Request $request) {
		$this->validate($request, [
			'shop' => 'required|string',
			'valuta' => 'required|in:€,$,£',
			'price' => 'required|numeric',
			'date' => 'required|date',
			'note' => 'string',

			'games.*.name' => 'required|string',
			'games.*.status' => 'required|exists:statuses,id',
			'games.*.note' => 'string',

			'dlc.*.game' => 'required|exists:games,name',
			'dlc.*.name' => 'required|string',
			'dlc.*.status' => 'required|exists:statuses,id',
			'dlc.*.note' => 'string',
		]);

		// Create new Purchase from request
		$purchase = new Purchase();
		$purchase->shop = $request->shop;
		$purchase->valuta = $request->valuta;
		$purchase->price = str_replace(",", ".", $request->price);
		$purchase->purchased_at = $request->date;
		$purchase->note = $request->note;
		$purchase->save();

		// Insert games (unless they exist) and attach to new purchase
		foreach($request->games as $game) {
			$gameModel = Game::firstOrNew(['name' => $game['name']]);
			if(!$gameModel->exists) {
				$gameModel->status_id = $game['status'];
				$gameModel->note = $game['note'];
				$gameModel->save();
			}
			$gameModel->purchases()->attach($purchase->id);
		}

		// Insert DLC and attach to game (unless they exist) and attach to new purchase
		foreach($request->dlc as $dlc) {
			$dlcModel = Dlc::firstOrNew(['name' => $dlc['name']]);
			if(!$dlcModel->exists) {
				// Get game_id of game with given name
				$gameId = Game::where('name', $dlc['game'])->firstOrFail()->id;
				// Set DLC properties and insert
				$dlcModel->game_id = $gameId;
				$dlcModel->status_id = $dlc['status'];
				$dlcModel->note = $dlc['note'];
				$dlcModel->save();
			}
			$dlcModel->purchases()->attach($purchase->id);
		}

		// PRG redirect
		return redirect()->action('PurchaseController@index');
	}

	public function show($id) {
		return view('purchase.show', ['purchase' => Purchase::find($id)]);
	}

	public function edit($id) {
		//
	}

	public function update(Request $request, $id) {
		//
	}

	public function destroy(Purchase $purchase) {
		$purchase->delete();

		return redirect()->action('PurchaseController@index')->with('status', 'Purchase deleted!');
	}
}
