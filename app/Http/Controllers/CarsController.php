<?php

namespace App\Http\Controllers;

use App\Services\CarsService;
use Illuminate\http\Request;

class CarsController extends Controller {
    
    private $carsService;
    
    public function __construct(CarsService $carsService) {
        $this->carsService = $carsService;
    }

    public function getAll(){
        return $this->carsService->getAll();
    }

    public function get($id){
        return $this->carsService->get($id);
    }

    public function store(Request $request){
        return $this->carsService->store($request);
    }

    public function update($id, Request $request){
        return $this->carsService->update($id, $request);
    }

    public function destroy($id){
        return $this->carsService->destroy($id);
    }
}
