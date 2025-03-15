<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

use App\Services\PurchaseService;

use App\Models\Buy;

use App\DTOs\BuyResponseDTO;


class BuyController extends Controller
{
    protected $purchaseService;

    public function __construct(PurchaseService $purchaseService)
    {
        $this->purchaseService = $purchaseService;
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'payment' => 'required|exists:payments,id',
                'products' => 'required|array',
                'products.*.id' => 'required|exists:products,id',
                'products.*.amount' => 'required|integer|min:1',
            ]);

            $result = $this->purchaseService->processPurchase($validated);

            $buyDTO = BuyResponseDTO::fromBuy($result['buy']);

            if (!empty($result['errorProducts'])) {
                return response()->json([
                    'message' => 'Purchase partially processed',
                    'data' => $buyDTO,
                    'observation' => $result['errorProducts'],
                ], 400);
            }

            return response()->json($buyDTO, 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Invalid data',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'There was an error processing the purchaSse',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $buy = Buy::with(['user', 'payment', 'buyProducts.product'])->find($id);

        if (!$buy) {
            return response()->json([
                'message' => 'Purchase not found'
            ], 404);
        }

        $buyDTO = BuyResponseDTO::fromBuy($buy);

        return response()->json($buyDTO, 200);
    }
}
