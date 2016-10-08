<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dlc;

class DlcController extends Controller {
	public function index(Request $request) {
		// Start Eloquent query
		$dlcQuery = Dlc::with('status')
			->orderBy('name');

		// Completion filter
		if($request->has('completion')) {
			$dlcQuery = $dlcQuery->whereHas('status', function($q) use($request) {
				$q->where('completed', '=', $request->completion);
			});
		}

		return view('dlc.index', ['dlc' => $dlcQuery->get()]);
	}

	public function show(Dlc $dlc) {
		return view('dlc.show', ['dlc' => $dlc]);
	}

	public function edit(Dlc $dlc) {
		return view('dlc.edit', ['dlc' => $dlc]);
	}

	public function update(Request $request, Dlc $dlc) {
		$this->validate($request, [
			'name'      => 'required|string',
			'status'    => 'required|exists:statuses,id',
			'note'      => 'string',
		]);

		// Update properties
		$dlc->name = $request->name;
		$dlc->status_id = $request->status;
		$dlc->note = $request->note;
		$dlc->save();

		return redirect()->action('DlcController@edit', ['id' => $dlc->id])->with('status', 'DLC modified!');
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
		$dlcQuery = Dlc::whereIn('id', $request->checkedDlc);

		if(isset($request->updateStatus)) {
			$dlcQuery->update(['status_id' => $request->status]);
		}

		if(isset($request->setHidden)) {
			$dlcQuery->update(['hidden' => true]);
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
