<?php

namespace Tests\Unit;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_task()
    {
        $taskData = [
            'title' => 'Test Task',
            'completed' => false
        ];

        $task = Task::create($taskData);

        $this->assertInstanceOf(Task::class, $task);
        $this->assertEquals('Test Task', $task->title);
        $this->assertFalse($task->completed);
    }

    public function test_can_update_task()
    {
        $task = Task::create([
            'title' => 'Original Title',
            'completed' => false
        ]);

        $task->update([
            'title' => 'Updated Title',
            'completed' => true
        ]);

        $this->assertEquals('Updated Title', $task->title);
        $this->assertTrue($task->completed);
    }

    public function test_can_delete_task()
    {
        $task = Task::create([
            'title' => 'Task to Delete',
            'completed' => false
        ]);

        $taskId = $task->id;
        $task->delete();

        $this->assertDatabaseMissing('tasks', ['id' => $taskId]);
    }

    public function test_completed_scope()
    {
        Task::create(['title' => 'Completed Task', 'completed' => true]);
        Task::create(['title' => 'Pending Task', 'completed' => false]);

        $completedTasks = Task::completed()->get();
        $this->assertCount(1, $completedTasks);
        $this->assertEquals('Completed Task', $completedTasks->first()->title);
    }

    public function test_pending_scope()
    {
        Task::create(['title' => 'Completed Task', 'completed' => true]);
        Task::create(['title' => 'Pending Task', 'completed' => false]);

        $pendingTasks = Task::pending()->get();
        $this->assertCount(1, $pendingTasks);
        $this->assertEquals('Pending Task', $pendingTasks->first()->title);
    }
}