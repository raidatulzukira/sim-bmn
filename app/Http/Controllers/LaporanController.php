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
        $asets = AsetBmn::orderBy('nama_barang')->get();
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
                    
                    $previewData['pemeliharaans'] = $query->orderBy('tanggal_pengajuan', 'desc')->get();
                    $previewData['start'] = $start;
                    $previewData['end'] = $end;
                    break;

                case 'riwayat_pemeliharaan_aset':
                    if ($request->filled('aset_id')) {
                        $aset = AsetBmn::find($request->input('aset_id'));
                        if ($aset) {
                            $previewData['aset'] = $aset;
                            $previewData['pemeliharaans'] = Pemeliharaan::with(['pelapor', 'approver'])
                                                        ->where('aset_id', $aset->id)
                                                        ->orderBy('tanggal_pengajuan', 'desc')->get();
                        }
                    }
                    break;

                case 'detail_pemeliharaan_aset':
                    if ($request->filled('aset_id')) {
                        $aset = AsetBmn::find($request->input('aset_id'));
                        if ($aset) {
                            $previewData['aset'] = $aset;
                            $previewData['pemeliharaans'] = Pemeliharaan::with(['pelapor', 'approver'])
                                                        ->where('aset_id', $aset->id)
                                                        ->orderBy('tanggal_pengajuan', 'desc')->get();
                        }
                    }
                    break;

                case 'riwayat_peminjaman_aset':
                    if ($request->filled('aset_id')) {
                        $aset = AsetBmn::find($request->input('aset_id'));
                        if ($aset) {
                            $previewData['aset'] = $aset;
                            $previewData['peminjamans'] = Peminjaman::with(['user', 'approver'])
                                            ->where('aset_id', $aset->id)
                                            ->orderBy('created_at', 'desc')->get();
                        }
                    }
                    break;

                case 'dbr':
                    if ($request->filled('ruangan_id')) {
                        $ruangan = Ruangan::find($request->input('ruangan_id'));
                        if ($ruangan) {
                            $previewData['ruangan'] = $ruangan;
                            $previewData['asets'] = AsetBmn::where('ruangan_id', $ruangan->id)->orderBy('nama_barang')->get();
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

        $data = [];
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
                
                $data['pemeliharaans'] = $query->orderBy('tanggal_pengajuan', 'desc')->get();
                $data['start'] = $start;
                $data['end'] = $end;
                $viewName = 'laporan.pdf.rekap_pemeliharaan';
                $filename = 'Laporan_Rekap_Pemeliharaan_' . date('Ymd');
                break;

            case 'riwayat_pemeliharaan_aset':
                $aset = AsetBmn::find($request->input('aset_id'));
                if (!$aset) return redirect()->back()->with('error', 'Aset tidak ditemukan');
                
                $data = [
                    'aset' => $aset,
                    'pemeliharaans' => Pemeliharaan::with(['pelapor', 'approver'])
                                        ->where('aset_id', $aset->id)
                                        ->orderBy('tanggal_pengajuan', 'desc')->get()
                ];
                $viewName = 'laporan.pdf.riwayat_pemeliharaan_aset';
                $filename = 'Laporan_Riwayat_Pemeliharaan_Aset_' . $aset->kode_barang;
                break;

            case 'detail_pemeliharaan_aset':
                $request->validate(['aset_id' => 'required']);
                $aset = AsetBmn::findOrFail($request->input('aset_id'));
                
                $data['aset'] = $aset;
                $data['pemeliharaans'] = Pemeliharaan::with(['pelapor', 'approver'])
                                            ->where('aset_id', $aset->id)
                                            ->orderBy('tanggal_pengajuan', 'desc')->get();
                $viewName = 'laporan.pdf.detail_pemeliharaan_aset';
                $filename = 'Laporan_Detail_Pemeliharaan_Aset_' . $aset->kode_barang;
                break;

            case 'riwayat_peminjaman_aset':
                $request->validate(['aset_id' => 'required']);
                $aset = AsetBmn::findOrFail($request->input('aset_id'));
                
                $data['aset'] = $aset;
                $data['peminjamans'] = Peminjaman::with(['user', 'approver'])
                                        ->where('aset_id', $aset->id)
                                        ->orderBy('created_at', 'desc')->get();
                $viewName = 'laporan.pdf.riwayat_peminjaman_aset';
                $filename = 'Laporan_Riwayat_Peminjaman_Aset_' . $aset->kode_barang;
                break;

            case 'dbr':
                $request->validate(['ruangan_id' => 'required']);
                $ruangan = Ruangan::findOrFail($request->input('ruangan_id'));
                
                $data['ruangan'] = $ruangan;
                $data['asets'] = AsetBmn::where('ruangan_id', $ruangan->id)->orderBy('nama_barang')->get();
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
