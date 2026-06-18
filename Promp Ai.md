# AI Usage Log - Tugas 3 IAE
Nama : Zidan Aliansyah Shidiq
NIM : 102022400220
Service : Jadwal Dokter

## Prompt 1
Saya mendapatkan error saat menjalankan Laravel:

Could not open input file: artisan

Bagaimana cara mengetahui apakah saya berada di folder project Laravel yang benar?

### Hasil
Menemukan bahwa saya masih berada di folder luar dan harus masuk ke folder JadwalDokter-Service terlebih dahulu.

---

## Prompt 2
Saya mendapatkan error:

SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo for mysql failed

Bagaimana cara memperbaiki konfigurasi database pada Laravel?

### Hasil
Mengubah konfigurasi DB_HOST pada file .env dan membersihkan cache konfigurasi Laravel.

---

## Prompt 3
Saya mendapatkan error:

SESSION_DRIVER=database
CACHE_STORE=database

Bagaimana cara menjalankan Laravel tanpa bergantung pada database untuk session dan cache?

### Hasil
Mengubah SESSION_DRIVER dan CACHE_STORE menjadi file.

---

## Prompt 4
Bagaimana cara mendapatkan token dari IAE Mock Server menggunakan API Key KEY-MHS-262 melalui Postman?

### Hasil
Berhasil mendapatkan token M2M menggunakan endpoint:

POST /api/v1/auth/token

---

## Prompt 5
Saya mendapatkan response:

{
  "status": "error",
  "message": "Provide api_key (M2M) or email+password (End-User SSO)."
}

Apa penyebabnya?

### Hasil
Body request belum menggunakan format JSON yang benar.

---

## Prompt 6
Saya mendapatkan response:

{
  "status": "error",
  "message": "Unauthorized"
}

Bagaimana cara menggunakan token pada Postman?

### Hasil
Menambahkan Bearer Token pada tab Authorization.

---

## Prompt 7
Saya mendapatkan error:

Invalid protocol: post https:

Apa yang salah?

### Hasil
Menemukan bahwa kata POST ikut tertulis pada kolom URL Postman.

---

## Prompt 8
Bagaimana cara mengirim data ke RabbitMQ melalui endpoint:

POST /api/v1/messages/publish

menggunakan Postman?

### Hasil
Berhasil mengirim payload JSON menggunakan Bearer Token.

---

## Prompt 9
Saya mendapatkan error:

{
  "status": "error",
  "message": "message (object or string) is required."
}

Bagaimana format payload yang benar?

### Hasil
Payload harus dibungkus dalam atribut:

{
  "message": { ... }
}

---

## Prompt 10
Bagaimana cara mengecek apakah pesan yang saya kirim berhasil masuk ke RabbitMQ?

### Hasil
Menggunakan halaman RabbitMQ Board dan memastikan pesan berhasil muncul pada board.

---

## Prompt 11
Apakah payload berikut sudah sesuai untuk Service Jadwal Dokter?

{
  "event": "doctor_schedule_created",
  "schedule_id": 2,
  "doctor_name": "Dr Rina",
  "specialization": "Anak",
  "status": "available"
}

### Hasil
Payload dapat digunakan sebagai event jadwal dokter dan berhasil dipublish ke RabbitMQ.

---

## Prompt 12
Buatkan Sequence Diagram untuk Service Jadwal Dokter dengan proses:

- Lihat jadwal dokter
- Lihat detail jadwal
- Booking jadwal dokter
- Integrasi RabbitMQ

### Hasil
Berhasil membuat Sequence Diagram yang sesuai dengan requirement Tugas 3.