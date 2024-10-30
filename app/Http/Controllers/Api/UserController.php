<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\Models\Department;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (!Gate::allows('view_users')) {
            return $this->error('Unauthorized', 403);
        }

        $users = User::query()
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('username', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email_work', 'like', "%{$search}%");
                });
            })
            ->when($request->department_id, function ($query, $departmentId) {
                $query->whereHas('departments', function ($q) use ($departmentId) {
                    $q->where('departments.id', $departmentId);
                });
            })
            ->when($request->team_id, function ($query, $teamId) {
                $query->whereHas('teams', function ($q) use ($teamId) {
                    $q->where('teams.id', $teamId);
                });
            })
            ->when($request->role_id, function ($query, $roleId) {
                $query->whereHas('roles', function ($q) use ($roleId) {
                    $q->where('roles.id', $roleId);
                });
            })
            ->when($request->office_id, function ($query, $officeId) {
                $query->whereHas('offices', function ($q) use ($officeId) {
                    $q->where('offices.id', $officeId);
                });
            })
            ->when($request->agency_id, function ($query, $agencyId) {
                $query->where('agency_id', $agencyId);
            })
            ->paginate($request->per_page ?? 15);

        return $this->success(UserResource::collection($users));
    }

    public function show(User $user)
    {
        if (!Gate::allows('view_users')) {
            return $this->error('Unauthorized', 403);
        }

        return $this->success(new UserResource($user));
    }

    public function store(Request $request)
    {
        if (!Gate::allows('create_users')) {
            return $this->error('Unauthorized', 403);
        }

        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email_work' => 'required|email|max:255|unique:users',
            'email_personal' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'job_title' => 'required|string|max:255',
            'timezone_id' => 'required|exists:timezones,id',
            'location' => 'required|string|max:255',
            'agency_id' => 'required|exists:agencies,id',
            'user_type_id' => 'required|exists:user_types,id',
            'departments' => 'array',
            'departments.*' => 'exists:departments,id',
            'teams' => 'array',
            'teams.*' => 'exists:teams,id',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
            'offices' => 'array',
            'offices.*' => 'exists:offices,id',
        ]);

        $user = User::create($validated);

        if (!empty($validated['departments'])) {
            $user->departments()->attach($validated['departments']);
        }
        if (!empty($validated['teams'])) {
            $user->teams()->attach($validated['teams']);
        }
        if (!empty($validated['roles'])) {
            $user->roles()->attach($validated['roles']);
        }
        if (!empty($validated['offices'])) {
            $user->offices()->attach($validated['offices']);
        }

        return $this->success(new UserResource($user), 'User created successfully', 201);
    }

    public function update(Request $request, User $user)
    {
        if (!Gate::allows('edit_users')) {
            return $this->error('Unauthorized', 403);
        }

        $validated = $request->validate([
            'username' => 'sometimes|string|max:255|unique:users,username,' . $user->id,
            'email_work' => 'sometimes|email|max:255|unique:users,email_work,' . $user->id,
            'email_personal' => 'sometimes|email|max:255|unique:users,email_personal,' . $user->id,
            'password' => 'sometimes|string|min:8',
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'start_date' => 'sometimes|date',
            'job_title' => 'sometimes|string|max:255',
            'timezone_id' => 'sometimes|exists:timezones,id',
            'location' => 'sometimes|string|max:255',
            'agency_id' => 'sometimes|exists:agencies,id',
            'user_type_id' => 'sometimes|exists:user_types,id',
            'departments' => 'array',
            'departments.*' => 'exists:departments,id',
            'teams' => 'array',
            'teams.*' => 'exists:teams,id',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
            'offices' => 'array',
            'offices.*' => 'exists:offices,id',
        ]);

        $user->update($validated);

        if (isset($validated['departments'])) {
            $user->departments()->sync($validated['departments']);
        }
        if (isset($validated['teams'])) {
            $user->teams()->sync($validated['teams']);
        }
        if (isset($validated['roles'])) {
            $user->roles()->sync($validated['roles']);
        }
        if (isset($validated['offices'])) {
            $user->offices()->sync($validated['offices']);
        }

        return $this->success(new UserResource($user), 'User updated successfully');
    }

    public function destroy(User $user)
    {
        if (!Gate::allows('delete_users')) {
            return $this->error('Unauthorized', 403);
        }

        $user->delete();

        return $this->success(null, 'User deleted successfully');
    }

    public function subordinates(User $user)
    {
        if (!Gate::allows('view_users')) {
            return $this->error('Unauthorized', 403);
        }

        return $this->success(UserResource::collection($user->subordinates));
    }

    public function manager(User $user)
    {
        if (!Gate::allows('view_users')) {
            return $this->error('Unauthorized', 403);
        }

        return $this->success($user->manager ? new UserResource($user->manager) : null);
    }

    public function orgChart(Request $request)
    {
        if (!Gate::allows('view_org_chart')) {
            return $this->error('Unauthorized', 403);
        }

        $users = User::whereNull('manager_id')
            ->with(['subordinates' => function ($query) {
                $query->with('departments', 'teams', 'roles');
            }])
            ->get();

        return $this->success($this->buildOrgChartData($users));
    }

    public function orgChartByDepartment(Department $department)
    {
        if (!Gate::allows('view_org_chart')) {
            return $this->error('Unauthorized', 403);
        }

        $users = $department->users()
            ->whereNull('manager_id')
            ->with(['subordinates' => function ($query) use ($department) {
                $query->whereHas('departments', function ($q) use ($department) {
                    $q->where('departments.id', $department->id);
                })->with('departments', 'teams', 'roles');
            }])
            ->get();

        return $this->success($this->buildOrgChartData($users));
    }

    public function orgChartByTeam(Team $team)
    {
        if (!Gate::allows('view_org_chart')) {
            return $this->error('Unauthorized', 403);
        }

        $users = $team->users()
            ->whereNull('manager_id')
            ->with(['subordinates' => function ($query) use ($team) {
                $query->whereHas('teams', function ($q) use ($team) {
                    $q->where('teams.id', $team->id);
                })->with('departments', 'teams', 'roles');
            }])
            ->get();

        return $this->success($this->buildOrgChartData($users));
    }

    protected function buildOrgChartData($users)
    {
        return $users->map(function ($user) {
            $data = [
                'id' => $user->id,
                'name' => $user->full_name,
                'title' => $user->job_title,
                'departments' => $user->departments->pluck('name'),
                'teams' => $user->teams->pluck('name'),
                'roles' => $user->roles->pluck('name'),
            ];

            if ($user->subordinates->isNotEmpty()) {
                $data['children'] = $this->buildOrgChartData($user->subordinates);
            }

            return $data;
        });
    }
}