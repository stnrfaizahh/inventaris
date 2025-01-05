@extends('layouts.app')

@section('title','E-Invensi-Barang Keluar')
@section('header','Input Barang Keluar')
@section('content')
<!-- // Basic multiple Column Form section start -->
<<section id="multiple-column-form">
    <div class="row match-height">
      <div class="col-12">
        <div class="card">
          <div class="card-content">
            <div class="card-body">
              <form class="form" action="{{ route('barang-keluar.store') }}" method="POST">
                @csrf
                <!-- Alert Error -->
                @if (session('error'))
                <div class="alert alert-danger">
                  <span class="icon">⚠️</span>
                  {{ session('error') }}
                </div>
                @endif
  
                @if ($errors->any())
                <div class="alert alert-danger">
                  <span class="icon">⚠️</span>
                  <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
                @endif
  
                <!-- Baris Pertama -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="nama_penanggungjawab" class="form-label">Penanggung Jawab</label>
                          <input type="text" id="nama_penanggungjawab" class="form-control" placeholder="Penanggung Jawab" name="nama_penanggungjawab" required />
                        </div>
                      </div>
                      
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="kategori_barang" class="form-label">Kategori Barang</label>
                      <select id="kategori_barang" name="kategori_barang" class="form-control" required>
                        <option value="" disabled selected>-- Pilih Kategori --</option>
                        @foreach($barangMasuk->unique('id_kategori_barang') as $barang)
                        <option value="{{ $barang->id_kategori_barang }}">{{ $barang->kategori->nama_kategori_barang }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
  
                <!-- Baris Kedua -->
                <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="nama_barang" class="form-label">Barang</label>
                        <select id="nama_barang" name="nama_barang" class="form-control" disabled>
                          <option value="" disabled selected>Pilih Barang</option>
                          @foreach($barangMasuk as $barang)
                            <option value="{{ $barang->nama_barang }}" data-kategori="{{ $barang->id_kategori_barang }}">
                              {{ $barang->nama_barang }}
                            </option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="jumlah_keluar" class="form-label">Jumlah Keluar</label>
                          <input type="number" id="jumlah_keluar" name="jumlah_keluar" class="form-control" required />
                        </div>
                      </div>
                      
                  
                </div>
  
                <!-- Baris Ketiga -->
                <div class="row">
                  
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="kondisi" class="form-label">Kondisi Barang</label>
                          <select id="kondisi" name="kondisi" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Kondisi --</option>
                            <option value="baru">Baru</option>
                            <option value="rusak">Rusak</option>
                            <option value="hilang">Hilang</option>
                          </select>
                        </div>
                      </div>
                      

                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="lokasi" class="form-label">Lokasi</label>
                          <select id="lokasi" name="lokasi" class="form-control" required>
                            <option value="" disabled selected>Pilih Lokasi</option>
                            @foreach ($lokasi as $loc)
                              <option value="{{ $loc->id_lokasi }}">{{ $loc->nama_lokasi }}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      
                </div>
  
                <!-- Baris Keempat -->
                <div class="row">
                  
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="tanggal_keluar" class="form-label">Tanggal Keluar</label>
                          <input type="date" id="tanggal_keluar" class="form-control" name="tanggal_keluar" required />
                        </div>
                      </div>                      
               
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="masa_pakai-column" class="form-label">Masa Pakai (bulan)</label>
                          <input type="number" id="masa_pakai" class="form-control" name="masa_pakai" >
                        </div>
                        </div>
                      
                </div>

  
                <!-- Submit dan Reset -->
                <div class="row">
                  <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                    <a href="{{ route('barang-keluar.index') }}" class="btn btn-light-secondary me-1 mb-1">Batal</a>
        
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <style>
        .form-select {
      max-height: 150px; /* Tinggi maksimum dropdown */
      overflow-y: auto; /* Tambahkan scroll vertikal */
    }
    
    .form-control, .form-select {
      width: 100%; /* Pastikan semua elemen form lebar penuh */
      box-sizing: border-box; /* Menghindari masalah padding */
    }
    
    .card-body {
      padding: 2rem;
    }
    
    .form-label {
      font-weight: bold;
      margin-bottom: 0.5rem;
    }
    
    button {
      min-width: 100px; /* Konsistensi lebar tombol */
    }
    .alert {
                padding: 15px;
                border-radius: 5px;
                margin-bottom: 20px;
                font-size: 16px;
            }
            .alert-danger {
                background-color: #f8d7da;
                border-color: #f5c6cb;
                color: #721c24;
                display: flex;
                align-items: center;
            }
            .alert-danger .icon {
                font-size: 20px;
                margin-right: 10px;
                color: #721c24;
            }
            .alert-danger ul {
                margin: 0;
                padding: 0;
                list-style: none;
            }
      </style>
  </section>
  

  <!-- // Basic multiple Column Form section end -->
  <script>
    // Ambil elemen dropdown kategori dan nama barang
    const kategoriDropdown = document.getElementById('kategori_barang');
    const namaBarangDropdown = document.getElementById('nama_barang');

    // Event listener untuk ketika kategori barang berubah
    kategoriDropdown.addEventListener('change', function () {
        const selectedKategori = this.value; // Ambil nilai kategori yang dipilih

        // Reset dropdown nama barang
        namaBarangDropdown.value = "";
        namaBarangDropdown.disabled = false;

        // Filter nama barang berdasarkan kategori yang dipilih
        Array.from(namaBarangDropdown.options).forEach(option => {
            if (option.dataset.kategori == selectedKategori || option.value == "") {
                option.style.display = "block"; // Tampilkan opsi
            } else {
                option.style.display = "none"; // Sembunyikan opsi
            }
        });
    });
</script>
<script src="{{asset('dist/assets/static/js/components/dark.js')}}"></script>
<script src="{{asset('dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('dist/assets/compiled/js/app.js')}}"></script>
<script src="{{asset('dist/assets/extensions/jquery/jquery.min.js')}}"></script>
<script src="{{asset('dist/assets/extensions/parsleyjs/parsley.min.js')}}"></script>
<script src="{{asset('dist/assets/static/js/pages/parsley.js')}}"></script>

@endsection