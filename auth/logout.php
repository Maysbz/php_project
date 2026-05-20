<?php
require_once __DIR__ . '/../init.php';

ensure_session();
session_destroy();
redirect(page_url('index.php'));
