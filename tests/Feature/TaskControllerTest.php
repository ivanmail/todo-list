<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_displays_index_page()
    {
        Task::factory()->count(50)->create();

        $response = $this->get(route('tasks.index'));

        $response->assertStatus(200);
        $response->assertInertia(function ($page) {
            $page
                ->component('Tasks/Index')
                ->has('tasks.data');
        });
    }

    public function test_displays_task_create_page()
    {
        $response = $this->get(route('tasks.create'));

        $response->assertStatus(200);
        $response->assertInertia(function ($page) {
            $page->component('Tasks/Create');
        });
    }

    public function test_displays_task_edit_page()
    {
        $task = Task::factory()->create();

        $response = $this->get(route('tasks.edit', $task));

        $response->assertStatus(200);
        $response->assertInertia(function ($page) use ($task) {
            $page
                ->component('Tasks/Edit')
                ->where('task.id', $task->id);
        });
    }

    public function test_creates_a_task_and_redirects()
    {
        $taskData = [
            'title' => 'Test Title',
            'description' => 'Test Description',
            'completed' => false,
        ];

        $response = $this->post(route('tasks.store'), $taskData);

        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Title',
            'description' => 'Test Description',
            'completed' => false,
        ]);
    }

    public function test_updates_the_task_and_redirects()
    {
        $task = Task::factory()->create([
            'title' => 'Old Title',
            'description' => 'Old Description',
            'completed' => false,
        ]);

        $newData = [
            'title' => 'New Title',
            'description' => 'New Description',
            'completed' => true,
        ];

        $response = $this->put(route('tasks.update', $task), $newData);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'New Title',
            'description' => 'New Description',
            'completed' => true,
        ]);
    }

    public function test_toggles_completed_field_and_redirects_back()
    {
        $task = Task::factory()->create(['completed' => false]);

        $response = $this->put(
            route('tasks.completion', $task),
            ['completed' => true]
        );

        $response->assertRedirect();
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'completed' => true,
        ]);
    }

    public function test_deletes_the_task_and_redirects_back()
    {
        $task = Task::factory()->create();

        $response = $this->delete(route('tasks.destroy', $task));

        $response->assertRedirect();
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
