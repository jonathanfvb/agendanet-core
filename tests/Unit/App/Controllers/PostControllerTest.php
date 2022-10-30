<?php

namespace Tests\Unit\App\Controllers;

use Agendanet\App\Controllers\PostController;
use Agendanet\Domain\Schedules\UseCase\CreateScheduleUC;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\Psr7\Utils;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;

final class PostControllerTest extends TestCase
{
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
        $response = $postController->handler($request);
        
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
        $response = $postController->handler($request);
        
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
        $response = $postController->handler($request);
        
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
        $response = $postController->handler($request);
        
        // ASSERT
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals($expectedBody, $response->getBody()->__toString());
    }
    
    public function testWhenSuccessPayloadIsSentShouldReturnHttp200()
    {
        // ARRANGE
        $postController = $this->getPostController();
        $payload = $this->getSuccessPayload();
        $request = $this->getRequest($payload);
        
        $expectedBody = json_encode($payload);
        
        // ACT
        $response = $postController->handler($request);
        
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
            new CreateScheduleUC()
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
            'schedule_datetime' => '2022-12-31 23:59:00'
        ];
    }
}
