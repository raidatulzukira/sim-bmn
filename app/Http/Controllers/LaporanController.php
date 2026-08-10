<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AsetBmn;
use App\Models\Ruangan;
use App\Models\Pemeliharaan;
use App\Models\Peminjaman;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $asets = AsetBmn::select('kode_barang', 'nama_barang', 'merk', 'tipe', 'nama', 'jenis_bmn')
            ->groupBy('kode_barang', 'nama_barang', 'merk', 'tipe', 'nama', 'jenis_bmn')
            ->orderBy('nama_barang')
            ->get();
        $ruangans = Ruangan::orderBy('nama_ruangan')->get();

        $previewData = null;
        $jenis = $request->input('jenis_laporan');

        if ($jenis) {
            $previewData = [];
            switch ($jenis) {
                case 'rekap_pemeliharaan':
                    $start = $request->input('tanggal_awal');
                    $end = $request->input('tanggal_akhir');
                    
                    $query = Pemeliharaan::with(['asetBmn', 'pelapor', 'approver']);
                    if ($start && $end) {
                        $query->whereBetween('tanggal_pengajuan', [$start, $end]);
                    }
                    
                    $pemeliharaans = $query->orderBy('tanggal_pengajuan', 'desc')->get();
                    $previewData['pemeliharaans'] = $pemeliharaans->groupBy('batch_id')->map(function ($group) {
                        $first = $group->first();
                        $first->jumlah_item = $group->count();
                        return $first;
                    })->values();
                    
                    $previewData['start'] = $start;
                    $previewData['end'] = $end;
                    break;

                case 'riwayat_pemeliharaan_aset':
                    if ($request->filled('kode_barang')) {
                        $kode_barang = $request->input('kode_barang');
                        $aset = AsetBmn::where('kode_barang', $kode_barang)->first();
                        if ($aset) {
                            $previewData['aset'] = $aset;
                            $pemeliharaans = Pemeliharaan::with(['pelapor', 'approver'])
                                ->whereHas('asetBmn', function($q) use ($kode_barang) {
                                    $q->where('kode_barang', $kode_barang);
                                })
                                ->orderBy('tanggal_pengajuan', 'desc')->get();
                                
                            $previewData['pemeliharaans'] = $pemeliharaans->groupBy('batch_id')->map(function ($group) {
                                $first = $group->first();
                                $first->jumlah_item = $group->count();
                                return $first;
                            })->values();
                        }
                    }
                    break;

                case 'detail_pemeliharaan_aset':
                    if ($request->filled('kode_barang')) {
                        $kode_barang = $request->input('kode_barang');
                        $aset = AsetBmn::where('kode_barang', $kode_barang)->first();
                        if ($aset) {
                            $previewData['aset'] = $aset;
                            $pemeliharaans = Pemeliharaan::with(['pelapor', 'approver'])
                                ->whereHas('asetBmn', function($q) use ($kode_barang) {
                                    $q->where('kode_barang', $kode_barang);
                                })
                                ->orderBy('tanggal_pengajuan', 'desc')->get();
                                
                            $previewData['pemeliharaans'] = $pemeliharaans->groupBy('batch_id')->map(function ($group) {
                                $first = $group->first();
                                $first->jumlah_item = $group->count();
                                return $first;
                            })->values();
                        }
                    }
                    break;

                case 'riwayat_peminjaman_aset':
                    if ($request->filled('kode_barang')) {
                        $kode_barang = $request->input('kode_barang');
                        $aset = AsetBmn::where('kode_barang', $kode_barang)->first();
                        if ($aset) {
                            $previewData['aset'] = $aset;
                            $peminjamans = Peminjaman::with(['user', 'approver'])
                                ->whereHas('asetBmn', function($q) use ($kode_barang) {
                                    $q->where('kode_barang', $kode_barang);
                                })
                                ->orderBy('created_at', 'desc')->get();
                                
                            $previewData['peminjamans'] = $peminjamans->groupBy('batch_id')->map(function ($group) {
                                $first = $group->first();
                                $first->jumlah_item = $group->count();
                                return $first;
                            })->values();
                        }
                    }
                    break;

                case 'dbr':
                    if ($request->filled('ruangan_id')) {
                        $ruangan = Ruangan::find($request->input('ruangan_id'));
                        if ($ruangan) {
                            $previewData['ruangan'] = $ruangan;
                            $previewData['asets'] = AsetBmn::where('ruangan_id', $ruangan->id)
                                ->select('kode_barang', 'nama_barang', 'status', \DB::raw('COUNT(id) as jumlah_item'), \DB::raw('MAX(tanggal_perolehan) as max_tanggal_perolehan'))
                                ->groupBy('kode_barang', 'nama_barang', 'status')
                                ->orderBy('nama_barang')->get();
                        }
                    }
                    break;
            }
        }

        return view('laporan.index', compact('asets', 'ruangans', 'previewData', 'jenis'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'jenis_laporan' => 'required|string',
            'format' => 'required|in:pdf,excel'
        ]);

        $jenis = $request->input('jenis_laporan');
        $format = $request->input('format');

        $data = ['isPdf' => ($format === 'pdf')];
        $viewName = '';
        $filename = '';

        switch ($jenis) {
            case 'rekap_pemeliharaan':
                $start = $request->input('tanggal_awal');
                $end = $request->input('tanggal_akhir');
                
                $query = Pemeliharaan::with(['asetBmn', 'pelapor', 'approver']);
                if ($start && $end) {
                    $query->whereBetween('tanggal_pengajuan', [$start, $end]);
                }
                
                $pemeliharaans = $query->orderBy('tanggal_pengajuan', 'desc')->get();
                $data['pemeliharaans'] = $pemeliharaans->groupBy('batch_id')->map(function ($group) {
                    $first = $group->first();
                    $first->jumlah_item = $group->count();
                    return $first;
                })->values();
                
                $data['start'] = $start;
                $data['end'] = $end;
                $viewName = 'laporan.pdf.rekap_pemeliharaan';
                $filename = 'Laporan_Rekap_Pemeliharaan_' . date('Ymd');
                break;

            case 'riwayat_pemeliharaan_aset':
                $kode_barang = $request->input('kode_barang');
                $aset = AsetBmn::where('kode_barang', $kode_barang)->first();
                if (!$aset) return redirect()->back()->with('error', 'Aset tidak ditemukan');
                
                $pemeliharaans = Pemeliharaan::with(['pelapor', 'approver'])
                                    ->whereHas('asetBmn', function($q) use ($kode_barang) {
                                        $q->where('kode_barang', $kode_barang);
                                    })
                                    ->orderBy('tanggal_pengajuan', 'desc')->get();
                                    
                $data['aset'] = $aset;
                $data['pemeliharaans'] = $pemeliharaans->groupBy('batch_id')->map(function ($group) {
                    $first = $group->first();
                    $first->jumlah_item = $group->count();
                    return $first;
                })->values();
                $viewName = 'laporan.pdf.riwayat_pemeliharaan_aset';
                $filename = 'Laporan_Riwayat_Pemeliharaan_Aset_' . $aset->kode_barang;
                break;

            case 'detail_pemeliharaan_aset':
                $request->validate(['kode_barang' => 'required']);
                $kode_barang = $request->input('kode_barang');
                $aset = AsetBmn::where('kode_barang', $kode_barang)->firstOrFail();
                
                $pemeliharaans = Pemeliharaan::with(['pelapor', 'approver'])
                                    ->whereHas('asetBmn', function($q) use ($kode_barang) {
                                        $q->where('kode_barang', $kode_barang);
                                    })
                                    ->orderBy('tanggal_pengajuan', 'desc')->get();
                                    
                $data['aset'] = $aset;
                $data['pemeliharaans'] = $pemeliharaans->groupBy('batch_id')->map(function ($group) {
                    $first = $group->first();
                    $first->jumlah_item = $group->count();
                    return $first;
                })->values();
                $viewName = 'laporan.pdf.detail_pemeliharaan_aset';
                $filename = 'Laporan_Detail_Pemeliharaan_Aset_' . $aset->kode_barang;
                break;

            case 'riwayat_peminjaman_aset':
                $request->validate(['kode_barang' => 'required']);
                $kode_barang = $request->input('kode_barang');
                $aset = AsetBmn::where('kode_barang', $kode_barang)->firstOrFail();
                
                $peminjamans = Peminjaman::with(['user', 'approver'])
                                    ->whereHas('asetBmn', function($q) use ($kode_barang) {
                                        $q->where('kode_barang', $kode_barang);
                                    })
                                    ->orderBy('created_at', 'desc')->get();
                                    
                $data['aset'] = $aset;
                $data['peminjamans'] = $peminjamans->groupBy('batch_id')->map(function ($group) {
                    $first = $group->first();
                    $first->jumlah_item = $group->count();
                    return $first;
                })->values();
                $viewName = 'laporan.pdf.riwayat_peminjaman_aset';
                $filename = 'Laporan_Riwayat_Peminjaman_Aset_' . $aset->kode_barang;
                break;

            case 'dbr':
                $request->validate(['ruangan_id' => 'required']);
                $ruangan = Ruangan::findOrFail($request->input('ruangan_id'));
                
                $data['ruangan'] = $ruangan;
                $data['asets'] = AsetBmn::where('ruangan_id', $ruangan->id)
                    ->select('kode_barang', 'nama_barang', 'status', \DB::raw('COUNT(id) as jumlah_item'), \DB::raw('MAX(tanggal_perolehan) as max_tanggal_perolehan'))
                    ->groupBy('kode_barang', 'nama_barang', 'status')
                    ->orderBy('nama_barang')->get();
                $viewName = 'laporan.pdf.dbr';
                $filename = 'Laporan_Daftar_Barang_Ruangan_' . str_replace(' ', '_', $ruangan->nama_ruangan);
                break;
                
            default:
                return back()->with('error', 'Jenis laporan tidak valid.');
        }

        if ($format === 'excel') {
            return Excel::download(new LaporanExport($viewName, $data), $filename . '.xlsx');
        } else {
            $pdf = Pdf::loadView($viewName, $data)->setPaper('a4', 'landscape');
            return $pdf->download($filename . '.pdf');
        }
    }
}
