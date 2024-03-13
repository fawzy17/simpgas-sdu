<?php

namespace Config;

use App\Validation\UserValidation;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        UserValidation::class
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public array $login = [
        'email' => [
            'rules' => 'required|valid_email',
            'errors' => [
                'required' => 'Email harus diisi',
                'valid_email' => 'Email tidak valid',
            ]
        ],
        'password' => [
            'rules' => 'required|min_length[8]',
            'errors' => [
                'required' => 'Password harus diisi',
                'min_length' => 'Password setidaknya terdiri dari 8 karakter',
            ]
        ],
    ];

    public array $register = [
        'email' => [
            'rules' => 'required|valid_email|is_unique[users.email]',
            'errors' => [
                'required' => 'Email harus diisi',
                'valid_email' => 'Email tidak valid',
                'is_unique' => 'Email sudah digunakan atau terdaftar'
            ]
        ],
        'username' => [
            'rules' => 'required|min_length[8]',
            'errors' => [
                'required' => 'Username harus diisi',
                'min_length' => 'Username setidaknya terdiri dari 8 karakter'
            ]
        ],
        'password' => [
            'rules' => 'required|min_length[8]',
            'errors' => [
                'required' => 'Password harus diisi',
                'min_length' => 'Password setidaknya terdiri dari 8 karakter'
            ]
        ],
        'confirm_password' => [
            'rules' => 'required|matches[password]',
            'errors' => [
                'required' => 'Konfirmasi Password harus diisi',
                'matches' => 'Konfirmasi Password harus sesuai dengan Password'
            ]
        ]
    ];

    public array $tabung = [
        'name' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Nama tabung harus diisi'
            ]
        ],
        'category' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Kategory tabung harus diisi'
            ]
        ],
        'stock' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Berat tabung harus diisi'
            ]
        ],
    ];

    public array $mitra = [
        'name' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Nama mitra harus diisi'
            ]
        ],
        'address' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Alamat mitra wajib diisi'
            ]
        ],
        'email' => [
            'rules' => 'required|user_valid_email',
            'errors' => [
                'required' => 'Alamat mitra wajib diisi',
                'user_valid_email' => 'Email ini tidak ditemukan di database'
            ]
        ]

    ];
}
