<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function exportUsers(Request $request)
    {
        if (!Gate::allows('view_users')) {
            abort(403);
        }

        $format = $request->input('format', 'csv');
        $filename = 'users_export_' . now()->format('Y-m-d_His');

        $users = User::with(['departments', 'teams', 'roles', 'offices', 'agency', 'userType'])
            ->get()
            ->map(function ($user) {
                return [
                    'ID' => $user->id,
                    'Username' => $user->username,
                    'Full Name' => $user->full_name,
                    'Work Email' => $user->email_work,
                    'Job Title' => $user->job_title,
                    'Departments' => $user->departments->pluck('name')->join(', '),
                    'Teams' => $user->teams->pluck('name')->join(', '),
                    'Roles' => $user->roles->pluck('name')->join(', '),
                    'Offices' => $user->offices->pluck('name')->join(', '),
                    'Agency' => $user->agency->name,
                    'User Type' => $user->userType->name,
                    'Start Date' => $user->start_date->format('Y-m-d'),
                    'Location' => $user->location,
                ];
            });

        if ($format === 'csv') {
            return $this->exportCsv($users->toArray(), $filename);
        }

        return $this->exportExcel($users->toArray(), $filename);
    }

    protected function exportCsv(array $data, string $filename): StreamedResponse
    {
        return response()->stream(
            function () use ($data) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, array_keys(reset($data)));

                foreach ($data as $row) {
                    fputcsv($handle, $row);
                }

                fclose($handle);
            },
            200,
            [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"{$filename}.csv\"",
            ]
        );
    }

    protected function exportExcel(array $data, string $filename)
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Headers
        $sheet->fromArray([array_keys(reset($data))], null, 'A1');

        // Data
        $sheet->fromArray($data, null, 'A2');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        return response()->stream(
            function () use ($writer) {
                $writer->save('php://output');
            },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => "attachment; filename=\"{$filename}.xlsx\"",
            ]
        );
    }
}