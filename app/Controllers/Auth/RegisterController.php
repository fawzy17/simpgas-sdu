<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Controllers\Home;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Google_Client;

class RegisterController extends BaseController
{
    protected $googleClient;

    public function __construct()
    {
        $this->googleClient = new Google_Client();

        $clientId = getenv('CLIENT_ID');
        $clientSecret = getenv('CLIENT_SECRET');

        $this->googleClient->setClientId($clientId);
        $this->googleClient->setClientSecret($clientSecret);
        $this->googleClient->setRedirectUri('http://localhost:8080/auth/register/google');
        $this->googleClient->addScope('email');
        $this->googleClient->addScope('profile');
    }

    public function index()
    {
        helper(['form']);
        $email = $this->request->getVar('email');

        $data = [
            'title' => 'Register',
            'validation' => \Config\Services::validation(),
            'link' => $this->googleClient->createAuthUrl(),
            'email' => $email
        ];

        if (session()->get('logged_in')) {
            if (session()->get('role_id') == 1 || session()->get('role_id') == 2) {
                return redirect()->to(base_url('admin/dashboard'));
            } else {
                return redirect()->to(base_url('/dashboard'));
            }
        };
        return view('auth/register', $data);
    }

    public function register()
    {
        helper(['form']);

        if (!$this->validate('register')) {
            $data = [
                'title' => 'Login',
                'validation' => $this->validator,
                'link' => $this->googleClient->createAuthUrl(),
                'email' => ''
            ];

            return view('auth/register', $data);
        }

        $user = new \App\Entities\UserEntity();
        $user->email = $this->request->getPost('email');
        $user->username = $this->request->getPost('username');
        $user->role_id = 3;
        $user->verified = 0;
        $password = $this->request->getVar('password');
        $user->password = password_hash($password, PASSWORD_DEFAULT);

        $userModel = new UserModel();
        $userModel->save($user);
        $dataSession = $user->toArray() + [
            'id' => $user->id,
            'username' => $user->username,
            'role_id' => $user->role_id,
            'verified' => $user->verified,
            'logged_in' => true,
        ];
        $sendEmailController = new Home();
        $sendEmailController->send_email($user->email, "PT. SUMA DELTA UTAMA (SDU)", "Akun berhasil " . $user->email . " didaftarkan");

        session()->set($dataSession);
        if (session()->get('logged_in')) {
            if (session()->get('role_id') == 1 || session()->get('role_id') == 2) {
                return redirect()->to(base_url('admin/dashboard'))->with('success_message', 'Berhasil mendaftar, selamat datang, ' . $user->username);
            } else {
                return redirect()->to(base_url('/dashboard'))->with('success_message', 'Berhasil mendaftar, selamat datang, ' . $user->username);
            }
        };
    }

    public function registerGoogle()
    {
        if (isset($_GET['code'])) {
            $token = $this->googleClient->fetchAccessTokenWithAuthCode($this->request->getVar('code'));

            $googleService = new \Google\Service\Oauth2($this->googleClient);
            $userData = $googleService->userinfo->get();

            $entity = new \App\Entities\UserEntity();
            $entity->email = $userData['email'];
            $entity->username = $userData['givenName'];
            $entity->role_id = 3;
            $entity->verified = 0;
            $entity->avatar = $userData['picture'];

            $userModel = new UserModel();
            $user = $userModel->withDeleted()->where('email', $entity->email)->first();
            if ($user) {
                $dataSession =  [
                    'id' => $user->id,
                    'username' => $user->username,
                    'role_id' => $user->role_id,
                    'verified' => $user->verified,
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
                        return redirect()->to(base_url('admin/dashboard'))->with('success_message', 'Berhasil mendaftar, selamat datang, ' . $userNew->username);
                    } else {
                        return redirect()->to(base_url('/dashboard'))->with('success_message', 'Berhasil mendaftar, selamat datang, ' . $userNew->username);
                    }
                };
            }
        }
    }
}
