# Project - Appstarter Untuk CodeIgniter 4 Simple RBAC

Appstarter project untuk **CodeIgniter 4 Simple RBAC Module**, baca detail module [disini](https://github.com/skuadron45/ci4adminrbac)

# Siapkan Database
Buat database dengan nama **ci4adminlte**
    
konfigurasi ada di **app/Config/Database.php**, silahkan ubah sesuai kebutuhan.

# Cara Install
## Manual
1. Download Zip
2. Ekstrak zip file ke path direktori yang diinginkan. (htdocs for xampp or www for laragon)
3. Buka CMD/Shell, cd ke lokasi folder tujuan pada poin 2.
4. Lakukan perintah:
```
composer update --no-dev
```

## Clone Git
1. Buka CMD/Shell, CD path direktori yang diinginkan. (htdocs for xampp or www for laragon)
2. Lakukan perintah: 
```
git -clone https://github.com/skuadron45/ci4adminlte
```
3. Lakukan perintah: 
```
composer update --no-dev
```

Untuk menjalankan aplikasi, silahkan baca **User Guide CI4** [di sini](https://codeigniter4.github.io/userguide/installation/running.html)

# Spak Command Untuk Instalasi Modul
```
php spark ci4adminrbac:install
```

## User login:

Akses URL : [Base_URL sesuai config]/admin

example:

http://localhost:8080/admin -> bila menggunakan spark serve

http://ci4adminlte.test/admin -> bila menggunakan virtual host (XAMPP/Laragon)


**Administrator:**

username: rika

password: rika

Home module : Profile

username: zahid

password: zahid

Home module : Dashboard

*Hak Akses saya buat tidak dapat melakukan Add, Edit, Delete

**Super Admin:**

username: root

password: root

Semoga bermanfaat,

Github:

https://github.com/skuadron45/ci4adminlte

*(Password root hanya berlaku di localhost)

![capture](https://raw.githubusercontent.com/skuadron45/ci4adminlte/master/capture.png)