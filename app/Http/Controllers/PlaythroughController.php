<?php

namespace App\Http\Controllers;

use App\Playthrough;
use Illuminate\Http\Request;

class PlaythroughController extends Controller {
	public function index() {
		$all = Playthrough::with('playable')
			->get()
			->sortByDesc(function($row) {
				// Sort by ended_at date is started_at is not set
				return empty($row['started_at']) ? $row['ended_at'] : $row['started_at'];
			});

		$pending = $all->filter(function($value) {
			return !$value->ended;
		});

		$ended = $all->filter(function($value) {
			return $value->ended;
		});

		return view('playthrough.index', ['pending' => $pending, 'ended' => $ended]);
	}

	public function create() {
		return view('playthrough.create');
	}

	public function store(Request $request) {
		$this->validate($request, [
			'playable_type'  => 'required|in:Game,Dlc',
			'game'           => 'exists:games,id',
			'dlc'            => 'exists:dlc,id',
			'started_at'     => 'date_format:Y-m-d',
			'note'           => 'string',

			'isEnded'        => 'in:on',
			'ended_at'       => 'date_format:Y-m-d',

			'updateStatus'   => 'in:on',
			'status'         => 'required_if:updateStatus,on|exists:statuses,id'
		]);

		// Create new Playthrough from request
		$playthrough = new Playthrough();
		$playthrough->playable_type = 'App\\' . $request->playable_type;
		$playthrough->playable_id = $request->{$request->playable_type};
		$playthrough->started_at = $request->started_at;
		$playthrough->note = $request->note;
		$playthrough->ended = isset($request->isEnded);
		$playthrough->ended_at = $request->ended_at;
		$playthrough->save();

		// Set status on playable (if needed)
		if($request->updateStatus) $playthrough->playable()->update(['status_id' => $request->status]);

		return redirect()->action('PlaythroughController@index')->with('status', 'Playthrough inserted!');
	}

	public function edit(Playthrough $playthrough) {
		return view('playthrough.edit', ['pt' => $playthrough]);
	}

	public function update(Request $request, Playthrough $playthrough) {
		$this->validate($request, [
			'started_at'     => 'date_format:Y-m-d',
			'note'           => 'string',

			'isEnded'        => 'in:on',
			'ended_at'       => 'date_format:Y-m-d',

			'updateStatus'   => 'in:on',
			'status'         => 'required_if:updateStatus,on|exists:statuses,id'
		]);

		// Update properties
		$playthrough->started_at = $request->started_at;
		$playthrough->note = $request->note;
		$playthrough->ended = isset($request->isEnded);
		$playthrough->ended_at = $request->ended_at;
		$playthrough->save();

		// Set status on playable (if needed)
		if($request->updateStatus) $playthrough->playable()->update(['status_id' => $request->status]);

		return redirect()->back()->with('status', 'Playthrough updated!');
	}

	public function destroy(Playthrough $playthrough) {
		$playthrough->delete();

		return redirect()->back()->with('status', 'Playthrough deleted!');
	}

	public function destroyMany(Request $request) {
		Playthrough::destroy($request->checkedPlaythroughs);

		return redirect()->back()->with('status', 'Playthroughs deleted!');
	}

	public function patchMany(Request $request) {
		$this->validate($request, [
			'status'    => 'required|exists:statuses,id',
			'ended_at'  => 'required|date_format:Y-m-d'
		]);

		Playthrough::whereIn('id', $request->checkedPlaythroughs)
			->get()
			->each(function(Playthrough $pt) use($request) {
				// Update ended date and status
				$pt->update([
					'ended' => true,
					'ended_at' => $request->ended_at
				]);

				// Update status of playable
				$pt->playable()->update(['status_id' => $request->status]);
			});

		return redirect()->back()->with('status', 'Playthroughs updated!');
	}
}
