<?php

namespace App\Http\Controllers;

use App\Models\Registrant;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RegistrantController extends Controller
{
  private $validation_rules = [
    'name' => 'required|max:255',
    'id_card_number' => 'required|unique:registrants|max:20',
    'phone' => 'max:20',
  ];

  private function basic_response()
  {
    return [
      'timestamp' => Carbon::now()->toDateTimeString(),
      'status' => 200,
      // 'error' => '',
      'message' => '',
      'results' => []
    ];
  }

  private $response = [];

  public function __construct()
  {
    $this->response = $this->basic_response();
  }

  public function index()
  {
    try {
      $this->response['results'] = Registrant::all();
    } catch (\Throwable $th) {
      $this->response['status'] = 500;
      $this->response['message'] = $th->getMessage();
    }
    return response()->json($this->response);
  }

  public function create(Request $request)
  {
    // $this->validate($request, $this->validation_rules);
    // create new validator rather than using validate() on file Laravel\Lumen\Routing\ProvidesConvenienceMethods::validate()
    $validator = $this->getValidationFactory()->make($request->post(), $this->validation_rules);
    if ($validator->fails()) {
      $this->response['status'] = 422;
      $this->response['message'] = $validator->errors();
    } else {
      try {
        $registrant = new Registrant();
        $registrant->name = $request->name;
        $registrant->id_card_number = $request->id_card_number;
        $registrant->address = $request->address;
        $registrant->phone = $request->phone;
        if ($registrant->save()) {
          $this->response['message'] = 'registrant data saved successfully!';
        } else {
          $this->response['status'] = 500;
          $this->response['message'] = 'registrant data failed to save!';
        }
      } catch (\Throwable $th) {
        $this->response['status'] = 500;
        $this->response['message'] = $th->getMessage();
      }
    }
    return response()->json($this->response);
  }

  public function show($id)
  {
    $validator = $this->getValidationFactory()->make(['id' => $id], ['id' => 'required|numeric']);
    if ($validator->fails()) {
      $this->response['status'] = 422;
      $this->response['message'] = $validator->errors();
    } else {
      try {
        $this->response['results'] = Registrant::find($id);
      } catch (\Throwable $th) {
        $this->response['status'] = 500;
        $this->response['message'] = $th->getMessage();
      }
    }
    return response()->json($this->response);
  }

  public function update(Request $request, $id)
  {
    $this->validation_rules['id_card_number'] = 'required|max:20';
    $validator = $this->getValidationFactory()->make($request->all(), $this->validation_rules);
    if ($validator->fails()) {
      $this->response['status'] = 422;
      $this->response['message'] = $validator->errors();
    } else {
      try {
        $registrant = Registrant::find($id);
        $registrant->name = $request->name;
        $registrant->id_card_number = $request->id_card_number;
        $registrant->address = $request->address;
        $registrant->phone = $request->phone;
        if ($registrant->save()) {
          $this->response['message'] = 'registrant data has been successfully updated!';
        } else {
          $this->response['status'] = 500;
          $this->response['message'] = 'registrant data failed to update!';
        }
      } catch (\Throwable $th) {
        $this->response['status'] = 500;
        $this->response['message'] = $th->getMessage();
      }
    }

    return response()->json($this->response);
  }

  public function destroy($id)
  {
    $validator = $this->getValidationFactory()->make(['id' => $id], ['id' => 'required|numeric']);
    if ($validator->fails()) {
      $this->response['status'] = 422;
      $this->response['message'] = $validator->errors();
    } else {
      try {
        $registrant = Registrant::find($id);
        if ($registrant->delete()) {
          $this->response['message'] = 'registrant data removed successfully!';
        } else {
          $this->response['status'] = 500;
          $this->response['message'] = 'registrant data failed to remove!';
        }
      } catch (\Throwable $th) {
        $this->response['status'] = 500;
        $this->response['message'] = $th->getMessage();
      }
    }

    return response()->json($this->response);
  }
}
