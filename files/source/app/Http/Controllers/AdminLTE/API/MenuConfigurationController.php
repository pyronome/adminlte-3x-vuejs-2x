<?php

namespace App\Http\Controllers\AdminLTE\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\AdminLTE\AdminLTE;
use App\AdminLTE\AdminLTEUser;
use App\Http\Requests\AdminLTE\API\MenuConfigurationPOSTRequest;

class MenuConfigurationController extends Controller
{

    public function get(Request $request)
    {

        $response = [];

        if (Storage::disk('local')->exists('config/adminlte_menu.json'))
        {
            $menu_json = Storage::disk('local')->get('config/adminlte_menu.json');
        }
        else
        {
            $menu_json = config('adminlte_menu_json');
        } // if (!$forceDefault

        $response['menu_json'] = json_encode($menu_json,
                (JSON_HEX_QUOT
                | JSON_HEX_TAG
                | JSON_HEX_AMP
                | JSON_HEX_APOS));
        
        return $response;

    }

    public function post(MenuConfigurationPOSTRequest $request)
    {
        $has_error = false;
        $error_msg = '';
        $return_data = [];

        $menu_json = rawurldecode(
                htmlspecialchars_decode(
                $request->input('menu_json')));

        Storage::disk('local')->put('config/adminlte_menu.json', $menu_json);
        
        $return_data['has_error'] = false;
        $return_data['error_msg'] = '';

        return $return_data;
    }

}
