<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Dlc;

class DlcController extends Controller {
	public function index() {

	}

	public function create() {

	}

	public function store(Request $request) {
		//
	}

	public function show($id) {

	}

	public function edit($id) {
		//
	}

	public function update(Request $request, $id) {
		//
	}

	public function destroy(Dlc $dlc) {
		$dlc->delete();

		return redirect()->back()->with('status', 'DLC deleted!');
	}

	public function destroyMany(Request $request) {
		Dlc::destroy($request->checkedDlc);

		return redirect()->back()->with('status', 'DLC deleted!');
	}

	public function patchMany(Request $request) {
		// Get DLC query builder from array of IDs
		$dlc = Dlc::whereIn('id', $request->checkedDlc);

		if(isset($request->updateStatus)) {
			$dlc->update(['status_id' => $request->status]);
		}

		if(isset($request->setHidden)) {
			$dlc->update(['hidden' => true]);
		}

		return redirect()->back()->with('status', 'DLC updated!');
	}

	public function getJson() {
		$dlc = Dlc::orderBy('name')->get();

		$dlcArray = $dlc->map(function($dlc) {
			return ['label' => $dlc->name,
			        'id'    => $dlc->id];
		});

		return response()->json($dlcArray);
	}
}
