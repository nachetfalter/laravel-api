<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RecordPageVisitTest extends TestCase
{
    /**
     * Test invalid page name
     *
     * @return void
     */
    public function testInvalidPageName()
    {
        $response = $this->withHeaders(['accept' => 'application/json'])->post('/api/record-page-visit', [
            'pageName' => 'product',
            'ipAddress' => '78.68.215.15',
            'visitedAt' => '24-05-2021 12:04:30'
        ]);

        $response->assertStatus(422);

        $responseData = json_decode($response->content(), true);
        $this->assertTrue(isset($responseData['errors']['pageName']));
    }

    /**
     * Test invalid ip address
     *
     * @return void
     */
    public function testInvalidIpAddress()
    {
        $response = $this->withHeaders(['accept' => 'application/json'])->post('/api/record-page-visit', [
            'pageName' => 'products',
            'ipAddress' => '78.68.215.15asdqweqweqasdzxcasd',
            'visitedAt' => '24-05-2021 12:04:30'
        ]);

        $response->assertStatus(422);
        $responseData = json_decode($response->content(), true);
        $this->assertTrue(isset($responseData['errors']['ipAddress']));
    }

    /**
     * Test invalid visit time
     *
     * @return void
     */
    public function testInvalidVisitedAt()
    {
        $response = $this->withHeaders(['accept' => 'application/json'])->post('/api/record-page-visit', [
            'pageName' => 'products',
            'ipAddress' => '78.68.215.15',
            'visitedAt' => '24/05/2021 12:04:30'
        ]);

        $response->assertStatus(422);
        $responseData = json_decode($response->content(), true);
        $this->assertTrue(isset($responseData['errors']['visitedAt']));
    }

    /**
     * Test invalid/empty body
     *
     * @return void
     */
    public function testInvalidBody()
    {
        $response = $this->withHeaders(['accept' => 'application/json'])->post(
            '/api/record-page-visit',
            ['asldkjalskdj']
        );

        $response->assertStatus(422);
        $responseData = json_decode($response->content(), true);
        $this->assertTrue(isset($responseData['errors']['pageName']));
        $this->assertTrue(isset($responseData['errors']['ipAddress']));
        $this->assertTrue(isset($responseData['errors']['visitedAt']));
    }

    /**
     * Test correct input
     *
     * @return void
     */
    public function testCorrectInput()
    {
        $response = $this->withHeaders(['accept' => 'application/json'])->post(
            '/api/record-page-visit',
            [
                'pageName' => 'contact',
                'ipAddress' => '78.68.215.15',
                'visitedAt' => '24-05-2021 12:04:30'
            ]
        );

        $response->assertStatus(200);
        $responseData = json_decode($response->content(), true);
        $this->assertTrue(
            isset($responseData['message'])
            && $responseData['message'] == 'The site visit record has been saved'
        );
    }
}
