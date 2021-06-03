<?php

return [
    'default_username'=>env('DEFAULT_IMAP_USER', ''),
    'default_passcode'=>env('DEFAULT_IMAP_PASS', ''),
    'default_enquiry_user'=>env('DEFAULT_ENQUIRY_USER'),
    'default_enquiry_pass'=>env('DEFAULT_ENQUIRY_PASS'),
    'default_enquiry_mail_subject'=>env('DEFAULT_ENQUIRY_MAIN_SUBJECT'),
    'mail_auto_renew'=>env('MAIL_AUTO_RENEW'),
    'common_mailbox'=>env('COMMON_MAILBOX'),
    'mail_auto_renew1'=>env('MAIL_AUTO_RENEW1'),
    'mail_auto_renew2'=>env('MAIL_AUTO_RENEW2'),
    'pagination_factor'=>env('PAGINATION_FACTOR')
];
