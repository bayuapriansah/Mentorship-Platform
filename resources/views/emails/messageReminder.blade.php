<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Message Reminder From Staff</title>
    <style>
       @import url('https://fonts.cdnfonts.com/css/intelone-display');/* Inline or embedded styles are often used in email templates due to varying support for external stylesheets */
       * {
        font-family: 'IntelOne Display', sans-serif;
       }
    </style>
</head>
<body>
    <div id="container">
        <p>
            Hello <strong>{{ $data['student_name'] }}</strong>
            <br>
            <br>
            You have received a message on the <strong>{{ $data['project_name'] }}</strong> - Task <strong>{{ $data['task_name'] }}</strong> messaging board.
        </p>
    </div>
</body>
</html>