<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/municipalities/search', function (Request $request) {
    $term = $request->query('q', '');
    
    if (strlen($term) < 2) {
        return response()->json([]);
    }
    
    $municipalities = \App\Models\DianMunicipality::search($term)
        ->limit(20)
        ->get()
        ->map(function ($municipality) {
            return [
                'factus_id' => $municipality->factus_id,
                'name' => $municipality->name,
                'department' => $municipality->department,
                'code' => $municipality->code,
                'display' => "{$municipality->name} – {$municipality->department}",
            ];
        });
    
    return response()->json($municipalities);
});

Route::get('/measurement-units/search', function (Request $request) {
    $term = $request->query('q', '');
    
    if (strlen($term) < 2) {
        return response()->json([]);
    }
    
    $units = \App\Models\DianMeasurementUnit::search($term)
        ->limit(20)
        ->get()
        ->map(function ($unit) {
            return [
                'factus_id' => $unit->factus_id,
                'name' => $unit->name,
                'code' => $unit->code,
                'display' => "{$unit->name} ({$unit->code})",
            ];
        });
    
    return response()->json($units);
});
