<?php

return [
    'title' => 'Autenticação de dois fatores',
    'settings' => [
        'about' => 'A autenticação de dois fatores (2FA) fortalece a segurança de acesso ao exigir dois métodos (também chamados de fatores) para verificar sua identidade. A autenticação de dois fatores protege contra ataques de phishing, engenharia social e força bruta de senha e protege seus logins de invasores que exploram credenciais fracas ou roubadas.',
        'cancel_2fa_text' => 'Se você deseja desativar a autenticação de dois fatores. Confirme sua senha e clique no botão Desativar 2FA.',
        'cancel_2fa_button' => 'Cancelar 2FA',
        'generate_2fa_button' => 'Gerar chave secreta para habilitar 2FA',
        'enable_2fa_button' => 'Ativar 2FA',
        'current_password' => 'Senha Atual',
        '2fa_is_actived' => 'A 2FA está atualmente <b>ativada</b> em sua conta.',
        'authenticator_code' => 'Código do Autenticador',
        'set_step_1' => 'Digitalize este código QR com seu aplicativo Google Authenticator. Alternativamente, você pode usar o código: ',
        'set_step_2' => 'Digite o PIN do aplicativo Google Authenticator:'

    ],
    'alerts' => [
        'key_generated' => 'Chave secreta gerada.',
        '2fa_enabled' => '2FA ativado com sucesso.',
        '2fa_disabled' => '2FA agora está desabilitado.',
        'invalid_code' => 'Código de verificação inválido, por favor tente novamente.',
        'wrong_password' => 'Sua senha não corresponde à senha da sua conta. Por favor, tente novamente.'
    ]
];
