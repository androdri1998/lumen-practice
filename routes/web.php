<?php

$router->group(["prefix" => "api/cars"], function() use($router){
    $router->get("/", "CarsController@getAll");
    $router->post("/", "CarsController@store");
    $router->get("/{id}", "CarsController@get");
    $router->put("/{id}", "CarsController@update");
    $router->delete("/{id}", "CarsController@destroy");
});
