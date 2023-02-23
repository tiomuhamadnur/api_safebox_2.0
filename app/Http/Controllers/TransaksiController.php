<?php

namespace App\Http\Controllers;

use App\Models\Sirkulasi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function periksa()
    {
        $interval = 2;
        $sekarang = Carbon::now();
        $transaksi_pending_pinjam = Sirkulasi::where('status', 'pending')->where('proses', 'pinjam')->first();
        $transaksi_pending_kembali = Sirkulasi::where('status', 'pending')->where('proses', 'kembali')->first();

        if ($transaksi_pending_pinjam)
        {
            $waktu_pending = $transaksi_pending_pinjam->updated_at;
            $selisih = $sekarang->diffInMinutes($waktu_pending);
            if ($selisih >= $interval)
            {
                $transaksi_pending_pinjam->delete();
                return response()->json([
                    'status' => 'NOT OK',
                    'message' => 'Transaksi pinjam expired, telah dihapus'
                ]);
            }
            else
            {
                return response()->json([
                    'status' => 'OK',
                    'part' => $transaksi_pending_pinjam->alat->name,
                    'user' => $transaksi_pending_pinjam->pegawai->name,
                    'tanggal' => Carbon::parse($transaksi_pending_pinjam->updated_at)->format('d-m-Y'),
                    'waktu' => Carbon::parse($transaksi_pending_pinjam->updated_at)->format('H:i:s'),
                    'lokasi' => $transaksi_pending_pinjam->alat->location,
                    'message' => 'Proses pinjam',
                ]);
            }
        }

        elseif ($transaksi_pending_kembali)
        {
            $waktu_pending = $transaksi_pending_kembali->updated_at;
            $selisih = $sekarang->diffInMinutes($waktu_pending);
            if ($selisih >= $interval)
            {
                $transaksi_pending_kembali
                ->update([
                    'status' => 'pinjam',
                    'proses' => 'pinjam',
                ]);
                return response()->json([
                    'status' => 'NOT OK',
                    'message' => 'Transaksi kembali expired, diubah ke status pinjam'
                ]);
            }
            else
            {
                return response()->json([
                    'status' => 'OK',
                    'part' => $transaksi_pending_kembali->alat->name,
                    'user' => $transaksi_pending_kembali->pegawai->name,
                    'tanggal' => Carbon::parse($transaksi_pending_kembali->updated_at)->format('d-m-Y'),
                    'waktu' => Carbon::parse($transaksi_pending_kembali->updated_at)->format('H:i:s'),
                    'lokasi' => $transaksi_pending_kembali->alat->location,
                    'message' => 'Proses kembali',
                ]);
            }
        }

        else
        {
            return response()->json([
                'status' => 'NOT OK',
                'message' => 'Tidak ada alat yang dipinjam/dikembalikan'
            ]);
        }
    }
}