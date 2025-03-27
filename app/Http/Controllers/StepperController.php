<?php

namespace App\Http\Controllers;

use App\Models\Stepper;
use App\Http\Requests\StoreStepperRequest;
use App\Http\Requests\UpdateStepperRequest;
use App\Models\Shipment;
use Illuminate\Http\Request;

class StepperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $steppers = Stepper::all();
        return response()->json(['status' => '000', "information" => $steppers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function addStep(Request $request)
    {
        // return "ok";
        // $validatedData = $request->validate([
        //     'ref' => 'required|string',
        //     'stepper_id' => 'required|integer',
        //     'description' => 'required|string',
        //     'valider' => 'required|boolean',
        // ]);

        // if (!$validatedData) {
        //     return response()->json(['status' => '001', 'information' => 'Invalid data provided']);
        // }
        $shipment = Shipment::where("ref", $request->json("ref"))->first();

        $trackingInfo = $shipment->tracking_info;

        $trackingInfo[] = [
            'stepper_id' => $request->json("stepper_id"),
            'description' => $request->json("description"),
            'valider' => $request->json("valider"),
        ];

        $shipment->tracking_info = $trackingInfo;
        $shipment->save();

        return response()->json(['status' => '000', "information" => "Step added successfully"]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStepperRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Stepper $stepper)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stepper $stepper)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStepperRequest $request, Stepper $stepper)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stepper $stepper)
    {
        //
    }
}
