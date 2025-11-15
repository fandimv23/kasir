<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= isset($title) ? $title : 'Dashboard'; ?></title>

    <link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">
</head>

<?php
// Tangkap segmen URI pertama (controller)
$controller = $this->uri->segment(1);

// Jika halaman auth (login atau registration), beri background biru
$auth_pages = ['auth', 'login', 'registration'];

// Jika tidak ada segment (berarti URL kosong seperti http://localhost/kasir/), anggap sebagai 'auth'
if ($controller == '') {
    $controller = 'auth';
}

if (in_array(strtolower($controller), $auth_pages)) {
    $body_class = 'bg-gradient-primary';
} else {
    $body_class = '';
}
?>


<body id="page-top" class="<?= $body_class; ?>">
    <!-- Page Wrapper -->
    <div id="wrapper">