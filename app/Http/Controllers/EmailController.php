<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        return response()->json([
            'status' => 'ok',
            'ip-address' => $request->ip(),
            'query' => $request->query(),
            'input' => $request->all(),
            'emailcontent' => $request->input('emailcontent'),
        ], 200);
    }






    // MAIN ENDPOINT
    // I've chosen the store method because this LARAVEL's resource controller method issues a POST request by default, which makes sense for this 'send email' type of request. 
    //  |   |   |
    //  V   V   V

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validationMatchArray= [
            'email' => 'required|email',
            'subject' => 'required',
            'content' => 'required|min:3',
        ];

        $customErrorMessages = [
            'from.required'=> 'Please provide your email address so I can reply to you.',
            'from.email'=> 'Your email address isn\'t properly formatted.',
            'subject.required'=> 'Please add a subject.',
            'content.required'=> 'Please add some content.',
            'content.min'=> 'Please add a few more words to the email, I\'d love to read what you have to say.',
        ];

        $validated = \Validator::make(
            $request->all(),
            $validationMatchArray,
            $customErrorMessages
        );

        // Send error response if there's a validation error
        if ( $validated->fails() ) {
            return response()->json(
                [
                    'status' => 'error',
                    'errors' => $validated->errors(),
                    'message' => 'Validation Errors',
                    'data' => null,
                ], 422
            );
        };





        $emailDetails = [
            'from' => $request->input('email'),
            'subject' => $request->input('subject'),
            'content' => $request->input('content'),
        ];
        
        $reply_array = array_merge(
            [
            'status' => 'ok',
            ],$emailDetails
        );


        // !! REPLACE WITH YOUR EMAIL ADDRESS !!
        $to      = 'your_email@your_domain.com';
        $subject = $request->input('subject');
        $message = $request->input('content') . "\r\n" . $request->input('email');
        // Some shared host providers will not allow you to use php's default mail() function unless you send the email directly from the hosted domain, and for this to work you'll need to send the right header, which should look something like this: 
        // !! REPLACE WITH YOUR EMAIL ADDRESS from your domain on this webhost !!
        $headers = 'From: your_email@samewebhost_domain.com' . "\r\n" .
                   'Reply-To: ' .$request->input('email') . "\r\n";
        // Alternatively you can use a better php library to send emails like PHPMailer
        // You should also make sure to pass on the "sender's email address" to the backend so you can reply to whoever sent you the email, there's better ways to to this like adding it to the headers but for me, because of the restrictions of my particular webhost, I'll just append it at the end of the email content and add it to a "Reply-To" header.

        $mailSent = mail($to, $subject, $message, $headers);

        if ( empty($mailSent) ) {
            return response()->json(
                [
                    'status' => 'error',
                    'errors' => [
                        'content' => 'There was an error while sending the email, please try again.'
                    ],
                    'message' => 'There was an error while sending the email, please try again.',
                    'data' => null,
                ], 422
            );
        };

        return response()->json($reply_array, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function show(Email $email)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Email $email)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function destroy(Email $email)
    {
        //
    }
}
