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

	public function destroy($id) {
		//
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
