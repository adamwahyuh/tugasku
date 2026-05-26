<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    // SELANJUTNYA BUAT VIEW UNTUK MENAMPILKAN DATA TASK
    public function index(Request $request){
        // AMBIL SEMUA DATA DARI TASK

        // buat query string
        $status = $request->query('status');
        $date_start = $request->query('date_start');
        $date_end = $request->query('date_end');

        $tasks = Task::query();

        if ($date_start && $date_end) {
            $tasks->whereBetween('created_at', [$date_start, $date_end]);
        }

        if ($status === 'selesai'){
            $tasks->whereNotNull('selesai_pada');
        }
        elseif ($status === 'belum'){
            $tasks->whereNull('selesai_pada');
        }

        $tasks = $tasks->latest('created_at')->get();
        
        return view('tugas', compact('tasks'));
    }

    // MENYIMPAN DATA
    public function store(Request $request){
        // Import Request

        //validasi request

        $validasi = $request->validate([
            'deskripsi' => ['required', 'string', 'max:255'],
            'tenggat_waktu' => ['required', 'date'],
        ]);

        // MASUKAN DATA YANG SUDAH DI VALIDASI KEDALAM DB

        $task = Task::create([
            'deskripsi' => $validasi['deskripsi'],
            'tenggat_waktu' => $validasi['tenggat_waktu'],
        ]);

        // KEMBALIKAN KE HALAMAN AWAL
        return back();
    }

    // BAGIAN YANG MENANGKAP PARAM, WAJIB ADA PENANGKAPNYA CONTOH
    // MODEL $NamaParamYangTertulisDiRoute
    // Contoh Task $task
    public function update(Task $task, Request $request){
        // kalo tugas sudah selesai maka tidak bisa update

        if($task->selesai_pada) return back();
    
        $validasi = $request->validate([
            'deskripsi' => ['required', 'string', 'max:255'],
        ]);
    
        $task->update([
            'deskripsi' => $validasi['deskripsi'],
        ]);

        return back();
    }


    public function destroy(Task $task){
        // kalo sudah selesai tidak bisa dihapus
        if($task->selesai_pada) return back();

        $task->delete();

        return back();
    }

    public function markAsDone(Task $task){
        $task->selesai_pada = now();

        $task->save();

        return back();
    }
}
