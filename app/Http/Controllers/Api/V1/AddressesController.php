<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Account\Address;
use Illuminate\Http\Request;

class AddressesController extends Controller
{
    public function index(Request $request)
    {
        return AddressResource::collection($request->user()->addresses()->latest()->get());
    }

    public function store(AddressRequest $request)
    {
        $validated = $request->validated();

        $address = $request->user()->addresses()->create($validated);

        return AddressResource::make($address)->response()->setStatusCode(201);
    }

    public function show(Address $address)
    {
        return AddressResource::make($address);
    }

    public function update(AddressRequest $request, Address $address)
    {
        $validated = $request->validated();

        $address->update($validated);

        return AddressResource::make($address);
    }

    public function destroy(Address $address)
    {
        $address->delete();

        return response()->noContent();
    }
}
