<?php

use App\Models\Task;

test('should create a task', function () {
    $task = Task::factory()->make()->toArray();
    $urlBase = env('API_URL');

    $response = $this->postJson("{$urlBase}/task", $task);

    $response->assertCreated()
             ->assertJson([
                'Ok' => true,
                'message' => 'Tarefa cadastrada com sucesso!'
            ]);
});

test('should load tasks', function () {
    $urlBase = env('API_URL');
    Task::factory()->create();

    $response = $this->getJson("{$urlBase}/task");

    $response->assertStatus(200)
            ->assertJsonStructure([
                'Ok',
                'data' => [
                    '*' => ['id', 'title', 'description', 'finish', 'limit_date']
                ]   
            ]);           
});

