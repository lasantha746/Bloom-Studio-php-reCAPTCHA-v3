# Code With Lasa — PHP reCAPTCHA v3

## Video Tutorial
[Click Here](https://youtu.be/9DD5QLEL6c0)

## Frontend
```html
<script src="https://www.google.com/recaptcha/api.js?render=YOUR_SITE_KEY"></script>
<input type="hidden" name="token" id="token">
```

## JavaScript
```javascript
grecaptcha.ready(function () {
  grecaptcha.execute('YOUR_SITE_KEY', {action: 'submit'}).then(function (token) {
    document.getElementById('token').value = token;
  });
});
```

## Backend
```php
$secretKey = "YOUR_SECRET_KEY";

$token = $_POST['token'] ?? '';

$verify = file_get_contents(
"https://www.google.com/recaptcha/api/siteverify?secret=$secretKey&response=$token"
);

$result = json_decode($verify);

if (!$result->success || $result->score < 0.5) {
    exit;
}
```

Follow GitHub and star repository.
