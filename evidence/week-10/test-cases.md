# Test Cases - Praktikum Pertemuan 10

| No | Skenario | Input Utama | Hasil yang Diharapkan | Status |
|----|----------|-------------|----------------------|--------|
| 1 | Simpan data valid | Semua field valid | Data tersimpan, redirect ke index, pesan sukses | [x] Lulus |
| 2 | Kode kosong | `code` kosong | Validasi gagal, data tidak tersimpan | [x] Lulus |
| 3 | Kode duplikat | `WEB-101` dimasukkan dua kali | Ditolak oleh rule unique | [x] Lulus |
| 4 | Nama kosong | `name` kosong | Validasi gagal | [x] Lulus |
| 5 | Biaya negatif | `fee = -1000` | Ditolak karena min:0 | [x] Lulus |
| 6 | Kuota 0 | `quota = 0` | Ditolak karena min:1 | [x] Lulus |
| 7 | Status tidak valid | Ubah manual nilai select menjadi `active` | Ditolak karena hanya menerima draft/open/closed | [x] Lulus |
| 8 | Daftar tampil ulang | Reload halaman `/courses` | Data tetap ada karena tersimpan permanen di MySQL | [x] Lulus |