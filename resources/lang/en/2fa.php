<?php

return [
    'title' => 'Two Factor Authentication',
    'settings' => [
        'about' => 'Two factor authentication (2FA) strengthens access security by requiring two methods (also referred to as factors) to verify your identity. Two factor authentication protects against phishing, social engineering and password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.',
        'cancel_2fa_text' => 'If you are looking to disable Two Factor Authentication. Please confirm your password and Click Disable 2FA Button.',
        'cancel_2fa_button' => 'Cancel 2FA',
        'generate_2fa_button' => 'Generate Secret Key to Enable 2FA',
        'enable_2fa_button' => 'Enable 2FA',
        'current_password' => 'Current Password',
        '2fa_is_actived' => '2FA is currently <b>enabled</b> on your account.',
        'authenticator_code' => 'Authenticator Code',
        'set_step_1' => 'Scan this QR code with your Google Authenticator App. Alternatively, you can use the code: ',
        'set_step_2' => 'Enter the pin from Google Authenticator app:'
    ],
    'alerts' => [
        'key_generated' => 'Secret key is generated.',
        '2fa_enabled' => '2FA is enabled successfully.',
        '2fa_disabled' => '2FA is now disabled.',
        'invalid_code' => 'Invalid verification Code, Please try again.',
        'wrong_password' => 'Your password does not matches with your account password. Please try again.'
    ]
];
