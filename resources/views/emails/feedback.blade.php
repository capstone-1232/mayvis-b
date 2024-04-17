<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <title>Feedback Submitted</title>
   </head>
   <body>
      <p>Dear {{ $userName }},</p>
      <p>Your feedback for the proposal: <strong>{{ $proposalTitle }}<strong>.</p>
      <p>The current status of your proposal is: <strong>{{ $proposalStatus }}</strong>.</p>
      @isset($clientMessage)
      <p>Client's message: {{ $clientMessage }}</p>
      @endisset
      <p>Best Regards,<br>Your friendly mayvis mailer.</p>
   </body>
</html>