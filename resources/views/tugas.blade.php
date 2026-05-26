{{-- Membuat form post tugas --}}

<h3>Buat tugas</h3>
<form action="{{ route('tugas.store') }}" method="POST">
    @csrf
    {{-- csrf ini akan menambahkan input hidden dengan name= _token --}}
    <input type="text" name="deskripsi">
    <input type="datetime-local" name="tenggat_waktu">

    <button type="submit">Buat Tugas</button>
</form>

<h3>Filter</h3>
<form action="{{ route('tugas.index') }}" method="GET">
    <input type="date" name="date_start" value="{{ request('date_start') }}">
    <input type="date" name="date_end"  value="{{ request('date_end') }}">

    Pilih: 
    <input type="radio" {{ request('status') == 'selesai' ? 'checked' : '' }}  name="status" value="selesai" > Selesai
    <input type="radio"  {{ request('status') == 'belum' ? 'checked' : '' }} name="status" value="belum" > Belum Selesai
    <input type="radio"  {{ request('status') == null ? 'checked' : '' }} name="status" value="" > Semua
    <button>Filter</button>
</form>
<table border="1">
    <thead>
        <th>No</th>
        <th>Deskripsi</th>
        <th>Tenggat Waktu</th>
        <th>Selesai Pada</th>
        <th colspan="2">Aksi</th>
    </thead>

    <tbody>
        @foreach ($tasks as $task)
            
            <tr>
                <td>{{ $loop->iteration }}</td>

                @if (!$task->selesai_pada)
                    
                <td>
                    <form action="{{ route('tugas.update', ['task' => $task->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="text" name="deskripsi" value="{{ $task->deskripsi }}">
                        <button type="submit">simpan</button>
                    </form>
                </td>

                @else
                <td>{{ $task->deskripsi }}</td>
                @endif



                <td>{{ $task->tenggat_waktu }}</td>
                <td>{{ $task->selesai_pada ?? 'Belum selesai' }}</td>

                <td>
                    @if (!$task->selesai_pada)
                    <form action="{{ route('tugas.destroy', ['task' => $task->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="color: red;">Hapus</button>
                    </form>
                    @else
                    -
                    @endif
                </td>
                <td>
                    @if (!$task->selesai_pada)
                    <form action="{{ route('tugas.mark_as_done', ['task' => $task->id]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" style="color: blue;">Tandai Selesai</button>
                    </form>
                    @else
                    -
                    @endif
                </td>
            </tr>
        @endforeach

    </tbody>
</table>
