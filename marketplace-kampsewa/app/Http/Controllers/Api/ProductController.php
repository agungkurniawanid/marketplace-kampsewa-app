<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // fungsi untuk menampilkan 2 produk rating tertinggi
    // di halaman pertama dashboard mobile
    public function produkRatingTertinggi()
    {
        // Ambil data produk dengan rata-rata rating
        $produk = Produk::leftJoin('rating_produk', 'produk.id', '=', 'rating_produk.id_produk')
            ->leftJoin('users', 'users.id', '=', 'produk.id_user')
            ->leftJoin('variant_produk', 'produk.id', '=', 'variant_produk.id_produk')
            ->leftJoin('detail_variant_produk', 'variant_produk.id', '=', 'detail_variant_produk.id_variant_produk')
            ->select(
                'produk.id as id_produk',
                'produk.id_user as id_user',
                'produk.nama as nama_produk',
                'produk.foto_depan',
                DB::raw('AVG(rating_produk.rating) as rata_rating'),
                DB::raw('MIN(detail_variant_produk.harga_sewa) as harga_sewa')
            )
            ->whereNotNull('rating_produk.rating')
            ->whereNotNull('detail_variant_produk.harga_sewa')
            ->groupBy('produk.id', 'produk.id_user', 'produk.nama', 'produk.foto_depan')
            ->orderByDesc(DB::raw('AVG(rating_produk.rating)'))
            ->orderBy(DB::raw('MIN(detail_variant_produk.harga_sewa)'))
            ->get();

        // Check apakah data ada
        if ($produk->isEmpty()) {
            // Jika tidak ada maka response 404
            return response()->json(['message' => 'Data tidak ditemukan!'], 404);
        }

        // Jika data ada maka response 200
        return response()->json([
            'message' => 'success',
            'data_produk' => $produk
        ], 200);
    }



    // fungsi untuk menampilkan product berdasarkan
    // kategori: tenda, pakaian, tas & sepatu, perlengkapan, semua
    // berdasarkan: rating, termurah, termahal, terdekat
    public function getProdukByFilter($kategori = 'semua')
    {
        $filter = request()->query('filter', 'semua');
        $search = request()->query('search', null);
        $hargaMin = request()->query('hargaMin', null);
        $hargaMax = request()->query('hargaMax', null);

        // Ambil data dengan join table produk, users, variant_produk, detail_variant_produk, rating_produk
        $produk = Produk::leftJoin('users', 'users.id', '=', 'produk.id_user')
            ->leftJoin('rating_produk', 'produk.id', '=', 'rating_produk.id_produk')
            ->leftJoin('variant_produk', 'produk.id', '=', 'variant_produk.id_produk')
            ->leftJoin('detail_variant_produk', 'variant_produk.id', '=', 'detail_variant_produk.id_variant_produk')
            ->select(
                'produk.id as id_produk',
                'produk.id_user as id_user',
                DB::raw('MAX(rating_produk.id) as id_rating_produk'),
                DB::raw('MAX(variant_produk.id) as id_variant_produk'),
                DB::raw('MAX(detail_variant_produk.id) as id_detail_variant_produk'),
                'produk.nama as nama_produk',
                'produk.foto_depan',
                DB::raw('AVG(rating_produk.rating) as rata_rating'),
                DB::raw('MIN(detail_variant_produk.harga_sewa) as harga_sewa')
            )
            ->whereNotNull('rating_produk.rating')
            ->whereNotNull('detail_variant_produk.harga_sewa');

        // Filter kategori jika bukan 'semua'
        if ($kategori !== 'semua') {
            $produk->where('produk.kategori', 'like', '%' . $kategori . '%');
        }

        // Pencarian berdasarkan nama atau deskripsi produk
        if ($search) {
            $produk->where(function ($query) use ($search) {
                $query->where('produk.nama', 'like', '%' . $search . '%')
                    ->orWhere('produk.deskripsi', 'like', '%' . $search . '%');
            });
        }

        // Filter berdasarkan harga minimal dan maksimal
        if ($hargaMin !== null) {
            $produk->having('harga_sewa', '>=', $hargaMin);
        }

        if ($hargaMax !== null) {
            $produk->having('harga_sewa', '<=', $hargaMax);
        }

        // Filter berdasarkan metode urutan
        switch ($filter) {
            case 'rating':
                $produk->orderBy('rata_rating', 'desc');
                break;
            case 'termurah':
                $produk->orderBy('harga_sewa', 'asc');
                break;
            case 'termahal':
                $produk->orderBy('harga_sewa', 'desc');
                break;
            case 'semua':
            default:
                break;
        }

        // Group by produk untuk menghindari duplikasi
        $produk->groupBy('produk.id', 'produk.id_user', 'produk.nama', 'produk.foto_depan');

        // Eksekusi query dan ambil hasil
        $data = $produk->get();

        return response()->json([
            'message' => 'success',
            'data' => $data,
        ], 200);
    }



    // fungsi untuk menampilkan detial : nama, stok, harga, warna, ukuran
    // saat user clik icon keranjang produk, $parameter berdasarkan id/nama produk
    public function getDetailProdukKeranjang($parameter)
    {
        $warna = request()->query('warna');
        $ukuran = request()->query('ukuran');

        // Query untuk mendapatkan semua produk dan variannya
        $tb_produk = Produk::leftJoin('variant_produk', 'produk.id', '=', 'variant_produk.id_produk')
            ->leftJoin('detail_variant_produk', 'variant_produk.id', '=', 'detail_variant_produk.id_variant_produk')
            ->select(
                'produk.id as id_produk',
                'produk.nama as nama_produk',
                'produk.foto_depan',
                'variant_produk.id as id_variant_produk',
                'variant_produk.warna',
                'detail_variant_produk.id as id_detail_variant_produk',
                'detail_variant_produk.ukuran',
                'detail_variant_produk.stok',
                'detail_variant_produk.harga_sewa'
            )
            ->where(function ($query) use ($parameter) {
                $query->where('produk.nama', $parameter)
                    ->orWhere('produk.id', $parameter);
            });

        // Filter berdasarkan warna
        if ($warna) {
            $tb_produk->where('variant_produk.warna', 'like', '%' . $warna . '%');
        }

        // Filter berdasarkan ukuran
        if ($ukuran) {
            $tb_produk->where('detail_variant_produk.ukuran', 'like', $ukuran);
        }

        $filtered_results = $tb_produk->get();

        // Query untuk mendapatkan semua varian produk tanpa filter warna dan ukuran
        $all_variants = Produk::leftJoin('variant_produk', 'produk.id', '=', 'variant_produk.id_produk')
            ->leftJoin('detail_variant_produk', 'variant_produk.id', '=', 'detail_variant_produk.id_variant_produk')
            ->select(
                'produk.id as id_produk',
                'produk.nama as nama_produk',
                'produk.foto_depan',
                'variant_produk.id as id_variant_produk',
                'variant_produk.warna',
                'detail_variant_produk.id as id_detail_variant_produk',
                'detail_variant_produk.ukuran',
                'detail_variant_produk.stok',
                'detail_variant_produk.harga_sewa'
            )
            ->where(function ($query) use ($parameter) {
                $query->where('produk.nama', $parameter)
                    ->orWhere('produk.id', $parameter);
            })
            ->get();

        if ($all_variants->isEmpty()) {
            return response()->json([
                'message' => 'Data tidak ditemukan!',
            ], 404);
        }

        return response()->json([
            'message' => 'success',
            'semua_data_variant' => $all_variants,
            'hasil_filter' => $filtered_results,
        ], 200);
    }

    // fungsi untuk get detail produk
}
