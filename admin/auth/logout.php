<?php
require_once __DIR__ . '/../../init.php';

ensure_session();
session_destroy();
redirect(admin_url('index.php'));
