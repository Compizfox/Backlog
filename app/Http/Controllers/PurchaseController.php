<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Purchase;
use App\Game;
use App\Dlc;

class PurchaseController extends Controller {
	public function index() {
		// Retrieve all purchases (eager load games and dlc) and pass it to the view
		return view('purchase.index', ['purchases' => Purchase::with('games', 'dlc')->orderBy('purchased_at', 'desc')->get()]);
	}

	public function create() {
		return view('purchase.create');
	}

	public function store(Request $request) {
		$this->validate($request, [
			'shop'           => 'required|string',
			'valuta'         => 'required|in:€,$,£',
			'date'           => 'date_format:Y-m-d',
			'note'           => 'string',

			'games.*.name'   => 'required|string',
			'games.*.status' => 'required|exists:statuses,id',
			'games.*.note'   => 'string',

			'dlc.*.game'     => 'required|exists:games,name',
			'dlc.*.name'     => 'required|string',
			'dlc.*.status'   => 'required|exists:statuses,id',
			'dlc.*.note'     => 'string',
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
		foreach($request->input('games', []) as $game) {
			$gameModel = Game::firstOrCreate(['name' => $game['name']], ['status_id' => $game['status'], 'note' => $game['note']]);
			$gameModel->purchases()->attach($purchase);
		}

		// Insert DLC and attach to game (unless they exist) and attach to new purchase
		foreach($request->input('dlc', []) as $dlc) {
			// Get game_id of game with given name
			$gameId = Game::where('name', $dlc['game'])->firstOrFail()->id;

			$dlcModel = Dlc::firstOrCreate(['name' => $dlc['name']], ['game_id' => $gameId, 'status_id' => $dlc['status'], 'note' => $dlc['note']]);
			$dlcModel->purchases()->attach($purchase->id);
		}

		return redirect()->action('PurchaseController@index')->with('status', 'Purchase inserted!');
	}

	public function show(Purchase $purchase) {
		return view('purchase.show', ['purchase' => $purchase]);
	}

	public function edit(Purchase $purchase) {
		return view('purchase.edit', ['purchase' => $purchase]);
	}

	public function update(Request $request, Purchase $purchase) {
		$this->validate($request, [
			'shop'      => 'required|string',
			'valuta'    => 'required|in:€,$,£',
			'date'      => 'required|date',
			'note'      => 'string',
		]);

		// Delete purchase if it has no children
		if((count($request->games) + count($request->dlc)) == 0) {
			$purchase->delete();

			return redirect()->action('PurchaseController@index')->with('status', 'Purchase deleted!');
		}

		// Update properties
		$purchase->shop = $request->shop;
		$purchase->valuta = $request->valuta;
		$purchase->price = str_replace(",", ".", $request->price);
		$purchase->purchased_at = $request->date;
		$purchase->note = $request->note;
		$purchase->save();

		// Sync members
		$purchase->games()->sync($request->games ?? []);
		$purchase->dlc()->sync($request->dlc ?? []);

		return redirect()->action('PurchaseController@edit', ['id' => $purchase->id])->with('status', 'Purchase modified!');
	}

	public function destroy(Request $request, Purchase $purchase) {
		if(isset($request->deleteChildren)) {
			$purchase->games()->delete();
			$purchase->dlc()->delete();
		}

		$purchase->delete();

		return redirect()->action('PurchaseController@index')->with('status', 'Purchase deleted!');
	}

	public function destroyMany(Request $request) {
		// Pass every purchase to $this->destroy()
		foreach($request->checkedPurchases as $purchaseId) {
			$this->destroy($request, Purchase::find($purchaseId));
		}

		return redirect()->action('PurchaseController@index')->with('status', 'Purchases deleted!');
	}

	public function cleanup() {
		$count = Purchase::isEmpty()->delete();

		return redirect()->action('SettingsController@get')->with('status', "$count empty purchases deleted!");
	}
}
