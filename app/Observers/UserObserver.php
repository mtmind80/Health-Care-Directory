<?php

use Illuminate\Support\Facades\Hash;

class UserObserver
{

    use ActionTrait;

    public function creating($model)
    {
        $model->password = Hash::make($model->password);
    }

    public function updating($model)
    {
        if ( ! $this->isAction('users', ['togglestatus', 'inlineupdate'])) {
            $repeatPassword = Request::get('repeat_password');
            if ( ! empty($model->password)) {
                if ($model->password == $repeatPassword) {
                    $model->password = Hash::make($model->password);
                } else {
                    return redirect()->back()->with('error', 'Password don\'t match.');
                }
            } else {
                $model->password = Request::get('old_password');
            }
        }
    }

    public function saved($model)
    {
        if ( ! $this->isAction('users', ['togglestatus', 'inlineupdate'])) {
            $oldAvatar = Request::get('old_avatar');
            if ( ! empty($model->avatar) && ($model->avatar != $oldAvatar)) {
                if (env('S3_ACTIVE', false)) {
                    Storage::disk('s3')->put('public/images/avatars/'.$model->avatar, file_get_contents(storage_path().'/tmp/'.$model->avatar));
                    unlink(storage_path() .'/tmp/'.$model->avatar);
                    if ( ! empty($oldAvatar) && Storage::disk('s3')->exists('public/images/avatars/'.$oldAvatar)) {
                        Storage::disk('s3')->delete('public/images/avatars/'.$oldAvatar);
                    }
                } else {
                    rename(storage_path().'/tmp/'.$model->avatar, public_path().'/images/avatars/'.$model->avatar);
                    if ( ! empty($oldAvatar) && file_exists(public_path() .'/images/avatars/'.$oldAvatar)) {
                        unlink(public_path() .'/images/avatars/'.$oldAvatar);
                    }
                }
            }
        }
    }

    public function deleting($model)
    {
        if (env('S3_ACTIVE', false)) {
            if ( ! empty($model->avatar) && Storage::disk('s3')->exists('public/images/avatars/'.$model->avatar)) {
                Storage::disk('s3')->delete('public/images/avatars/'.$model->avatar);
            }
        } else {
            if ( ! empty($model->avatar) && file_exists(public_path() .'/images/avatars/'.$model->avatar)) {
                unlink(public_path() .'/images/avatars/'.$model->avatar);
            }
        }
    }

}

