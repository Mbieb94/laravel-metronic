<?php

namespace App\Policies;

use App\Models\Resources;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ResourcesPolicy
{
    protected $model;
    protected $segment;

    public function __construct(Request $request, Resources $model) {
        try {
            $this->segment = $request->segment(1);
            if (file_exists(app_path('Models/' . Str::studly($this->segment)) . '.php')) {
                $this->model = app("App\Models\\" . Str::studly($this->segment));
            } else {
                if ($model->checkTableExists($this->segment)) {
                    $this->model = $model;
                    $this->model->setTable($this->segment);
                }
            }

            if (!$this->model) abort(404);
        } catch (Exception $e) {
            //throw $th;
        }
    }
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Resources $resources): bool
    {
        // return true;
    }

    public function detail(User $user, Resources $resources): bool
    {
        // if(Auth::isAdmin()) return true;
        // return $user->id == $resources->created_by;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Resources $resources): bool
    {
        if(Auth::isAdmin()) return true;
        return $user->id == $resources->created_by;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Resources $resources): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Resources $resources): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Resources $resources): bool
    {
        //
    }

    public function ownerCostCenter(User $user, Resources $resources): bool
    {
        if(Auth::isAdmin()) return true;
        if(!$user->cost_center) return false;
        return in_array($resources->cost_centre, json_decode($user->cost_center, true));
    }
}
