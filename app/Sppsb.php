<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sppsb extends Model
{
//    protected $connection = 'KONEKSIWEB';
    protected $table = 'sppsb';

    protected $fillable = [
    	'user_id',
        'no_sertifikat',
        'no_jaminan',
        'no_registrasi',
        'nama_dokumen',
        'no_dokumen',
        'tgl_dokumen',
        'nama_kontraktor', 
        'bidang_usaha', 
        'alamat_kontraktor', 
        'direksi',  
        'jabatan_direksi', 
        'dokumen_pendukung', 
        'pemilik_proyek', 
        'nama_pejabat', 
        'jabatan_pejabat', 
        'alamat', 
        'jenis_pekerjaan', 
        'pembayaran', 
        'jml_termin',
        'fasilitas', 
        'persentase', 
        'sumber_dana', 
        'nilai_proyek', 
        'nilai_jaminan', 
        'waktu_mulai',
        'waktu_selesai', 
        'durasi',
        'dokumen1', 
        'dokumen2', 
        'dokumen3',
        'dokumen4',
        'dokumen5',
        'dokumen6',
        'barang_agunan',
        'pengalaman_kontraktor',
        'status',
        'jenis_sppsb',
        'skpd',
        'tgl_cetak',
        'created_by',
        'updated_by',
    ];
}
