<?php

    if (!function_exists('rg_permissions_array')) {
        function rg_permissions_array()
        {
            $Permissions = \Rutatiina\User\Models\Permission::all();
            $permissionsArray = [];

            foreach ($Permissions as $Permission) 
            {
                //skip the tenants roles ie roles of id tenants 3100 - 3199

                if ($Permission->id >= 3100 && $Permission->id <= 3199) continue;

                $parts = explode('.', $Permission->name);
                $last = array_pop($parts);
                $parts = array(implode('.', $parts), $last);
                $permissionsArray[$parts[0]][] = [
                    'name' => $Permission->name,
                    'label' => $parts[1]
                ];
            }

            return $permissionsArray;
        }
    }

    if (!function_exists('rg_permission_human_readable_name')) {
        function rg_permission_human_readable_name($value)
        {
            //return \Illuminate\Support\Str::of('foo-bar')->replace('-', ' ')->ucfirst();
            $value = ucwords(str_ireplace('.', ': ', $value));
        	return str_ireplace('-', ' ', $value);
        }
    }