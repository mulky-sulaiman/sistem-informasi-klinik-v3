# SIK : Sistem Informasi Klinik v3

## Installation

-   Make a clone from respository.

```bash
git clone git@github.com:mulky-sulaiman/sistem-informasi-klinik-v3.git
```

-   Downloading packages and requirements.

```bash
composer install
```

-   Creating a copy of .env.example file to `.env` .
-   Generate your .env file key.

```bash
php artisan key:generate
```

-   Create database with name `sistem_informasi_klinik_v3`.
-   Runing migration with seeding, this will generate all the initial data for each models as sample to be used.

```bash
php artisan migrate:fresh --seed
```

-   Or populate the new database using this sql dump by running the import command in the MySQL server.

```bash
https://github.com/mulky-sulaiman/sistem-informasi-klinik-v3/tree/main/database/sistem_informasi_klinik_v3_2024-05-29.sql
```

-   Runing server.

```bash
npm i && npm run dev
```

### Sample User

| Name                | Email                    | Password  |
| ------------------- | ------------------------ | --------- |
| Super Admin         | superadmin@example.com   | passsword |
| Admin               | admin@example.com        | passsword |
| Operator Clinic 1   | operator.1@example.com   | passsword |
| Operator Clinic 2   | operator.2@example.com   | passsword |
| Operator Clinic 3   | operator.3@example.com   | passsword |
| Operator Clinic 4   | operator.4@example.com   | passsword |
| Operator Clinic 5   | operator.5@example.com   | passsword |
| Pharmacist Clinic 1 | pharmacist.1@example.com | passsword |
| Pharmacist Clinic 2 | pharmacist.2@example.com | passsword |
| Pharmacist Clinic 3 | pharmacist.3@example.com | passsword |
| Pharmacist Clinic 4 | pharmacist.4@example.com | passsword |
| Pharmacist Clinic 5 | pharmacist.1@example.com | passsword |
| Doctor Clinic 1     | doctor.1@example.com     | passsword |
| Doctor Clinic 2     | doctor.2@example.com     | passsword |
| Doctor Clinic 3     | doctor.3@example.com     | passsword |
| Doctor Clinic 4     | doctor.4@example.com     | passsword |
| Doctor Clinic 5     | doctor.2@example.com     | passsword |

-   ERD (Table Screenshot) : https://github.com/mulky-sulaiman/sistem-informasi-klinik-v3/tree/main/database/ERD.png

-   Sequence Diagram : https://github.com/mulky-sulaiman/sistem-informasi-klinik-v3/tree/main/public/diagrams/seqdiag-appointment-transaction.svg

## License

MIT - For testing purpose only

## Progress

_Ketentuan aplikasi secara umum yang dibuat terdiri dari_ :

1. ~~Terdapat user login berdasarkan hak aksesnya (SRBAC)~~ DONE
2. ~~Terdapat master CRUD untuk pembuatan master wilayah, user, dan pegawai, tindakan, obat~~ DONE
3. ~~Terdapat menu transaksi untuk pendaftaran pasien~~ DONE
4. ~~Terdapat menu transaksi untuk memberikan tindakan dan obat pada pasien~~ DONE
5. ~~Terdapat menu informasi untuk melakukan pembayaran tagihan pasien~~ DONE
6. Terdapat menu laporan yang dapat ditampilkan dengan grafik
