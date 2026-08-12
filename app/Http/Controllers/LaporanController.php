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
    public function getJenisAset()
    {
        $jenis = AsetBmn::select('jenis_bmn')->distinct()->orderBy('jenis_bmn')->pluck('jenis_bmn');
        return response()->json($jenis);
    }

    public function getNamaAset(Request $request)
    {
        $jenis = $request->jenis_bmn;
        $aset = AsetBmn::where('jenis_bmn', $jenis)
            ->select('nama_barang', 'kode_barang')
            ->distinct()
            ->orderBy('nama_barang')
            ->get();
        return response()->json($aset);
    }

    public function getNupAset(Request $request)
    {
        $kode_barang = $request->kode_barang;
        $aset = AsetBmn::where('kode_barang', $kode_barang)
            ->select('id', 'nup', 'merk', 'tipe', 'status')
            ->orderBy('nup')
            ->get();
        return response()->json($aset);
    }

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
                        
                        $deskripsiCounts = [];
                        foreach($group as $item) {
                            $desc = $item->deskripsi_kerusakan ?: 'Tanpa Keterangan';
                            if (!isset($deskripsiCounts[$desc])) $deskripsiCounts[$desc] = 0;
                            $deskripsiCounts[$desc]++;
                        }
                        
                        $aggregatedDesc = [];
                        foreach($deskripsiCounts as $desc => $count) {
                            if ($count == $first->jumlah_item) {
                                $aggregatedDesc[] = $desc;
                            } else {
                                $aggregatedDesc[] = "$desc ($count Unit)";
                            }
                        }
                        $first->aggregated_deskripsi = implode(', ', $aggregatedDesc);
                        
                        return $first;
                    })->values();
                    
                    $previewData['start'] = $start;
                    $previewData['end'] = $end;
                    break;

                case 'riwayat_pemeliharaan_aset':
                    if ($request->filled('aset_id')) {
                        $aset_id = $request->input('aset_id');
                        $aset = AsetBmn::find($aset_id);
                        if ($aset) {
                            $previewData['aset'] = $aset;
                            $previewData['pemeliharaans'] = Pemeliharaan::with(['pelapor', 'approver'])
                                ->where('aset_id', $aset_id)
                                ->orderBy('tanggal_pengajuan', 'desc')->get();
                        }
                    }
                    break;

                case 'detail_pemeliharaan_aset':
                    if ($request->filled('aset_id')) {
                        $aset_id = $request->input('aset_id');
                        $aset = AsetBmn::find($aset_id);
                        if ($aset) {
                            $previewData['aset'] = $aset;
                            $previewData['pemeliharaans'] = Pemeliharaan::with(['pelapor', 'approver'])
                                ->where('aset_id', $aset_id)
                                ->orderBy('tanggal_pengajuan', 'desc')->get();
                        }
                    }
                    break;

                case 'riwayat_peminjaman_aset':
                    if ($request->filled('aset_id')) {
                        $aset_id = $request->input('aset_id');
                        $aset = AsetBmn::find($aset_id);
                        if ($aset) {
                            $previewData['aset'] = $aset;
                            $previewData['peminjamans'] = Peminjaman::with(['user', 'approver'])
                                ->where('aset_id', $aset_id)
                                ->orderBy('created_at', 'desc')->get();
                        }
                    }
                    break;

                case 'dbr':
                    if ($request->filled('ruangan_id')) {
                        $ruangan = Ruangan::find($request->input('ruangan_id'));
                        if ($ruangan) {
                            $previewData['ruangan'] = $ruangan;
                            $previewData['asets'] = AsetBmn::where('ruangan_id', $ruangan->id)
                                ->orderBy('nama_barang')->orderBy('nup')->get();
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
                    $deskripsiCounts = [];
                    foreach($group as $item) {
                        $desc = $item->deskripsi_kerusakan ?: 'Tanpa Keterangan';
                        if (!isset($deskripsiCounts[$desc])) $deskripsiCounts[$desc] = 0;
                        $deskripsiCounts[$desc]++;
                    }
                    $aggregatedDesc = [];
                    foreach($deskripsiCounts as $desc => $count) {
                        if ($count == $first->jumlah_item) {
                            $aggregatedDesc[] = $desc;
                        } else {
                            $aggregatedDesc[] = "$desc ($count Unit)";
                        }
                    }
                    $first->aggregated_deskripsi = implode(', ', $aggregatedDesc);
                    return $first;
                })->values();
                
                $data['start'] = $start;
                $data['end'] = $end;
                $viewName = 'laporan.pdf.rekap_pemeliharaan';
                $filename = 'Laporan_Rekap_Pemeliharaan_' . date('Ymd');
                break;

            case 'riwayat_pemeliharaan_aset':
                $request->validate(['aset_id' => 'required']);
                $aset_id = $request->input('aset_id');
                $aset = AsetBmn::find($aset_id);
                if (!$aset) return redirect()->back()->with('error', 'Aset tidak ditemukan');
                
                $pemeliharaans = Pemeliharaan::with(['pelapor', 'approver'])
                                    ->where('aset_id', $aset_id)
                                    ->orderBy('tanggal_pengajuan', 'desc')->get();
                                    
                $data['aset'] = $aset;
                $data['pemeliharaans'] = $pemeliharaans;
                $viewName = 'laporan.pdf.riwayat_pemeliharaan_aset';
                $filename = 'Laporan_Riwayat_Pemeliharaan_Aset_' . $aset->nup;
                break;

            case 'detail_pemeliharaan_aset':
                $request->validate(['aset_id' => 'required']);
                $aset_id = $request->input('aset_id');
                $aset = AsetBmn::findOrFail($aset_id);
                
                $pemeliharaans = Pemeliharaan::with(['pelapor', 'approver'])
                                    ->where('aset_id', $aset_id)
                                    ->orderBy('tanggal_pengajuan', 'desc')->get();
                                    
                $data['aset'] = $aset;
                $data['pemeliharaans'] = $pemeliharaans;
                $viewName = 'laporan.pdf.detail_pemeliharaan_aset';
                $filename = 'Laporan_Detail_Pemeliharaan_Aset_' . $aset->nup;
                break;

            case 'riwayat_peminjaman_aset':
                $request->validate(['aset_id' => 'required']);
                $aset_id = $request->input('aset_id');
                $aset = AsetBmn::findOrFail($aset_id);
                
                $peminjamans = Peminjaman::with(['user', 'approver'])
                                    ->where('aset_id', $aset_id)
                                    ->orderBy('created_at', 'desc')->get();
                                    
                $data['aset'] = $aset;
                $data['peminjamans'] = $peminjamans;
                $viewName = 'laporan.pdf.riwayat_peminjaman_aset';
                $filename = 'Laporan_Riwayat_Peminjaman_Aset_' . $aset->nup;
                break;

            case 'dbr':
                $request->validate(['ruangan_id' => 'required']);
                $ruangan = Ruangan::findOrFail($request->input('ruangan_id'));
                
                $data['ruangan'] = $ruangan;
                $data['asets'] = AsetBmn::where('ruangan_id', $ruangan->id)
                    ->orderBy('nama_barang')->orderBy('nup')->get();
                $viewName = 'laporan.pdf.dbr';
                $filename = 'Laporan_Daftar_Barang_Ruangan_' . str_replace(' ', '_', $ruangan->nama_ruangan);
                break;
                
            default:
                return back()->with('error', 'Jenis laporan tidak valid.');
        }

        if ($format === 'excel') {
            $data['is_pdf'] = false;
            return Excel::download(new LaporanExport($viewName, $data), $filename . '.xlsx');
        } else {
            $data['is_pdf'] = true;
            $pdf = Pdf::loadView($viewName, $data)->setPaper('a4', 'landscape');
            return $pdf->download($filename . '.pdf');
        }
    }
}
