<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'username' => $this->username,
            'email_work' => $this->email_work,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'phone_number' => $this->phone_number,
            'job_title' => $this->job_title,
            'job_description' => $this->job_description,
            'location' => $this->location,
            'photo_url' => $this->photo_url,
            'slack' => $this->slack,
            'skype' => $this->skype,
            'telegram' => $this->telegram,
            'whatsapp' => $this->whatsapp,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'departments' => $this->departments->pluck('name'),
            'teams' => $this->teams->pluck('name'),
            'roles' => $this->roles->pluck('name'),
            'offices' => $this->offices->pluck('name'),
            'agency' => $this->agency->name,
            'user_type' => $this->userType->name,
        ];

        // Only include sensitive information for authorized users
        if ($request->user() && ($request->user()->hasPermission('view_employee_salary') || $request->user()->id === $this->id)) {
            $data['email_personal'] = $this->email_personal;
            $data['salary'] = $this->salary;
            $data['salary_including_agency_fees'] = $this->salary_including_agency_fees;
            $data['bonus_structure'] = $this->bonus_structure;
        }

        return $data;
    }
}