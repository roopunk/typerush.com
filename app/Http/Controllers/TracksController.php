<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class TracksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        require_once('recaptchalib.php');
        $publickey = "6LdhawcTAAAAAH84MAcozmtseiUYtuRchOf4OD0M"; // you got this from the signup page
        $recaptcha_html = recaptcha_get_html($publickey);

        return view('tracks.add', [
            'recaptcha_html' => $recaptcha_html
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'para' => 'required|min:5|max:1000',
            'aboutPara' => 'required|min:5|max:200',
        ]);

        require_once('recaptchalib.php');
        $resp = recaptcha_check_answer (
            '6LdhawcTAAAAAG-AtjWFUtfS8UzvlqJF3EL5u2LS',
            $_SERVER["REMOTE_ADDR"],
            $_POST["recaptcha_challenge_field"],
            $_POST["recaptcha_response_field"]
        );

        if (!$resp->is_valid) {
            return redirect('track/add')->withErrors(['Captcha entered is invalid.']);
        }

        $post = $request->all();
        list($para, $length) = filterPara($post['para']);
        $user = 0;

        $track = new \App\Track;
        $track->content = $para;
        $track->words = $length;
        $track->user = $user;
        $track->about = $post['aboutPara'];
        if( false && $track->save() )
            return view('tracks/success', ['id' => $track->id, 'length' => strlen($para), 'num_words' => $length]);
        else return view('tracks/failure', ['m' => 'INSERT_FAILURE']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
