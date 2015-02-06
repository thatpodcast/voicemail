# Simple voicemail app

``` bash
> git clone https://github.com/thatpodcast/voicemail.git
> cd voicemail
> heroku create
> heroku addons:add sendgrid:starter
> heroku addons:open sendgrid:starter > configure as necessary
> heroku config:set VOICEMAIL_EMAIL_ADDRESS=you@example.com
> git push heroku
```

Configure a twilio number with http://#app_name#.heroku.com/voice as the voice end point

Want to give it a try? Leave [@thatpodcast](https://twitter.com/thatpodcast) a voicemail on [+19793530100](tel:+19793530100)
