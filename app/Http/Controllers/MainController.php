<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;


class MainController extends CommonController
{

    public function home()
    {
        $userId = !\Auth::user()->isAdmin() ? \Auth::user()->id : null;

       // dd(\App\Credential::generalStats($userId)['rows'][0]->name);

        $data = [
            'generalStats'  => \App\Credential::generalStats($userId),
            'approvedStats' => \App\Credential::approvedStats($userId),
            'seo'           => [
                'pageTitlePrefix' => '',
                'pageTitle'       => 'Welcome to Joint Independent Provider Association',
            ],
        ];

        return view('pages.index', $data);
    }

    public function uploadInsertedImage(Request $request)
    {
        list($fileName, $ext) = explode('.', $_FILES['file']['name']);
        $filename = str_replace('.', '', uniqid($fileName . '-', true)) . '.' . $ext;

        if (move_uploaded_file($_FILES['file']['tmp_name'], storage_path() . '/tmp/' . $filename)) {
            $path = '/images/warehouse/';
            if ($this->s3) {
                \Storage::disk('s3')->put('public' . $path . $filename, file_get_contents(storage_path() . '/tmp/' . $filename));
                unlink(storage_path() . '/tmp/' . $filename);
            } else {
                rename(storage_path() . '/tmp/' . $filename, public_path() . $path . $filename);
            }

            $input = $request->all();

            return json_encode([
                'success'   => true,
                'url'       => $this->siteUrl . $path . $filename,
                'fileName'  => $filename,
                'link'      => $input['link'],
                'altText'   => $input['altText'],
                'newWindow' => $input['newWindow'],
            ]);
        } else {
            return json_encode([
                'success' => false,
                'error'   => 'File could not be uploaded.',
            ]);
        }
    }

}
