<?php

namespace Agendanet\App\Controllers;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\RequestInterface;
use Agendanet\App\Commons\Http\Exceptions\BadRequestException;
use Agendanet\App\Commons\Http\Exceptions\BusinessException;
use Agendanet\App\Commons\Http\Response\JsonResponse;
use Agendanet\Domain\DTO\CreateScheduleRequest;
use Agendanet\Domain\UseCase\CreateSchedule;

class PostController
{
    private ResponseInterface $response;
    private CreateSchedule $createSchedule;
    
    public function __construct(
        ResponseInterface $response,
        CreateSchedule $createSchedule
    )
    {
        $this->response = $response;
        $this->createSchedule = $createSchedule;
    }
    
    public function handler(RequestInterface $request)
    {
        try {
            $createScheduleRequest = $this->mapHttpRequestToUseCaseRequest(
                $request
            );
            $payload = $this->createSchedule->execute($createScheduleRequest);
            $this->response->getBody()->write(json_encode($payload));
        } catch (BusinessException $e) {
            $this->response->getBody()->write(json_encode($e->toArray()));
            $this->response = $this->response->withStatus($e->getCode());
        } catch (Exception $e) {
            $this->response->getBody()->write(json_encode([
                'code' => 500,
                'message' => $e->getMessage()
            ]));
            $this->response = $this->response->withStatus($e->getCode());
        } finally {
            return JsonResponse::send($this->response);
        }
    }
    
    private function mapHttpRequestToUseCaseRequest(RequestInterface $request) : CreateScheduleRequest
    {
        $params = json_decode($request->getBody()->getContents(), true);
        if (empty($params['user_phone'])) {
            throw new BadRequestException('user_phone is a mandatory parameter');
        }
        if (empty($params['user_name'])) {
            throw new BadRequestException('user_name is a mandatory parameter');
        }
        if (empty($params['doctor_id'])) {
            throw new BadRequestException('doctor_id is a mandatory parameter');
        }
        if (empty($params['schedule_datetime'])) {
            throw new BadRequestException('schedule_datetime is a mandatory parameter');
        }
        
        return new CreateScheduleRequest(
            $params['user_phone'],
            $params['user_name'],
            $params['doctor_id'],
            $params['schedule_datetime']
            );
    }
}
