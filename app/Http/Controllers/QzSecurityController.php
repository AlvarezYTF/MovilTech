<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignQzMessageRequest;
use App\Services\Printing\QzSigningService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class QzSecurityController extends Controller
{
    public function __construct(
        private readonly QzSigningService $qzSigningService
    ) {}

    public function certificate(): Response
    {
        try {
            $certificate = $this->qzSigningService->certificate();

            return response($certificate, 200, [
                'Content-Type' => 'text/plain; charset=UTF-8',
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return response('No fue posible obtener el certificado de QZ Tray.', 500);
        }
    }

    public function sign(SignQzMessageRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $signature = $this->qzSigningService->sign((string) $validated['request']);

            return response()->json([
                'signature' => $signature,
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => 'No fue posible firmar la solicitud de QZ Tray.',
            ], 500);
        }
    }
}
