<?php

namespace App\Imports;

use App\Models\AsetBmn;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class AsetBmnImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $tanggalPerolehan = null;
        if (isset($row['tanggal_perolehan']) && $row['tanggal_perolehan'] != '') {
            if (is_numeric($row['tanggal_perolehan'])) {
                $tanggalPerolehan = Date::excelToDateTimeObject($row['tanggal_perolehan']);
            } else {
                $tanggalPerolehan = Carbon::parse($row['tanggal_perolehan']);
            }
        } else {
            $tanggalPerolehan = Carbon::now();
        }

        // Clean numeric
        $nilai = preg_replace('/[^0-9\.]/', '', $row['nilai_perolehan_pertama'] ?? 0);

        return new AsetBmn([
            'jenis_bmn'               => $row['jenis_bmn'] ?? '-',
            'kode_barang'             => $row['kode_barang'],
            'nup'                     => $row['nup'] ?? null,
            'nama_barang'             => $row['nama_barang'] ?? '-',
            'merk'                    => $row['merk'] ?? null,
            'tipe'                    => $row['tipe'] ?? null,
            'nama'                    => $row['nama'] ?? null,
            'tanggal_perolehan'       => $tanggalPerolehan,
            'nilai_perolehan_pertama' => $nilai !== '' ? $nilai : 0,
            'status'                  => 'tersedia',
        ]);
    }

    public function rules(): array
    {
        return [
            'kode_barang' => 'required',
            'nama_barang' => 'required',
            'jenis_bmn'   => 'required',
        ];
    }
}
