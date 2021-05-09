# Laravel-Simple-Email-API
A minimalistic API in Laravel that sends an email to a specific mailbox (typical use case: endpoint of a frontend contact page with an email form)
<br>

## How-to
To use this simply edit the controller at:
> /app/Http/Controllers/EmailController.php

and adjust the code following the comments.

<br>

The endpoint will be /email but you can change it in /routes/api.php on the following line:
> Route::apiResource('email', 'EmailController');
