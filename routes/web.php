<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;


// MEMBUAT ROUTE UNTUK MENGHANDLE MASING MASING TUJUAN

// LALU KITA AKAN BUAT MASING MASING METHOD NYA DI CONTROLLER
// MELIHAT TUGAS DAN HALAMAN UTAMA
Route::get('/tugas', [TaskController::class, 'index'])->name('tugas.index');


// MEMBUAT TUGAS

Route::post('/tugas', [TaskController::class, 'store'])->name('tugas.store');


// BAGIAN YANG PERLU PASSING ID MAKA HARUS ADA PARAM PENANGKAP DAN BINDING DENGAN MODEL TASK
// CONTOH {task:id} mengacu pada model task kolom id
// MENGUBAH TUGAS

Route::put('/tugas/{task:id}', [TaskController::class, 'update'])->name('tugas.update');

// MENGHAPUS TUGAS

Route::delete('/tugas/{task:id}', [TaskController::class, 'destroy'])->name('tugas.destroy');

// MENANDAKAN SELESAI TUGAS

Route::patch('/tugas/{task:id}', [TaskController::class, 'markAsDone'])->name('tugas.mark_as_done');
