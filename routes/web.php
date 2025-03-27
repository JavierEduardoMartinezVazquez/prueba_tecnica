<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/parte-uno', function () {
    function ordenArray($arr)
    {
        if (count($arr) < 3) {
            return "ERROR: El array debe contener al menos 3 elementos";
        }

        $primer_e = $segundo_e = $tercer_e = PHP_INT_MIN;

        foreach ($arr as $ele) {
            if ($ele > $primer_e) {
                $tercer_e = $segundo_e;
                $segundo_e = $primer_e;
                $primer_e = $ele;
            } elseif ($ele > $segundo_e) {
                $tercer_e = $segundo_e;
                $segundo_e = $ele;
            } elseif ($ele > $tercer_e) {
                $tercer_e = $ele;
            }
        }
        return response()->json([$primer_e, $segundo_e, $tercer_e]);
    }

    $arr = [10, 4, 3, 50, 23, 90];
    return ordenArray($arr);
});

Route::get('/parte-tres', function (Request $request){
    function processNumbers(array $nums): array {
        if (empty($nums)) {
            throw new InvalidArgumentException("Error, Array VACIO");
        }

        foreach ($nums as $num) {
            if (!is_numeric($num)) {
                throw new InvalidArgumentException("Error, SOLO NUMEROOS");
            }
        }

        return array_map(fn($num) => $num % 2 === 0 ? $num * 2 : $num * 3, $nums);
    }

    $input = $request->query('nums');
    if (!$input) {
        return response()->json(['error' => 'Este array solo acepta numeros'], 400);
    }
    $numsArray = explode(',', $input);
    $numsArray = array_map('trim', $numsArray);
    try {
        $result = processNumbers($numsArray);
        return response()->json(['resultado' => $result]);
    } catch (InvalidArgumentException $e) {
        return response()->json(['error' => $e->getMessage()], 400);
    }
});
