<?php

    if (!function_exists('rg_permissions_array')) {
        function rg_permissions_array()
        {
            $Permissions = \Spatie\Permission\Models\Permission::all();
            $permissionsArray = [];

            foreach ($Permissions as $Permission) {
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