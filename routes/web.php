<?php

use App\Http\Controllers\{
    DashboardController,
    MenuController,
    PenjualanController,
    PembelianController,
    MemberController,
    PelangganController,
    UserController,
    BahanBakuController,
    LaporanController,
    ProfileController,
    MembersController,
    MenusController,
    GrafikLaporanController,
    NotaController
};
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\BahanBaku;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('login', function () {
    return view('auth.login');
})->name('login'); // pastikan path ini sesuai dengan lokasi file login Anda
Route::get('dashboard', function () {
    return view('dashboard.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');


// Rute untuk Admin (id_role = 1)
Route::group(['middleware' => ['auth', 'cekrole:2']], function () {
    Route::get('user', [UserController::class, 'index'])->name('user.index');
    Route::resource('user', UserController::class);
    Route::post('users', [UserController::class, 'store'])->name('user.store');
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan_penjualan', [LaporanController::class, 'laporanPenjualan'])->name('laporan.penjualan');
    Route::get('laporan_pembelian', [LaporanController::class, 'laporanPembelian'])->name('laporan.pembelian');
    Route::get('/laporan_penjualan/{id}/detail', [LaporanController::class, 'showDetailPenjualan'])->name('laporan.penjualan.detail');
    Route::get('/laporan_pembelian/{id}/detail', [LaporanController::class, 'showDetailPembelian'])->name('laporan.pembelian.detail');    
    Route::get('/laporan-penjualan/{id}/pdf', [LaporanController::class, 'generatePDFJual'])->name('laporan.penjualan.pdf');
    Route::get('/laporan-pembelian/{id}/pdf', [LaporanController::class, 'generatePDFBeli'])->name('laporan.pembelian.pdf');
    Route::get('/grafik-laporan', [GrafikLaporanController::class, 'index'])->name('laporan.grafik');
    Route::get('/user/check-user/{id}', [UserController::class, 'checkUser']);
});

// Rute untuk Pegawai (id_role = 2)
Route::group(['middleware' => ['auth', 'cekrole:3']], function () {
    Route::get('penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
    Route::get('/penjualan/tambah', [PenjualanController::class, 'create'])->name('penjualan.create');
    Route::post('/penjualan', [PenjualanController::class, 'store']);
    Route::get('/nota/{id}', [NotaController::class, 'show'])->name('nota.show');

    Route::get('/pembelian', [PembelianController::class, 'index'])->name('pembelian.index');
    Route::resource('pembelian', PembelianController::class)->except(['show']);
    Route::get('/pembelian/tambah', [PembelianController::class, 'create'])->name('pembelian.create');
    Route::post('/pembelian', [PembelianController::class, 'store']);

    Route::get('bahanbaku', [BahanBakuController::class, 'index'])->name('bahanbaku.index');
    Route::post('bahanbaku', [BahanBakuController::class, 'store'])->name('bahanbaku.store');
    Route::resource('bahanbaku', BahanBakuController::class);

    Route::get('member', [MemberController::class, 'index'])->name('member.index');
    Route::post('member', [MemberController::class, 'store'])->name('member.store');
    Route::resource('member', MemberController::class);

    Route::resource('pelanggan', PelangganController::class)->except(['show']);;
    Route::resource('menu', MenuController::class);
    Route::get('/pelanggan/tambah', [PelangganController::class, 'create'])->name('pelanggan.create');
    Route::post('/pelanggan', [PelangganController::class, 'store'])->name('pelanggan.store');;
    Route::get('/member/check-pelanggan/{id}', [MemberController::class, 'checkPelanggan']);
    Route::get('/menu/check-menu/{id}', [MenuController::class, 'checkMenu']);
    Route::get('/pelanggan/check-pelanggan/{id}', [PelangganController::class, 'checkPelanggan']);
    Route::get('/bahanbaku/check-bahanbaku/{id}', [BahanBakuController::class, 'checkBahanBaku']);
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('menus', [MenusController::class, 'index'])->name('menus.index');
Route::post('menus', [MenusController::class, 'store'])->name('menus.store');
Route::get('members', [MembersController::class, 'index'])->name('members.index');

require __DIR__ . '/auth.php';