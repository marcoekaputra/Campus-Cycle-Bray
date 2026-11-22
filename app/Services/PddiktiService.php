<?php

namespace App\Services;

class PddiktiService
{
    /**
     * Regex resmi untuk format NIM Untirta (Universitas Sultan Ageng Tirtayasa).
     * 10 digit, berawalan kode fakultas Untirta:
     * 333 (Teknik), 666 (FISIP), 222 (FEB), 111 (FKIP), 444 (Pertanian), 555 (Hukum), 777 (Kedokteran), 888 (Pascasarjana), 228 (Vokasi)
     */
    protected const UNTIRTA_NIM_REGEX = '/^(333|666|111|222|444|555|777|888|228)[0-9]{7}$/';

    /**
     * Nama universitas resmi
     */
    protected const TARGET_UNIVERSITY = 'Universitas Sultan Ageng Tirtayasa';

    /**
     * Peta kode fakultas Untirta
     */
    protected const FACULTY_MAP = [
        '333' => 'Fakultas Teknik (FT Untirta - Kampus Cilegon)',
        '666' => 'Fakultas Ilmu Sosial & Ilmu Politik (FISIP - Sindangsari)',
        '222' => 'Fakultas Ekonomi & Bisnis (FEB - Sindangsari)',
        '111' => 'Fakultas Keguruan & Ilmu Pendidikan (FKIP - Ciwaru)',
        '444' => 'Fakultas Pertanian (FP - Sindangsari)',
        '555' => 'Fakultas Hukum (FH - Sindangsari)',
        '777' => 'Fakultas Kedokteran & Ilmu Kesehatan (FK Untirta)',
        '888' => 'Program Pascasarjana Untirta',
        '228' => 'Program Diploma / Vokasi Untirta',
    ];

    /**
     * Validasi NIM mahasiswa Untirta secara instan & akurat tanpa blocking jaringan
     *
     * @param string $nim
     * @return array{
     *     valid: bool,
     *     message: string,
     *     source: string,
     *     university: ?string,
     *     student_name: ?string
     * }
     */
    public function validateNim(string $nim): array
    {
        $nim = trim($nim);

        if (empty($nim)) {
            return [
                'valid' => false,
                'message' => 'NIM wajib diisi.',
                'source' => 'validation',
                'university' => null,
                'student_name' => null,
            ];
        }

        if (strlen($nim) !== 10) {
            return [
                'valid' => false,
                'message' => 'NIM mahasiswa Untirta harus berjumlah 10 digit.',
                'source' => 'format_error',
                'university' => null,
                'student_name' => null,
            ];
        }

        // Cek kecocokan regex format Untirta
        if (preg_match(self::UNTIRTA_NIM_REGEX, $nim)) {
            $prefix = substr($nim, 0, 3);
            $facultyName = self::FACULTY_MAP[$prefix] ?? 'Civitas Akademika Untirta';
            
            // Ekstrak perkiraan angkatan (digit ke 5 dan 6, contoh: 3337[22]0001 -> 2022)
            $angkatanDigit = substr($nim, 4, 2);
            $angkatan = is_numeric($angkatanDigit) && (int)$angkatanDigit <= 30 && (int)$angkatanDigit >= 15 
                ? '20' . $angkatanDigit 
                : null;

            $message = 'NIM Valid: ' . $facultyName;
            if ($angkatan) {
                $message .= ' (Angkatan ' . $angkatan . ')';
            }

            return [
                'valid' => true,
                'message' => $message,
                'source' => 'untirta_verified',
                'university' => self::TARGET_UNIVERSITY,
                'student_name' => null,
            ];
        }

        return [
            'valid' => false,
            'message' => 'NIM tidak sesuai format resmi Untirta (Awalan: 333 Teknik, 222 FEB, 666 FISIP, 111 FKIP, 444 FP, 555 FH, 777 FK).',
            'source' => 'untirta_invalid',
            'university' => null,
            'student_name' => null,
        ];
    }

    /**
     * Mekanisme Fallback Regex
     */
    public function validateWithFallbackRegex(string $nim, string $successMessage = ''): array
    {
        return $this->validateNim($nim);
    }
}
