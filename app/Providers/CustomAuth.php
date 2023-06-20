<?php

namespace App\Providers;

// use App\Models\Roles;

use App\Models\Roles;
use Illuminate\Auth\SessionGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Cookie\QueueingFactory as CookieJar;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;

class CustomAuth extends SessionGuard
{
    public function login(AuthenticatableContract $user, $remember = false)
    {
        $this->updateSession($user->getAuthIdentifier());

        if ($remember) {
            $this->ensureRememberTokenIsSet($user);
            $this->queueRecallerCookie($user);
        }

        $this->fireLoginEvent($user, $remember);
        $this->setUser($user);
    }

    protected function updateSession($id)
    {
        $this->session->put($this->getName(), $id);

        $this->session->migrate(true);
    }

    public function allowedUri($uri)
    {
        $priveleges = session('permissions');
        if (!$priveleges) $priveleges = ['dashboard'];

        if (
            in_array($uri, $priveleges) ||
            in_array("*", $priveleges)
        ) return true;

        return false;
    }

    // public function getRoleName()
    // {
    //     $role = Roles::findOrFail(Auth::user()->role);
    //     if (!$role) return 'Anonime Users';
    //     return $role->name;
    // }

    public function getImage()
    {
        $image = Auth::user()->photo;

        if (!$image) {
            return asset('assets/media/avatars/300-1.jpg');
        }

        $dataArray = json_decode($image);
        $path = $dataArray->bucket . '/' . $dataArray->filename;
        if (is_file($path)) {
            $data = file_get_contents($path);
            $base64 = 'data:image/' . $dataArray->mime_type . ';base64,' . base64_encode($data);

            return $base64;
        }

        return asset('assets/media/avatars/300-1.jpg');
    }

    public function isAdmin () : bool
    {
        $userRoles = auth()->user()->roles;
        $filter = $userRoles->filter(function($role) {
            return $role->roles_id === 1;
        });

        return $filter->count();
    }

    public function isSuperUser () : bool {
        $userRoles = auth()->user()->roles;
        $filter = $userRoles->filter(function($role) {
            return $role->roles_id === 2;
        });

        return $filter->count();
    }

    public function isKeyUser () : bool {
        $userRoles = auth()->user()->roles;
        $filter = $userRoles->filter(function($role) {
            return $role->roles_id === 3;
        });

        return $filter->count();
    }

    public function isEndUser () : bool {
        $userRoles = auth()->user()->roles;
        $filter = $userRoles->filter(function($role) {
            return $role->roles_id === 4;
        });

        return $filter->count();
    }

    public function isOwner ($costCentre = NULL) : bool {
        if(Auth::isAdmin()) return true;
        if(in_array('*', json_decode(auth()->user()->cost_center, true))) return true;
        if(!empty($costCentre) && in_array($costCentre, json_decode(auth()->user()->cost_center, true))) return true;
        return false;
    }
}
