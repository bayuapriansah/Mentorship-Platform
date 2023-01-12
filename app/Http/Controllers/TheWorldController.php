<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nnjeim\World\WorldHelper;
use Nnjeim\World\World;

class TheWorldController extends Controller
{
    public function TheWorld(){
        $action =  World::countries([
            'fields' => 'iso2',
        ]);
        

        if ($action->success) {
          $countries = $action->data;
        }

        return $countries;
    }

    public function states(){
        $act =  World::countries([
            'fields' => 'states,cities',
            'filters' => [
                'iso2',
            ]
        
        ]);
        if ($act->success) {
          $state = $act->data;
        }

        return $state;
    }
}
