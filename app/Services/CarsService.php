<?php

namespace App\Services;

use Illuminate\http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use App\Models\ValidationCars;
use App\Repositories\CarsRepositoryInterface;

class CarsService{
    private $carsRepository;
    
    public function __construct(CarsRepositoryInterface $carsRepository) {
        $this->carsRepository = $carsRepository;
    }
   
    public function getAll(){
      try{
        $cars = $this->carsRepository->getAll();
        if(count($cars) > 0){
            return response()->json($cars, Response::HTTP_OK);
        }
        else{
            return response()->json([], Response::HTTP_OK);
        }
      }catch (QueryException $exception){
        return response()->json(["error" => "There's not database connection!"], Response::HTTP_INTERNAL_SERVER_ERROR);
      }
    }

    public function get($id){
      try {
        $car = $this->carsRepository->get($id);
        if(empty($car)){
            return response()->json($car, Response::HTTP_OK);
        }
        else{
            return response()->json(null, Response::HTTP_OK);
        }
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

        $car = $this->carsRepository->store($request);
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
        
        $car = $this->carsRepository->update($id, $request);
          return response()->json($car, Response::HTTP_OK);
      }catch (QueryException $exception){
        return response()->json(["error" => "There's not database connection!"], Response::HTTP_INTERNAL_SERVER_ERROR);
      }
    }

    public function destroy($id){
      try{
        $car = $this->carsRepository->destroy($id);
        return response()->json(null, Response::HTTP_OK);
      }catch (QueryException $exception){
        return response()->json(["error" => "There's not database connection!"], Response::HTTP_INTERNAL_SERVER_ERROR);
      }
    }
}
