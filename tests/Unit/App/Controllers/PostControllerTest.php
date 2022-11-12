<?php

namespace Tests\Unit\App\Controllers;

use Agendanet\App\Controllers\PostController;
use Agendanet\Domain\Doctor\Entity\Doctor;
use Agendanet\Domain\Doctor\Repository\DoctorRepositoryInterface;
use Agendanet\Domain\Doctor\Repository\DoctorScheduleRepositoryInterface;
use Agendanet\Domain\Schedule\Factory\ScheduleFactoryInterface;
use Agendanet\Domain\Schedule\Repository\ScheduleRepositoryInterface;
use Agendanet\Domain\Schedule\UseCase\CreateScheduleUC;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;
use Agendanet\Domain\Doctor\Entity\DoctorSchedule;
use Agendanet\Domain\Pacient\Entity\Pacient;
use Agendanet\Domain\Schedule\Entity\Schedule;
use Agendanet\Domain\Schedule\Enum\ScheduleStatus;

final class PostControllerTest extends TestCase
{
    private DoctorRepositoryInterface $doctorRepositoryMock;
    
    private DoctorScheduleRepositoryInterface $doctorScheduleRepositoryMock;
    
    private ScheduleRepositoryInterface $scheduleRepositoryMock;
    
    private ScheduleFactoryInterface $scheduleFactoryMock;
    
    
    public function setUp(): void
    {
        $this->doctorRepositoryMock = $this->createMock(
            DoctorRepositoryInterface::class
        );
        $this->doctorScheduleRepositoryMock = $this->createMock(
            DoctorScheduleRepositoryInterface::class
        );
        $this->scheduleRepositoryMock = $this->createMock(
            ScheduleRepositoryInterface::class
        );
        $this->scheduleFactoryMock = $this->createMock(
            ScheduleFactoryInterface::class
        );
        parent::setUp();
    }
    
    public function testWhenUserPhoneIsNotSentShouldReturnHttp400()
    {
        // ARRANGE
        $postController = $this->getPostController();
        $payload = $this->getSuccessPayload();
        unset($payload['user_phone']);
        $request = $this->getRequest($payload);
        
        $expectedBody = json_encode([
            'code' => 400,
            'message' => 'user_phone is a mandatory parameter'
        ]);
        
        // ACT
        $response = $postController->createSchedule($request);
        
        // ASSERT
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals($expectedBody, $response->getBody()->__toString());
    }
    
    public function testWhenUserNameIsNotSentShouldReturnHttp400()
    {
        // ARRANGE
        $postController = $this->getPostController();
        $payload = $this->getSuccessPayload();
        unset($payload['user_name']);
        $request = $this->getRequest($payload);
        
        $expectedBody = json_encode([
            'code' => 400,
            'message' => 'user_name is a mandatory parameter'
        ]);
        
        // ACT
        $response = $postController->createSchedule($request);
        
        // ASSERT
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals($expectedBody, $response->getBody()->__toString());
    }
    
    public function testWhenDoctorIdIsNotSentShouldReturnHttp400()
    {
        // ARRANGE
        $postController = $this->getPostController();
        $payload = $this->getSuccessPayload();
        unset($payload['doctor_id']);
        $request = $this->getRequest($payload);
        
        $expectedBody = json_encode([
            'code' => 400,
            'message' => 'doctor_id is a mandatory parameter'
        ]);
        
        // ACT
        $response = $postController->createSchedule($request);
        
        // ASSERT
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals($expectedBody, $response->getBody()->__toString());
    }
    
    public function testWhenScheduleDatetimeIsNotSentShouldReturnHttp400()
    {
        // ARRANGE
        $postController = $this->getPostController();
        $payload = $this->getSuccessPayload();
        unset($payload['schedule_datetime']);
        $request = $this->getRequest($payload);
        
        $expectedBody = json_encode([
            'code' => 400,
            'message' => 'schedule_datetime is a mandatory parameter'
        ]);
        
        // ACT
        $response = $postController->createSchedule($request);
        
        // ASSERT
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals($expectedBody, $response->getBody()->__toString());
    }
    
    public function testWhenSuccessPayloadIsSentShouldReturnHttp200()
    {
        // ARRANGE
        $scheduleDateTime = \DateTime::createFromFormat('Y-m-d H:i', '2022-12-31 23:59');
        $pacient = new Pacient("John Doe", "41988887777");
        $doctor = new Doctor('aaa-123');
        $schedule = new Schedule(
            '8b062905-26d7-4afc-84c7-567b8a069axx', 
            $pacient, 
            $doctor, 
            $scheduleDateTime, 
            new ScheduleStatus(ScheduleStatus::PENDING), 
            new \DateTime()
        );
        $this->doctorRepositoryMock
            ->method('findByDoctorId')
            ->willReturn($doctor);
        
        $this->doctorScheduleRepositoryMock
            ->method('findSchedule')
            ->willReturn(new DoctorSchedule($doctor, $scheduleDateTime, true));
        
        $this->scheduleFactoryMock
            ->method('make')
            ->willReturn($schedule);
        
        $this->scheduleRepositoryMock
            ->method('create')
            ->withAnyParameters();
        
        $postController = $this->getPostController();
        $payload = $this->getSuccessPayload();
        $request = $this->getRequest($payload);
        
        $payload['schedule_datetime'] = '2022-12-31 23:59:00';
        $expectedBody = json_encode($payload);
        
        // ACT
        $response = $postController->createSchedule($request);
        
        // ASSERT
        $responseBody = json_decode($response->getBody()->__toString(), true);
        unset($responseBody['created_at']);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($expectedBody, json_encode($responseBody));
    }
    
    private function getPostController(): PostController
    {
        return new PostController(
            new Response(),
            new CreateScheduleUC(
                $this->doctorRepositoryMock,
                $this->doctorScheduleRepositoryMock,
                $this->scheduleRepositoryMock,
                $this->scheduleFactoryMock
            )
        );
    }
    
    private function getRequest(array $payload): RequestInterface
    {
        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn(json_encode($payload));
        
        $request = $this->createMock(RequestInterface::class);
        $request->method('getBody')->willReturn($stream);
        
        return $request;
    }
    
    private function getSuccessPayload(): array
    {
        return [
            'user_phone' => '41988887777',
            'user_name' => 'John Doe',
            'doctor_id' => 'aaa-123',
            'schedule_datetime' => '2022-12-31 23:59'
        ];
    }
}
