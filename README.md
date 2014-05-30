# Simple voicemail app

- git clone https://github.com/thatpodcast/voicemail.git
- cd voicemail
- heroku create
- heroku addons:add sendgrid:starter
- (optional) heroku addons:open sendgrid:starter
- heroku config:set VOICEMAIL_EMAIL_ADDRESS=<your_address>
- git push heroku
- Configure a twilio number with http://<app_name>.heroku.com/voice as the voice
  end point

