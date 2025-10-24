@extends('layout.main')

@section('content')
    <div class="container my-4">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h4 class="card-title">
                            Tambah Kegiatan
                        </h4>
                    </div>
                    <div class="col text-end">
                        <a href="{{ route('presence.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('presence.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                        <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan"
                            value="{{ old('nama_kegiatan') }}">
                            @error('nama_kegiatan')
                                <div class="text-danger small">
                                    {{ $message }}
                                </div>
                                
                            @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tgl_kegiatan" class="form-label">Tanggal Kegiatan</label>
                        <input type="date" class="form-control" id="tgl_kegiatan" name="tgl_kegiatan"
                            value="{{ old('tgl_kegiatan') }}">
                            @error('tgl_kegiatan')
                                <div class="text-danger small">
                                    {{ $message }}
                                </div>
                                
                            @enderror
                    </div>
                    <div class="mb-3">
                        <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                        <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai"
                            value="{{ old('waktu_mulai') }}">
                            @error('waktu_mulai')
                                <div class="text-danger small">
                                    {{ $message }}
                                </div>
                                
                            @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>

@endsection