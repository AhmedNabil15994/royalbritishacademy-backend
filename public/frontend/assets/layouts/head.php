<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sama || Sama Electronic Educational Platform</title>
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicons/favicon-32x32.png">

    <!-- plugin scripts -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik+Gemstones&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,500i,600,700,800%7CSatisfy&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome-free-5.11.2-web/css/all.min.css">
    <link rel="stylesheet" href="assets/plugins/sama-icons/style.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/vegas.min.css">
  <?php 
    if(isset($styles) && count($styles)){
        foreach($styles as $style){
            echo "<link rel=\"stylesheet\" href=\"assets/css/{$style}.css\">";
        }
    }
    ?>
    <!-- template styles -->
    <link rel="stylesheet" href="assets/css/style-en.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
</head>

<body>
    <div class="preloader"><span></span></div><!-- /.preloader -->
