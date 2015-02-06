# Simple voicemail app

This app acts as a voicemail box and emails you when someone leaves a message on a Twilio number.

Want to give it a try? Leave [@thatpodcast](https://twitter.com/thatpodcast) a voicemail on [+19793530100](tel:+19793530100).

## Deployment

Deploy to Heroku using a single click:

[![Deploy](https://www.herokucdn.com/deploy/button.png)](https://heroku.com/deploy)

Alternatively, you can deploy manually:

```
$ git clone https://github.com/thatpodcast/voicemail
$ cd voicemail
$ heroku create
$ heroku addons:add sendgrid:starter
$ heroku addons:open sendgrid:starter > configure as necessary
$ heroku config:set VOICEMAIL_EMAIL_ADDRESS=you@example.com
$ git push heroku master
```

## Configure Twilio

[Configure a Twilio number](http://www.twilio.com/help/faq/voice/how-do-i-assign-my-twilio-number-to-my-voice-application) with `http://{YOUR_APP_NAME}.herokuapp.com/voice` as the voice end point.
