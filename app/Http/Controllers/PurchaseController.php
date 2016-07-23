<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Purchase;

class PurchaseController extends Controller {
	public function index() {
		return view('purchase.index', ['purchases' => Purchase::all()]);
	}

	public function create() {
		return view('purchase.create');
	}

	public function store(Request $request) {
		//
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

	public function destroy($id) {
		//
	}
}
