<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_tasks()
    {
        Task::create(['title' => 'Task 1', 'completed' => false]);
        Task::create(['title' => 'Task 2', 'completed' => true]);

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        '*' => ['id', 'title', 'completed', 'created_at', 'updated_at']
                    ]
                ]);
    }

    public function test_can_create_task()
    {
        $taskData = [
            'title' => 'New Task',
            'completed' => false
        ];

        $response = $this->postJson('/api/tasks', $taskData);

        $response->assertStatus(201)
                ->assertJson([
                    'success' => true,
                    'message' => 'Task created successfully'
                ]);

        $this->assertDatabaseHas('tasks', $taskData);
    }

    public function test_can_show_task()
    {
        $task = Task::create(['title' => 'Test Task', 'completed' => false]);

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'data' => [
                        'id' => $task->id,
                        'title' => 'Test Task',
                        'completed' => false
                    ]
                ]);
    }

    public function test_can_update_task()
    {
        $task = Task::create(['title' => 'Original Title', 'completed' => false]);

        $updateData = [
            'title' => 'Updated Title',
            'completed' => true
        ];

        $response = $this->putJson("/api/tasks/{$task->id}", $updateData);

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Task updated successfully'
                ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated Title',
            'completed' => true
        ]);
    }

    public function test_can_delete_task()
    {
        $task = Task::create(['title' => 'Task to Delete', 'completed' => false]);

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(200)
                ->assertJson([
                    'success' => true,
                    'message' => 'Task deleted successfully'
                ]);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function test_create_task_validation()
    {
        $response = $this->postJson('/api/tasks', []);

        $response->assertStatus(422)
                ->assertJson([
                    'success' => false,
                    'message' => 'Validation failed'
                ]);
    }

    public function test_update_task_validation()
    {
        $task = Task::create(['title' => 'Test Task', 'completed' => false]);

        $response = $this->putJson("/api/tasks/{$task->id}", ['title' => '']);

        $response->assertStatus(422)
                ->assertJson([
                    'success' => false,
                    'message' => 'Validation failed'
                ]);
    }
}