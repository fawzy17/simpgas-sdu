<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Controllers\Home;
use App\Models\UserModel;
use Google_Client;

class LoginController extends BaseController
{
    protected $googleClient;

    public function __construct()
    {
        $this->googleClient = new Google_Client();

        $clientId = getenv('CLIENT_ID');
        $clientSecret = getenv('CLIENT_SECRET');

        $this->googleClient->setClientId($clientId);
        $this->googleClient->setClientSecret($clientSecret);
        $this->googleClient->setRedirectUri('http://localhost:8080/auth/login/google');
        $this->googleClient->addScope('email');
        $this->googleClient->addScope('profile');
    }

    public function index()
    {
        helper(['form']);

        $data = [
            'title' => 'Login',
            'validation' => \Config\Services::validation(),
            'link' => $this->googleClient->createAuthUrl()
        ];

        if (session()->get('logged_in')) {
            if (session()->get('role_id') == 1 || 2) {
                return redirect()->to(base_url('admin/dashboard'));
            } else {
                return redirect()->to(base_url('/dashboard'));
            }
        };

        return view('auth/login', $data);
    }

    public function login()
    {
        helper(['form']);

        if (!$this->validate('login')) {
            $data = [
                'title' => 'Login',
                'validation' => $this->validator,
                'link' => $this->googleClient->createAuthUrl()
            ];

            return view('auth/login', $data);
        }

        $userEntity = new \App\Entities\UserEntity();
        $userEntity->email = $this->request->getPost('email');
        $userEntity->password = $this->request->getPost('password');
        $userModel = new UserModel();

        $user = $userModel->where('email', $userEntity->email)->first();
        if (!$user) {
            return redirect()->to(base_url('/auth/login'))->withInput()->with('error_message', 'Email yang anda masukkan tidak ditemukan');
        }

        $password = password_verify($this->request->getVar('password'), $user->password);
        if (!$password) {
            return redirect()->to(base_url('/auth/login'))->withInput()->with('error_message', 'Password yang anda masukkan salah');
        }

        $dataSession = [
            'id' => $user->id,
            'username' => $user->username,
            'role_id' => $user->role_id,
            'avatar' => $user->avatar,
            'logged_in' => true,
        ];

        session()->set($dataSession);
        if (session()->get('logged_in')) {
            if (session()->get('role_id') == 1 || session()->get('role_id') == 2) {
                return redirect()->to(base_url('admin/dashboard'))->with('success_message', 'Berhasil login, selamat datang, ' . $user->username);
            } else {
                return redirect()->to(base_url('/dashboard'))->with('success_message', 'Berhasil login, selamat datang, ' . $user->username);
            }
        };
    }

    public function loginGoogle()
    {
        if (isset($_GET['code'])) {
            $token = $this->googleClient->fetchAccessTokenWithAuthCode($this->request->getVar('code'));
            if (!isset($token['error'])) {
                $this->googleClient->setAccessToken($token['access_token']);

                $googleService = new \Google\Service\Oauth2($this->googleClient);
                $userData = $googleService->userinfo->get();

                $entity = new \App\Entities\UserEntity();
                $entity->email = $userData['email'];
                $entity->username = $userData['givenName'];
                $entity->avatar = $userData['picture'];
                $entity->role_id = 3;
                $entity->image = $userData['picture'];

                $userModel = new UserModel();
                $user = $userModel->withDeleted()->where('email', $entity->email)->first();
                if ($user) {
                    $dataSession = [
                        'id' => $user->id,
                        'username' => $user->username,
                        'role_id' => $user->role_id,
                        'avatar' => $user->avatar,
                        'logged_in' => true,
                    ];

                    session()->set($dataSession);
                    if (session()->get('logged_in')) {
                        if (session()->get('role_id') == 1 || session()->get('role_id') == 2) {
                            return redirect()->to(base_url('admin/dashboard'))->with('success_message', 'Berhasil mendaftar, selamat datang, ' . $user->username);
                        } else {
                            return redirect()->to(base_url('/dashboard'))->with('success_message', 'Berhasil mendaftar, selamat datang, ' . $user->username);
                        }
                    };
                } else {
                    $userModel->save($entity);

                    $userNew = $userModel->where('email', $entity->email)->first();

                    $dataSession = $entity->toArray() + [
                        'id' => $userNew->id,
                        'logged_in' => true,
                    ];
                    $sendEmailController = new Home();
                    $sendEmailController->send_email($entity->email, "PT. SUMA DELTA UTAMA (SDU)", "Akun " . $entity->email . " berhasil didaftarkan");


                    session()->set($dataSession);
                    if (session()->get('logged_in')) {
                        if (session()->get('role_id') == 1 || session()->get('role_id') == 2) {
                            return redirect()->to(base_url('admin/dashboard'))->with('success_message', 'Berhasil login, selamat datang, ' . $userNew->username);
                        } else {
                            return redirect()->to(base_url('/dashboard'))->with('success_message', 'Berhasil login, selamat datang, ' . $userNew->username);
                        }
                    };
                }
            }
        } else {
            return redirect()->to(base_url('auth/login'));
        }
    }

    public function logout()
    {
        session()->destroy();
        $response = [
            'status' => 'success',
            'message' => 'Berhasil logout'
        ];

        echo json_encode($response);
    }
}
