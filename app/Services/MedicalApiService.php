<?php

namespace App\Services;

use ANZ\BitUmc\SDK\Builder;
use ANZ\BitUmc\SDK\Core\Dictionary\ClientScope;
use ANZ\BitUmc\SDK\Core\Dictionary\Protocol;
use ANZ\BitUmc\SDK\Factory;
use ANZ\BitUmc\SDK\Service\Exchange\Soap;

class MedicalApiService
{
    protected Object $exchangeService;

    public function __construct()
    {
        $this->exchangeService = $this->init();
    }

    private function init(): Soap
    {
        try {

            $client = Builder\ExchangeClient::init()
                ->setLogin(config('services.medical.username'))
                ->setPassword(config('services.medical.password'))
                ->setPublicationProtocol(config('services.medical.ssl')? Protocol::HTTPS : Protocol::HTTP)
                ->setPublicationAddress(config('services.medical.address'))
                ->setBaseName(config('services.medical.base_name'))
                ->setScope(ClientScope::WEB_SERVICE)
                ->build();

            return (new Factory\Exchange($client))->create();
        } catch (\Exception $e) {
            throw new \RuntimeException('Ошибка при инициализации ExchangeService: ' . $e->getMessage(), 0, $e);
        }
    }

    public function getClinics(): array
    {
        $result = $this->exchangeService->getClinics();
        return $this->formatResult($result);
    }

    public function getEmployees(): array
    {
        $result = $this->exchangeService->getEmployees();
        return $this->formatResult($result);
    }

    public function getNomenclature($clinicUid): array
    {
        $result = $this->exchangeService->getNomenclature($clinicUid);
        return $this->formatResult($result);
    }

    public function getSchedule($daysCount, $clinicUid, $employeeUids, $startDate): array
    {
        $result = $this->exchangeService->getSchedule($daysCount, $clinicUid, $employeeUids, $startDate);
        return $this->formatResult($result);
    }

    public function getOrderStatus($orderUid): array
    {
        $result = $this->exchangeService->getOrderStatus($orderUid);
        return $this->formatResult($result);
    }

    public function createWaitList(array $waitListData): array
    {
        $waitList = Builder\Order::createWaitList()
            ->setSpecialtyName($waitListData['specialtyName'])
            ->setName($waitListData['name'])
            ->setLastName($waitListData['lastName'])
            ->setSecondName($waitListData['secondName'] ?? null)
            ->setDateTimeBegin(\DateTime::createFromFormat('d.m.Y H:i:s', $waitListData['dateTimeBegin']))
            ->setPhone($waitListData['phone'])
            ->setEmail($waitListData['email'])
            ->setAddress($waitListData['address'])
            ->setClinicUid($waitListData['clinicUid'])
            ->setComment($waitListData['comment'] ?? null)
            ->build();

        $result = $this->exchangeService->sendWaitList($waitList);
        return $this->formatResult($result);
    }

    public function reserveTime(array $reserveData): array
    {
        $reserve = Builder\Order::createReserve()
            ->setClinicUid($reserveData['clinicUid'])
            ->setSpecialtyName($reserveData['specialtyName'])
            ->setEmployeeUid($reserveData['employeeUid'])
            ->setDateTimeBegin(\DateTime::createFromFormat('d.m.Y H:i:s', $reserveData['dateTimeBegin']))
            ->build();

        $result = $this->exchangeService->sendReserve($reserve);
        return $this->formatResult($result);
    }

    public function createOrder(array $orderData): array
    {
        $order = Builder\Order::createOrder()
            ->setEmployeeUid($orderData['refUid'])
            ->setName($orderData['name'])
            ->setLastName($orderData['lastName'])
            ->setSecondName($orderData['secondName'])
            ->setDateTimeBegin(\DateTime::createFromFormat('Y-m-d\TH:i:s', $orderData['timeBegin']))
            ->setPhone($orderData['phone'])
            ->setEmail($orderData['email'] ?? '')
            ->setAddress($orderData['address'] ?? '')
            ->setClientBirthday($orderData['clientBirthday'] ?? '')
            ->setClinicUid($orderData['clinicUid'])
            ->setAppointmentDuration($orderData['appointmentDuration'])
            ->setComment($orderData['comment'] ?? '')
            ->setServices($orderData['services'] ?? [])
            ->setOrderUid($orderData['orderUid'] ?? '')
            ->setDoctorCode($orderData['DoctorCode']?? '')
            ->build();


        $result = $this->exchangeService->sendOrder($order);
        return $this->formatResult($result);
    }

    public function deleteOrder($orderUid): array
    {
        $result = $this->exchangeService->deleteOrder($orderUid);
        return $this->formatResult($result);
    }

    /**
     * Форматирование результата запроса.
     */
    private function formatResult($result)
    {
        if ($result->isSuccess()) {
            return [
                'success' => true,
                'data' => $result->getData()
            ];
        } else {
            return [
                'success' => false,
                'message' => $result->getErrorMessages()
            ];
        }
    }
}

