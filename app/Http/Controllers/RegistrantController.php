<?php

namespace App\Http\Controllers;

use App\Models\Registrant;
use Illuminate\Http\Request;

class RegistrantController extends Controller
{
  public function index()
  {
    $registrants = Registrant::all();
    return response()->json($registrants);
  }

  public function create(Request $request)
  {
    $registrant = new Registrant();
    $registrant->name = $request->name;
    $registrant->id_card_number = $request->id_card_number;
    $registrant->address = $request->address;
    $registrant->phone = $request->phone;
    $registrant->save();

    return response()->json($registrant);
  }

  public function show($id)
  {
    $registrant = Registrant::find($id);
    return response()->json($registrant);
  }

  public function update(Request $request, $id)
  {
    $registrant = Registrant::find($id);
    $registrant->name = $request->name;
    $registrant->id_card_number = $request->id_card_number;
    $registrant->address = $request->address;
    $registrant->phone = $request->phone;
    $registrant->save();

    return response()->json($registrant);
  }

  public function destroy($id)
  {
    $registrant = Registrant::find($id);
    $registrant->delete();

    return response()->json('registrant removed successfully');
  }
}
