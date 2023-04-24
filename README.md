# Library Project

Merupakan hasil Tugas Rancang dengan menjadikan topik peminjaman buku sebagai ide utamanya. Website ini merupakan
perpustakaan E-book yang menyediakan berbagai macam e-book yang bisa dibaca dalam bentuk pdf file.

## Installation

### Download

Ada berbagai cara untuk menginstall project ini, diantaranya:

- Download ZIP

```bash
  klik tombol hijau 'Code' -> download ZIP 
```

- Clone Repo (_Recommended_)
  By SSH

```bash
  git@github.com:AgungPN/library.git
```

By HTTP

```bash
  https://github.com/AgungPN/library.git
```

pastikan memindahkan folder hasil download/clone pada folder server.

- `Xampp:` _xampp/htdocs/_
- `Laragon:` _laragon/www/_
- `Linux:`_var/www/html/_
- etc

### Database
kemudian buat database baru (direkomendasikan dengan nama _library_) dan export file  [library.sql](https://github.com/AgungPN/library/library.sql) pada database.
Jika menggunakan PHPmyadmin ada menu `export=>select file=>ok`
 
### Environment
buka file [env.php](https://github.com/AgungPN/library/env.php) untuk melakukan setup configuration

## Technology

- __PHP native__ without package/library/framework

- __Bootstrap 4__
- __Stisla Template__
- __Datatable__ untuk membuat feature search, paginate, sorting pada tabel
- __Toast__ popup message error/success

## Role
---- 
**Admin** memiliki hak akses untuk CRUD buku, read update delete User, melihat Denda(penalty) dan merubah status Denda

**Visitor** Pengunjung perpustakaan. Memiliki hak akses untuk melihat buku, mencari buku, meminjam, mengembalikan, denda

## User Story
---
### Authentications
--- 

1. sebagai visitor, mampu melakukan registrasi dan secara otomatis akan memiliki hak akses sebagai **Visitor**.
1. sebagai users(visitor/admin), mampu login dengan memanfaatkan page yang sama. Tetapi, jika login menggunakan akun __
   admin__ maka akan dipindahkan ke page CRUD buku, sebaliknya kalau login sebagai __Visitor__ maka akan masuk ke page
   populate buku.
1. sebagai user (visitor/admin), mampu logout dan keluar aplikasi
1. user yang telah logged, tidak bisa mengakses page login, begitu juga sebaliknya guest(belum login) maka tidak bisa
   masuk kedalam aplikasi.
1. Visitor tidak dapat mengakses page admin, begitu juga sebaliknya.

### Admin Dashboard
---

#### Book Management

1. Admin mampu melakukan CRUD data buku dengan field nama,author,tahun terbit, cover buku (img), pdf buku (pdf),
   category.
1. Pada tabel data menggunakan __datatable__ seperti penjelasan pada section _technology_

#### User Management

1. Admin mampu menghapus data user
1. Admin mampu merubah data user, seperti merubah role dari visitor ke admin, begitu juga sebaliknya.

#### Denda (Penalty) Management

1. admin mampu melihat semua data penalty
1. admin mampu melihat apakah user telah membayar penalty
1. admin mampu merubah status penalty jika visitor telah membayar denda dengan status:

- _Paid_ Terbayar
- _Unpaid_ Blm dibayar
- _Unconfirmed_ visitor telah membayar, tapi belum diconfirmasi oleh admin

---

### Visitor Dashboard

---

#### Populate Books

1. Sebagai visitor mampu melihat list buku dan melakukan search data buku berdasarkan nama buku
1. Sebagai visitor mampu melihat detail buku (tanpa data __pdf__ buku). Karena data PDF hanya bisa dilihat setelah buku
   masuk ke collections.
1. sebagai visitor mampu menambahkan buku kedalam collections. dengan catatan:

- max per visitor 5 books
- tidak ada denda dengan status selain _Paid_

#### Collections Books

1. visitor mampu melihat list buku yang dipinjamnya
2. visitor mampu membaca buku (dengan __PDF__)
3. Secara default _expired_at_ akan ditetapkan dalam _7 hari_. Selelah expired dan buku belum dikembalikan maka secara
   otomatis akan masuk kedalam penalty (untuk sementara fungsi otomatis iki akan dijalankan setika seseorang membuka
   page login)

#### Penalty (Denda)

1. visitor mampu melihat riwayat pelanggarannya
2. visitor yang melakukan penalty diwajibkan membayar denda, dengan cara mentransfer pada rekening yang telah
   ditentukkan. Setiap hari biaya dendan akan semakin meningkat. Default perhitungannya `jml_hari * 5000`.
3. setelah visitor membayar denda diwajibkan untuk mengupload bukti transfer (proof). Agar status dapat berubah
   menjadi `Unconfirmed` dan menunggu admin untuk mengkonfirmasinya.
4. ketika registrasi vistor memberikan beberapa data diri terutama address, jadi jika visitor tidak kunjung membayar
   dendan. Munkin admin bisa saja mendatangi rumahnya (diluar sistem aplikasi).