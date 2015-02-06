<?php

use Services_Twilio_Twiml as Twiml;
use Silex\Application;
use Silex\Provider\MonologServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use SendGrid\Email;

require 'vendor/autoload.php';

$app = new Application;

$app->register(new MonologServiceProvider(), [
    'monolog.logfile' => 'php://stdout',
    'monolog.level' => getenv('LOG_LEVEL')
        ? constant('Monolog\Logger::'.strtoupper(getenv('LOG_LEVEL')))
        : 'warning',
]);

$app['sendgrid'] = function ($app) {
    return new SendGrid(
        getenv('SENDGRID_USERNAME'),
        getenv('SENDGRID_PASSWORD')
    );
};

$app->post("/voice", function (Request $request, Application $app) {

    $twiml = new Twiml;
    $twiml->say("Thanks for calling That Podcast! Please leave a message after the beep, pressing any key when you are done. Please be sure to leave an email address so we can contact you.");
    $twiml->record([
        'maxLength' => 120,
        'action' => '/recordings',
    ]);

    return new Response((string) $twiml);
});

$app->post("/recordings", function (Request $request, Application $app) {

    $email = new Email();

    $to = getenv('VOICEMAIL_EMAIL_ADDRESS');
    $app['logger']->info("Sending notification to $to");

    $email->addTo($to)
        ->setFrom($to)
        ->setSubject("New Voicemail!")
        ->setText(sprintf(
            "SID: %s\nDuration: %s\nURL: %s\n",
            $request->get("CallSid"),
            $request->get("RecordingDuration"),
            $request->get("RecordingUrl")
        ));

    $rsp = $app['sendgrid']->send($email);

    if (is_object($rsp) && isset($rsp->errors)) {
        $app['logger']->error(json_encode($rsp));
    }

    $twiml = new Twiml;
    $twiml->say("Thanks for leaving a message, you're awesome.");
    $twiml->hangup();

    return new Response((string) $twiml);
});

return $app;
