<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?></title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
    
    <!-- datatable -->
    <link rel="stylesheet" href="<?= base_url('assets/css/dataTables.dataTables.css'); ?>">

    <!-- sweetalert -->
    <link rel="stylesheet" href="<?= base_url('assets/css/sweetalert2.min.css'); ?>">

    <!-- main -->
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css'); ?>">
    <?= $this->renderSection('heads'); ?>
</head>
<body>