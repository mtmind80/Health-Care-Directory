<?php

trait RuacTrait
{

    /******************************* CHECK functions *****************************/

    public function authUserCan($actions = [])
    {
        if (! \Auth::check() || empty($actions)) {
            return false;
        }

        if ($this->authUserIs('root')) {
            return true;
        }

        if (is_array($actions)) {
            return (boolean)array_intersect($actions, $this->getAuthUserPrivileges());
        } else {
            return in_array($actions, $this->getAuthUserPrivileges());
        }
    }

    public function authUserCannot($actions = [])
    {
        return ! $this->authUserCan($actions);
    }

    // -----------------------------


    public function userCan($userId, $actions = [])
    {
        if (empty($actions)) {
            return false;
        }

        $user = \App\User::find($userId);

        if ($user->userIs($userId, 'root')) {
            return true;
        }

        if (is_array($actions)) {
            return (boolean)array_intersect($actions, $this->getUserPrivileges($userId));
        } else {
            return in_array($actions, $this->getUserPrivileges($userId));
        }
    }

    public function userCannot($userId, $actions = [])
    {
        return ! $this->userCan($userId, $actions);
    }


    /******************************* ROLE functions *****************************/


    public function authUserIs($roles = [])
    {
        if (! \Auth::check() || empty($roles)) {
            return false;
        }

        $userRoles = $this->getAuthUserRoles();

        if (in_array('root', $userRoles)) {
            return true;
        }

        if (is_array($roles)) {
            return (boolean)array_intersect($roles, $userRoles);
        } else {
            return in_array($roles, $userRoles);
        }
    }

    public function authUserIsNot($roles = [])
    {
        return ! $this->authUserIs($roles);
    }

    // alias function
    public function is($roles = [])
    {
        return $this->authUserIs($roles);
    }

    // alias function
    public function isNot($roles = [])
    {
        return ! $this->authUserIs($roles);
    }


    // -------------------------------------------

    public function userIs($userId, $roles = [])
    {
        if (empty($roles)) {
            return false;
        }

        $userRoles = $this->getUserRoles($userId);

        if (in_array('root', $userRoles)) {
            return true;
        }

        if (is_array($roles)) {
            return (boolean)array_intersect($roles, $userRoles);
        } else {
            return in_array($roles, $userRoles);
        }
    }

    public function userIsNot($userId, $roles = [])
    {
        return ! $this->userIs($userId, $roles);
    }


    /******************************* protected functions *****************************/

    protected function getAuthUserRoles()
    {
        $roles = [];

        if (\Auth::user()->roles->count()) {
            foreach (\Auth::user()->roles as $role) {
                if (!in_array($role->role_name, $roles)) {
                    $roles[] = $role->role_name;
                }
            }
        }

        return $roles;
    }

    protected function getAuthUserRolesPrivileges()
    {
        $privileges = [];

        if (\Auth::user()->roles->count()) {
            foreach (\Auth::user()->roles as $role) {
                if ($role->privileges->count()) {
                    foreach ($role->privileges as $privilege) {
                        if (!in_array($privilege->privilege_name, $privileges)) {
                            $privileges[] = $privilege->privilege_name;
                        }
                    }
                }
            }
        }

        return $privileges;
    }

    protected function getAuthUserAssignedPrivileges()
    {
        $privileges = [];

        if (\Auth::user()->privileges->count()) {
            foreach (\Auth::user()->privileges as $privilege) {
                if (!in_array($privilege->privilege_name, $privileges)) {
                    $privileges[] = $privilege->privilege_name;
                }
            }
        }

        return $privileges;
    }

    protected function getAuthUserPrivileges()
    {
        return array_merge($this->getAuthUserRolesPrivileges(), $this->getAuthUserAssignedPrivileges());
    }

    // ----------------------------------------------

    protected function getUserRoles($userId)
    {
        $roles = [];

        $user = \App\User::find($userId);

        if ($user && $user->roles->count()) {
            foreach ($user->roles as $role) {
                if (!in_array($role->role_name, $roles)) {
                    $roles[] = $role->role_name;
                }
            }
        }

        return $roles;
    }

    protected function getUserRolesPrivileges($userId)
    {
        $privileges = [];

        $user = \App\User::find($userId);

        if ($user && $user->roles->count()) {
            foreach ($user->roles as $role) {
                if ($role->privileges->count()) {
                    foreach ($role->privileges as $privilege) {
                        if (!in_array($privilege->privilege_name, $privileges)) {
                            $privileges[] = $privilege->privilege_name;
                        }
                    }
                }
            }
        }

        return $privileges;
    }

    protected function getUserAssignedPrivileges($userId)
    {
        $privileges = [];

        $user = \App\User::find($userId);

        if ($user && $user->roles->count()) {
            foreach ($user->privileges as $privilege) {
                if (!in_array($privilege->privilege_name, $privileges)) {
                    $privileges[] = $privilege->privilege_name;
                }
            }
        }

        return $privileges;
    }

    protected function getUserPrivileges($userId)
    {
        return array_merge($this->getUserRolesPrivileges($userId), $this->getUserAssignedPrivileges($userId));
    }


    protected function getUserRolesIds($userId)
    {
        $roles = [];

        $user = \App\User::find($userId);

        if ($user && $user->roles->count()) {
            foreach ($user->roles as $role) {
                if (!in_array($role->id, $roles)) {
                    $roles[] = $role->id;
                }
            }
        }

        return $roles;
    }

    protected function getUserRolesPrivilegesIds($userId)
    {
        $privileges = [];

        $user = \App\User::find($userId);

        if ($user && $user->roles->count()) {
            foreach ($user->roles as $role) {
                if ($role->privileges->count()) {
                    foreach ($role->privileges as $privilege) {
                        if (!in_array($privilege->id, $privileges)) {
                            $privileges[] = $privilege->id;
                        }
                    }
                }
            }
        }

        return $privileges;
    }

    protected function getUserAssignedPrivilegesIds($userId)
    {
        $privileges = [];

        $user = \App\User::find($userId);

        if ($user && $user->roles->count()) {
            foreach ($user->privileges as $privilege) {
                if (!in_array($privilege->id, $privileges)) {
                    $privileges[] = $privilege->id;
                }
            }
        }

        return $privileges;
    }

    protected function getUserPrivilegesIds($userId)
    {
        return array_merge($this->getUserRolesPrivilegesIds($userId), $this->getUserAssignedPrivilegesIds($userId));
    }

}
