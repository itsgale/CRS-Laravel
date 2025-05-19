<?php

namespace App\Http\Controllers;

use App\Models\CateringService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CateringServiceController extends Controller
{
    // GET /catering-services - List all catering services
    public function index()
    {
        $services = CateringService::orderBy('created_at', 'desc')->get();
        return response()->json($services);
    }

    // POST /catering-services - Create a new catering service (admin only)
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'available' => 'boolean',
        ]);

        $service = CateringService::create($validated);

        return response()->json(['message' => 'Catering service created', 'data' => $service], 201);
    }

    // GET /catering-services/{id} - Show specific catering service details
    public function show($id)
    {
        $service = CateringService::findOrFail($id);
        return response()->json($service);
    }

    // PUT /catering-services/{id} - Update a catering service (admin only)
    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $service = CateringService::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'available' => 'boolean',
        ]);

        $service->update($validated);

        return response()->json(['message' => 'Catering service updated', 'data' => $service]);
    }

    // DELETE /catering-services/{id} - Delete a catering service (admin only)
    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $service = CateringService::findOrFail($id);
        $service->delete();

        return response()->json(['message' => 'Catering service deleted']);
    }
}
