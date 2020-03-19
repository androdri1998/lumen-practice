<?php

namespace App\Http\Controllers;

use Illuminate\http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Cars;

class CarsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct(Cars $cars)
    {
      $this->model = $cars;   
    }

    public function getAll(Request $request){
      try{
        $cars = $this->model->all();
        if(count($cars) > 0)
          return response()->json($cars, Response::HTTP_OK);
        else
          return response()->json([], Response::HTTP_OK);
      }catch (QueryException $exception){
        return response()->json(["error" => "There's not database connection!"], Response::HTTP_INTERNAL_SERVER_ERROR);
      }
    }

    public function get($id, Request $request){
      try {
        $car = $this->model->find($id);
        if(count($car) > 0)
          return response()->json($car, Response::HTTP_OK);
        else
          return response()->json(null, Response::HTTP_OK);
      }catch (QueryException $exception){
        return response()->json(["error" => "There's not database connection!"], Response::HTTP_INTERNAL_SERVER_ERROR);
      }
    }

    public function store(Request $request){
      try{
        $validator = Validator::make(
          $request->all(),
          [
            'name' => 'required | max:80',
            'description' => 'required',
            'model' => 'required | max:10 | min:2',
          ]
        );
        
        if($validator -> fails()){
          return response()->json([$validator -> errors()], Response::HTTP_BAD_REQUEST);
        }

        $car = $this->model->create($request->all());
        return response()->json($car, Response::HTTP_CREATED);
      }catch (QueryException $exception){
        return response()->json(["error" => "There's not database connection!"], Response::HTTP_INTERNAL_SERVER_ERROR);
      }
    }

    public function update($id, Request $request){
      try{
        $validator = Validator::make(
          $request->all(),
          [
            'name' => 'required | max:80',
            'description' => 'required',
            'model' => 'required | max:10 | min:2',
          ]
        );
        
        if($validator -> fails()){
          return response()->json([$validator -> errors()], Response::HTTP_BAD_REQUEST);
        }
        
        $car = $this->model->find($id)
          ->update($request->all());
          return response()->json($car, Response::HTTP_OK);
      }catch (QueryException $exception){
        return response()->json(["error" => "There's not database connection!"], Response::HTTP_INTERNAL_SERVER_ERROR);
      }
    }

    public function destroy($id, Request $request){
      try{
        $car = $this->model->find($id)
          ->delete();
        return response()->json(null, Response::HTTP_OK);
      }catch (QueryException $exception){
        return response()->json(["error" => "There's not database connection!"], Response::HTTP_INTERNAL_SERVER_ERROR);
      }
    }
}
