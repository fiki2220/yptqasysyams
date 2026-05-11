<?php

namespace Database\Seeders;

use App\Models\RolePermission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'guru' => [
                'dashboard.view',
                'classes.manage',
                'meetings.manage',
                'attendances.manage',
                'assessments.manage',
                'evaluations.manage',
                'grades.manage',
                'reports.view',
                'reports.download',
            ],
            'student' => [
                'dashboard.view',
                'reports.view',
                'payments.manage',
            ],
        ];

        foreach (RolePermission::ROLES as $role => $label) {
            foreach (RolePermission::PERMISSIONS as $permission => $permissionLabel) {
                RolePermission::updateOrCreate(
                    [
                        'role' => $role,
                        'permission' => $permission,
                    ],
                    [
                        'is_allowed' => in_array($permission, $defaults[$role] ?? [], true),
                    ]
                );
            }
        }
    }
}
