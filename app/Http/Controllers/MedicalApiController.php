<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\GetScheduleRequest;
use Illuminate\Http\Request;
use App\Services\MedicalApiService;

class MedicalApiController extends Controller
{
    protected MedicalApiService $medicalApiService;

    public function __construct(MedicalApiService $medicalApiService)
    {
        $this->medicalApiService = $medicalApiService;
    }

    public function getClinics(): \Illuminate\Http\JsonResponse
    {
        $result = $this->medicalApiService->getClinics();
        return $this->handleResponse($result);
    }

    public function getEmployees(): \Illuminate\Http\JsonResponse
    {
        $result = $this->medicalApiService->getEmployees();
        return $this->handleResponse($result);
    }

    public function getNomenclature($clinicUid): \Illuminate\Http\JsonResponse
    {
        $result = $this->medicalApiService->getNomenclature($clinicUid);
        return $this->handleResponse($result);
    }

    public function getSchedule(getScheduleRequest $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validated();

        $result = $this->medicalApiService->getSchedule(
            $validated['daysCount'] ?? null,
            $validated['clinicUid'] ?? null,
            $validated['employeeUids'] ?? null,
            $validated['startDate'] ?  \DateTime::createFromFormat("d.m.Y", $validated['startDate']) : null
        );

        return $this->handleResponse($result);
    }

    public function getOrderStatus($orderUid): \Illuminate\Http\JsonResponse
    {
        $result = $this->medicalApiService->getOrderStatus($orderUid);
        return $this->handleResponse($result);
    }

    public function createWaitList(Request $request): \Illuminate\Http\JsonResponse
    {
        $waitListData = $request->all();
        $result = $this->medicalApiService->createWaitList($waitListData);
        return $this->handleResponse($result);
    }

    public function reserveTime(Request $request): \Illuminate\Http\JsonResponse
    {
        $reserveData = $request->all();
        $result = $this->medicalApiService->reserveTime($reserveData);
        return $this->handleResponse($result);
    }

    public function createOrder(CreateOrderRequest $request): \Illuminate\Http\JsonResponse
    {
        $orderData = $request->validated();
        $services = [];
        foreach ($orderData['services'] as $service) {
            array_push($services, $service['uid']);
        }
        $orderData['services'] = $services;
        $result = $this->medicalApiService->createOrder($orderData);
        return $this->handleResponse($result);
    }

    public function deleteOrder($orderUid): \Illuminate\Http\JsonResponse
    {
        $result = $this->medicalApiService->deleteOrder($orderUid);
        return $this->handleResponse($result);
    }

    /**
     * Унифицированный метод для обработки ответов.
     */
    private function handleResponse($result): \Illuminate\Http\JsonResponse
    {
        if ($result['success']) {
            return response()->json($result['data'], 200);
        } else {
            return response()->json(['error' => $result['message']], 400);
        }
    }
}

