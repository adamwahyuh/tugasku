<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_melihat_semua_tugas(){

        $tasks = Task::factory(10)->create();

        $task = $tasks[0];

        $response = $this->get(route('tugas.index'));

        $response->assertSee($task->deskripsi);

        $response->assertViewIs('tugas');
    }

    public function test_berhasil_membuat_tugas(){
        $data = [
            'deskripsi' => 'Tugas 1',
            'tenggat_waktu' => now(),
        ];

        $response = $this->post(route('tugas.store'), $data);

        $response->assertRedirectBack();

        $this->assertDatabaseHas('tasks', [
            'deskripsi' => $data['deskripsi'],
            'tenggat_waktu' => $data['tenggat_waktu'],
        ]);
    }

    public function test_berhasil_mengubah_tugas(){
        $data = [
            'deskripsi' => 'Tugas 1',
            'tenggat_waktu' => now(),
        ];

        
        $tasks = Task::factory(10)->create();

        $task = $tasks[0];

        // cek dulu data pertama
        $this->assertDatabaseHas('tasks', [
            'deskripsi' => $task->deskripsi,
            'tenggat_waktu' => $task->tenggat_waktu,
        ]);

        $response = $this->put(
            route('tugas.update', ['task' => $task->id]), 
            ['deskripsi' => $data['deskripsi']
        ]);

        $response->assertRedirectBack();
        // cek data terupdate
        $this->assertDatabaseHas('tasks', [
            'deskripsi' => $data['deskripsi'],
            'tenggat_waktu' => $task->tenggat_waktu,
            'updated_at' => now(),
        ]);

        // cek data laama sudah ilang atau belum?
        $this->assertDatabaseMissing('tasks', [
            'deskripsi' => $task->deskripsi,
            'tenggat_waktu' => $task->tenggat_waktu,
        ]);
    }

    public function test_berhasil_menghapus_tugas(){
        $tasks = Task::factory(10)->create();

        $task = $tasks[0];

        // cek dulu data pertama
        $this->assertDatabaseHas('tasks', [
            'deskripsi' => $task->deskripsi,
            'tenggat_waktu' => $task->tenggat_waktu,
        ]);

        $response = $this->delete(route('tugas.destroy', ['task' => $task->id]));

        $response->assertRedirectBack();
        $this->assertDatabaseMissing('tasks', [
            'deskripsi' => $task->deskripsi,
            'tenggat_waktu' => $task->tenggat_waktu,
        ]);
    }

    public function test_berhasil_menandai_tugas_selesai(){
        $tasks = Task::factory(10)->create();

        $task = $tasks[0];

        // cek dulu data pertama
        $this->assertDatabaseHas('tasks', [
            'deskripsi' => $task->deskripsi,
            'tenggat_waktu' => $task->tenggat_waktu,
            'selesai_pada' => null,
        ]);

        $response = $this->patch(route('tugas.mark_as_done', ['task' => $task->id]));

        $response->assertRedirectBack();
        // cek selesai pada
        $this->assertDatabaseHas('tasks', [
            'deskripsi' => $task->deskripsi,
            'tenggat_waktu' => $task->tenggat_waktu,
            'selesai_pada' => now(),
        ]);
    }
}
