# Project - Simple RBAC Using CI 4 + AdminLte3

1. Implementasi Filters terkait Autentikasi
2. View Parser, View Renderer
3. ResponseTrait
4. Library Datatable Server Side.
5. Datatable Builder di file custom js.
6. Form Builder untuk modal.
7. Login User (Encrypt dan Decrypt)
8. Add, Edit By Reload Page
9. Add, Edit, Delete By Ajax Modal
10. Hak Akses Add, Delete, Edit, View tiap modul. (Grup Pengguna)
11. Template AdminLte3, Sweet Alert, Pace Js untuk loading bar.
12. Model yang ada masih menggunakan cara CI3 (belum extend CodeIgniter\Model)
13. CSRF Filter
14. Mengakali Dynamic BASE URL seperti CI3 di Config/App.php
15. Redirect Success Url/Home Modul tiap User setelah Login.
16. Stored Procedure di database
17. Function di database.

## Update 07-03-2020 !
18. Compiling Assets (Mix) menggunakan Laravel Mix, (1 js dan 1 css untuk template adminlte)
19. Ubah request login menggunakan ajax

## Next Update
1. Penggunaan Database Migration
2. Penggunaan Model dan Entity
3. Module Profil Pengguna
4. HMVC module agar memaksimalkan namespaces
5. ...

# Cara Install
## Manual
1. Download Zip
2. Ekstrak zip file ke path direktori yang diinginkan. (htdocs for xampp or www for laragon)
3. Buka command prompt/shell, cd ke lokasi folder tujuan pada poin 2.
4. Lakukan perintah: composer update
5. import file sql cms_ci4.sql

## Clone Git
1. Buka command prompt/shell, cd path direktori yang diinginkan. (htdocs for xampp or www for laragon)
2. Lakukan perintah: git -clone https://github.com/skuadron45/ci4adminlte
3. Lakukan perintah: composer update
4. import file sql cms_ci4.sql

Untuk menjalankan aplikasi, silahkan baca user guide CI4 di link berikut:
https://codeigniter4.github.io/userguide/installation/running.html

## User login:

Administrator:

username: rika

password: rika

Home module : Profile

username: zahid

password: zahid

Home module : Dashboard

*Hak Akses saya buat tidak dapat melakukan Add, Edit, Delete

Super Admin:

username: root

password: root

Semoga bermanfaat,

Github:
https://github.com/skuadron45/ci4adminlte

Demo:
http://ci4test.itcupu.com/login

*(Password root hanya berlaku di localhost)
