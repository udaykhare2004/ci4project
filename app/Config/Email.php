<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public string $protocol    = 'smtp';
    public string $SMTPHost    = '';
    public string $SMTPUser    = '';
    public string $SMTPPass    = '';
    public int    $SMTPPort    = 587;
    public string $SMTPCrypto  = 'tls';
    public bool   $SMTPKeepAlive = false;
    public string $fromEmail   = '';
    public string $fromName    = 'phplearn';
    public string $mailType    = 'html';
}