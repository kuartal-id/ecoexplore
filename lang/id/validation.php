<?php

// Indonesian validation messages for the rules Ecoexplore uses. Missing keys fall back to
// lang/en/validation.php.
return [
    'accepted' => ':attribute harus disetujui.',
    'after' => ':attribute harus setelah :date.',
    'after_or_equal' => ':attribute harus pada atau setelah :date.',
    'alpha_dash' => ':attribute hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah.',
    'boolean' => ':attribute harus benar atau salah.',
    'confirmed' => 'Konfirmasi :attribute tidak cocok.',
    'date' => ':attribute bukan tanggal yang valid.',
    'email' => ':attribute harus berupa alamat email yang valid.',
    'gte' => ['numeric' => ':attribute harus lebih besar atau sama dengan :value.'],
    'in' => ':attribute yang dipilih tidak valid.',
    'integer' => ':attribute harus berupa bilangan bulat.',
    'max' => ['numeric' => ':attribute tidak boleh lebih dari :max.', 'string' => ':attribute tidak boleh lebih dari :max karakter.'],
    'min' => ['numeric' => ':attribute minimal :min.', 'string' => ':attribute minimal :min karakter.'],
    'password' => [
        'letters' => ':attribute harus berisi setidaknya satu huruf.',
        'mixed' => ':attribute harus berisi huruf besar dan kecil.',
        'numbers' => ':attribute harus berisi setidaknya satu angka.',
        'symbols' => ':attribute harus berisi setidaknya satu simbol.',
        'uncompromised' => ':attribute ini pernah muncul dalam kebocoran data. Silakan pilih yang lain.',
    ],
    'regex' => 'Format :attribute tidak valid.',
    'required' => ':attribute wajib diisi.',
    'string' => ':attribute harus berupa teks.',
    'unique' => ':attribute sudah digunakan.',

    'attributes' => [
        'contact_name' => 'nama lengkap',
        'contact_email' => 'email',
        'contact_phone' => 'nomor telepon',
        'quantity' => 'jumlah',
        'start_date' => 'tanggal mulai',
        'end_date' => 'tanggal selesai',
        'payment_method' => 'metode pembayaran',
        'accept_terms' => 'syarat & ketentuan',
        'name' => 'nama',
        'email' => 'email',
        'phone' => 'nomor telepon',
        'password' => 'kata sandi',
        'transfer_reference' => 'referensi transfer',
        'confirm' => 'konfirmasi',
    ],
];
